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
        $path->setLabel('Path');
        //$path->setAttribute('placeholder', 'Enter your Path');
        $path->setAttribute('class', 'form-control');
        $path->addValidator(new PresenceOf(array(
            'message' => 'The Path is required'
        )));
        $path->addValidator(new StringLength(array(
            'min' => 2,
            'messageMinimum' => 'The Path is too short'
        )));
        $this->add($path);


        // Image
        $image = new ImageElement('image');
        $image->setLabel('Image');
        $this->add($image);

        // Date
        $date = new Text('date');
        $date->setLabel('Date');
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $date->addValidator(new PresenceOf(array(
            'message' => 'The Date is required'
        )));
        $date->addValidator(new StringLength(array(
            'min' => 2,
            'messageMinimum' => 'The Date is too short'
        )));
        $this->add($date);

        // Mime Type
        $mimetype = new TextElement('mimetype');
        $mimetype->setLabel('Mime Type');
        //$mimetype->setAttribute('placeholder', 'Enter your Mime Type');
        $mimetype->setAttribute('class', 'form-control');
        $mimetype->addValidator(new PresenceOf(array(
            'message' => 'The Mime Type is required'
        )));
        $mimetype->addValidator(new StringLength(array(
            'min' => 2,
            'messageMinimum' => 'The Mime Type is too short'
        )));
        $this->add($mimetype);

        // File Size
        $filesize = new TextElement('filesize');
        $filesize->setLabel('File Size');
        //$filesize->setAttribute('placeholder', 'Enter your File Size');
        $filesize->setAttribute('class', 'form-control');
        $filesize->addValidator(new PresenceOf(array(
            'message' => 'The File Size is required'
        )));
        $filesize->addValidator(new StringLength(array(
            'min' => 2,
            'messageMinimum' => 'The File Size is too short'
        )));
        $this->add($filesize);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
