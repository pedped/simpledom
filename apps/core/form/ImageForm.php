<?php

namespace Simpledom\Core;

use ImageElement;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Simpledom\Core\AtaForm;
use TextElement;

class ImageForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);

        // Path
        $path = new TextElement('path');
        $path->setLabel(_('Path'));
        //$path->setAttribute('placeholder', 'Enter your Path');
        $path->setAttribute('class', 'form-control');
        $path->addValidator(new PresenceOf(array(
        )));
        $path->addValidator(new StringLength(array(
            'min' => 2,
        )));
        $this->add($path);


        // Image
        $image = new ImageElement('image');
        $image->setLabel('Image');
        $this->add($image);

        // Date
        $date = new Text('date');
        $date->setLabel(_('Date'));
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $date->addValidator(new PresenceOf(array(
        )));
        $date->addValidator(new StringLength(array(
            'min' => 2,
        )));
        $this->add($date);

        // Mime Type
        $mimetype = new TextElement('mimetype');
        $mimetype->setLabel(_('Mime Type'));
        //$mimetype->setAttribute('placeholder', 'Enter your Mime Type');
        $mimetype->setAttribute('class', 'form-control');
        $mimetype->addValidator(new PresenceOf(array(
        )));
        $mimetype->addValidator(new StringLength(array(
            'min' => 2,
        )));
        $this->add($mimetype);

        // File Size
        $filesize = new TextElement('filesize');
        $filesize->setLabel(_('File Size'));
        //$filesize->setAttribute('placeholder', 'Enter your File Size');
        $filesize->setAttribute('class', 'form-control');
        $filesize->addValidator(new PresenceOf(array(
        )));
        $filesize->addValidator(new StringLength(array(
            'min' => 2,
        )));
        $this->add($filesize);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setAttribute("value", _("Submit"));
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
