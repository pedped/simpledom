<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class ChargeForm extends AtaForm {

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


        // Type
        $type = new TextElement('type');
        $type->setLabel('Type');
        //$type->setAttribute('placeholder', 'Enter your Type');
        $type->setAttribute('class', 'form-control');
        $type->addValidator(new PresenceOf(array(
        )));
        $this->add($type);


        // Value
        $value = new TextAreaElement('value');
        $value->setLabel('Value');
        //$value->setAttribute('placeholder', 'Enter your Value');
        $value->setAttribute('class', 'form-control');
        $value->addValidator(new PresenceOf(array(
        )));
        $this->add($value);


        // Phone Number
        $phonenumber = new EnableDisableElement('phonenumber');
        $phonenumber->setLabel('Phone Number');
        //$phonenumber->setAttribute('placeholder', 'Enter your Phone Number');
        $phonenumber->setAttribute('class', 'form-control');
        $phonenumber->addValidator(new PresenceOf(array(
        )));
        $this->add($phonenumber);


        // Target Phone Number
        $targetphonenumber = new TextElement('targetphonenumber');
        $targetphonenumber->setLabel('Target Phone Number');
        //$targetphonenumber->setAttribute('placeholder', 'Enter your Target Phone Number');
        $targetphonenumber->setAttribute('class', 'form-control');
        $targetphonenumber->addValidator(new PresenceOf(array(
        )));
        $this->add($targetphonenumber);


        // Offline Mode
        $offlinemode = new TextElement('offlinemode');
        $offlinemode->setLabel('Offline Mode');
        //$offlinemode->setAttribute('placeholder', 'Enter your Offline Mode');
        $offlinemode->setAttribute('class', 'form-control');
        $offlinemode->addValidator(new PresenceOf(array(
        )));
        $this->add($offlinemode);


        // Order ID
        $orderid = new TextElement('orderid');
        $orderid->setLabel('Order ID');
        //$orderid->setAttribute('placeholder', 'Enter your Order ID');
        $orderid->setAttribute('class', 'form-control');
        $this->add($orderid);


        // Credit ID
        $creditid = new TextElement('creditid');
        $creditid->setLabel('Credit ID');
        //$creditid->setAttribute('placeholder', 'Enter your Credit ID');
        $creditid->setAttribute('class', 'form-control');
        $this->add($creditid);


        // Elka Trans ID
        $elkatransid = new TextElement('elkatransid');
        $elkatransid->setLabel('Elka Trans ID');
        //$elkatransid->setAttribute('placeholder', 'Enter your Elka Trans ID');
        $elkatransid->setAttribute('class', 'form-control');
        $this->add($elkatransid);


        // Cart ID
        $cartid = new TextElement('cartid');
        $cartid->setLabel('Cart ID');
        //$cartid->setAttribute('placeholder', 'Enter your Cart ID');
        $cartid->setAttribute('class', 'form-control');
        $this->add($cartid);


        // Status
        $status = new TextElement('status');
        $status->setLabel('Status');
        //$status->setAttribute('placeholder', 'Enter your Status');
        $status->setAttribute('class', 'form-control');
        $status->addValidator(new PresenceOf(array(
        )));
        $this->add($status);


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
