<?php
/**
 * First Utility Omline Experience Smoke Tests
 * @copyright (c) 2014, First Utility
 * @author Leigh Mills
 * @author Ashley Kitson
 * @author Bade Adegboye
 */

/**
 * My Account Usage Graphs page object
 */
class MyAccountUsageGraphPage {

    protected $webdriver;

    private $locators = array(
        'gasGraph' => '/myaccount/graph/gas',
        'elecGraph' => '/myaccount/graph/electricity',
        'usageHeader' => "//div[contains(@class,'page-heading')]//h1[text()='my energy usage']",
        'usageDownloadBtn' => "//div[@id='download-usage-container']//a[contains(@class,'button')]",
        'signOut' => "//ul[@class='main_nav']//li[contains(@class,'last')]/a",
    );

    private $validationData = array(

    );

    public function __construct($webdriver) {
        $this->webdriver = $webdriver;
    }

    public function open($graphType)
    {
        $this->webdriver->get(BASEURL. $this->locators[$graphType]);
        $this->webdriver->setImplicitWaitTimeout(10000); //allow for page to load
    }

    public function verifyElecUsagePageIsLoaded($test) {
   		$headerEl = $this->webdriver->findElementBy(LocatorStrategy::xpath,$this->locators['usageHeader']);
    	$test->assertNotNull($headerEl);

    	$usageBtnEl = $this->webdriver->findElementBy(LocatorStrategy::xpath,$this->locators['usageDownloadBtn']);
    	$test->assertNotNull($usageBtnEl);
    }

    public function verifyGasUsagePageIsLoaded($test) {
        $headerEl = $this->webdriver->findElementBy(LocatorStrategy::xpath,$this->locators['usageHeader']);
    	$test->assertNotNull($headerEl);

    	$usageBtnEl = $this->webdriver->findElementBy(LocatorStrategy::xpath,$this->locators['usageDownloadBtn']);
    	$test->assertNotNull($usageBtnEl);
    }

    public function clickSignOut() {
        $element = $this->webdriver->findElementBy(LocatorStrategy::xpath, $this->locators['signOut']);
        $element->click();
    }

}
