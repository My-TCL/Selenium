<?php
/**
 * First Utility Online Experience Smoke Tests
 * @copyright (c) 2014, First Utility
 * @author Leigh Mills
 * @author Ashley Kitson
 * @author Bade Adegboye
 */

/**
* Usage grapgh functional tests
*
* @author Bade Adegboye <bade.adegboye@first-utility.com>
* @author Leigh Mills <leigh.mills@first-utility.com>
*/
class MyAccountUsageGraph extends CWebDriverTestCase {

    protected $userData;

    protected function setUp()
    {
        //data
        $dataProvider =   new WebsiteDataProvider('MyAccountCrawlData',DATADIR);
        $this->userData = $dataProvider->getTestData();
        parent::setUp(SELHOST, SELPORT);

    }

    public function testUsageGraph()
    {
        $myAccountLoginPage = new MyAccountLoginPage($this->webdriver, $this);
        $myAccountLoginPage->open();
        $myAccountLoginPage->verifyPageIsLoaded($this);
        $myAccountLoginPage->enterUserId($this->userData);
        $myAccountLoginPage->enterUserPassword($this->userData);
        $myAccountLoginPage->clickButton();
        $myAccountLoginPage->verifyDashboardPageIsLoaded($this);

        $myAccountUsagePage = new MyAccountUsageGraphPage($this->webdriver);

        //elec
        $myAccountUsagePage->open('elecGraph');
        $myAccountUsagePage->verifyElecUsagePageIsLoaded($this);

        //gas
        $myAccountUsagePage->open('gasGraph');
        $myAccountUsagePage->verifyGasUsagePageIsLoaded($this);

        $myAccountUsagePage->clickSignOut();
    }
}
