<?php

namespace Simpledom\Frontend\Controllers;

use Area;
use City;
use Simpledom\Frontend\BaseControllers\IndexControllerBase;

class IndexController extends IndexControllerBase {

    public function indexAction() {
        parent::indexAction();
        $cities = City::find("captial = 1");
        $this->view->cities = $cities;

        // load area for cities
        $areas = array();
        foreach ($cities as $city) {
            $areas[$city->id] = Area::getHighestArea($city->id);
        }
        $this->view->cityAreas = $areas;
    }

}
