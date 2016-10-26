<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class CategoryForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Parent Category
        $parentcategory = new SelectElement('parentcategory');
        $parentcategory->setLabel('دسته والد');
        //$parentcategory->setAttribute('placeholder', 'Enter your Parent Category');
        $parentcategory->setAttribute('class', 'form-control');
//        $parentcategory->addValidator(new PresenceOf(array(
//        )));
        $this->add($parentcategory);


        // Title
        $title = new TextElement('title');
        $title->setLabel('تیتر');
        //$title->setAttribute('placeholder', 'Enter your Title');
        $title->setAttribute('class', 'form-control');
        $title->addValidator(new PresenceOf(array(
        )));
        $this->add($title);


        // Image ID
        $imageid = new FileElement('imageid');
        $imageid->setLabel('تصویر');
        //$imageid->setAttribute('placeholder', 'Enter your Image ID');
//        $imageid->setAttribute('class', 'form-control');
//        $imageid->addValidator(new PresenceOf(array(
//        )));
        $this->add($imageid);


        // Description
        $description = new TextAreaElement('description');
        $description->setLabel('توضیحات دسته');
        //$description->setAttribute('placeholder', 'Enter your Description');
        $description->setAttribute('class', 'form-control');
//        $description->addValidator(new PresenceOf(array(
//        )));
        $this->add($description);


        // Active
        $active = new EnableDisableElement('active');
        $active->setLabel('Active');
        //$active->setAttribute('placeholder', 'Enter your Active');
        $active->setAttribute('class', 'form-control');
        $active->addValidator(new PresenceOf(array(
        )));
        $this->add($active);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
