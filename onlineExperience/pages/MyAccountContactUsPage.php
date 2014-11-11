<?php
/**
 * First Utility Online Experience Smoke Tests
 * @copyright (c) 2014, First Utility
 * @author Ashley Kitson
 */

/**
 * My Account Contact Us page object
 * this is the page that displays for logged on users clicking the 'contact us'
 * 'My Account' sub menu item - Not the public form
 */
class MyAccountContactUsPage extends MyAccount
{

    /**
     * Base uri for page
     * @var string
     */
    protected $baseUri = '/myaccount/contact';

    private $locators = array(
        'form' => 'frmMyAccountContactUs',
        'fields' => array(
            'I am' => 'MyAccountContactUsForm_iAm',
            'enquiry topic' => 'MyAccountContactUsForm_enquiryTopic',
            'enquiry' => 'MyAccountContactUsForm_enquiry',
            'account number' => 'MyAccountContactUsForm_accountNumber',
            'first name' => 'MyAccountContactUsForm_firstName',
            'first name' => 'MyAccountContactUsForm_surName',
            'email address' => 'MyAccountContactUsForm_emailAddress',
            'postcode' => 'MyAccountContactUsForm_postcode'
        ),
        'submit' => 'logon',
    );

    private $prefilled = array(
        'account number', 'first name', 'surname', 'email address', 'postcode'
    );
    
    public function checkContactForm()
    {
        $strtgy = LocatorStrategy::id;
        $this->checkForElement($this->locators['form'], 'Cannot see contact form', $strtgy);
        foreach ($this->locators['fields'] as $name => $sel) {
            $ele = $this->checkForElement($sel, "Cannot see contact form element '{$name}'", $strtgy);
            if (in_array($name, $this->prefilled)) {
                $this->testCase->assertNotEmpty($ele->getValue(),"'{$name}' element should not be empty");
            }
        }
        
        return $this;
    }
}
