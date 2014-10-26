<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class BongahSubscriberForm extends AtaForm {

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


        // Bongah Subscribe Item
        $bongahsubscribeitemid = new TextElement('bongahsubscribeitemid');
        $bongahsubscribeitemid->setLabel('Bongah Subscribe Item');
        //$bongahsubscribeitemid->setAttribute('placeholder', 'Enter your Bongah Subscribe Item');
        $bongahsubscribeitemid->setAttribute('class', 'form-control');
        $bongahsubscribeitemid->addValidator(new PresenceOf(array(
        )));
        $this->add($bongahsubscribeitemid);


        // Date
        $date = new TextElement('date');
        $date->setLabel('Date');
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
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
