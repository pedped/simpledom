<?php

namespace Simpledom\Core;

use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class VerifyPhoneForm extends AtaForm {

    public function initialize() {


        // Verify Code
        $verifycode = new Text("verifycode");
        $verifycode->setLabel("Verify Code");
        $verifycode->setAttribute("placeholder", "Enter the number you have recived in your Phone");
        $verifycode->setAttribute("class", "form-control");
        $verifycode->addValidator(new PresenceOf(array(
        )));
        $verifycode->addValidator(new StringLength(array(
            'min' => 6,
        )));
        $this->add($verifycode);


        // Submit Button
        $submit = new Submit("submit");
        $submit->setAttribute("value", _("Submit"));
        $submit->setAttribute("class", 'btn btn-primary');
        $this->add($submit);
    }

}
