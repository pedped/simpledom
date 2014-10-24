<?php

namespace Simpledom\Core;

use EditorElement;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Simpledom\Core\AtaForm;
use TextElement;

class AgreementForm extends AtaForm {

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
        $title->setAttribute('class', 'form-control');
        $title->addValidator(new PresenceOf(array(
        )));
        $title->addValidator(new StringLength(array(
            'min' => 5
        )));
        $this->add($title);


        // Text
        $text = new EditorElement('text');
        $text->setLabel('Text');
        $text->setAttribute('class', 'form-control');
        $text->addValidator(new PresenceOf(array(
        )));
        $text->addValidator(new StringLength(array(
            'min' => 12
        )));
        $this->add($text);


        // Date
        $date = new TextElement('date');
        $date->setLabel('Date');
        $date->setAttribute('class', 'form-control');
        $this->add($date);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setAttribute("value", _("Submit"));
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
