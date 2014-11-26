<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class BongahSentMelkForm extends AtaForm {

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


        // Melk Phone Listner
        $melkphonelistnerid = new TextElement('melkphonelistnerid');
        $melkphonelistnerid->setLabel('Melk Phone Listner');
        //$melkphonelistnerid->setAttribute('placeholder', 'Enter your Melk Phone Listner');
        $melkphonelistnerid->setAttribute('class', 'form-control');
        $melkphonelistnerid->addValidator(new PresenceOf(array(
        )));
        $this->add($melkphonelistnerid);


        // Melk ID
        $melkid = new TextElement('melkid');
        $melkid->setLabel('Melk ID');
        //$melkid->setAttribute('placeholder', 'Enter your Melk ID');
        $melkid->setAttribute('class', 'form-control');
        $melkid->addValidator(new PresenceOf(array(
        )));
        $this->add($melkid);


        // Message
        $message = new TextElement('message');
        $message->setLabel('Message');
        //$message->setAttribute('placeholder', 'Enter your Message');
        $message->setAttribute('class', 'form-control');
        $message->addValidator(new PresenceOf(array(
        )));
        $this->add($message);


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
