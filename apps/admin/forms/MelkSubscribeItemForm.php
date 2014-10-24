<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Simpledom\Core\AtaForm;

class MelkSubscribeItemForm extends AtaForm {

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
        $name->addValidator(new StringLength(array(
            'min' => 10
        )));
        $this->add($name);


        // Description
        $description = new TextElement('description');
        $description->setLabel('Description');
        //$description->setAttribute('placeholder', 'Enter your Description');
        $description->setAttribute('class', 'form-control');
        $description->addValidator(new PresenceOf(array(
        )));
        $description->addValidator(new StringLength(array(
            'min' => 20
        )));
        $this->add($description);


        // Melk Can Add
        $melkscanadd = new TextElement('melkscanadd');
        $melkscanadd->setLabel('Melk Can Add');
        //$melkscanadd->setAttribute('placeholder', 'Enter your Melk Can Add');
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


        // Valid Date
        $validdate = new TextElement('validdate');
        $validdate->setLabel('Valid Date');
        //$validdate->setAttribute('placeholder', 'Enter your Valid Date');
        $validdate->setAttribute('class', 'form-control');
        $validdate->addValidator(new PresenceOf(array(
        )));
        $this->add($validdate);


        // Send SMS to Users
        $sendmessagetousers = new EnableDisableElement('sendmessagetousers');
        $sendmessagetousers->setLabel('Send SMS to Users');
        //$sendmessagetousers->setAttribute('placeholder', 'Enter your Send SMS to Users');
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
