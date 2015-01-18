<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class AppEmailRequestForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // phone
        $phone = new TextElement('phone');
        $phone->setLabel('phone');
        //$phone->setAttribute('placeholder', 'Enter your phone');
        $phone->setAttribute('class', 'form-control');
        $phone->addValidator(new PresenceOf(array(
        )));
        $this->add($phone);


        // email
        $email = new TextElement('email');
        $email->setLabel('email');
        //$email->setAttribute('placeholder', 'Enter your email');
        $email->setAttribute('class', 'form-control');
        $email->addValidator(new PresenceOf(array(
        )));
        $email->addValidator(new Email(array(
        )));
        $this->add($email);


        // date
        $date = new TextElement('date');
        $date->setLabel('date');
        //$date->setAttribute('placeholder', 'Enter your date');
        $date->setAttribute('class', 'form-control');
        $this->add($date);


        // ip
        $ip = new TextElement('ip');
        $ip->setLabel('ip');
        //$ip->setAttribute('placeholder', 'Enter your ip');
        $ip->setAttribute('class', 'form-control');
        $ip->addValidator(new PresenceOf(array(
        )));
        $this->add($ip);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
