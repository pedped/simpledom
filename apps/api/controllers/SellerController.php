<?php

namespace Simpledom\Api\Controllers;

use Product;
use stdClass;

class SellerController extends ControllerBase {

    public function findbyproductidAction($productID) {
        if (!isset($productID) || intval($productID) == 0) {
            $this->errors[] = "کد محصول نا معتبر است";
            return $this->getResponse(false);
        }


        // load product
        $product = Product::findFirst(array("id = :id:", "bind" => array("id" => $productID)));
        if (!$product) {
            $this->errors[] = "محصول نا معتبر است";
            return $this->getResponse(false);
        }

        // load seller
        return $this->getResponse($product->getSeller()->getPublicResponse());
    }

    public function getcurrencylistAction() {

        $items = array();

        $item = new stdClass();
        $item->key = "IRR";
        $item->title = "ریال ایران";
        $items[] = $item;

        $item2 = new stdClass();
        $item2->key = "USD";
        $item2->title = "دلار آمریکا";
        $items[] = $item2;

        // send result
        return $this->getResponse($items);
    }

    public function getmoreproductsAction($productID) {


        if (!isset($productID) || intval($productID) == 0) {
            $this->errors[] = "کد محصول نا معتبر است";
            return $this->getResponse(false);
        }

        // load product
        $product = Product::findFirst(array("id = :id:", "bind" => array("id" => $productID)));
        if (!$product) {
            $this->errors[] = "محصول نا معتبر است";
            return $this->getResponse(false);
        }

        // find user products
        $start = (int) $_POST["start"];
        $limit = (int) $_POST["limit"];

        $products = Product::find(
                        array(
                            "userid = :userid: AND status = 1 AND id != :id:",
                            "bind" =>
                            array(
                                "userid" => $product->userid,
                                "id" => $productID,
                            )
                        )
        );

        // send products
        $results = array();
        foreach ($products as $product) {
            $results[] = $product->getPublicResponse();
        }
        return $this->getResponse($results);
    }

    public function getproductsAction() {

        // find user products
        $start = (int) $_POST["start"];
        $limit = (int) $_POST["limit"];

        $products = Product::find(
                        array(
                            "userid = :userid: AND status = 1",
                            "order" => "id DESC",
                            "limit" => "$start , $limit",
                            "bind" =>
                            array("userid" => $this->user->userid)
                        )
        );

        // send products
        $results = array();
        foreach ($products as $product) {
            $results[] = $product->getPublicResponse();
        }
        return $this->getResponse($results);
    }

}
