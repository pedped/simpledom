<?php

namespace Simpledom\Api\Controllers;

use BaseUser;
use City;

class CityController extends ControllerBase {

    public function getAction($id) {
        return $this->getResponse(BaseUser::findFirst($id)->getPublicResponse());
    }

    public function listAction($stateid) {
        $items = City::find(array("stateid = :stateid:", "bind" => array("stateid" => $stateid)));
        $results = array();
        foreach ($items as $city) {
            $results[$city->id] = $city->name;
        }
        return $this->getResponse($results);
    }

}
