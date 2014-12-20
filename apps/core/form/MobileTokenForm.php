<?php

namespace Simpledom\Core;

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use TextElement;

class MobileTokenForm extends AtaForm {

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


        // Device ID
        $deviceid = new TextElement('deviceid');
        $deviceid->setLabel('Device ID');
        //$deviceid->setAttribute('placeholder', 'Enter your Device ID');
        $deviceid->setAttribute('class', 'form-control');
        $deviceid->addValidator(new PresenceOf(array(
        )));
        $this->add($deviceid);


        // Device Type
        $devicetype = new TextElement('devicetype');
        $devicetype->setLabel('Device Type');
        //$devicetype->setAttribute('placeholder', 'Enter your Device Type');
        $devicetype->setAttribute('class', 'form-control');
        $devicetype->addValidator(new PresenceOf(array(
        )));
        $this->add($devicetype);


        // Token
        $token = new TextElement('token');
        $token->setLabel('Token');
        //$token->setAttribute('placeholder', 'Enter your Token');
        $token->setAttribute('class', 'form-control');
        $this->add($token);


        // Date
        $date = new TextElement('date');
        $date->setLabel('Date');
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $date->addValidator(new PresenceOf(array(
        )));
        $this->add($date);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
