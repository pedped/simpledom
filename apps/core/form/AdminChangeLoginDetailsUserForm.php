<?php

namespace Simpledom\Core;

use PasswordElement;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use TextElement;

class AdminChangeLoginDetailsUserForm extends AtaForm {

    public function initialize() {

        // ٍEmail
        $email = new TextElement("email");
        $email->setLabel("Email");
        $email->setAttribute("placeholder", "Enter Email");
        $email->setAttribute("class", "form-control");
        $email->addValidator(new PresenceOf(array(
        )));
        $email->addValidator(new Email(array(
        )));
        $this->add($email);


        // Password
        $password = new PasswordElement("password");
        $password->setLabel("Password");
        $password->setAttribute("placeholder", "Enter your Password");
        $password->setAttribute("class", "form-control");
        $password->addValidator(new PresenceOf(array(
        )));
//        $password->addValidator(new Between(array(
//            'max' => 50,
//            'min' => 8,
//            'messageMaximum' => 'The password should be at maximum 8 characters',
//            'messageMinimum' => 'The password should be at least 8 characters'
//        )));
        $this->add($password);


        // Submit Button
        $submit = new Submit("submit");
        $submit->setName("submit");
        $submit->setAttribute("class", 'btn btn-primary');
        $this->add($submit);
    }

}
