<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class CreditUsageForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Amount
        $amount = new TextElement('amount');
        $amount->setLabel('Amount');
        //$amount->setAttribute('placeholder', 'Enter your Amount');
        $amount->setAttribute('class', 'form-control');
        $amount->addValidator(new PresenceOf(array(
        )));
        $this->add($amount);


        // Charge ID
        $chargeid = new TextElement('chargeid');
        $chargeid->setLabel('Charge ID');
        //$chargeid->setAttribute('placeholder', 'Enter your Charge ID');
        $chargeid->setAttribute('class', 'form-control');
        $chargeid->addValidator(new PresenceOf(array(
        )));
        $this->add($chargeid);


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
