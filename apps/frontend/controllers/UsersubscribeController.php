<?php

namespace Simpledom\Frontend\Controllers;

use BongahAmlakKeshvar;
use Melk;
use MelkSubscribeItem;
use PriceViewer;
use Simpledom\Core\Classes\Order;

class UsersubscribeController extends ControllerBaseFrontEnd {

    protected function ValidateAccess($id) {
        
    }

    public function plansAction($melkid = null) {

        // set title
        $this->setPageTitle("پلان املاک داران");

        // check if we have to show to send infos
        if (isset($melkid)) {

            // get melk info
            $melk = Melk::findFirst(array("id = :id:", "bind" => array("id" => $melkid)));

            // get bonngahs list
            if (true || (!$this->user->isBongahDar() && !$this->user->isSuperAdmin() && intval($melk->userid) == ($this->userid))) {
                // find apprch bongahs
                $toSendBongahs = BongahAmlakKeshvar::find(
                                array(
                                    "cityid = :cityid: AND address LIKE CONCAT('%' , :query: , '%') ",
                                    "bind" => array(
                                        "cityid" => $melk->cityid,
                                        "query" => $melk->getInfo()->address
                                    )
                                )
                );

                $this->view->toSendBongahs = $toSendBongahs;
                $this->view->melk = $melk;
            }
        }

        // show price list
        $viewr = new PriceViewer();
        $viewr->setPlans(MelkSubscribeItem::find('enable = 1'));
        $viewr->setHeaderFieldName("name");
        $viewr->setSetPurchaseFieldName("getPurchaseButton()");
        $viewr->setSetPriceRowIndex(3);
        $viewr->setFields(array(
            "getFeaturedAsBool()",
            "getValidDateHuman()",
            "melkscanadd",
            "getHumanPrice()",
        ));
        $viewr->setInfos(array(
            "ارسال اطلاعات ملک به بنگاه داران",
            "مدت زمان نمایش ملک در سامانه املاک گستر",
            "املاک قابل افزودن",
            "قیمت",
        ));

        $this->view->plans = $viewr->Create();
    }

    public function purchaseAction($planID) {
        $this->errors = array();
        $order = new Order($this->user->userid);
        $orderID = $order->CreateOrder($this->errors, 4, $planID);
        $order->PayOrder($this->errors, $orderID, 1);
        if (count($this->errors) > 0) {
            var_dump($this->errors);
        }
    }

}
