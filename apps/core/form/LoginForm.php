<?php

namespace Simpledom\Core;

use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;

class LoginForm extends AtaForm {

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


        // Password
        $password = new Password("password");
        $password->setLabel("Password");
        $password->setAttribute("placeholder", "Enter your Password");
        $password->setAttribute("class", "form-control");
        $password->addValidator(new PresenceOf(array(
            'message' => 'The password is required'
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
