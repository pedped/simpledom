<?php

use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class LoginDetailsForm extends AtaForm {

    public function initialize() {


        // ٍEmail
        $email = new Text("email");
        $email->setLabel("Email");
        $email->setAttribute("disabled", "true");
        $email->setAttribute("placeholder", "Enter Email");
        $email->setAttribute("class", "form-control disabled");
        $this->add($email);


        // Password
        $password = new Password("password");
        $password->setLabel("Current Password");
        $password->setAttribute("placeholder", "Enter your Password");
        $password->setAttribute("class", "form-control");
        $password->addValidator(new PresenceOf(array(
            'message' => 'The Password is required'
        )));
        $this->add($password);

        // New Password
        $newpassword = new Password("newpassword");
        $newpassword->setLabel("New Password");
        $newpassword->setAttribute("placeholder", "Enter your Password");
        $newpassword->setAttribute("class", "form-control");
        $newpassword->addValidator(new PresenceOf(array(
            'message' => 'The New Password is required'
        )));
        $this->add($newpassword);

        // New Password Confirm
        $newpasswordconfirm = new Password("newpasswordconfirm");
        $newpasswordconfirm->setLabel("Confirm New Password");
        $newpasswordconfirm->setAttribute("placeholder", "Enter your Password");
        $newpasswordconfirm->setAttribute("class", "form-control");
        $newpasswordconfirm->addValidator(new PresenceOf(array(
            'message' => 'The Confirm New Password is required'
        )));
        $this->add($newpasswordconfirm);


        // Submit Button
        $submit = new Submit("submit");
        $submit->setName("submit");
        $submit->setAttribute("class", 'btn btn-primary');
        $this->add($submit);
    }

}
