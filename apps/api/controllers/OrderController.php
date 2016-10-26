<?php

namespace Simpledom\Api\Controllers;

class OrderController extends ControllerBase {

    public function gettrackinfoAction() {
        return $this->getResponse($this->user->getOrderTracks());
    }

}
