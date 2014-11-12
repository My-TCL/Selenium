<?php
/**
 * First Utility Omline Experience Smoke Tests
 * @copyright (c) 2014, First Utility
 * @author Leigh Mills
 * @author Ashley Kitson
 * @author Bade Adegboye
 */

/**
 * My Account logon page object
 */
class MyAccountLoginPage extends BasePage
{

    /**
     * Base uri for page
     * @var string
     */
    protected $baseUri = '/login';

    /**
     * Locator strings used by this class
     * @var array
     */
    private $locators = array(
        'userId' => 'LogonForm_uid',
        'userPassword' => 'LogonForm_pwd',
        'loginButtonLocation' => "//form[@id='frmLogon']//input[@name='logon']",
        'headerLocation' => '/html/body/div/div/h1',
        'submitButtonName' => 'logon',
        'elecGraphPartial' => "//div[@id='electricity-graph-container']",
        'gasGraphPartial' => "//div[@id='gas-graph-container']",
        'userErrorMessage' => "//div[@id='LogonForm_uid_em_']",
        'passwordErrorMessage' => "//div[@id='LogonForm_pwd_em_']",
        'invalidLoginError' => "//ul[contains(@class,'flash-message')]//li[@class='error']",
        'multipleAccountErrorMessage' => '/html/body/div[4]/div/div/div[2]',
    );

    /**
     * Various strings we need to search for to validate pages
     * @var array
     */
    private $validationData = array(
        //Login page error messages
        'userIdError' => 'This information is required. Please enter your username, account number or email address.',
        'userPasswordError' => 'Please enter your password',
        'bothInError' => 'Incorrect username or password',
    );

    public function verifyPageIsLoaded()
    {
        $this->checkForElement($this->locators['loginButtonLocation'], 'Could not find login button');

        return $this;
    }

    public function enterUserId($uid)
    {
        $element = $this->checkForElement($this->locators['userId'], 'Cannot locate user id input', "id");
        $element->sendKeys($uid);

        return $this;
    }

    public function enterUserEmail($data)
    {
        $element = $this->checkForElement($this->locators['userId'], 'Cannot locate user id input', "id");
        $element->sendKeys($data['email']);

        return $this;
    }

    public function enterUserPassword($password)
    {
        $element = $this->checkForElement($this->locators['userPassword'], 'Cannot locate user password input', "id");
        $element->sendKeys($password);

        return $this;
    }


    public function checkUserErrorMessage()
    {
        sleep(5); //use sleep for JS checks
        $el = $this->checkForElement($this->locators['userErrorMessage'], 'Cannot see user error message');
        $msg = $el->getText();
        $this->testCase->assertEquals(
                $this->validationData['userIdError'],
                $msg,
                "Error message does not match expected message");

        return $this;
    }

    public function checkPasswordErrorMessage()
    {
        sleep(5); //use sleep for JS checks
        $el = $this->checkForElement($this->locators['passwordErrorMessage'],'Cannot see password error message' );
        $this->testCase->assertTrue(
                preg_match("/" . $this->validationData['userPasswordError'] . "/",
                        $el->getText()) > 0
        );

        return $this;
    }

    public function checkInvalidLoginError()
    {
        sleep(5);
        $el = $this->checkForElement($this->locators['invalidLoginError'], 'Cannot see invalid logon error message');
        $this->testCase->assertEquals($this->validationData['bothInError'],
                $el->getText());

        return $this;
    }

    public function checkMultipleAccountErrorMessage()
    {
        $el = $this->checkForElement($this->locators['multipleAccountErrorMessage'], 'Cannot see multiple account error message');
        //TODO:: Where is this $data variable comming from?
        $this->testCase->assertEquals($data['multipleAccountError'],
                $el->getText());

        return $this;
    }

    public function clickButton()
    {
        $element = $this->checkForElement($this->locators['submitButtonName'], 'Cannot locate logon submit button', "name");
        $element->click();

        return $this;
    }
}
