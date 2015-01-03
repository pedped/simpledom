<?php

namespace Simpledom\Core;

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;
use TextElement;

class OnTimeTokenForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // userid
        $userid = new TextElement('userid');
        $userid->setLabel('userid');
        //$userid->setAttribute('placeholder', 'Enter your userid');
        $userid->setAttribute('class', 'form-control');
        $userid->addValidator(new PresenceOf(array(
        )));
        $this->add($userid);


        // token
        $token = new TextElement('token');
        $token->setLabel('token');
        //$token->setAttribute('placeholder', 'Enter your token');
        $token->setAttribute('class', 'form-control');
        $token->addValidator(new PresenceOf(array(
        )));
        $this->add($token);


        // date
        $date = new TextElement('date');
        $date->setLabel('date');
        //$date->setAttribute('placeholder', 'Enter your date');
        $date->setAttribute('class', 'form-control');
        $this->add($date);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
