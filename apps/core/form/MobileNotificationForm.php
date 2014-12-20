<?php

namespace Simpledom\Core;

use EditorElement;
use EnableDisableElement;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;
use TextElement;



class MobileNotificationForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Title
        $title = new TextElement('title');
        $title->setLabel('Title');
        //$title->setAttribute('placeholder', 'Enter your Title');
        $title->setAttribute('class', 'form-control');
        $title->addValidator(new PresenceOf(array(
        )));
        $this->add($title);


        // Message
        $message = new EditorElement('message');
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
        $this->add($link);


        // Link Text
        $linktext = new TextElement('linktext');
        $linktext->setLabel('Link Text');
        //$linktext->setAttribute('placeholder', 'Enter your Link Text');
        $linktext->setAttribute('class', 'form-control');
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
        $enable = new EnableDisableElement('enable');
        $enable->setLabel('Enable');
        //$enable->setAttribute('placeholder', 'Enter your Enable');
        $enable->setAttribute('class', 'form-control');
        $enable->addValidator(new PresenceOf(array(
        )));
        $this->add($enable);


        // By IP
        $byip = new TextElement('byip');
        $byip->setLabel('By IP');
        //$byip->setAttribute('placeholder', 'Enter your By IP');
        $byip->setAttribute('class', 'form-control');
        $this->add($byip);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
