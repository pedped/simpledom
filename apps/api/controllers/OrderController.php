<?php

namespace Simpledom\Api\Controllers;

class OrderController extends ControllerBase {

    public function gettrackinfoAction() {
        return $this->getResponse($this->user->getOrderTracks());
    }

    public function getinvoiceinfoAction($invoiceid) {
        $invoice = \Invoice::findFirst(array("id = :id:", "bind" => array("id" => $invoiceid)));
        if ($invoice == FALSE) {
            $this->errors[] = "فاکتور مورد نظر پیدا نگردید";
            return $this->getResponse(false);
        }

        if ($invoice->userid != $this->user->userid) {
            $this->errors[] = "فاکتور مورد نظر پیدا نگردید";
            return $this->getResponse(false);
        }
        
        // get public response
        return $this->getResponse($invoice->getPublicResponse());
    }

}
