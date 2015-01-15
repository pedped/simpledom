<?php

namespace Simpledom\Frontend\Controllers;

use AppDownload;
use Area;
use City;
use Simpledom\Core\Classes\Config;
use Simpledom\Core\Classes\Helper;
use Simpledom\Core\Classes\Order;
use Simpledom\Frontend\BaseControllers\IndexControllerBase;
use UserOrder;

class IndexController extends IndexControllerBase {

    public function indexAction() {
        parent::indexAction();
        $cities = City::find(array("captial = 1", "order" => "name ASC"));
        $this->view->cities = $cities;


        // load area for cities
        $areas = array();
        foreach ($cities as $city) {
            $areas[$city->id] = Area::getHighestArea($city->id);
        }
        $this->view->cityAreas = $areas;
    }

    public function bongahmobileappAction() {
        $this->setPageTitle("برنامه اندروید مشاوران املاک");
    }

    public function downloadbongahappAction() {

        // user want to download app, first we have to track user request ,
        // after that rediercet user to download link
        $appDownload = new AppDownload();
        $appDownload->appversion = Config::GetAndroidVersionName();
        $appDownload->agent = json_encode($_SERVER);
        $appDownload->ip = $_SERVER["REMOTE_ADDR"];
        $appDownload->link = Config::GetAndroidDownloadLink();
        $appDownload->userid = isset($this->user) ? $this->user->userid : null;
        $appDownload->create();


        // now we have to redirect user to download page
        Helper::RedirectToURL(Config::GetAndroidDownloadLink());
        die();
    }

    public function buywithmobileAction($orderid) {


        // check if user is not logged in, show 404
        if (!isset($this->user)) {
            $this->show404();
            return;
        }

        // check if order id is valid
        $order = UserOrder::findFirst(array("id = :id:", "bind" => array("id" => $orderid)));
        if ($order == FALSE) {
            $this->show404();
            return;
        }

        // we have to request pay order
        $orderObject = new Order($this->user->userid);
        $orderObject->PayOrder($this->errors, $order->id, 1);
    }

}
