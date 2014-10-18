<?php

namespace Simpledom\Core;

use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class FaqForm extends AtaForm {

    public function initialize() {



        // Head
        $name = new Text("head");
        $name->setLabel("Head");
        $name->setAttribute("class", "form-control");
        $name->addValidator(new PresenceOf(array(
            'message' => 'The head is required'
        )));
        $name->addValidator(new StringLength(array(
            'min' => 6,
            'messageMinimum' => 'The head is too short'
        )));
        $this->add($name);


        // Title
        $title = new Text("title");
        $title->setLabel("Title");
        $title->setAttribute("class", "form-control");
        $title->addValidator(new PresenceOf(array(
            'message' => 'The title is required'
        )));
        $title->addValidator(new StringLength(array(
            'min' => 6,
            'messageMinimum' => 'The title is too short'
        )));
        $this->add($title);


        // Message
        $message = new TextArea("message");
        $message->setLabel("Message");
        $message->setAttribute("class", "form-control");
        $message->addValidator(new PresenceOf(array(
            'message' => 'The message is required'
        )));
        $message->addValidator(new StringLength(array(
            'min' => 10,
            'messageMinimum' => 'The message is too short'
        )));
        $this->add($message);


        // Submit Button
        $submit = new Submit("submit");
        $submit->setName("submit");
        $submit->setAttribute("class", 'btn btn-primary');
        $this->add($submit);
    }

}
