<?php
/**
 * First Utility Online Experience Smoke Tests
 * @copyright (c) 2014, First Utility
 * @author Leigh Mills
 * @author Ashley Kitson
 * @author Bade Adegboye
 */

/**
 * My details functional tests
 *
 * @author Bade Adegboye <bade.adegboye@first-utility.com>
 */
class MyAccountSubmitReading extends CWebDriverTestCase {
    protected $userData;

    protected function setUp()
    {
        //data
        $dataProvider =   new WebsiteDataProvider('MyAccountCrawlData',DATADIR);
        $this->userData = $dataProvider->getTestData();
        parent::setUp(SELHOST, SELPORT);

    }

    public function testMyDetails()
    {
        $myAccountLoginPage = new MyAccountLoginPage($this->webdriver, $this);
        $myAccountLoginPage->open();
        $myAccountLoginPage->verifyPageIsLoaded($this);
        $myAccountLoginPage->enterUserId($this->userData);
        $myAccountLoginPage->enterUserPassword($this->userData);
        $myAccountLoginPage->clickButton();
        $myAccountLoginPage->verifyDashboardPageIsLoaded($this);

        $myAccountMyDetailsPage = new MyAccountMyDetailsPage($this->webdriver, $this);
        $myAccountMyDetailsPage->open();
        $myAccountMyDetailsPage->verifyPageIsLoaded($this);
        $myAccountMyDetailsPage->verifyChangeOfPersonalDetails($this);

        //sign out
        $myAccountMyDetailsPage->clickSignOut();
    }

}
