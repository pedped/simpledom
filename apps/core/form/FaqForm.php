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
        $name->setLabel(_("Head"));
        $name->setAttribute("class", "form-control");
        $name->addValidator(new PresenceOf(array(
        )));
        $name->addValidator(new StringLength(array(
            'min' => 6,
        )));
        $this->add($name);


        // Title
        $title = new Text("title");
        $title->setLabel(_("Title"));
        $title->setAttribute("class", "form-control");
        $title->addValidator(new PresenceOf(array(
        )));
        $title->addValidator(new StringLength(array(
            'min' => 6,
        )));
        $this->add($title);


        // Message
        $message = new TextArea("message");
        $message->setLabel(_("Message"));
        $message->setAttribute("class", "form-control");
        $message->addValidator(new PresenceOf(array(
        )));
        $message->addValidator(new StringLength(array(
            'min' => 10,
        )));
        $this->add($message);


        // Submit Button
        $submit = new Submit("submit");
        $submit->setAttribute("value", _("Submit"));
        $submit->setAttribute("class", 'btn btn-primary');
        $this->add($submit);
    }

}
