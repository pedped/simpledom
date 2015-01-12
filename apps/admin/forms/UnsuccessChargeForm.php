<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class UnsuccessChargeForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Charge ID
        $chargeid = new TextElement('chargeid');
        $chargeid->setLabel('Charge ID');
        //$chargeid->setAttribute('placeholder', 'Enter your Charge ID');
        $chargeid->setAttribute('class', 'form-control');
        $chargeid->addValidator(new PresenceOf(array(
        )));
        $this->add($chargeid);


        // Value
        $value = new TextElement('value');
        $value->setLabel('Value');
        //$value->setAttribute('placeholder', 'Enter your Value');
        $value->setAttribute('class', 'form-control');
        $value->addValidator(new PresenceOf(array(
        )));
        $this->add($value);


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
