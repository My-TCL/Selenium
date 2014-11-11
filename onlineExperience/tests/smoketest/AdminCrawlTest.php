<?php
/**
 * First Utility Omline Experience Smoke Tests
 * @copyright (c) 2014, First Utility
 * @author Ashley Kitson
 */

/**
 * Admin page crawl
 */
class AdminCrawlTest extends CWebDriverTestCase {

    /**
     * @var array
     */
    protected $userData;

    /**
     * @var int
     */
    protected $defaultTimeoutForFinds = 5000; //5 seconds
    /**
     * @var int
     */
    protected $upperTimeoutForFinds = 10000; //10 seconds

    /**
     *
     * @var MyAccountLoginPage
     */
    protected $loginPage;

    /**
     *
     * @var \FreePage
     */
    protected $pageObject;

    /**
     *
     * @var \AdminDashboardPage
     */
    protected $dashboardPage;

    protected $pagesToLoad = array(
		'admin/config',
		'admin/dashboard',
		'admin/error/noaccess',
		'admin/info',
		'admin/masq',
//		'admin/pumasq', //portal unmasking not avail unless you masq first as edm customer
    );

    protected $redirectedPages = array(
		'admin/creditcheck' => 'portal/ops/login',  //no service on UAT
		'admin/umasq' => 'admin/dashboard',  //redirect to dashboard if not masqing as lognet customer
        'admin/meterread' => 'portal/ops/login',  //no service on UAT
        'admin/onboarding'  => 'portal/ops/login',  //no service on UAT,
		'admin/setcustpwd'  => 'portal/ops/login',  //no service on UAT,
		'admin/setemail'  => 'portal/ops/login',  //no service on UAT,
        );

    public function setUp()
    {
        parent::setUp(SELHOST, SELPORT);

        //data
        $dataProvider =   new WebsiteDataProvider(DATAFILE,DATADIR);
        $this->userData = $dataProvider->getTestData();
        $this->webdriver->setImplicitWaitTimeout($this->defaultTimeoutForFinds);
        //Page objects
        $this->loginPage = new MyAccountLoginPage($this->webdriver, $this, LOCATION);
        $this->pageObject = new FreePage($this->webdriver, $this, LOCATION);
        $this->dashboardPage = new AdminDashboardPage($this->webdriver, $this, LOCATION);
    }

    /**
     * Crawl publicly available page links to make sure page exists
     */
    public function testCrawl()
    {
        $this->loginPage->open()
                ->enterUserId('functestadmin3')
                ->enterUserPassword('Connect@1')
                ->clickButton();
        $this->dashboardPage->isLoaded();

        foreach($this->pagesToLoad as $link) {
            try {
                $this->pageObject
                        ->setBaseUri('/' . $link)
                        ->open();
            } catch (\Exception $e) {
                //fail individual page test but don't stop
                $this->fail($e->getMessage() . ' for route ' . $link);
            }
        }
        $this->dashboardPage->open()->clickSignOut();
    }

    /**
     * Crawl public pages that redirect somewhere else
     */
//    public function testRedirects()
//    {
//        foreach($this->redirectedPages as $link => $redirect) {
//            try {
//                $this->webdriver->get(BASEURL. '/' . $link);
//                $this->pageObject
//                    ->setBaseUri('/' . $redirect)
//                    ->isLoaded();
//            } catch (Exception $e) {
//                //fail individual page test but don't stop
//                $this->fail($e->getMessage());
//            }
//
//        }
//    }

}
