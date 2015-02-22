<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class BongahActionForm extends AtaForm {

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


        // Action Code
        $actioncode = new TextElement('actioncode');
        $actioncode->setLabel('Action Code');
        //$actioncode->setAttribute('placeholder', 'Enter your Action Code');
        $actioncode->setAttribute('class', 'form-control');
        $actioncode->addValidator(new PresenceOf(array(
        )));
        $this->add($actioncode);


        // Data
        $data = new TextElement('data');
        $data->setLabel('Data');
        //$data->setAttribute('placeholder', 'Enter your Data');
        $data->setAttribute('class', 'form-control');
        $this->add($data);


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
