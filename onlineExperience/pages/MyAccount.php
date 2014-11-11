<?php
/**
 * First Utility Omline Experience Smoke Tests
 * @copyright (c) 2014, First Utility
 * @author Ashley Kitson
 */

/**
 * My Account base page object
 * All My Account pages should extend from this
 */
/**
 * Base page for logged in My Account Pages
 */
abstract class MyAccount extends BasePage
{
    private $locators = array(
        'signOut' => "//ul[@class='main_nav']//li/a[contains(text(),'Log out')]",
        'accountNumber' => '//div[contains(@class,"page-heading")]/p[contains(@class,"sub-heading")]/strong[@class="userId"]',
    );

    public function checkAccountId()
    {
        $el = $this->checkForElement($this->locators['accountNumber'], 'Cannot find customer account id display');
        $this->testCase->assertNotEmpty($el->getText(), 'Customer account number is empty for page: ' . $this->pageNameAsTitle);

        return $this;
    }

    public function clickSignOut()
    {
        $element = $this->webdriver->findElementBy(LocatorStrategy::xpath,
                $this->locators['signOut']);
        $this->testCase->assertNotNull($element, 'Cannot find logout menu entry');
        $element->click();

        return $this;
    }
}
