<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class CategoryForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('کد');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Title
        $title = new TextElement('title');
        $title->setLabel('تیتر');
        //$title->setAttribute('placeholder', 'Enter your Title');
        $title->setAttribute('class', 'form-control');
        $title->addValidator(new PresenceOf(array(
        )));
        $this->add($title);


        // Date
        $date = new TextAreaElement('date');
        $date->setLabel('تاریخ');
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $this->add($date);


        // Description
        $description = new TextAreaElement('description');
        $description->setLabel('توضیحات دسته');
        //$description->setAttribute('placeholder', 'Enter your Description');
        $description->setAttribute('class', 'form-control');
        $description->addValidator(new PresenceOf(array(
        )));
        $this->add($description);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
