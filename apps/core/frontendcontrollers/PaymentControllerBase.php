<?php

namespace Simpledom\Frontend\BaseControllers;

use PaymentMethod;
use PaymentType;
use Phalcon\Text;
use Phalcon\Validation\Exception;

class PaymentControllerBase extends ControllerBase {

    /**
     *
     * @var PaymentMethod 
     */
    private $paymentHandler;

    public function finishAction($handler, $paymentid) {

        try {
            // the payment has been finished, check for the handler
            $paymentMethod = PaymentType::findFirst(array("key = :key:", "bind" => array("key" => $handler)));
            if (!$paymentMethod || $paymentMethod->enable = FALSE) {
                // the payment option is disabled
                $this->flash->error(_("unable to find the payment method, may be it is disabled"));
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
                $this->flash->success("<h3 style='margin-top:0px;'>" . _("Success") . "</h3>" . _("Your payment was successfully") . "");
            } else {
                $this->flash->error("<h3 style='margin-top:0px;'>" . _("Ooops") . "</h3>", implode("<br/>", $this->errors));
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    protected function ValidateAccess($id) {
        return true;
    }

}
