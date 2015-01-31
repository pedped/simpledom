<?php

namespace Simpledom\Frontend\Controllers;

use BannerAdvertPackage;
use LocationPickerForm;
use PriceViewer;
use PurchasedBanner;
use Simpledom\Core\Classes\Config;
use Simpledom\Core\Classes\Order;

class BongahBannerAdvertController extends ControllerBaseFrontEnd {

    protected function ValidateAccess($id) {
        
    }

    public function plansAction($cityid = null) {

        $this->setPageTitle("پلان تبلیغاتی مشاوران املاک");

        // load city form
        $form = new LocationPickerForm();
        $this->view->form = $form;

        // check if user entered cityid
        if (isset($cityid)) {

            // we have to get city packages and check if exist
            $currentPurchasedPackages = PurchasedBanner::find(array("cityid = :cityid: AND validuntil >= :validuntil: AND banner_type = 1", "bind" => array(
                            "cityid" => $cityid,
                            "validuntil" => time(),
            )));

            // check if all banner are reserved 
            if ($currentPurchasedPackages != FALSE && count($currentPurchasedPackages) >= Config::TotalBannerCanSupportInCityList()) {
                // all packages are reserved
                $this->view->state = 3;
            } else {
                $plans = BannerAdvertPackage::find(
                                array(
                                    "enable = 1 AND ( cityid = :cityid: OR cityid = 0 OR cityid IS NULL)",
                                    "bind" => array("cityid" => $cityid),
                ));
                // show price list
                $viewr = new PriceViewer();
                $viewr->setPlans($plans);
                $viewr->setHeaderFieldName("title");
                $viewr->setSetPurchaseFieldName("getPurchaseButton()");
                $viewr->setSetPriceRowIndex(2);
                $viewr->setFields(array(
                    "getValidDateHuman()",
                    "description",
                    "getHumanPrice()",
                ));
                $viewr->setInfos(array(
                    "مدت زمان نمایش تبلیغ",
                    "توضیحات",
                    "قیمت",
                ));

                $this->view->plans = $viewr->Create();
                $this->view->state = 2;
            }


            // sent current purchased info
            $this->view->currentPurchasedPackages = $currentPurchasedPackages;
        } else {
            // we have to notify user to find city list
            // Locations Can Support
            $plans = BannerAdvertPackage::find('enable = 1');

            // show the status
            $this->view->state = 1;
        }
    }

    public function purchaseAction($planID) {

        if (!isset($this->user)) {
            $this->dispatcher->forward(array(
                "controller" => "user",
                "action" => "login",
                "params" => array()
            ));
            return;
        }

        $order = new Order($this->user->userid);
        $orderID = $order->CreateOrder($this->errors, 6, $planID);
        $order->PayOrder($this->errors, $orderID, 1);
        if (count($this->errors) > 0) {
            var_dump($this->errors);
        }
    }

}
