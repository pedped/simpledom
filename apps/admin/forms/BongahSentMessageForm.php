<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class BongahSentMessageForm extends AtaForm {

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


        // Bongah Title
        $bongahtitle = new TextElement('bongahtitle');
        $bongahtitle->setLabel('Bongah Title');
        //$bongahtitle->setAttribute('placeholder', 'Enter your Bongah Title');
        $bongahtitle->setAttribute('class', 'form-control');
        $bongahtitle->addValidator(new PresenceOf(array(
        )));
        $this->add($bongahtitle);


        // To Phone
        $tophone = new TextElement('tophone');
        $tophone->setLabel('To Phone');
        //$tophone->setAttribute('placeholder', 'Enter your To Phone');
        $tophone->setAttribute('class', 'form-control');
        $tophone->addValidator(new PresenceOf(array(
        )));
        $this->add($tophone);


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


        // SMS Message ID
        $smsmessageid = new TextElement('smsmessageid');
        $smsmessageid->setLabel('SMS Message ID');
        //$smsmessageid->setAttribute('placeholder', 'Enter your SMS Message ID');
        $smsmessageid->setAttribute('class', 'form-control');
        $smsmessageid->addValidator(new PresenceOf(array(
        )));
        $this->add($smsmessageid);


        // Received
        $received = new EnableDisableElement('received');
        $received->setLabel('Received');
        //$received->setAttribute('placeholder', 'Enter your Received');
        $received->setAttribute('class', 'form-control');
        $received->addValidator(new PresenceOf(array(
        )));
        $this->add($received);


        // Bongah Phone
        $bongahphone = new TextElement('bongahphone');
        $bongahphone->setLabel('Bongah Phone');
        //$bongahphone->setAttribute('placeholder', 'Enter your Bongah Phone');
        $bongahphone->setAttribute('class', 'form-control');
        $bongahphone->addValidator(new PresenceOf(array(
        )));
        $this->add($bongahphone);


        // Distance
        $distance = new TextElement('distance');
        $distance->setLabel('Distance');
        //$distance->setAttribute('placeholder', 'Enter your Distance');
        $distance->setAttribute('class', 'form-control');
        $distance->addValidator(new PresenceOf(array(
        )));
        $this->add($distance);


        // Type
        $type = new TextElement('type');
        $type->setLabel('Type');
        //$type->setAttribute('placeholder', 'Enter your Type');
        $type->setAttribute('class', 'form-control');
        $type->addValidator(new PresenceOf(array(
        )));
        $this->add($type);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
