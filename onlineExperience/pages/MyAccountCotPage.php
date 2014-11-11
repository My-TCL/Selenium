<?php

/**
 * First Utility Online Experience Smoke Tests
 * @copyright (c) 2014, First Utility
 * @author Leigh Mills
 * @author Ashley Kitson
 * @author Bade Adegboye
 */

/**
 * My Account Change of Tariff page object
 */
class MyAccountCotPage extends MyAccount
{
    /**
     * Base uri for page
     * @var string
     */
    protected $baseUri = '/myaccount/house';
    
    private $locators = array(
        'moveDate' => 'CotForm_movingOutDate',
        'submit' => "//form[@id='frmHouseMove']//input[@type='submit']",
        'successMessageFinder' => "//div[@class='module']/div[@class='details']/p[1]",
        'signOut' => "//ul[@class='main_nav']//li/a[contains(text(),'Log out')]",
        'cotForm' => array(
            'form' => 'frmHouseMove',
            'moving date' => 'CotForm_movingOutDate',
            'final elec reading' => 'CotForm_finalElecRead0',
            'final gas reading' => 'CotForm_finalGasRead0',
            'incoming occupier name' => 'CotForm_incomingOccupierName',
            'incoming occupier contact' => 'CotForm_incomingOccupierContactNumber',
            'new address number' => 'CotForm_outgoingAddressLine1',
            'new address street 1' => 'CotForm_outgoingAddressLine2',
            'new address street 2' => 'CotForm_outgoingAddressLine3',
            'new address town' => 'CotForm_outgoingAddressLine4',
            'new address county' => 'CotForm_outgoingAddressLine5',
            'new address postcode' => 'CotForm_outgoingPostCode',
        )
    );
    private $validationData = array(
        "cotSuccessPattern" => "Thank-you for letting us know you're moving home",
    );

    public function checkCotForm()
    {
        $strategy = "id";
        $elements = $this->locators['cotForm'];
        $sel = array_shift($elements);
        $this->checkForElement($sel, 'Cannot see COT form', $strategy);
        foreach ($elements as $name => $sel) {
            $this->checkForElement($sel, "Cannot see COT form element '{$name}'", $strategy);
        }
        
        return $this;
    }
    
    public function verifySuccessfulCotRequest($test)
    {
        //enter date
        $dt = new \DateTime();
        $dt->add(new \DateInterval('P1D'));
        $readDate = $dt->format('d/m/Y');
        $readDateElement = $this->webdriver->findElement(WebDriverBy::id($this->locators['moveDate']));
        $readDateElement->sendKeys((string) $readDate);

        //submit form
        $submitElement = $this->webdriver->findElement(WebDriverBy::xpath($this->locators['submit']));
        $submitElement->click();

        //confirm success
        $this->webdriver->manage()->timeouts()->implicitlyWait(10000);
        $element = $this->webdriver->findElement(WebDriverBy::xpath($this->locators['successMessageFinder']));
        $test->assertTrue(
                preg_match("/" . $this->validationData['cotSuccessPattern'] . "/", $element->getText()) > 0
        );
        
        return $this;
    }

}
