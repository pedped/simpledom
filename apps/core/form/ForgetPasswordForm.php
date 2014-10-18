<?php

namespace Simpledom\Core;

use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;

class ForgetPasswordForm extends AtaForm {

    public function initialize() {

        // ٍEmail
        $email = new Text("email");
        $email->setLabel("Email");
        $email->setAttribute("placeholder", "Enter Email");
        $email->setAttribute("class", "form-control");
        $email->addValidator(new PresenceOf(array(
            'message' => 'The email is required'
        )));
        $email->addValidator(new Email(array(
            'message' => 'please enter a valid email'
        )));
        $this->add($email);



        // Submit Button
        $submit = new Submit("submit");
        $submit->setName("submit");
        $submit->setAttribute("class", 'btn btn-primary');
        $this->add($submit);
    }

}
