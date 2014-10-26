<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class BongahSubscribeItemForm extends AtaForm {

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


        // Description
        $description = new TextElement('description');
        $description->setLabel('Description');
        //$description->setAttribute('placeholder', 'Enter your Description');
        $description->setAttribute('class', 'form-control');
        $description->addValidator(new PresenceOf(array(
        )));
        $this->add($description);


        // Melks Can Add
        $melkscanadd = new TextElement('melkscanadd');
        $melkscanadd->setLabel('Melks Can Add');
        //$melkscanadd->setAttribute('placeholder', 'Enter your Melks Can Add');
        $melkscanadd->setAttribute('class', 'form-control');
        $melkscanadd->addValidator(new PresenceOf(array(
        )));
        $this->add($melkscanadd);


        // Price
        $price = new TextElement('price');
        $price->setLabel('Price');
        //$price->setAttribute('placeholder', 'Enter your Price');
        $price->setAttribute('class', 'form-control');
        $price->addValidator(new PresenceOf(array(
        )));
        $this->add($price);


        // Valid Days
        $validdate = new TextElement('validdate');
        $validdate->setLabel('Valid Days');
        //$validdate->setAttribute('placeholder', 'Enter your Valid Days');
        $validdate->setAttribute('class', 'form-control');
        $validdate->addValidator(new PresenceOf(array(
        )));
        $this->add($validdate);


        // Send Message To Users
        $sendmessagetousers = new EnableDisableElement('sendmessagetousers');
        $sendmessagetousers->setLabel('Send Message To Users');
        //$sendmessagetousers->setAttribute('placeholder', 'Enter your Send Message To Users');
        $sendmessagetousers->setAttribute('class', 'form-control');
        $sendmessagetousers->addValidator(new PresenceOf(array(
        )));
        $this->add($sendmessagetousers);


        // Featured
        $featured = new EnableDisableElement('featured');
        $featured->setLabel('Featured');
        //$featured->setAttribute('placeholder', 'Enter your Featured');
        $featured->setAttribute('class', 'form-control');
        $featured->addValidator(new PresenceOf(array(
        )));
        $this->add($featured);


        // Can See User Phone
        $canseeuserphone = new EnableDisableElement('canseeuserphone');
        $canseeuserphone->setLabel('Can See User Phone');
        //$canseeuserphone->setAttribute('placeholder', 'Enter your Can See User Phone');
        $canseeuserphone->setAttribute('class', 'form-control');
        $canseeuserphone->addValidator(new PresenceOf(array(
        )));
        $this->add($canseeuserphone);


        // Default SMS Credit
        $defaultsmscredit = new TextElement('defaultsmscredit');
        $defaultsmscredit->setLabel('Default SMS Credit');
        //$defaultsmscredit->setAttribute('placeholder', 'Enter your Default SMS Credit');
        $defaultsmscredit->setAttribute('class', 'form-control');
        $defaultsmscredit->addValidator(new PresenceOf(array(
        )));
        $this->add($defaultsmscredit);


        // Receive Portal
        $receiveportal = new EnableDisableElement('receiveportal');
        $receiveportal->setLabel('Receive Portal');
        //$receiveportal->setAttribute('placeholder', 'Enter your Receive Portal');
        $receiveportal->setAttribute('class', 'form-control');
        $receiveportal->addValidator(new PresenceOf(array(
        )));
        $this->add($receiveportal);


        // Enable
        $enable = new EnableDisableElement('enable');
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
