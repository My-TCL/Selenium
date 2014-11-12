<?php

/**
 * First Utility Online Experience Smoke Tests
 * @copyright (c) 2014, First Utility
 * @author Ashley Kitson
 * Don't forget to run `composer update` to add your new class - and then remove this line!
 */

/**
 * Page Header page object
 */
class Header extends MyAccount
{

    /**
     * Base uri for page
     * @var string
     */
    protected $baseUri = '/';

    protected $navLinks = array(
        array("/energy/", "Home Energy"),
        array("/energy/compare-tariffs/", "Compare tariffs"),
        array("/energy/switching-explained/", "Switching explained"),
        array("/energy/submit-a-meter-read/", "Submit a meter read"),
        array("/energy/compare-tariffs/", "Switch Now"),
        array("/about-us/", "About Us"),
        array("/about-us/who-and-why/", "What makes us different"),
        array("/about-us/service/", "Service"),
        array("/about-us/saving/", "Saving"),
        array("/about-us/technology/", "Technology"),
        array("/about-us/company/", "Company"),
        array("/contact-us", "Contact Us"),
        array("/about-us/careers/", "Careers"),
        array("/the-utility-room", "Blog"),
        array("/help", "Help & Advice"),
        array("/help/My_Account", "My account"),
        array("/help/Bills_and_Payments", "Bills & payments"),
        array("/help/My_Meter", "My meter"),
        array("/help/Tariffs", "Tariffs"),
        array("/help/Switching_to_First_Utility", "Switching"),
        array("/myaccount/registration", "My registration"),
        array("/help/Emergency_Information", "Emergencies"),
        array("/business-energy/", "Business"),
    );

    protected $locators = array(
        'weblogon' => "//ul[@class='main_nav']//li[contains(@class,'hide-for-small')]//a[contains(text(),'Log in')]",
        'mobilelogon' => "//ul[@class='main_nav']//li[contains(@class,'hide-for-medium-up')]//a[contains(text(),'Log in')]",
        'hamburger' => "//div[contains(@class,'hamburger')]",
    );

    public function checkMenuLinks()
    {
        foreach ($this->navLinks as $link) {
            $this->checkMenuLink($link[0],$link[1]);
        }

        //The logon menu item depends on the screen format so:
        // we look for the normal browser one
        $this->checkForElement($this->locators['weblogon'], 'Cannot find web menu link')->click();
        // and the small format one (but don't click as it will fail because it's hidden
        $this->checkForElement($this->locators['mobilelogon'], 'Cannot find hidden mobile menu logon link');

        //check that the mobile hamburger menu exists
        $this->checkForElement($this->locators['hamburger'], 'Cannot find hidden mobile menu hamburger');

        return $this;
    }

    public function checkSearchBoxExists()
    {
        $this->checkForElement("//form[@name='siteSearch']", "Menu search box not found");

        return $this;
    }

    /**
     * Check that a menu link is there and displays
     * @param string $uri
     * @param string $label
     */
    protected function checkMenuLink($uri, $label)
    {
        //TODO: What is this $uri for?
        $xpath = "//ul[@class='main_nav']//a[contains(text(), '{$label}')]";
        $link = $this->checkForElement($xpath, "Cannot find menu link '{$label}'");
        $link->click();
    }

}
