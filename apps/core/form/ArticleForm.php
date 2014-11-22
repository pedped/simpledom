<?php

namespace Simpledom\Core;

use EditorElement;
use EnableDisableElement;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Simpledom\Core\AtaForm;
use TextElement;

class ArticleForm extends AtaForm {

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
        $title->addValidator(new StringLength(array(
            'min' => 8
        )));
        $this->add($title);

        // Link
        $link = new TextElement('link');
        $link->setLabel('Link');
        $link->setAttribute('class', 'form-control');
        $link->addValidator(new PresenceOf(array(
        )));
        $link->addValidator(new StringLength(array(
            'min' => 8
        )));
        $this->add($link);



        // Text
        $text = new EditorElement('text');
        $text->setLabel('Text');
        //$text->setAttribute('placeholder', 'Enter your Text');
        $text->setAttribute('class', 'form-control');
        $text->addValidator(new PresenceOf(array(
        )));
        $text->addValidator(new StringLength(array(
            'min' => 100
        )));
        $this->add($text);


        // User ID
        $userid = new TextElement('userid');
        $userid->setLabel('User ID');
        //$userid->setAttribute('placeholder', 'Enter your User ID');
        $userid->setAttribute('class', 'form-control');
        $userid->addValidator(new PresenceOf(array(
        )));
        $this->add($userid);


        // Date
        $date = new TextElement('date');
        $date->setLabel('Date');
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $this->add($date);


        // Approved
        $approved = new EnableDisableElement('approved');
        $approved->setLabel('Approved');
        //$approved->setAttribute('placeholder', 'Enter your Approved');
        $approved->setAttribute('class', 'form-control');
        $approved->addValidator(new PresenceOf(array(
        )));
        $this->add($approved);


        // Delete
        $delete = new EnableDisableElement('delete');
        $delete->setLabel('Delete');
        //$delete->setAttribute('placeholder', 'Enter your Delete');
        $delete->setAttribute('class', 'form-control');
        $delete->addValidator(new PresenceOf(array(
        )));
        $this->add($delete);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
