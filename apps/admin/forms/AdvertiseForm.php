<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class AdvertiseForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // User ID
        $userid = new TextElement('userid');
        $userid->setLabel('کد کاربر');
        //$userid->setAttribute('placeholder', 'Enter your User ID');
        $userid->setAttribute('class', 'form-control');
        $this->add($userid);


        // IP
        $ip = new TextElement('ip');
        $ip->setLabel('آی پی');
        //$ip->setAttribute('placeholder', 'Enter your IP');
        $ip->setAttribute('class', 'form-control');
        $this->add($ip);


        // Date
        $date = new TextElement('date');
        $date->setLabel('تاریخ');
        //$date->setAttribute('placeholder', 'Enter your Date');
        $date->setAttribute('class', 'form-control');
        $this->add($date);


        // Device ID
        $deviceid = new SelectElement('deviceid', Device::find(), array(
            "using" => array(
                "id", "name"
            )
        ));
        $deviceid->setLabel('دستگاه');
        //$deviceid->setAttribute('placeholder', 'Enter your Device ID');
        $deviceid->setAttribute('class', 'form-control');
        $this->add($deviceid);


        // Current View
        $currentview = new TextElement('currentview');
        $currentview->setLabel('وضعیت ظاهری');
        //$currentview->setAttribute('placeholder', 'Enter your Current View');
        $currentview->setAttribute('class', 'form-control');
        $currentview->addValidator(new PresenceOf(array(
        )));
        $this->add($currentview);

        // Current View
        $description = new TextAreaElement('description');
        $description->setLabel('توضیحات');
        $description->setAttribute('class', 'form-control');
        $this->add($description);


        // Repaired
        $repaired = new EnableDisableElement('repaired');
        $repaired->setLabel('تعمیر شدگی');
        //$repaired->setAttribute('placeholder', 'Enter your Repaired');
        $repaired->setAttribute('class', 'form-control');
        $repaired->addValidator(new PresenceOf(array(
        )));
        $this->add($repaired);

        // Repaired
        $status = new SelectElement('status', array(
            "-1" => "در انتظار تایید",
            "0" => "رد شده",
            "1" => "تایید شده",
        ));
        $status->setLabel('وضعیت');
        //$repaired->setAttribute('placeholder', 'Enter your Repaired');
        $status->setAttribute('class', 'form-control');
        $status->addValidator(new PresenceOf(array(
        )));
        $this->add($status);


        // Haveholder
        $haveholder = new EnableDisableElement('haveholder');
        $haveholder->setLabel('Haveholder');
        //$haveholder->setAttribute('placeholder', 'Enter your Haveholder');
        $haveholder->setAttribute('class', 'form-control');
        $this->add($haveholder);


        // Price
        $price = new TextElement('price');
        $price->setLabel('قیمت');
        //$price->setAttribute('placeholder', 'Enter your Price');
        $price->setAttribute('class', 'form-control');
        $price->addValidator(new PresenceOf(array(
        )));
        $this->add($price);


        // Garantee
        $garantee = new TextElement('garantee');
        $garantee->setLabel('گارانتی');
        //$garantee->setAttribute('placeholder', 'Enter your Garantee');
        $garantee->setAttribute('class', 'form-control');
        $this->add($garantee);


        // More Accecories
        $moreacc = new TextArea('moreacc');
        $moreacc->setLabel('لوازم اضافه');
        //$moreacc->setAttribute('placeholder', 'Enter your More Accecories');
        $moreacc->setAttribute('class', 'form-control');
        $this->add($moreacc);


        // Visit Time
        $visittime = new TextArea('visittime');
        $visittime->setLabel('تاریخ بازدید');
        //$visittime->setAttribute('placeholder', 'Enter your Visit Time');
        $visittime->setAttribute('class', 'form-control');
        $this->add($visittime);


        // Image ID
        $imageid = new TextElement('imageid');
        $imageid->setLabel('کد تصویر');
        //$imageid->setAttribute('placeholder', 'Enter your Image ID');
        $imageid->setAttribute('class', 'form-control');
        $this->add($imageid);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary btn-lg btn-block');
        $submit->setAttribute('value', 'ارسال');
        $this->add($submit);
    }

}
