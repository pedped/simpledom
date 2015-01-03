<?php

use Simpledom\Core\Classes\Helper;

class SMSCreditCost extends BaseSMSCreditCost {

    public function getHumanPrice() {
        return Helper::GetPrice($this->price / 10000000);
    }

    public function getPublicResponse() {
        $item = parent::getPublicResponse();
        $item->price = $this->getHumanPrice();
        return $item;
    }

}
