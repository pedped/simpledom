<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class ChargeTypeForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Name
        $name = new TextElement('name');
        $name->setLabel('Name');
        //$name->setAttribute('placeholder', 'Enter your Name');
        $name->setAttribute('class', 'form-control');
        $name->addValidator(new PresenceOf(array(
        )));
        $this->add($name);


        // Persian Name
        $persianname = new TextElement('persianname');
        $persianname->setLabel('Persian Name');
        //$persianname->setAttribute('placeholder', 'Enter your Persian Name');
        $persianname->setAttribute('class', 'form-control');
        $persianname->addValidator(new PresenceOf(array(
        )));
        $this->add($persianname);


        // Status
        $status = new TextAreaElement('status');
        $status->setLabel('Status');
        //$status->setAttribute('placeholder', 'Enter your Status');
        $status->setAttribute('class', 'form-control');
        $status->addValidator(new PresenceOf(array(
        )));
        $this->add($status);


        // Status Message
        $statusmessage = new EnableDisableElement('statusmessage');
        $statusmessage->setLabel('Status Message');
        //$statusmessage->setAttribute('placeholder', 'Enter your Status Message');
        $statusmessage->setAttribute('class', 'form-control');
        $this->add($statusmessage);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
