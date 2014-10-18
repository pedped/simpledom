<?php

namespace Simpledom\Core;

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;
use TextElement;

class UserCachChangeForm extends AtaForm {

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


        // Amount
        $amount = new TextElement('amount');
        $amount->setLabel('Amount');
        //$amount->setAttribute('placeholder', 'Enter your Amount');
        $amount->setAttribute('class', 'form-control');
        $amount->addValidator(new PresenceOf(array(
        )));
        $this->add($amount);


        // Date
        $date = new TextElement('date');
        $date->setLabel('Date');
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $this->add($date);


        // Reason
        $reasonid = new TextElement('reasonid');
        $reasonid->setLabel('Reason');
        //$reasonid->setAttribute('placeholder', 'Enter your Reason');
        $reasonid->setAttribute('class', 'form-control');
        $reasonid->addValidator(new PresenceOf(array(
        )));
        $this->add($reasonid);


        // More Info
        $more = new TextElement('more');
        $more->setLabel('More Info');
        //$more->setAttribute('placeholder', 'Enter your More Info');
        $more->setAttribute('class', 'form-control');
        $this->add($more);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
