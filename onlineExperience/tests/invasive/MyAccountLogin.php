<?php
/**
 * First Utility Online Experience Smoke Tests
 * @copyright (c) 2014, First Utility
 * @author Leigh Mills
 * @author Ashley Kitson
 * @author Bade Adegboye
 */

/**
* MyAccount Login functional tests
*
*/
class MyAccountLogin extends CWebDriverTestCase {

    /**
     *
     * @var array
     */
    protected $userData;

    /**
     * @var \MyAccountLoginPage
     */
    protected $loginPage;

    /**
     * @var \MyAccountDashboardPage
     */
    protected $dashboardPage;

    public function setUp()
    {
        //data
        $dataProvider =   new WebsiteDataProvider(DATAFILE,DATADIR);
        $this->userData = $dataProvider->getTestData();
        parent::setUp(SELHOST, SELPORT);
        $this->loginPage = new MyAccountLoginPage($this->webdriver, $this);
        $this->dashboardPage = new MyAccountDashboardPage($this->webdriver, $this);
    }

    public function testLoginWithProperUserIdAndPasswordGoestoDashboard()
    {
        $this->loginPage->open()
                ->enterUserId($this->userData['standard']['uid'])
                ->enterUserPassword($this->userData['standard']['pwd'])
                ->clickButton();
        $this->dashboardPage->isLoaded()
                ->clickSignOut();
    }

    public function testLoginWithProperAccountNumberAndPasswordGoestoDashboard()
    {
        $this->loginPage->open()
                ->enterUserId($this->userData['standard']['acNum'])
                ->enterUserPassword($this->userData['standard']['pwd'])
                ->clickButton();
        $this->dashboardPage->isLoaded()
                ->clickSignOut();
    }

    public function testLoginWithProperEmailAddressAndPasswordGoestoDashboard()
    {
        $this->loginPage->open()
                ->enterUserId($this->userData['standard']['email'])
                ->enterUserPassword($this->userData['standard']['pwd'])
                ->clickButton();
        $this->dashboardPage->isLoaded()
                ->clickSignOut();
    }

    public function testNullPasswordGivesAnError()
    {
        $this->loginPage->open()
                ->enterUserId($this->userData['standard']['uid'])
                ->clickButton()
                ->checkPasswordErrorMessage();
    }

    public function testNullUseridGivesError()
    {
        $this->loginPage->open()
                ->enterUserPassword($this->userData['standard']['pwd'])
                ->clickButton()
                ->checkUserErrorMessage();
    }

    public function testNullUseridAndPasswordLogin()
    {
        $this->loginPage->open()
                ->clickButton()
                ->checkPasswordErrorMessage();
    }

    public function testInvalidCredentialsGivesError()
    {
        $this->loginPage->open()
                ->enterUserId('foobar')
                ->enterUserPassword('barfoo')
                ->clickButton()
                ->checkInvalidLoginError();
    }

    /*
     * Cannot run multi account tests until we have a way of getting
     * known multiaccount users
     * 
    public function testMultipleAccountLogonByEmailError()
    {
        $this->loginPage->open()
                ->enterUserId($this->userData['multiaccount']['email'])
                ->enterUserPassword($this->userData['multiaccount']['pwd'])
                ->clickButton()
                ->checkMultipleAccountErrorMessage();
    }

    public function testMultipleAccountUserIdLogin1()
    {
        $myAccountLoginPage = new MyAccountLoginPage($this->webdriver);
        $myAccountLoginPage->open();
        $myAccountLoginPage->verifyPageIsLoaded($this);
        $myAccountLoginPage->enterMultipleAccountUserId1($this->userData);
        $myAccountLoginPage->enterUserPassword($this->userData);
        $myAccountLoginPage->clickButton();
        $myAccountLoginPage->verifyDashboardPageIsLoaded($this);
        $myAccountLoginPage->clickSignOut();
    }

    public function testMultipleAccountUserIdLogin2()
    {
        $myAccountLoginPage = new MyAccountLoginPage($this->webdriver);
        $myAccountLoginPage->open();
        $myAccountLoginPage->verifyPageIsLoaded($this);
        $myAccountLoginPage->enterMultipleAccountUserId2($this->userData);
        $myAccountLoginPage->enterUserPassword($this->userData);
        $myAccountLoginPage->clickButton();
        $myAccountLoginPage->verifyDashboardPageIsLoaded($this);
        $myAccountLoginPage->clickSignOut();
    }
    */
}
