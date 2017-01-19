<?php

namespace Simpledom\Api\Controllers;

class InvoiceController extends ControllerBase {
    
    public function listAction(){
        
        $invocies = \Invoice::find(array(
            "order"=> "id DESC"
        ));
        return $this->getResponse($invocies);
    }
}