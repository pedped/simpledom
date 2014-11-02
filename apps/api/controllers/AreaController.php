<?php

namespace Simpledom\Api\Controllers;

use Area;
use BaseUser;

class AreaController extends ControllerBase {

    public function getAction($id) {
        return $this->getResponse(BaseUser::findFirst($id)->getPublicResponse());
    }

    public function listwithnameAction($cityid, $query = null, $limit = "10") {


        $limit = (int) $limit;
        if ($limit == 0)
            $limit = 10;

        $items = Area::find(array(
                    "cityid = :cityid: AND name LIKE CONCAT('%' , :query: , '%')",
                    'limit' => $limit,
                    'order' => "name ASC",
                    "bind" => array(
                        "cityid" => $cityid,
                        "query" => $query,
        )));
        $results = array();
        foreach ($items as $city) {
            $results[$city->name] = $city->name;
        }
        return $this->getResponse($results);
    }

}
