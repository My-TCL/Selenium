<?php
/**
 * First Utility Omline Experience Smoke Tests
 * @copyright (c) 2014, First Utility
 * @author Leigh Mills
 * @author Ashley Kitson
 * @author Bade Adegboye
 */

/**
 * MyAccount crawl
 * Login and
 * - visit all My Account Pages
 * - visit all public pages
 * @author Leigh Mills
 * @author Ashley Kitson - amendments
 */
class MyAccountCrawlTest extends CWebDriverTestCase {

    /**
     * @var array
     */
    protected $userData;

    /**
     * @var \MyAccountLoginPage
     */
    protected $loginPage;
    /**
     * @var \MyAccountSubmitReadingPage
     */
    protected $readsPage;
    /**
     * @var \MyAccountDashboardPage
     */
    protected $dashboardPage;
    /**
     * @var \MyAccountBillsPage
     */
    protected $billsPage;
    /**
     *
     * @var \MyAccountChangeTariffPage
     */
    protected $tariffChangePage;
    /**
     *
     * @var \MyAccountMyDetailsPage
     */
    protected $detailsPage;
    /**
     *
     * @var \MyAccountCotPage;
     */
    protected $movingPage;
    /**
     *
     * @var \MyAccountContactUs
     */
    protected $loggedOnContactPage;
    /**
     *
     * @var \Header
     */
    protected $headerPage;
    /**
     *
     * @var \Footer
     */
    protected $footerPage;

    /**
     * @var int
     */
    protected $defaultTimeoutForFinds = 5000; //5 seconds
    /**
     * @var int
     */
    protected $upperTimeoutForFinds = 10000; //10 seconds

    public function setUp()
    {
        parent::setUp(SELHOST, SELPORT);

        //data
        $dataProvider =   new WebsiteDataProvider(DATAFILE,DATADIR);
        $this->userData = $dataProvider->getTestData();
        $this->webdriver->setImplicitWaitTimeout($this->defaultTimeoutForFinds);
        //Page objects
        $this->loginPage = new MyAccountLoginPage($this->webdriver, $this, LOCATION);
        $this->readsPage = new MyAccountSubmitReadingPage($this->webdriver, $this, LOCATION);
        $this->dashboardPage = new MyAccountDashboardPage($this->webdriver, $this, LOCATION);
        $this->billsPage = new MyAccountBillsPage($this->webdriver, $this, LOCATION);
        $this->tariffChangePage = new MyAccountChangeTariffPage($this->webdriver, $this, LOCATION);
        $this->detailsPage = new MyAccountMyDetailsPage($this->webdriver, $this, LOCATION);
        $this->movingPage = new MyAccountCotPage($this->webdriver, $this, LOCATION);
        $this->loggedOnContactPage = new MyAccountContactUsPage($this->webdriver, $this, LOCATION);
        $this->headerPage = new Header($this->webdriver, $this, LOCATION);
        $this->footerPage = new Footer($this->webdriver, $this, LOCATION);

    }

    /**
     * Do a simple site crawl
     */
    public function testCrawl()
    {
        $this->checkLogin();
        $this->checkDashboard();
        $this->checkReads();
        $this->checkBills();
        $this->checkChangeTariff();
        $this->checkDetails();
        $this->checkMovingHome();

        $this->dashboardPage->clickSignOut();
    }

    /**
     * The logged in contact us form won't work
     * for the testashley account, so use a different
     * account for this test
     */
    public function testLoggedInContactUsForm()
    {
        if (LOCATION == 'Live') {
            $this->markTestSkipped('Cannot run in Live environment');
            return;
        }
        $this->loginPage->open()
                ->enterUserId($this->userData['loggedInContactForm']['uid'])
                ->enterUserPassword($this->userData['loggedInContactForm']['pwd'])
                ->clickButton();
        $this->loggedOnContactPage->open()
                ->checkPageTitle('contact us')
                ->checkContactForm()
                ->navigateToContactUsViaSideButton()
                ->clickSignOut();
    }

