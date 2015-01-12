<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class CreditChangeForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // User ID
        $userid = new TextElement('userid');
        $userid->setLabel('User ID');
        //$userid->setAttribute('placeholder', 'Enter your User ID');
        $userid->setAttribute('class', 'form-control');
        $userid->addValidator(new PresenceOf(array(
        )));
        $this->add($userid);


        // Status
        $status = new TextElement('status');
        $status->setLabel('Status');
        //$status->setAttribute('placeholder', 'Enter your Status');
        $status->setAttribute('class', 'form-control');
        $status->addValidator(new PresenceOf(array(
        )));
        $this->add($status);


        // Value
        $value = new TextAreaElement('value');
        $value->setLabel('Value');
        //$value->setAttribute('placeholder', 'Enter your Value');
        $value->setAttribute('class', 'form-control');
        $value->addValidator(new PresenceOf(array(
        )));
        $this->add($value);


        // Charge ID
        $chargeid = new TextElement('chargeid');
        $chargeid->setLabel('Charge ID');
        //$chargeid->setAttribute('placeholder', 'Enter your Charge ID');
        $chargeid->setAttribute('class', 'form-control');
        $this->add($chargeid);


        // Date
        $date = new TextElement('date');
        $date->setLabel('Date');
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $this->add($date);


        // Message
        $message = new TextElement('message');
        $message->setLabel('Message');
        //$message->setAttribute('placeholder', 'Enter your Message');
        $message->setAttribute('class', 'form-control');
        $this->add($message);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
