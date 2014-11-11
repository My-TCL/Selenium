<?php
/**
 * First Utility Online Experience Smoke Tests
 * @copyright (c) 2014, First Utility
 * @author Leigh Mills
 * @author Ashley Kitson
 * @author Bade Adegboye
 */

/**
 * COT functional tests
 *
 * @author Bade Adegboye <bade.adegboye@first-utility.com>
 * @author Leigh Mills <leigh.mills@first-utility.com>
 */
class MyAccountCot extends CWebDriverTestCase {
    protected $userData;

    public function setUp()
    {
        //data
        $dataProvider =   new WebsiteDataProvider('MyAccountCrawlData',DATADIR);
        $this->userData = $dataProvider->getTestData();
        parent::setUp(SELHOST, SELPORT);

    }

    public function testSubmitMeterRead()
    {
        $myAccountLoginPage = new MyAccountLoginPage($this->webdriver);
        $myAccountLoginPage->open();
        $myAccountLoginPage->verifyPageIsLoaded($this);
        $myAccountLoginPage->enterUserId($this->userData);
        $myAccountLoginPage->enterUserPassword($this->userData);
        $myAccountLoginPage->clickButton();
        $myAccountLoginPage->verifyDashboardPageIsLoaded($this);

        //navigate to Cot page for testing
        $myAccountCotPage = new MyAccountCotPage($this->webdriver);
        $myAccountCotPage->open();
        $myAccountCotPage->verifySuccessfulCotRequest($this);

        //sign out
        $myAccountCotPage->clickSignOut();
    }

}
