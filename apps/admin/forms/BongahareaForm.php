<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class BongahAreaForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Bongah ID
        $bongahid = new TextElement('bongahid');
        $bongahid->setLabel('Bongah ID');
        //$bongahid->setAttribute('placeholder', 'Enter your Bongah ID');
        $bongahid->setAttribute('class', 'form-control');
        $bongahid->addValidator(new PresenceOf(array(
        )));
        $this->add($bongahid);


        // Area ID
        $areaid = new TextElement('areaid');
        $areaid->setLabel('Area ID');
        //$areaid->setAttribute('placeholder', 'Enter your Area ID');
        $areaid->setAttribute('class', 'form-control');
        $areaid->addValidator(new PresenceOf(array(
        )));
        $this->add($areaid);


        // Enable
        $enable = new TextElement('enable');
        $enable->setLabel('Enable');
        //$enable->setAttribute('placeholder', 'Enter your Enable');
        $enable->setAttribute('class', 'form-control');
        $enable->addValidator(new PresenceOf(array(
        )));
        $this->add($enable);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
