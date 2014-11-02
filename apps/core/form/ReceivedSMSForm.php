<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class ReceivedSMSForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Phone
        $phone = new TextElement('phone');
        $phone->setLabel('Phone');
        //$phone->setAttribute('placeholder', 'Enter your Phone');
        $phone->setAttribute('class', 'form-control');
        $phone->addValidator(new PresenceOf(array(
        )));
        $this->add($phone);


        // Message
        $message = new TextElement('message');
        $message->setLabel('Message');
        //$message->setAttribute('placeholder', 'Enter your Message');
        $message->setAttribute('class', 'form-control');
        $message->addValidator(new PresenceOf(array(
        )));
        $this->add($message);


        // From Number
        $fromnumber = new TextElement('fromnumber');
        $fromnumber->setLabel('From Number');
        //$fromnumber->setAttribute('placeholder', 'Enter your From Number');
        $fromnumber->setAttribute('class', 'form-control');
        $fromnumber->addValidator(new PresenceOf(array(
        )));
        $this->add($fromnumber);


        // IP
        $ip = new TextElement('ip');
        $ip->setLabel('IP');
        //$ip->setAttribute('placeholder', 'Enter your IP');
        $ip->setAttribute('class', 'form-control');
        $ip->addValidator(new PresenceOf(array(
        )));
        $this->add($ip);


        // Provider
        $provider = new SelectElement('provider', SMSProvider::find(), array(
            "using" => array(
                "id", "name"
            )
        ));
        $provider->setLabel('Provider');
        //$provider->setAttribute('placeholder', 'Enter your Provider');
        $provider->setAttribute('class', 'form-control');
        $provider->addValidator(new PresenceOf(array(
        )));
        $this->add($provider);


        // Date
        $date = new TextElement('date');
        $date->setLabel('Date');
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $this->add($date);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
