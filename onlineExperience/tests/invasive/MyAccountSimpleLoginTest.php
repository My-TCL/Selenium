<?php
/**
 * First Utility Online Experience Smoke Tests
 * @copyright (c) 2014, First Utility
 * @author Leigh Mills
 * @author Ashley Kitson
 * @author Bade Adegboye
 */

/**
* MyAccount simple Login functional tests
* Covers only the user case for single account, single user id, single email address
*/
class MyAccountSimpleLoginTest extends CWebDriverTestCase {

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
        $this->loginPage = new MyAccountLoginPage($this->webdriver, $this, LOCATION);
        $this->dashboardPage = new MyAccountDashboardPage($this->webdriver, $this, LOCATION);
    }

    public function testLoginWithProperUserIdAndPasswordGoestoDashboard()
    {
        if (LOCATION == 'Live') {
            $this->markTestSkipped('Cannot run in Live environment');
            return;
        }
        $this->loginPage->open()
                ->enterUserId($this->userData['standard']['uid'])
                ->enterUserPassword($this->userData['standard']['pwd'])
                ->clickButton();
        $this->dashboardPage->isLoaded()
                ->clickSignOut();
    }

    public function testLoginWithProperAccountNumberAndPasswordGoestoDashboard()
    {
        if (LOCATION == 'Live') {
            $this->markTestSkipped('Cannot run in Live environment');
            return;
        }
        $this->loginPage->open()
                ->enterUserId($this->userData['standard']['acNum'])
                ->enterUserPassword($this->userData['standard']['pwd'])
                ->clickButton();
        $this->dashboardPage->isLoaded()
                ->clickSignOut();
    }

    public function testLoginWithProperEmailAddressAndPasswordGoestoDashboard()
    {
        if (LOCATION == 'Live') {
            $this->markTestSkipped('Cannot run in Live environment');
            return;
        }
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
}
