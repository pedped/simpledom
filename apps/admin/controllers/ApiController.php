<?php

namespace Simpledom\Admin\Controllers;

use Product;
use Simpledom\Admin\BaseControllers\ApiControllerBase;
use UserPhone;

class ApiController extends ApiControllerBase {

    public function verifyphoneAction($phoneid) {
        if (!isset($phoneid)) {
            return false;
        }

        $phone = UserPhone::findFirst(array("id = :id:", "bind" => array("id" => $phoneid)));
        $phone->verified = 1;
        return $phone->save();
    }

    public function listproductsAction() {
        $term = $_GET["term"];
        $items = Product::find(array("title LIKE CONCAT('%' ,  :title: , '%' ) ", "bind" => array("title" => $term)));

        $result = array();
        foreach ($items as $value) {
            $k = new \stdClass();
            $k->label = $value->title;
            $k->id = $value->id;
            $k->name = $value->id;
            $result[] = $k;
        }
        
        echo json_encode($result);
    }

}
