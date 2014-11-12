<?php

/**
 * First Utility Online Experience Smoke Tests
 * @copyright (c) 2014, First Utility
 * @author Leigh Mills
 * @author Ashley Kitson
 * @author Bade Adegboye
 */

/**
 * My Account Bills page object
 */
class MyAccountBillsPage extends MyAccount
{

    /**
     * Base uri for page
     * @var string
     */
    protected $baseUri = '/myaccount/bills';

    private $locators = array(
        'viewBillsTitle' => "//div[@class='module'][1]//h2[text()='Recent bills']",
        'billsList' => '//table[@id="customersBillsList"]/tbody/tr',
        'paymentsListTitle' => '//div[@class="sidebarItem module"]/h2[contains(text(),"Recent Payments")]',
        'paymentsList' => '//div[@class="sidebarItem module"]/table/tbody/tr[1]',
        'tariffTitle' => '//div[@id="tariff-information"]/following::div//h2[contains(text(),"My tariff")]'
    );

    public function verifyBills()
    {
        $this->checkForElement($this->locators['viewBillsTitle'], 'Cannot see bills list panel');

        return $this;
    }

    public function checkWeHaveBills()
    {
        $this->checkForElement($this->locators['billsList'], 'Cannot see list of bills');

        return $this;
    }

    public function verifyRecentPayments()
    {
        $this->checkForElement($this->locators['paymentsListTitle'], 'Cannot see payments panel');

        return $this;
    }

    public function checkWeHavePayments()
    {
        $this->checkForElement($this->locators['paymentsList'], 'Cannot see list of payments');

        return $this;
    }

    public function verifyTariffs()
    {
        $this->checkForElement($this->locators['tariffTitle'], 'Cannot see tariff panel');

        return $this;
    }
}
