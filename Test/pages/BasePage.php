<?php
/**
 * First Utility Online Experience Smoke Tests
 * @copyright (c) 2014, First Utility
 * @author Leigh Mills
 * @author Ashley Kitson
 * @author Bade Adegboye
 */

/**
 * Abstract base page for all test suite page objects
 *
 */
abstract class BasePage
{

    /**
     *
     * @var \RemoteWebDriver
     */
    protected $webdriver;

    /**
     *
     * @var \CWebDriverTestCase
     */
    protected $testCase;

    /**
     * Base uri for page
     * Override in your ancestor
     * @var string
     */
    protected $baseUri;

    /**
     * What environment are we running in?
     * @var string
     */
    protected $env;

    /**
     * Class name converted to a name we can use in messages
     *
     * @var string
     */
    protected $pageNameAsTitle;

    private $locators = array(
        'contactUsButton' => '//a[contains(@class,"contact-button")]',
        'pageTitle' => "//div[contains(@class,'page-heading')]/h1[contains(@class,'left') and contains(text(),'%s')]",
        'errorBodyTag' => '//body[@class="error-page"]',
        'statusCode' => '//h1[contains(text(), "Error")]'
    );

    /**
     * Is page in debug mode?
     * @var boolean
     */
    protected $debug = false;

    public function __construct(\RemoteWebDriver $webdriver, \CWebDriverTestCase $testCase, $environment = array()) {
        $this->webdriver = $webdriver;
        $this->testCase = $testCase;
        $this->setPageNameAsTitle();
        $this->env = $environment;
    }

    /**
     * Set the web driver timeout for all find.. methods
     *
     * @param int $timeout milliseconds default timeout
     * @return \BasePage
     */
    public function setDefaultTimeoutForFinds($timeout)
    {
        $this->webdriver->manage()->timeouts()->implicitlyWait($timeout);

        return $this;
    }

    /**
     * Get Page base uri
     *
     * @return string
     */
    public function getBaseUri()
    {
        return $this->baseUri;
    }

    /**
     * Open the page.  Waits for page to actually return with the timeout limit
     * Will fail if not loaded within the specified timeout
     *
     * @param int $timeout millisecond time to wait
     * @return \BasePage
     */
    public function open($timeout = 10000) {

        $this->webdriver->get(BASEURL. $this->baseUri);
        $this->waitForUri($timeout);
        return $this;
    }

    /**
     * Is the page loaded?
     * Will fail if not loaded within the specified timeout
     *
     * @param int $timeout millisecond time to wait
     * @return \BasePage
     */
    public function isLoaded($timeout = 10000) {
        $this->testCase->assertTrue(
                $this->waitForUri($timeout, false),
                "Page {$this->baseUri} did not load"
                );
        return $this;
    }


    /**
     * Check that page title is correct
     *
     * @param type $title
     * @return \BasePage
     */
    public function checkPageTitle($title)
    {
        $this->checkForElement(sprintf($this->locators['pageTitle'], $title), 'Cannot find page title: "' . $title . '"');

        return $this;
    }

    /**
     * Navigate to the contact page using the screen side button
     *
     * @return \BasePage
     */
    public function navigateToContactUsViaSideButton() {
        $element = $this->checkForElement($this->locators['contactUsButton'], 'Cannot click contact us button');
        $element->click();

        return $this;
    }

    /**
     * Is the current page an error page?
     * @return boolean
     */
    public function isErrorPage()
    {
        try {
            $el = $this->webdriver->findElement(WebDriverBy::xpath($this->locators['errorBodyTag']));
            if ($el) {
                return true;
            }
        } catch (NoSuchElementException $e) {
            return false;
        }

        return false;
    }

    /**
     * Get the status code from an error page title
     * @return string
     */
    public function getErrorStatusCode()
    {
        try{
            $el = $this->webdriver->findElement(WebDriverBy::xpath($this->locators['statusCode']));
        }catch (NoSuchElementException $ex) {
            $el = Null;
            $this->testCase->assertNotNull($el, "Not an error page, so cannot get status code");
        }
        $matches = array();
        if (preg_match('/.*\((?P<sc>\d+)\)/', $el->getText(), $matches) == 1) {
            return $matches['sc'];
        } else {
            return 'unknown';
        }
    }

    /**
     * Set/unset the debug flag
     *
     * @param boolean $flag
     * @return \BasePage
     */
    public function setDebug($flag = true)
    {
        $this->debug = (boolean) $flag;

        return $this;
    }


    /**
     * Wait for this page's uri to respond
     * Will sleep 1/2 second between subsequent attempts
     *
     * @param int $timeout millisecond time to wait
     * @param boolean $throwException Throw exception if page not loaded else return boolean
     * @return boolean return test value if $throwException == false
     */
    protected function waitForUri($timeout = 10000, $throwException = true)
    {
        return $this->checkForUri($this->baseUri, $timeout, $throwException);
    }

    /**
     * Wait for a specified page uri to respond
     *
     * @param string $uri
     * @param int $timeout millisecond time to wait
     * @param boolean $throwException Throw exception if page not loaded else return boolean
     * @return boolen return test value if $throwException == false
     */
    protected function checkForUri($uri, $timeout = 10000, $throwException = true)
    {
        if ($this->debug) {
            echo "uri = {$uri}" . PHP_EOL;
        }
        $flag = true;
        $ttl = $timeout * 1000; //convert to microsecond
        while ($flag) {
            $path = parse_url($this->webdriver->getCurrentUrl(), PHP_URL_PATH);
            if ($this->debug) {
                echo "path = {$path}" . PHP_EOL;
            }
            if ($path == $uri) {
                break;
            } elseif($this->isErrorPage()) {
                sleep(2);
                $statusCode = $this->getErrorStatusCode();
                $this->testCase->fail("Check for uri '{$uri}' resulted in error page status: {$statusCode}");
            } else {
                $ttl -= 500000;
                if ($ttl<0) {
                    $flag = false;
                } else {
                    usleep(500000);
                }
            }
        }

        if ($throwException) {
            $this->testCase->assertTrue($flag, 'Timed out waiting for' . $this->baseUri);
        }

        return $flag;
    }

    /**
     *
     * @param string $selector
     * @param string $errMsg
     * @param string $strategy
     * @return \RemoteWebElement
     */
    protected function checkForElement($selector, $errMsg, $strategy = "xpath")
    {
        try {
            $el = $this->webdriver->findElement(WebDriverBy::$strategy($selector));
            $this->testCase->assertNotNull($el, "{$errMsg} for page: '{$this->pageNameAsTitle}'");
            return $el;
        } catch (NoSuchElementException $e) {
            $this->testCase->fail("No such element for {$strategy}: {$selector} for page '{$this->pageNameAsTitle}'");
        }

    }

    /**
     * Set the page name for use in error messages to a modified form
     * of the current class name
     */
    protected function setPageNameAsTitle()
    {
        $className = get_class($this);
        $raw = lcfirst(str_replace('MyAccount', '', $className));
        $pieces = preg_split('/(?=[A-Z])/',$raw);
        $pieces[0] = ucfirst($pieces[0]);
        $this->pageNameAsTitle = implode(' ', $pieces);
    }
}
