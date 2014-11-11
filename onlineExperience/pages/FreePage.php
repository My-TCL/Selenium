<?php
/**
 * First Utility Online Experience Smoke Tests
 * @copyright (c) 2014, First Utility
 * @author Ashley Kitson
 *
 */

/**
 * A 'free' page - can have its base uri set
 * - useful for crawling public pages
 */
class FreePage extends BasePage
{
    /**
     *
     * @param type $uri
     * @return \BasePageSet the base uri for the page
     */
    public function setBaseUri($uri)
    {
        $this->baseUri = $uri;
        return $this;
    }
}
