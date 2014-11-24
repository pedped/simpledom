<?php

namespace Simpledom\Core;

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use TextElement;

class VerifyPhoneForm extends AtaForm {

    public function initialize() {


        // Verify Code
        $verifycode = new TextElement("verifycode");
        $verifycode->setLabel(_("Verify Code"));
        $verifycode->setAttribute("placeholder", _("Enter the number you have recived in your Phone"));
        $verifycode->setAttribute("class", "form-control");
        $verifycode->addValidator(new PresenceOf(array(
        )));
        $verifycode->addValidator(new StringLength(array(
            'min' => 6,
        )));
        $this->add($verifycode);


        // Submit Button
        $submit = new Submit("submit");
        $submit->setAttribute("value", "تایید کد");
        $submit->setAttribute("class", 'btn btn-primary');
        $this->add($submit);
    }

}
