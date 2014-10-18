<?php

namespace Simpledom\Core;

use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class ProfileEditForm extends AtaForm {

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
        $firstname->setDefault($this->session->get("fname"));
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
        $lastname->setDefault($this->session->get("lname"));
        $this->add($lastname);


        // Gender
        $gender = new Select("gender", array(
            '1' => 'Male',
            '0' => 'Female'
        ));
        $gender->setLabel("Gender");
        $gender->setAttribute("class", "form-control");
        $gender->setDefault($this->session->get("gender"));
        $this->add($gender);


        // Submit Button
        $submit = new Submit("submit");
        $submit->setName("submit");
        $submit->setAttribute("class", 'btn btn-primary');
        $this->add($submit);
    }

}
