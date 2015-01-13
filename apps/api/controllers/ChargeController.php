<?php

namespace Simpledom\Api\Controllers;

use Charge;
use ChargeType;
use OneTimeToken;
use Simpledom\Core\Classes\Config;
use Simpledom\Core\Classes\Helper;
use Simpledom\Core\Classes\Order;

class ChargeController extends ControllerBase {

    /**
     * @mobile
     */
    public function requestchargeAction() {

        // get items
        $notvalidatedphone = $this->request->getPost("phone");
        $type = $this->request->getPost("type");
        $amount = $this->request->getPost("amount");

        // validate items
        $targetPhone = Helper::getCorrectIraninanMobilePhoneNumber($notvalidatedphone);
        if (!$targetPhone) {
            $this->errors[] = "شمار موبایل وارد شده نامعتبر است";
            return $this->getResponse(false);
        }

        // check for type
        if ($type != "online" && $type != "credit") {
            $this->errors[] = "نوع درخواست غبر معتبر است";
            return $this->getResponse(false);
        }

        // check for amount
        if (strval($amount) != "10000" && strval($amount) != "20000" && strval($amount) != "50000" && strval($amount) != "100000" && strval($amount) != "200000") {
            $this->errors[] = "مبلغ خواسته شده نامعتبر است";
            return $this->getResponse(false);
        }

        // Check if user want to pay online, create him a one time token
        if ($type == "online") {

            // we have to generate a new charge item
            $charge = new Charge();
            $charge->offlinemode = "0";
            $charge->phonenumber = $this->user->hasVerifiedPhone() ? $this->user->getVerifiedPhone() : null;
            $charge->status = "0";
            $charge->targetphonenumber = $targetPhone;
            $charge->type = ChargeType::findPhoneNumberType($targetPhone)->id;
            $charge->userid = $this->user->userid;
            $charge->value = $amount;
            if (!$charge->create()) {
                $this->errors[] = _("خطا در هنگام ساخت یک سفارش شارژ جدید");
                return $this->getResponse(false);
            }

            // we have to create token for user
            $token = OneTimeToken::GenerateToken($this->user->userid);
            $order = new Order($this->user->userid);
            $orderID = $order->CreateOrder($this->errors, 4, $charge->id);

            // check if we have no error
            if (intval($orderID) > 0 && !$this->hasError() && strlen($token) > 0) {
                // valid request, we have to create link for user to purchase
                $link = Config::getPublicUrl() . "index/buywithmobile/" . $orderID . "?ottoken=" . $token;
                return $this->getResponse($link);
            }
            
            // invalid order id or we have error
            return $this->getResponse(false);
        }

        // we have to create charge request
        $result = Charge::ChargeSimCart($this->errors, $this->user, $targetPhone, $type, $amount);

        // check for result
        return $this->getResponse($result);
    }

}
