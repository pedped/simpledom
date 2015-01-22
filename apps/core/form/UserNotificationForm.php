<?php

namespace Simpledom\Core;

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;
use TextElement;

class UserNotificationForm extends AtaForm {

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


        // Title
        $title = new TextElement('title');
        $title->setLabel('Title');
        //$title->setAttribute('placeholder', 'Enter your Title');
        $title->setAttribute('class', 'form-control');
        $title->addValidator(new PresenceOf(array(
        )));
        $this->add($title);


        // Message
        $message = new TextElement('message');
        $message->setLabel('Message');
        //$message->setAttribute('placeholder', 'Enter your Message');
        $message->setAttribute('class', 'form-control');
        $message->addValidator(new PresenceOf(array(
        )));
        $this->add($message);


        // Link
        $link = new TextElement('link');
        $link->setLabel('Link');
        //$link->setAttribute('placeholder', 'Enter your Link');
        $link->setAttribute('class', 'form-control');
        $link->addValidator(new PresenceOf(array(
        )));
        $this->add($link);


        // Link Text
        $linktext = new TextElement('linktext');
        $linktext->setLabel('Link Text');
        //$linktext->setAttribute('placeholder', 'Enter your Link Text');
        $linktext->setAttribute('class', 'form-control');
        $linktext->addValidator(new PresenceOf(array(
        )));
        $this->add($linktext);


        // Date
        $date = new TextElement('date');
        $date->setLabel('Date');
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $this->add($date);


        // Release Date
        $releasedate = new TextElement('releasedate');
        $releasedate->setLabel('Release Date');
        //$releasedate->setAttribute('placeholder', 'Enter your Release Date');
        $releasedate->setAttribute('class', 'form-control');
        $this->add($releasedate);


        // Enable
        $enable = new TextElement('enable');
        $enable->setLabel('Enable');
        //$enable->setAttribute('placeholder', 'Enter your Enable');
        $enable->setAttribute('class', 'form-control');
        $this->add($enable);


        // By IP
        $byip = new TextElement('byip');
        $byip->setLabel('By IP');
        //$byip->setAttribute('placeholder', 'Enter your By IP');
        $byip->setAttribute('class', 'form-control');
        $byip->addValidator(new PresenceOf(array(
        )));
        $this->add($byip);


        // Visited
        $visited = new TextElement('visited');
        $visited->setLabel('Visited');
        //$visited->setAttribute('placeholder', 'Enter your Visited');
        $visited->setAttribute('class', 'form-control');
        $this->add($visited);


        // Visit IP
        $visitip = new TextElement('visitip');
        $visitip->setLabel('Visit IP');
        //$visitip->setAttribute('placeholder', 'Enter your Visit IP');
        $visitip->setAttribute('class', 'form-control');
        $this->add($visitip);


        // Visit Date
        $visitdate = new TextElement('visitdate');
        $visitdate->setLabel('Visit Date');
        //$visitdate->setAttribute('placeholder', 'Enter your Visit Date');
        $visitdate->setAttribute('class', 'form-control');
        $this->add($visitdate);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
