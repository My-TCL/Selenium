<?php
/**
 * First Utility Online Experience Smoke Tests
 * @copyright (c) 2014, First Utility
 * @author Leigh Mills
 * @author Ashley Kitson
 * @author Bade Adegboye
 */

/**
 * My Account meter readings page object
 */
class MyAccountSubmitReadingPage extends MyAccount
{

    /**
     * Base uri for page
     * @var string
     */
    protected $baseUri = '/myaccount/viewreads';

    private $locators = array(
        'elecDate' => 'ElecSubmitReadForm_date',
        'gasDate' => 'GasSubmitReadForm_date',
        'elecSubmitBtn' => "//form[@id='mpanFrmSubmitread']//input[@name='submit']",
        'gasSubmitBtn' => "//form[@id='mprnFrmSubmitread']//input[@name='submit']",
        'lightboxClose' => "//a[contains(concat(' ',normalize-space(@class),' '), 'close-lightBoxing')]",
        'submit' => 'submit',
    );

    private $validationData = array(
    );

    public function verifyElecTabIsClickable()
    {
        $tab = $this->webdriver->findElementBy(LocatorStrategy::xpath, '//ul[@data-tabs="nav"]/li/a[text() = "Electricity"]');
        $this->testCase->assertNotNull($tab);

        return $this;
    }

    public function verifyGasTabIsClickable()
    {
        $tab = $this->webdriver->findElementBy(LocatorStrategy::xpath, '//ul[@data-tabs="nav"]/li/a[text() = "Gas"]');
        $this->testCase->assertNotNull($tab);

        return $this;
    }

    public function verifySuccessfulElectricityReadSubmission()
    {
        $tab = $this->webdriver->findElementBy(LocatorStrategy::xpath, '//ul[@data-tabs="nav"]/li/a[text() = "Electricity"]');
        //click tab
        $tab->click();

        //get reads advice
        $readsAdviceNode = $this->webdriver->findElementBy(LocatorStrategy::xpath,
                "//form[contains(@class, 'MPAN')]/fieldset/div[@class='form-item']//small[contains(@data-bind,'displayReadsGuide')]");
        $readsGuide = json_decode(str_replace("displayReadsGuide:", "", $readsAdviceNode->getAttribute("data-bind")));

        //enter read
        $readElement = $this->webdriver->findElementBy(LocatorStrategy::id, $readsGuide->id);
        $newRead = (string)(str_pad($readsGuide->min + 1, $readsGuide->digits, "0", STR_PAD_LEFT));
        $readElement->sendKeys(array($newRead));

        //enter read date
        $dt = new \DateTime();
        $dt->sub(new \DateInterval('P1D')); //use yesterdays date
        $readDate = $dt->format('d/m/Y');
        $readDateElement = $this->webdriver->findElementBy(LocatorStrategy::id, $this->locators['elecDate']);
        $readDateElement->sendKeys(array((string)$readDate));

        //submit form
        $submitElement = $this->webdriver->findElementBy(LocatorStrategy::xpath, $this->locators['elecSubmitBtn']);
        $submitElement->click();

        //confirm success
        $successElement = $this->webdriver->findElementBy(LocatorStrategy::xpath, "//span[@class='sprite-me success']");
        $this->testCase->assertNotNull($successElement);

        return $this;
    }

    public function verifySuccessfulGasReadSubmission()
    {
        $tab = $this->webdriver->findElementBy(LocatorStrategy::xpath, '//ul[@data-tabs="nav"]/li/a[text() = "Gas"]');
        //click tab
        $tab->click();

        //get reads advice
        $readsAdviceNode = $this->webdriver->findElementBy(LocatorStrategy::xpath,
                "//form[contains(@class, 'MPRN')]/fieldset/div[@class='form-item']//small[contains(@data-bind,'displayReadsGuide')]");
        $readsGuide = json_decode(str_replace("displayReadsGuide:", "", $readsAdviceNode->getAttribute("data-bind")));

        //enter read
        $readElement = $this->webdriver->findElementBy(LocatorStrategy::id, $readsGuide->id);
        $newRead = (string)(str_pad($readsGuide->min + 1, $readsGuide->digits, "0", STR_PAD_LEFT));
        $readElement->sendKeys(array($newRead));

        //enter read date
        $dt = new \DateTime();
        $dt->sub(new \DateInterval('P1D')); //use yesterdays date
        $readDate = $dt->format('d/m/Y');
        $readDateElement = $this->webdriver->findElementBy(LocatorStrategy::id, $this->locators['gasDate']);
        $readDateElement->sendKeys(array((string)$readDate));

        //submit form
        $submitElement = $this->webdriver->findElementBy(LocatorStrategy::xpath, $this->locators['gasSubmitBtn']);
        $submitElement->click();

        //confirm success
        $successElement = $this->webdriver->findElementBy(LocatorStrategy::xpath, "//span[@class='sprite-me success']");
        $this->testCase->assertNotNull($successElement);

        //close lightbox
        $this->webdriver->findElementBy(LocatorStrategy::xpath,$this->locators['lightboxClose'])->click();

        return $this;
    }

}