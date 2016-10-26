<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class ProductForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('کد محصول');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Title
        $title = new TextElement('title');
        $title->setLabel('نام محصول');
        //$title->setAttribute('placeholder', 'Enter your Title');
        $title->setAttribute('class', 'form-control');
        $title->addValidator(new PresenceOf(array(
        )));
        $this->add($title);


        // Category ID
        $categoryid = new SelectElement('categoryid');
        $categoryid->setLabel('دسته بندی');
        //$categoryid->setAttribute('placeholder', 'Enter your Category ID');
        $categoryid->setAttribute('class', 'form-control');
        $categoryid->addValidator(new PresenceOf(array(
        )));
        $this->add($categoryid);


        // Timestamp
        $timestamp = new TextElement('timestamp');
        $timestamp->setLabel('Timestamp');
        //$timestamp->setAttribute('placeholder', 'Enter your Timestamp');
        $timestamp->setAttribute('class', 'form-control');
        $this->add($timestamp);


        // Description
        $description = new TextArea('description');
        $description->setLabel('توضیحات');
        //$description->setAttribute('placeholder', 'Enter your Description');
        $description->setAttribute('class', 'form-control');
//        $description->addValidator(new PresenceOf(array(
//        )));
        $this->add($description);


        // Voice Path
        $voicepath = new FileElement('voicepath');
        $voicepath->setLabel('فایل صوتی');
        //$voicepath->setAttribute('placeholder', 'Enter your Voice Path');
        $this->add($voicepath);


        // Barcode
        $barcode = new TextElement('barcode');
        $barcode->setLabel('بارکد');
        //$barcode->setAttribute('placeholder', 'Enter your Barcode');
        $barcode->setAttribute('class', 'form-control');
//        $barcode->addValidator(new PresenceOf(array(
//        )));
        $this->add($barcode);


        // Height
        $height = new TextElement('height');
        $height->setLabel('ارتفاع');
        //$height->setAttribute('placeholder', 'Enter your Height');
        $height->setAttribute('class', 'form-control');
//        $height->addValidator(new PresenceOf(array(
//        )));
        $this->add($height);


        // Weight
        $weight = new TextElement('weight');
        $weight->setLabel('وزن');
        //$weight->setAttribute('placeholder', 'Enter your Weight');
        $weight->setAttribute('class', 'form-control');
//        $weight->addValidator(new PresenceOf(array(
//        )));
        $this->add($weight);


        // Depth
        $depth = new TextElement('depth');
        $depth->setLabel('عمق');
        //$depth->setAttribute('placeholder', 'Enter your Depth');
        $depth->setAttribute('class', 'form-control');
//        $depth->addValidator(new PresenceOf(array(
//        )));
        $this->add($depth);



        // Status
        $status = new EnableDisableElement('status');
        $status->setLabel('وضعیت');
        //$status->setAttribute('placeholder', 'Enter your Status');
        $status->setAttribute('class', 'form-control');
        $status->addValidator(new PresenceOf(array(
        )));
        $this->add($status);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute("label", "ارسال");
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
