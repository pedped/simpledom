<?php

namespace Simpledom\Core;

use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class ViewUserForm extends AtaForm {

    public function initialize() {



        // First Name
        $firstname = new Text("firstname");
        $firstname->setLabel("First Name");
        $firstname->setAttribute("placeholder", "Enter your First Name");
        $firstname->setAttribute("class", "form-control");
        $firstname->addValidator(new PresenceOf(array(
            'message' => 'The name is required'
        )));
        $firstname->addValidator(new StringLength(array(
            'min' => 2,
            'messageMinimum' => 'The name is too short'
        )));
        $this->add($firstname);



        // Last Name
        $lastname = new Text("lastname");
        $lastname->setLabel("Last Name");
        $lastname->setAttribute("placeholder", "Enter your Last Name");
        $lastname->setAttribute("class", "form-control");
        $lastname->addValidator(new PresenceOf(array(
            'message' => 'The last name is required'
        )));
        $lastname->addValidator(new StringLength(array(
            'min' => 2,
            'messageMinimum' => 'The last name is too short'
        )));
        $this->add($lastname);



        // Gender
        $gender = new Select("gender", array(
            '1' => 'Male',
            '0' => 'Female'
        ));
        $gender->setLabel("Gender");
        $gender->setAttribute("class", "form-control");
        $this->add($gender);


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
