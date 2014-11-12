<?php

/**
 * Description of WebsiteDataProvider
 *
 * @author leigh mills
 */

class WebsiteDataProvider {

    Protected $providedData;
    Protected $dataPath;
    Protected $testDataName;
    Protected $data;
    Protected $defaultData;

    function __construct($testDataName, $dataPath) {
        $this->testDataName = $testDataName;
        $this->dataPath = realpath(__DIR__ . "/{$dataPath}") . '/';

    	$this->setDefaultData ();

        if ($this->loadDataFromFile($this->testDataName)) {
            $this->mergeData($this->testDataName);
        }
    }

    public function getTestData() {
    	return $this->data;
    }

    public function setDefaultData() {
        $this->defaultData = array();
    }

    private function loadDataFromFile($param) {
        try {
            $dataPath = $this->dataPath . $param . '.php';
            require $dataPath;
            $this->providedData = $data;
            return true;
        } catch (Exception $exc) {
            return false;
        }
    }

    private function mergeData($param) {
        $this->data = array_merge($this->defaultData, $this->providedData);
    }

}