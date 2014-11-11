<?php

/**
 * First Utility Omline Experience Smoke Tests
 * @copyright (c) 2014, First Utility
 * @author Leigh Mills
 * @author Ashley Kitson
 * @author Bade Adegboye
 */

/**
 * My Account Dashboard page object
 */
class MyAccountDashboardPage extends MyAccount
{

    /**
     * Base uri for page
     * @var string
     */
    protected $baseUri = '/myaccount/energy';
    private $locators = array(
        'elecGraphPartial' => '//div[@class="module" and @data-bind="visible: roles.elecCustomer"]',
        'gasGraphPartial' => '//div[@class="module" and @data-bind="visible: roles.gasCustomer"]',
        'meterReadTitle' => "//div[@class='module']//h2[contains(text(),'Meter reading')]",
        'latestBillTitle' => "//div[@class='module']//h2[contains(text(),'Latest bill')]",
        'myTariffTitle' => "//div[@class='module']//h2[contains(text(),'My tariff')]",
        'signOut' => "//ul[@class='main_nav']//li/a[contains(text(),'Log out')]",
        'elecUsageButton' => "//div[contains(@class,'usageBtn') and contains(@class,'electricity')]//a",
        'gasUsageButton' => "//div[contains(@class,'usageBtn') and contains(@class,'gas')]//a",
        'previousReadsButton' => "//div/a[contains(@class,'button') and @href='/myaccount/viewreads#reads']",
        'submitReadingButton' => "//div/a[contains(@class,'button') and @href='/myaccount/viewreads']",
        'viewBillsButton' => "//div/a[contains(@class,'button') and @href='/myaccount/bills']",
        'manualPaymentButton' => "//div/a[contains(@class,'button') and @href='/myaccount/payments/manualpayment']",
        'fullTariffButton' => "//div/a[contains(@class,'button') and @href='/myaccount/bills#tariff-information']",
        'mobilePromo' => '//div[contains(@class,"mobile-promo")]',
    );

    public function verifyElecGraphPartial()
    {
        $this->checkForElement($this->locators['elecGraphPartial'], 'Cannot find elec graph');

        return $this;
    }

    public function verifyGasGraphPartial()
    {
        $this->checkForElement($this->locators['gasGraphPartial'], 'Cannot find gas graph');

        return $this;
    }

    public function checkMeterReadPartialHeading()
    {
        $this->checkForElement($this->locators['meterReadTitle'], 'Cannot find Meter reading panel');

        return $this;
    }

    public function checkLatestBillPartialHeading()
    {
        $this->checkForElement($this->locators['latestBillTitle'], 'Cannot find Bills panel');

        return $this;
    }

    public function checkMyTariffPartialHeading()
    {
        $this->checkForElement($this->locators['myTariffTitle'], 'Cannot find Tariffs panel');

        return $this;
    }

    public function checkMobilePromoBox()
    {
        $this->checkForElement($this->locators['mobilePromo'], 'Cannot find mobile promotion display');

        return $this;
    }

    public function clickSignOut()
    {
        $el = $this->checkForElement($this->locators['signOut'], 'Cannot find logout menu item');
        $el->click();

        return $this;
    }

    public function navigateToElecUsageGraph()
    {
        $el = $this->checkForElement($this->locators['elecUsageButton'], 'Cannot click elec usage graph button');
        $el->click();

        return $this;
    }

    public function navigateToGasUsageGraph()
    {
        $el = $this->checkForElement($this->locators['gasUsageButton'], 'Cannot click gas usage graph button');
        $el->click();

        return $this;
    }

    public function navigateToViewPreviousReads()
    {
        $el = $this->checkForElement($this->locators['previousReadsButton'], 'Cannot click previous reads button');
        $el->click();

        return $this;
    }

    public function navigateToSubmitReading()
    {
        $el = $this->checkForElement($this->locators['submitReadingButton'], 'Cannot click submit reading button');
        $el->click();

        return $this;
    }

    public function navigateToViewBills()
    {
        $el = $this->checkForElement($this->locators['viewBillsButton'], 'Cannot click view bills button');
        $el->click();

        return $this;
    }

    public function navigateToManualPayment()
    {
        $el = $this->checkForElement($this->locators['manualPaymentButton'], 'Cannot click manual payment button');
        $el->click();

        return $this;
    }

    public function navigateToFullTariffInfo()
    {
        $el = $this->checkForElement($this->locators['fullTariffButton'], 'Cannot click full tariff info button');
        $el->click();

        return $this;
    }

}
