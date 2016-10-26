<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class InvoiceProductsForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Invoice ID
        $invoiceid = new TextElement('invoiceid');
        $invoiceid->setLabel('Invoice ID');
        //$invoiceid->setAttribute('placeholder', 'Enter your Invoice ID');
        $invoiceid->setAttribute('class', 'form-control');
        $invoiceid->addValidator(new PresenceOf(array(
        )));
        $this->add($invoiceid);


        // Product ID
        $productid = new TextElement('productid');
        $productid->setLabel('Product ID');
        //$productid->setAttribute('placeholder', 'Enter your Product ID');
        $productid->setAttribute('class', 'form-control');
        $productid->addValidator(new PresenceOf(array(
        )));
        $this->add($productid);


        // Count
        $count = new TextElement('count');
        $count->setLabel('Count');
        //$count->setAttribute('placeholder', 'Enter your Count');
        $count->setAttribute('class', 'form-control');
        $count->addValidator(new PresenceOf(array(
        )));
        $this->add($count);


        // Message
        $message = new TextElement('message');
        $message->setLabel('Message');
        //$message->setAttribute('placeholder', 'Enter your Message');
        $message->setAttribute('class', 'form-control');
        $message->addValidator(new PresenceOf(array(
        )));
        $this->add($message);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
