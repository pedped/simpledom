<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class DeviceForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Company
        $company = new TextElement('company');
        $company->setLabel('Company');
        //$company->setAttribute('placeholder', 'Enter your Company');
        $company->setAttribute('class', 'form-control');
        $this->add($company);


        // Category ID
        $categoryid = new SelectElement('categoryid', Category::find(), array(
            "using" => array("id", "title")
        ));
        $categoryid->setLabel('کمپانی');
        //$categoryid->setAttribute('placeholder', 'Enter your Category ID');
        $categoryid->setAttribute('class', 'form-control');
        $categoryid->addValidator(new PresenceOf(array(
        )));
        $this->add($categoryid);


        // Name
        $name = new TextElement('name');
        $name->setLabel('نام دستگاه');
        $name->setAttribute('placeholder', 'Galaxy S5');
        $name->setAttribute('class', 'form-control');
        $name->addValidator(new PresenceOf(array(
        )));
        $this->add($name);


        // Dimensions
        $dimensions = new TextElement('dimensions');
        $dimensions->setLabel('اندازه');
        $dimensions->setAttribute('placeholder', '150 * 110 * 30 mm');
        $dimensions->setAttribute('class', 'form-control');
        $dimensions->addValidator(new PresenceOf(array(
        )));
        $this->add($dimensions);


        // Weight
        $weight = new TextElement('weight');
        $weight->setLabel('وزن');
        $weight->setAttribute('placeholder', '115 گرم');
        $weight->setAttribute('class', 'form-control');
        $weight->addValidator(new PresenceOf(array(
        )));
        $this->add($weight);


        // Simcount
        $simcount = new SelectElement('simcount', array(
            "1" => "1 سیم کارت",
            "2" => "2 سیم کارت",
            "3" => "3 سیم کارت",
            "4" => "4 سیم کارت",
        ));
        $simcount->setLabel('تعداد سیم کارت');
        $simcount->setAttribute('class', 'form-control');
        $simcount->addValidator(new PresenceOf(array(
        )));
        $this->add($simcount);


        // Display
        $display = new TextElement('display');
        $display->setLabel('صفحه نمایش');
        $display->setAttribute('placeholder', '4.7 اینچ');
        $display->setAttribute('class', 'form-control');
        $display->addValidator(new PresenceOf(array(
        )));
        $this->add($display);


        // Resolution
        $resolution = new TextElement('resolution');
        $resolution->setLabel('کیفیت تصویر');
        $resolution->setAttribute('placeholder', '1920 * 1080');
        $resolution->setAttribute('class', 'form-control');
        $resolution->addValidator(new PresenceOf(array(
        )));
        $this->add($resolution);


        // SD Cart Support
        $sdsupport = new EnableDisableElement('sdsupport');
        $sdsupport->setLabel('پشتیباتی از کارت حافطه');
        //$sdsupport->setAttribute('placeholder', 'Enter your SD Cart Support');
        $sdsupport->setAttribute('class', 'form-control');
        $sdsupport->addValidator(new PresenceOf(array(
        )));
        $this->add($sdsupport);


        // OS
        $os = new TextElement('os');
        $os->setLabel('سیستم عامل');
        $os->setAttribute('placeholder', 'Android 4.4');
        $os->setAttribute('class', 'form-control');
        $os->addValidator(new PresenceOf(array(
        )));
        $this->add($os);


        // CPU
        $cpu = new TextElement('cpu');
        $cpu->setLabel('سی پی یو');
        $cpu->setAttribute('placeholder', 'Cortext A5 - 1.5 GHZ');
        $cpu->setAttribute('class', 'form-control');
        $cpu->addValidator(new PresenceOf(array(
        )));
        $this->add($cpu);


        // GPU
        $gpu = new TextElement('gpu');
        $gpu->setLabel('جی پی یو');
        $gpu->setAttribute('placeholder', 'Mali TP-726');
        $gpu->setAttribute('class', 'form-control');
        $gpu->addValidator(new PresenceOf(array(
        )));
        $this->add($gpu);


        // Internal_memory
        $internal_memory = new TextElement('internal_memory');
        $internal_memory->setLabel('حافظه داخلی');
        $internal_memory->setAttribute('placeholder', '16 GB');
        $internal_memory->setAttribute('class', 'form-control');
        $internal_memory->addValidator(new PresenceOf(array(
        )));
        $this->add($internal_memory);


        // Camera
        $camera = new TextElement('camera');
        $camera->setLabel('دوربین');
        $camera->setAttribute('placeholder', '5 مگاپیکسل دوربین جلو  - 16 مگا پیکسل دوربین عقب');
        $camera->setAttribute('class', 'form-control');
        $camera->addValidator(new PresenceOf(array(
        )));
        $this->add($camera);

        // Image
        $image = new FileElement('image');
        $image->setLabel('تصویر');
        $this->add($image);


        // More Info
        $moreinfo = new TextAreaElement('moreinfo');
        $moreinfo->setLabel('اطلاعات بیشتر');
        $moreinfo->setAttribute('placeholder', 'مجهز به لرزشگیر دست (optical image stabilization)
قابلیت فوکوس لمسی (Touch Focus )
دارای ردیاب خودکار چهره و لبخند (Face and Smile Detection)
قابلیت ثبت موقعیت زمانی و مکانی عکس گرفته شده بر روی آن (Geo-Tagging)
قابلیت هایی مانند Simultaneous HD video and image recording، Dual Shot، Simulataneous HD ، Panorama ، HDR');
        $moreinfo->setAttribute('class', 'form-control');
        $moreinfo->setAttribute('rows', '6');
        $this->add($moreinfo);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary btn-lg');
        $submit->setAttribute('value', 'ارسال');
        $this->add($submit);
    }

}
