<?php

namespace Simpledom\Frontend\Controllers;

use PaymentMethod;
use PaymentType;
use Phalcon\Text;

class PaymentController extends ControllerBase {

    /**
     *
     * @var PaymentMethod 
     */
    private $paymentHandler;

    public function finishAction($handler, $paymentid) {

        try {
            // the payment has been finished, check for the handler
            $paymentMethod = PaymentType::findFirstByKey($handler);
            if (!$paymentMethod || $paymentMethod->enable = FALSE) {
                // the payment option is disabled
                $this->flash->error("unable to find the payment method, may be it is disabled");
                return;
            }

            $parameters = $_REQUEST;
            $parameters["pid"] = $paymentid;
            $parameters["userid"] = $this->user->userid;

            // check for the payment method name, find the class name, and call the 
            // finish function for the class
            $handlerUpperCase = Text::camelize($handler);
            $handlerName = "PaymentHandler" . $handlerUpperCase;
            $this->paymentHandler = new $handlerName();
            if ($this->paymentHandler->OnFinishPayment($this->errors, $parameters)) {
                $this->flash->success("<h3 style='margin-top:0px;'>Success</h3>Your payment was successfully");
            } else {
                $this->flash->error("<h3 style='margin-top:0px;'>Ooops</h3>", implode("<br/>", $this->errors));
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
