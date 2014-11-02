<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Simpledom\Core\AtaForm;

class MelkSubscriberForm extends AtaForm {

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
        $userid->addValidator(new StringLength(array(
            'min' => 10
        )));
        $this->add($userid);


        // Melk Subscribe ID
        $melksubscribeitemid = new TextElement('melksubscribeitemid');
        $melksubscribeitemid->setLabel('Melk Subscribe ID');
        //$melksubscribeitemid->setAttribute('placeholder', 'Enter your Melk Subscribe ID');
        $melksubscribeitemid->setAttribute('class', 'form-control');
        $melksubscribeitemid->addValidator(new PresenceOf(array(
        )));
        $melksubscribeitemid->addValidator(new StringLength(array(
            'min' => 20
        )));
        $this->add($melksubscribeitemid);


        // Date
        $date = new TextElement('date');
        $date->setLabel('Date');
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $date->addValidator(new PresenceOf(array(
        )));
        $this->add($date);


        // Order ID
        $orderid = new TextElement('orderid');
        $orderid->setLabel('Order ID');
        //$orderid->setAttribute('placeholder', 'Enter your Order ID');
        $orderid->setAttribute('class', 'form-control');
        $orderid->addValidator(new PresenceOf(array(
        )));
        $this->add($orderid);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}