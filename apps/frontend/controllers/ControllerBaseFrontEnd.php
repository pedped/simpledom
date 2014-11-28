<?php

namespace Simpledom\Frontend\Controllers;

use Simpledom\Frontend\BaseControllers\ControllerBase;

abstract class ControllerBaseFrontEnd extends ControllerBase {

    public function initialize() {
        parent::initialize();
    }

    public function loadSmallPriceOption() {


        $start = 0;
        $this->ejareRangeValues = array();
        for ($index = 50; $index < 1000; $index = $index + 50) {
            $this->ejareRangeValues[$start] = ($index / 1000);
            $start++;
        }
        for ($index = 1; $index < 5; $index = $index + 0.25) {
            $this->ejareRangeValues[$start] = $index;
            $start++;
        }
        for ($index = 5; $index < 20; $index = $index + 1) {
            $this->ejareRangeValues[$start] = $index;
            $start++;
        }
        for ($index = 20; $index <= 50; $index = $index + 5) {
            $this->ejareRangeValues[$start] = $index;
            $start++;
        }

        $start = 0;
        $this->rahnRangeValues = array();
        for ($index = 0; $index < 10; $index = $index + 1) {
            $this->rahnRangeValues[$start] = $index;
            $start++;
        }

        for ($index = 10; $index < 100; $index = $index + 10) {
            $this->rahnRangeValues[$start] = $index;
            $start++;
        }

        for ($index = 100; $index < 300; $index = $index + 25) {
            $this->rahnRangeValues[$start] = $index;
            $start++;
        }
        for ($index = 300; $index <= 500; $index = $index + 50) {
            $this->rahnRangeValues[$start] = $index;
            $start++;
        }

        $start = 0;
        $this->saleRangeValues = array();
        for ($index = 0; $index < 10; $index = $index + 1) {
            $this->saleRangeValues[$start] = $index;
            $start++;
        }

        for ($index = 10; $index < 100; $index = $index + 10) {
            $this->saleRangeValues[$start] = $index;
            $start++;
        }

        for ($index = 100; $index < 300; $index = $index + 25) {
            $this->saleRangeValues[$start] = $index;
            $start++;
        }
        for ($index = 300; $index < 500; $index = $index + 50) {
            $this->saleRangeValues[$start] = $index;
            $start++;
        }
        for ($index = 500; $index < 1000; $index = $index + 100) {
            $this->saleRangeValues[$start] = $index;
            $start++;
        }
        for ($index = 1; $index < 20.5; $index = $index + 0.5) {
            $this->saleRangeValues[$start] = $index * 1000;
            $start++;
        }

        $this->view->smallPriceOptions = $this->ejareRangeValues;
        $this->view->salePriceOptions = $this->saleRangeValues;
        $this->view->largePriceOptions = $this->rahnRangeValues;
    }

}
