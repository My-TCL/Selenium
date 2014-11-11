<?php

/**
 * First Utility Online Experience Smoke Tests
 * @copyright (c) 2014, First Utility
 * @author Ashley Kitson
 * Don't forget to run `composer update` to add your new class - and then remove this line!
 */

/**
 * Page footer page object
 */
class Footer extends MyAccount
{

    /**
     * Base uri for page
     * @var string
     */
    protected $baseUri = '/';
    //these are lifted straight out of the NavigationFooter widget
    //if you update that, update this!
    //NB - some items are hand amended to deal with redirects that happen, and other spurious urls
    // - originals commented out
    private $locators = array(
        array(
            'label' => '<a href="https://twitter.com/first_utility"><span class="sprite-me marginr-10 left twitter" ></span> Twitter</a>',
            'itemOptions' => array('class' => 'columns no-cube large-3 white'),
            'items' => array(
//                array('label' => 'Affiliates', 'url' => array('/about-us/company/affiliates/')),
                array('label' => 'Affiliates', 'url' => array('/about-us/company/affiliates')),
                array('label' => 'Careers', 'url' => array('/about-us/careers')),
                array('label' => 'Cheap dual fuel', 'url' => array('/cheap-dual-fuel')),
                array('label' => 'Cheapest electricity supplier', 'url' => array('/cheapest-electricity-supplier')),
                array('label' => 'Compare gas and electricity', 'url' => array('/compare-gas-and-electricity')),
            ),
        ),
        array(
            'label' => '<a href="http://www.youtube.com/user/firstutility"><span class="sprite-me marginr-10 left youtube" ></span> YouTube</a>',
            'submenuOptions',
            'itemOptions' => array('class' => 'columns no-cube large-3 white'),
            'items' => array(
                array('label' => 'Compare our tariffs', 'url' => array('/energy/compare-tariffs')),
//                array('label' => 'Complaints', 'url' => array('/about-us/service/how-we-handle-complaints/')),
                array('label' => 'Complaints', 'url' => array('/about-us/service/how-we-handle-complaints')),
                array('label' => 'Contact us', 'url' => array('/contact-us')),
//                array('label' => 'How to use your online account', 'url' => array('/energy/your-online-account')),
                array('label' => 'How to use your online account', 'url' => array('/help/My+Account/__ka1D0000000031aIAA/What-can-I-do-in-My-Account')),
//                array('label' => 'Electric prices', 'url' => array('/tariffs/electric-prices')),
                array('label' => 'Electric prices', 'url' => array('/electric-prices')),
            ),
        ),
        array(
            'label' => '<a href="http://www.linkedin.com/company/379026?trk=tyah"><span class="sprite-me marginr-10 left linkedin" ></span> LinkedIn</a>',
            'submenuOptions',
            'itemOptions' => array('class' => 'columns no-cube large-3 white'),
            'items' => array(
                array('label' => 'Electric suppliers', 'url' => array('/energy-suppliers')),
                array('label' => 'Energy monitor', 'url' => array('/energy-monitor')),
                array('label' => 'Energy meters', 'url' => array('/energy-meters')),
//                array('label' => 'Help and advice', 'url' => array('/help-and-advice')),
                array('label' => 'Help and advice', 'url' => array('/help/')),
                array('label' => 'Understand your energy bill', 'url' => array('/energy/understanding-your-bill')),
            ),
        ),
        array(
            'label' => '<a href="https://twitter.com/first_utilitycs"><span class="sprite-me marginr-10 left twitter" ></span> Customer Service</a>',
            'submenuOptions',
            'itemOptions' => array('class' => 'columns no-cube large-3 white last'),
            'items' => array(
//                array('label' => 'Our fuel mix', 'url' => array('/about-us/saving/energy-saving/our-fuel-mix/')),
                array('label' => 'Our fuel mix', 'url' => array('/about-us/saving/energy-saving/our-fuel-mix')),
//                array('label' => 'Our policies', 'url' => array('/about-us/service/our-policies/')),
                array('label' => 'Our policies', 'url' => array('/about-us/service/our-policies')),
                array('label' => 'Switch electricity', 'url' => array('/switch-electricity')),
                array('label' => 'Switch gas', 'url' => array('/switch-gas')),
                array('label' => 'Switching to us', 'url' => array('/energy/switching-explained')),
            ),
        ),
    );

    /**
     *
     * @var array static footer links
     */
    protected $staticLinks = array(
        'Terms & Conditions' => '/domestic-terms-and-conditions',
        'Business Terms & Conditions' => '/business-terms-and-conditions',
        'Website Terms of Use' => '/terms-of-use',
        'Privacy' => '/privacy',
        'Cookie Policy' => '/our-cookie-policy',
        'Accessibility' => '/accessibility'
    );

    /**
     * Check the main block of footer links
     * @return \Footer
     */
    public function checkFooterLinks()
    {
        foreach ($this->locators as $section) {
            $this->checkSocialLink($section['label']);
            foreach($section['items'] as $item) {
                $this->checkItemLink($item);
            }
        }

        return $this;
    }

    /**
     * Check the static page base footer links
     * @return \Footer
     */
    public function checkStaticLinks()
    {
        foreach ($this->staticLinks as $label => $uri) {
            $xpath = "//footer//a[contains(text(), '{$label}')]";
            $link = $this->checkForElement($xpath, "Cannot find footer link '{$label}'");
            $link->click();
            $this->checkForUri($uri);
            $this->open();
        }

        return $this;
    }

    /**
     * Check that a social link is on the page
     * Do not navigate to it
     * @param string $label
     */
    protected function checkSocialLink($label)
    {
        $matches = array();
        if (preg_match('/href="(?P<url>.*)"\>.*span\> (?P<text>.*)\</', $label, $matches) == 1) {
            $xpath = "//footer//a[@href='{$matches['url']}' and contains(text(), '{$matches['text']}')]";
            $this->checkForElement($xpath, "Cannot find footer social link '{$matches['text']}'");
        }
    }

    /**
     * Check that an internal link is there and displays
     * @param array $item
     */
    protected function checkItemLink(array $item)
    {
        $uri = $item['url'][0];
        $xpath = "//footer//a[contains(text(), '{$item['label']}')]";
        $link = $this->checkForElement($xpath, "Cannot find footer link '{$item['label']}'");
        $link->click();
        $this->checkForUri($uri);
        $this->open();
    }
}
