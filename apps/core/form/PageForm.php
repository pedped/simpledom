<?php

namespace Simpledom\Core;

use EditorElement;
use EnableDisableElement;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use TextElement;

class PageForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel(_('ID'));
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Key
        $key = new TextElement('key');
        $key->setLabel(_('Key'));
        //$key->setAttribute('placeholder', 'Enter your Key');
        $key->setAttribute('class', 'form-control');
        $key->addValidator(new PresenceOf(array(
        )));
        $key->addValidator(new StringLength(array(
            'min' => 4
        )));
        $this->add($key);


        // Title
        $title = new TextElement('title');
        $title->setLabel(_('Title'));
        //$title->setAttribute('placeholder', 'Enter your Title');
        $title->setAttribute('class', 'form-control');
        $title->addValidator(new PresenceOf(array(
        )));
        $title->addValidator(new StringLength(array(
            'min' => 4
        )));
        $this->add($title);


        // Text
        $text = new EditorElement('text');
        $text->setLabel(_('Text'));
        //$text->setAttribute('placeholder', 'Enter your Text');
        $text->setAttribute('class', 'form-control');
        $text->addValidator(new PresenceOf(array(
        )));
        $text->addValidator(new StringLength(array(
            'min' => 12
        )));
        $this->add($text);


        // Metadata Tags
        $metakey = new TextElement('metakey');
        $metakey->setLabel(_('Metadata Tags'));
        //$metakey->setAttribute('placeholder', 'Enter your Metadata Tags');
        $metakey->setAttribute('class', 'form-control');
        $this->add($metakey);


        // Metadata Description
        $metadata = new TextElement('metadata');
        $metadata->setLabel(_('Metadata Description'));
        //$metadata->setAttribute('placeholder', 'Enter your Metadata Description');
        $metadata->setAttribute('class', 'form-control');
        $this->add($metadata);


        // Show In Header
        $showinhead = new EnableDisableElement('showinhead');
        $showinhead->setLabel(_('Show In Header'));
        //$showinhead->setAttribute('placeholder', 'Enter your Show In Header');
        $showinhead->setAttribute('class', 'form-control');
        $this->add($showinhead);


        // Footer Text
        $footer = new TextElement('footer');
        $footer->setLabel(_('Footer Text'));
        //$footer->setAttribute('placeholder', 'Enter your Footer Text');
        $footer->setAttribute('class', 'form-control');
        $this->add($footer);


        // Date
        $date = new TextElement('date');
        $date->setLabel(_('Date'));
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $this->add($date);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setAttribute("value", _("Submit"));
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
