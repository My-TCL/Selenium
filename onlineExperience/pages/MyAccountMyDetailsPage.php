<?php
/**
 * First Utility Online Experience Smoke Tests
 * @copyright (c) 2014, First Utility
 * @author Leigh Mills
 * @author Ashley Kitson
 * @author Bade Adegboye
 */

/**
 * My Account Customer details page object
 */
class MyAccountMyDetailsPage extends MyAccount
{
    /**
     * Base uri for page
     * @var string
     */
    protected $baseUri = '/myaccount/details';

    private $locators = array(
        'headers' => array(
            'supplyAddressHeader' => "//div[@class='module']//h3[text()='My supply address']",
            'contactDetailsHeader' => "//div[@id='contactDetails']//h3[text()='My contact details']",
            'changePasswordHeader' => "//div[@id='password']//h3[text()='Change my password']",
            'bankDetailsHeader' => "//div[@id='bank']//h3[text()='Change my bank details']",
        ),
        'lightBoxSuccess' => "//span[@class='sprite-me success']",
        'lightboxClose' => "//a[contains(concat(' ',normalize-space(@class),' '), 'close-lightBoxing')]",
        'emailAddress' => "//input[@id='ChangeDetailsForm_email']",
        'homeTelNum' => "input[@id='ChangeDetailsForm_homeTel']",
        'changeDetailsSubmit' => "//form[@id='frmChangeDetails']//input[@type='submit']",
        'signOut' => "//ul[@class='main_nav']//li/a[contains(text(),'Log out')]",
    );

    private $validationData = array(
        'email' => '',
        'testEmail' => 'testemail@first-utility.com',
        'telnum' => '',
        'testTelnum' => '020 617 4351'
    );


    /**
     * Check page is loaded
     * @return \MyAccountMyDetailsPage
     */
    public function verifyPageIsLoaded()
    {
        foreach ($this->locators['headers'] as $name => $headerXpath) {
            $this->checkForElement($headerXpath, "Details page header '{$name}' not found");
        }

        return $this;
    }

    public function checkICanChangeMyContactDetails()
    {
        $this->checkICanChangeEmail();

        return $this;
    }

    public function checkICanChangeHomeTelNum()
    {
        $this->changeHomeTelNum();
        $this->revertHomeTelNum();

        return $this;
    }

    /**
     * Check we can change the email address
     * @return \MyAccountMyDetailsPage
     */
    public function checkICanChangeEmail()
    {
        $this->changeEmail();
        $this->revertEmail();

        return $this;
    }

    protected function changeEmail()
    {
        //change personal details ( email address ) is available and complete
        $userEmailAddressEl = $this->checkForElement($this->locators['emailAddress'], 'Email address input not found');
        $userEmailAddressText =  $userEmailAddressEl->getAttribute('value');
        if ($userEmailAddressText != '') {
            //save for later
            $this->validationData['email'] = $userEmailAddressText;
        } else {
            $this->testCase->fail('Cannot locate valid email address to save for test');
        }

        //change to test email
        $userEmailAddressEl->clear();
        $userEmailAddressEl->sendKeys(array($this->validationData['testEmail']));

        $this->confirmEmailChange();
    }


    protected function revertEmail()
    {
        //change back to original email
        //NB - you have to pick up the element twice - once to clear and then to send test
        $ele = $this->checkForElement($this->locators['emailAddress'],'Email address input not found')
            ->clear();
        $ele = $this->checkForElement($this->locators['emailAddress'],'Email address input not found')
            ->sendKeys(array($this->validationData['email']));

        $this->confirmEmailChange();
    }

    protected function confirmEmailChange()
    {
        //click submit
        $this->checkForElement($this->locators['changeDetailsSubmit'], 'Change details submit button not found')
                ->click();

        //confirm success
        $this->setDefaultTimeoutForFinds(10000);
        $this->checkForElement($this->locators['lightBoxSuccess'],'Success lightbox not seen');
        $this->setDefaultTimeoutForFinds();

        //close lightbox
        $this->checkForElement($this->locators['lightboxClose'], 'Success lightbox button not found')
                ->click();
    }

    protected function changeHomeTelNum()
    {
        $ele = $this->checkForElement($this->locators['homeTelNum'], 'Home telephone input not found');
        $telnum =  $userEmailAddressEl->getAttribute('value');
        if ($telnum != '') {
            //save for later
            $this->validationData['telnum'] = $telnum;
        } else {
            $this->validationData['telnum'] = '';
        }

        //change to test telnum
        $ele->clear();
        $ele->sendKeys(array($this->validationData['testTelnum']));

        $this->confirmEmailChange();
    }

    protected function revertHomeTelNum()
    {
        //NB - you have to pick up the element twice - once to clear and then to send test
        $ele = $this->checkForElement($this->locators['homeTelNum'],'Home telephone  input not found')
            ->clear();
        $ele = $this->checkForElement($this->locators['homeTelNum'],'Home telephone  input not found')
            ->sendKeys(array($this->validationData['telnum']));

        $this->confirmEmailChange();
    }
}