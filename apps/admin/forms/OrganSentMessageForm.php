<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class OrganSentMessageForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Organ ID
        $organid = new TextElement('organid');
        $organid->setLabel('Organ ID');
        //$organid->setAttribute('placeholder', 'Enter your Organ ID');
        $organid->setAttribute('class', 'form-control');
        $organid->addValidator(new PresenceOf(array(
        )));
        $this->add($organid);


        // Message
        $message = new TextElement('message');
        $message->setLabel('Message');
        //$message->setAttribute('placeholder', 'Enter your Message');
        $message->setAttribute('class', 'form-control');
        $message->addValidator(new PresenceOf(array(
        )));
        $this->add($message);


        // Date
        $date = new TextElement('date');
        $date->setLabel('Date');
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $this->add($date);


        // Sender Number
        $sendernumber = new TextElement('sendernumber');
        $sendernumber->setLabel('Sender Number');
        //$sendernumber->setAttribute('placeholder', 'Enter your Sender Number');
        $sendernumber->setAttribute('class', 'form-control');
        $sendernumber->addValidator(new PresenceOf(array(
        )));
        $this->add($sendernumber);


        // From Number
        $fromnumber = new TextElement('fromnumber');
        $fromnumber->setLabel('From Number');
        //$fromnumber->setAttribute('placeholder', 'Enter your From Number');
        $fromnumber->setAttribute('class', 'form-control');
        $fromnumber->addValidator(new PresenceOf(array(
        )));
        $this->add($fromnumber);


        // To Number
        $tonumber = new TextElement('tonumber');
        $tonumber->setLabel('To Number');
        //$tonumber->setAttribute('placeholder', 'Enter your To Number');
        $tonumber->setAttribute('class', 'form-control');
        $tonumber->addValidator(new PresenceOf(array(
        )));
        $this->add($tonumber);


        // Cost
        $cost = new TextElement('cost');
        $cost->setLabel('Cost');
        //$cost->setAttribute('placeholder', 'Enter your Cost');
        $cost->setAttribute('class', 'form-control');
        $cost->addValidator(new PresenceOf(array(
        )));
        $this->add($cost);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
