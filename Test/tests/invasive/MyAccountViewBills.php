<?php
/**
 * First Utility Online Experience Smoke Tests
 * @copyright (c) 2014, First Utility
 * @author Leigh Mills
 * @author Ashley Kitson
 * @author Bade Adegboye
 */

/**
 * View bills functional tests
 *
 * @author Leigh Mills <leigh.mills@first-utility.com>
 * @author Bade Adegboye <bade.adegboye@first-utility.com>
 */
class MyAccountViewBills extends CWebDriverTestCase {
    protected $userData;

    protected function setUp()
    {
        //data
        $dataProvider =   new WebsiteDataProvider('MyAccountCrawlData',DATADIR);
        $this->userData = $dataProvider->getTestData();
        parent::setUp(SELHOST, SELPORT);

    }

    public function testViewBills()
    {
        $myAccountLoginPage = new MyAccountLoginPage($this->webdriver, $this);
        $myAccountLoginPage->open();
        $myAccountLoginPage->verifyPageIsLoaded($this);
        $myAccountLoginPage->enterUserId($this->userData);
        $myAccountLoginPage->enterUserPassword($this->userData);
        $myAccountLoginPage->clickButton();
        $myAccountLoginPage->verifyDashboardPageIsLoaded($this);

        $myAccountViewBillsPage = new MyAccountViewBillsPage($this->webdriver);
        $myAccountViewBillsPage->open();
        $myAccountViewBillsPage->verifyPageIsLoaded($this);
        $myAccountViewBillsPage->clickSignOut();
    }

}