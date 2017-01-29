<?php

namespace Simpledom\Api\Controllers;

use Invoice;
use PriceCalculator;

class InvoiceController extends ControllerBase {
    
    public function listAction(){
        
        $invocies = Invoice::find(array(
            "order"=> "id DESC"
        ));
        return $this->getResponse($invocies);
    }
     public function calcordercostAction() {
        $products = json_decode($_POST["products"]);
        $deliverTime = $_POST["delivertime"];


        // request price calculator calc the price
        $finalPrice = PriceCalculator::CalcCost($this->user, $products, $deliverTime);

        return $this->getResponse($finalPrice);
    }
}