    public function testPublicMenuLinks()
    {
        $this->headerPage->open()
                ->checkSearchBoxExists()
                ->checkMenuLinks();
    }

    public function testFooterLinks()
    {
        $this->footerPage->open()
                ->checkFooterLinks()
                ->checkStaticLinks();
    }

    /**
     * Login - simple happy path
     */
    protected function checkLogin()
    {
        if (LOCATION == 'Live') {
            $this->markTestSkipped('Cannot run in Live environment');
            return;
        }
        $this->loginPage->open()
                ->navigateToContactUsViaSideButton()
                ->open()
                ->verifyPageIsLoaded()
                ->checkPageTitle('log in to My Account')
                ->enterUserId($this->userData['standard']['uid'])
                ->enterUserPassword($this->userData['standard']['pwd'])
                ->clickButton();
    }

    /**
     * Check dashboard components are intact
     */
    protected function checkDashboard()
    {
        if (LOCATION == 'Live') {
            $this->markTestSkipped('Cannot run in Live environment');
            return;
        }
        $this->dashboardPage->isLoaded()
                ->checkPageTitle('overview')
                ->setDefaultTimeoutForFinds($this->upperTimeoutForFinds)
                ->verifyElecGraphPartial()
                ->verifyGasGraphPartial()
                ->setDefaultTimeoutForFinds($this->defaultTimeoutForFinds)
                ->checkMeterReadPartialHeading()
                ->checkLatestBillPartialHeading()
                ->checkMyTariffPartialHeading()
                ->checkAccountId()
                ->checkMobilePromoBox()
                ->navigateToElecUsageGraph()
                ->open()
                ->navigateToGasUsageGraph()
                ->open()
                ->navigateToViewPreviousReads()
                ->open()
                ->navigateToSubmitReading()
                ->open()
                ->navigateToViewBills()
                ->open()
                ->navigateToManualPayment()
                ->open()
                ->navigateToFullTariffInfo()
                ->open()
                ->navigateToContactUsViaSideButton();

    }

    /**
     * Check view reads page components are intact
     */
    protected function checkReads()
    {
        $this->readsPage->open()
                ->checkPageTitle('submit meter reading')
                ->checkAccountId()
                ->verifyElecTabIsClickable()
                ->verifyGasTabIsClickable()
                ->navigateToContactUsViaSideButton();
    }

    /**
     * Check that the Bills page is intact
     */
    protected function checkBills()
    {
        $this->billsPage->open()
                ->checkPageTitle('my bills and payments')
                ->checkAccountId()
                ->verifyBills()
                ->checkWeHaveBills()
                ->verifyRecentPayments()
                ->checkWeHavePayments()
                ->verifyTariffs()
                ->navigateToContactUsViaSideButton();
    }

    /**
     * Check Change Tariff page is intact
     */
    protected function checkChangeTariff()
    {
        $this->tariffChangePage->open()
                ->checkPageTitle('change to a different tariff')
                ->checkAccountId()
                ->verifyTariffChangeForm()
                ->checkWeHaveCurrentTariff()
                ->navigateToContactUsViaSideButton();
    }

    /**
     * Check Details page is intact
     */
    protected function checkDetails()
    {
        $this->detailsPage->open()
                ->checkPageTitle('my details')
                ->checkAccountId()
                ->verifyPageIsLoaded()
                ->navigateToContactUsViaSideButton();
    }

    /**
     * Check COT page is intact
     */
    protected function checkMovingHome()
    {
        $this->movingPage->open()
                ->checkPageTitle('moving home')
                ->checkAccountId()
                ->checkCotForm()
                ->navigateToContactUsViaSideButton();
    }

    /** generate screenshot if any test has failed */
    /*protected function tearDown()
    {
        if( $this->hasFailed() ) {
            $date = "screenshot_" . date('Y-m-d-H-i-s') . ".png" ;
            $this->webdriver->getScreenshotAndSaveToFile( $date );
        }
        $this->close();
    }*/
}
