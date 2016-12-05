<?php

namespace Simpledom\Api\Controllers;

use BaseUser;
use DBServer;
use Invoice;
use InvoiceProducts;
use PriceCalculator;
use Product;
use Simpledom\Core\Classes\Config;
use stdClass;
use UserNotification;

class UserController extends ControllerBase {

    public function hasorderinprogressAction() {
        return $this->getResponse($this->user->hasOrderInProgress() ? 1 : 0);
    }

    public function requestorderAction() {

        $products = json_decode($_POST["products"]);
        $homephone = $_POST["homephone"];
        $phone = $_POST["phone"];
        $address = $_POST["address"];
        $deliverTime = $_POST["delivertime"];


        $productsArray = array();
        foreach ($products as $item) {
            // load product
            $pro = Product::findFirst(array("id = :id:", "bind" => array("id" => $item->productid)));
            if ($pro != FALSE) {
                $productsArray[] = $pro;
            } else {
                // invalid product
                $this->errors[] = "یکی از محصلات مورد سفارش یافت نگردید";
                return $this->getResponse(false);
            }
        }


        // request price calculator calc the price
        $cost = PriceCalculator::CalcCost($products, $deliverTime);

        // create new invoice
        $invoice = new Invoice();
        $invoice->address = $address;
        $invoice->cityid = CITY_SHIRAZ;
        $invoice->currency = "IRR";
        $invoice->mobile = $phone;
        $invoice->phone = $homephone;
        $invoice->price = $cost->finalcost;
        $invoice->userid = $this->user->userid;
        if ($invoice->save()) {
            // we have to add items to the invoice products
            foreach ($products as $k) {
                // load product
                $product = Product::findFirst(array("id = :id:", "bind" => array("id" => $k->productid)));
                $item = new InvoiceProducts();
                $item->invoiceid = $invoice->id;
                $item->productid = $product->id;
                $item->count = $k->count;
                if (!$item->save()) {
                    // unable to add 
                    // TODO ERROR
                    $this->errors[] = "خطای داخلی رخ داده است" . $item->getMessagesAsLines();
                    return $this->getResponse(false);
                }
            }


            // we have successfuly added items to the list
            $invoice->status = INVOICESTATUS_REQUESTED;
            $invoice->save();

            // send result
            return $this->getResponse($invoice->id);
        } else {
            // TODO ERROR
            $this->errors[] = "خطای داخلی رخ داده است : " . $invoice->getMessagesAsLines();
            return $this->getResponse(false);
        }
    }

    public function getrecentinvocesAction() {
        return $this->getResponse( \Invoice::find(array(
                    "userid = :userid:",
                    "bind" => array("userid" => $this->user->userid),
                    "order" => "id DESC"
        )));
    }

    public function loadmyusualordersAction() {

        // we want to load user usual limit
        $topSalesDay = Config::TopUserUsualPurchaseLimit();

        // find the product list in the factor items 
        $productIDs = DBServer::LoadUserUsualProducts($this->user->userid, $topSalesDay);

        if (count($productIDs) > 0) {
            // convert them to string
            $pdis = implode(", ", $productIDs);
            $products = Product::find(array("id IN (" . $pdis . ")", "order" => "id DESC"));
        } else {
            $products = array();
        }
//        var_dump($pdis);
//        die();
        // load the product list
        // send back the products
        return $this->getResponse($products);
    }

    public function getcachAction() {
        $result = new stdClass();
        $result->usercach = $this->user->cach;

        // send back response
        return $this->getResponse($result);
    }

    public function getAction($id) {
        return $this->getResponse(BaseUser::findFirst($id)->getPublicResponse());
    }

    public function getnotificationAction() {

        // get last visit
        $lastvisit = $this->request->getPost("lastvisit");

        // check for last visit
        if (!isset($lastvisit) || strlen($lastvisit) == 0) {
            // return $this->getResponse(false);
            $lastvisit = 0;
        }

        // get new notfications
        $notification = UserNotification::findFirst(array("userid = :userid: AND enable = 1 AND visited = '0'", "order" => "id ASC", "bind" => array("userid" => $this->user->userid)));
        if (!$notification) {
            // there is no new notification
            return $this->getResponse(false);
        } else {
            // set viisted
            $notification->visited = "1";
            $notification->visitdate = time();
            $notification->visitip = $_SERVER["REMOTE_ADDR"];
            $notification->save();
        }

        // send notification
        return $this->getResponse($notification->getPublicResponse());
    }

}
