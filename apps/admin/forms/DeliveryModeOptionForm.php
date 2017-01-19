<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class DeliveryModeOptionForm extends AtaForm {

    public function initialize() {


        // کد
        $id = new TextElement('id');
        $id->setLabel('کد');
        //$id->setAttribute('placeholder', 'Enter your کد');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // تیتر
        $title = new TextElement('title');
        $title->setLabel('تیتر');
        //$title->setAttribute('placeholder', 'Enter your تیتر');
        $title->setAttribute('class', 'form-control');
        $title->addValidator(new PresenceOf(array(
        )));
        $this->add($title);


        // نحوه ارسال مربوطه
        $delivery_mode_id = new SelectElement('delivery_mode_id', DeliveryMode::find(), array(
            "using" => array("id", "title")
        ));
        $delivery_mode_id->setLabel('نحوه ارسال مربوطه');
        //$delivery_mode_id->setAttribute('placeholder', 'Enter your نحوه ارسال مربوطه');
        $delivery_mode_id->setAttribute('class', 'form-control');
        $delivery_mode_id->addValidator(new PresenceOf(array(
        )));
        $this->add($delivery_mode_id);


        // توضیحات
        $description = new TextElement('description');
        $description->setLabel('توضیحات');
        //$description->setAttribute('placeholder', 'Enter your توضیحات');
        $description->setAttribute('class', 'form-control');
        $description->addValidator(new PresenceOf(array(
        )));
        $this->add($description);


        // وضعیت
        $status = new EnableDisableElement('status');
        $status->setLabel('وضعیت');
        //$status->setAttribute('placeholder', 'Enter your وضعیت');
        $status->setAttribute('class', 'form-control');
        $status->addValidator(new PresenceOf(array(
        )));
        $this->add($status);


        // ساعت شروع
        $time_start = new TextElement('time_start');
        $time_start->setLabel('ساعت شروع');
        //$time_start->setAttribute('placeholder', 'Enter your ساعت شروع');
        $time_start->setAttribute('class', 'form-control');
        $this->add($time_start);


        // ساعت پایان
        $time_end = new TextElement('time_end');
        $time_end->setLabel('ساعت پایان');
        //$time_end->setAttribute('placeholder', 'Enter your ساعت پایان');
        $time_end->setAttribute('class', 'form-control');
        $this->add($time_end);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
