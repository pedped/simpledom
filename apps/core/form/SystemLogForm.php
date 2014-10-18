<?php

namespace Simpledom\Core;

use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Simpledom\Core\AtaForm;

class SystemLogForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new Text('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);

        // Title
        $title = new Text('title');
        $title->setLabel('Title');
        //$title->setAttribute('placeholder', 'Enter your Title');
        $title->setAttribute('class', 'form-control');
        $title->addValidator(new PresenceOf(array(
            'message' => 'The Title is required'
        )));
        $title->addValidator(new StringLength(array(
            'min' => 2,
            'messageMinimum' => 'The Title is too short'
        )));
        $this->add($title);

        // IP
        $ip = new Text('ip');
        $ip->setLabel('IP');
        //$ip->setAttribute('placeholder', 'Enter your IP');
        $ip->setAttribute('class', 'form-control');
        $ip->addValidator(new PresenceOf(array(
            'message' => 'The IP is required'
        )));
        $ip->addValidator(new StringLength(array(
            'min' => 2,
            'messageMinimum' => 'The IP is too short'
        )));
        $this->add($ip);

        // Message
        $message = new Text('message');
        $message->setLabel('Message');
        //$message->setAttribute('placeholder', 'Enter your Message');
        $message->setAttribute('class', 'form-control');
        $message->addValidator(new PresenceOf(array(
            'message' => 'The Message is required'
        )));
        $message->addValidator(new StringLength(array(
            'min' => 2,
            'messageMinimum' => 'The Message is too short'
        )));
        $this->add($message);

        // Date
        $date = new Text('date');
        $date->setLabel('Date');
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $date->addValidator(new PresenceOf(array(
            'message' => 'The Date is required'
        )));
        $date->addValidator(new StringLength(array(
            'min' => 2,
            'messageMinimum' => 'The Date is too short'
        )));
        $this->add($date);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
