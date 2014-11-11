<?php
/**
 * First Utility Omline Experience Smoke Tests
 * @copyright (c) 2014, First Utility
 * @author Ashley Kitson
 */

/**
 * OE crawl
 */
class OECrawlTest extends CWebDriverTestCase {

    /**
     * @var array
     */
    protected $userData;

    /**
     * @var int
     */
    protected $defaultTimeoutForFinds = 5000; //5 seconds
    /**
     * @var int
     */
    protected $upperTimeoutForFinds = 10000; //10 seconds

    /**
     *
     * @var \BasePage
     */
    protected $pageObject;

    protected $pagesToLoad = array(
		'ops/login',
		'noservice',
		'the-utility-room/author/debbie-attwoodfirst-utility-com',
		'the-utility-room/search',
		'the-utility-room/super-league',
		'energy/changing-tariff',
		'energy/submit-a-meter-read',
		'about-us/service/reviews/customer-feedback',
		'vendor/contact-us-sme',
//		'vendor/e/<data>',
//		'vendor/<vendor>',
		'about-us/press',
		'business-energy',
		'cancellation-call-me',
		'careers/work-for-us',
//		'error/<error>',
		'error',
		'get-involved',
		'home-energy/vcform',
		'node/1859/lightbox2',
		'refer-a-friend',
		'search/google',
		'tariff-guide-not-found',
    );

    protected $redirectedPages = array(
		'feed-in-tariff/annual-declaration' => 'feed-in-tariff/annual-declaration-failure',
		'feed-in-tariff-submit-quarterly-reads' => 'feed-in-tariff-submit-quarterly-reads/closed',
        //just because our locator doesn't parse the query params
        'search/google/?q=energy' => 'search/google/',
        'unsubscribe-marketing-emails?id=000000&email=james@tst.com' => 'unsubscribe-marketing-emails',
        );

    public function setUp()
    {
        parent::setUp(SELHOST, SELPORT);

        //data
        $dataProvider =   new WebsiteDataProvider(DATAFILE,DATADIR);
        $this->userData = $dataProvider->getTestData();
        $this->webdriver->manage()->timeouts()->implicitlyWait($this->defaultTimeoutForFinds);
        //Page objects
        $this->pageObject = new FreePage($this->webdriver, $this, LOCATION);

    }

    /**
     * Crawl publicly available page links to make sure page exists
     */
    public function testCrawl()
    {
        foreach($this->pagesToLoad as $link) {
            try {
                $this->pageObject
                        ->setBaseUri('/' . $link)
                        ->open();
            } catch (\Exception $e) {
                //fail individual page test but don't stop
                $this->fail($e->getMessage());
            }
        }
    }

    /**
     * Crawl public pages that redirect somewhere else
     */
    public function testRedirects()
    {
        foreach($this->redirectedPages as $link => $redirect) {
            try {
                $this->webdriver->get(BASEURL. '/' . $link);
                $this->pageObject
                    ->setBaseUri('/' . $redirect)
                    ->isLoaded();
            } catch (Exception $e) {
                //fail individual page test but don't stop
                $this->fail($e->getMessage());
            }

        }
    }

}
