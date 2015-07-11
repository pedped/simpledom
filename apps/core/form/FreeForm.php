<?php

namespace Simpledom\Core;

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use TextElement;

class FreeForm extends AtaForm {

    public function initialize() {


        // Head
        $phone = new TextElement("phone");
        $phone->setAttribute("placeholder", "شماره موبایل");
        $phone->setAttribute("class", "form-control input-lg");
        $phone->addValidator(new PresenceOf(array(
            "message" => "شماره موبایل را وارد نمایید"
        )));
        $phone->addValidator(new StringLength(array(
            'min' => 10,
            'max' => 11,
            'messageMinimum' => "شماره موبایل باید حداقل ده رقم باشد",
            'messageMaximum' => "شماره موبایل باید حداکثر یازده رقم باشد"
        )));
        $this->add($phone);



        // Submit Button
        $submit = new Submit("submit");
        $submit->setAttribute("value", "دریافت");
        $submit->setAttribute("class", 'btn btn-success btn-lg btn-block');
        $this->add($submit);
    }

}
