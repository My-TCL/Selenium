<?php

/**
 * First Utility Online Experience Smoke Tests
 * @copyright (c) 2014, First Utility
 * @author Leigh Mills
 * @author Ashley Kitson
 * @author Bade Adegboye
 */

/**
 * My Account Change Tariff page object
 */
class MyAccountChangeTariffPage extends MyAccount
{

    /**
     * Base uri for page
     * @var string
     */
    protected $baseUri = '/myaccount/changetariff';

    private $locators = array(
        'tariffChangeForm' => '//form[@id="frmSelectTariff"]',
        'currentTariff' => '//div/h2[contains(text(), "My current tariff")]'
    );

    public function verifyTariffChangeForm()
    {
        $this->checkForElement($this->locators['tariffChangeForm'], 'Cannot see change tariff form');

        return $this;
    }

    public function checkWeHaveCurrentTariff()
    {
        $this->checkForElement($this->locators['currentTariff'], 'Cannot see current tariff');

        return $this;
    }
}
