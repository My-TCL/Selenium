<?php
/**
 * First Utility Online Experience Smoke Tests
 * @copyright (c) 2014, First Utility
 * @author Leigh Mills
 * @author Ashley Kitson
 * @author Bade Adegboye
 */

/**
 * Submit reads functional tests
 *
 * @author Bade Adegboye <bade.adegboye@first-utility.com>
 * @author Leigh Mills <leigh.mills@first-utility.com>
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

    public function testSubmitMeterRead()
    {
        $myAccountLoginPage = new MyAccountLoginPage($this->webdriver);
        $myAccountLoginPage->open();
        $myAccountLoginPage->verifyPageIsLoaded($this);
        $myAccountLoginPage->enterUserId($this->userData);
        $myAccountLoginPage->enterUserPassword($this->userData);
        $myAccountLoginPage->clickButton();
        $myAccountLoginPage->verifyDashboardPageIsLoaded($this);

        //navigate to Submit Reading for testing
        $myAccountSubmitReadingPage = new MyAccountSubmitReadingPage($this->webdriver);
        $myAccountSubmitReadingPage->open();
        $myAccountSubmitReadingPage->verifyElecTabIsClickable($this);
        $myAccountSubmitReadingPage->verifyGasTabIsClickable($this);
        $myAccountSubmitReadingPage->verifySuccessfulElectricityReadSubmission($this);
        $myAccountSubmitReadingPage->verifySuccessfulGasReadSubmission($this);

        //sign out
        $myAccountSubmitReadingPage->clickSignOut();
    }

}
