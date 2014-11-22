<?php

namespace Simpledom\Frontend\Controllers;

use Simpledom\Frontend\BaseControllers\PhoneControllerBase;

class PhoneController extends PhoneControllerBase {

    public function verifyAction($phone) {
        parent::verifyAction($phone);

        $this->setPageTitle("تایید شماره موبایل");
        $this->setSubtitle("تایید موبایل");
    }

}
