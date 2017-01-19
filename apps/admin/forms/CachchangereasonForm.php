<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class CachchangereasonForm extends AtaForm {

    public function initialize() {


        // کد
        $id = new TextElement('id');
        $id->setLabel('کد');
        //$id->setAttribute('placeholder', 'Enter your کد');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // نام
        $name = new TextElement('name');
        $name->setLabel('نام');
        //$name->setAttribute('placeholder', 'Enter your نام');
        $name->setAttribute('class', 'form-control');
        $name->addValidator(new PresenceOf(array(
        )));
        $this->add($name);


        // توضیحات
        $description = new TextElement('description');
        $description->setLabel('توضیحات');
        //$description->setAttribute('placeholder', 'Enter your توضیحات');
        $description->setAttribute('class', 'form-control');
        $description->addValidator(new PresenceOf(array(
        )));
        $this->add($description);


        // افزایشی
        $increase = new EnableDisableElement('increase');
        $increase->setLabel('افزایشی');
        //$increase->setAttribute('placeholder', 'Enter your افزایشی');
        $increase->setAttribute('class', 'form-control');
        $increase->addValidator(new PresenceOf(array(
        )));
        $this->add($increase);


        // هدیه می باشد
        $isgift = new EnableDisableElement('isgift');
        $isgift->setLabel('هدیه می باشد');
        $isgift->setFooter("ایا این تغییر اعتبار یک هدیه برای کاربر می باشد");
        $isgift->setAttribute('class', 'form-control');
        $isgift->addValidator(new PresenceOf(array(
        )));
        $this->add($isgift);


        // تصویر
        $imageid = new FileElement('imageid');
        $imageid->setLabel('تصویر');
        //$imageid->setAttribute('placeholder', 'Enter your تصویر');
//        $imageid->setAttribute('class', 'form-control');
        $this->add($imageid);

        // هزینه
        $amount = new TextElement('amount');
        $amount->setLabel('هزینه');
        //$imageid->setAttribute('placeholder', 'Enter your تصویر');
        $amount->setAttribute('class', 'form-control');
        $this->add($amount);
        

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
