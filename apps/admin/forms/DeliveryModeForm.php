<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class DeliveryModeForm extends AtaForm {

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


        // Description
        $description = new TextElement('description');
        $description->setLabel('توضیحات');
        //$description->setAttribute('placeholder', 'Enter your Description');
        $description->setAttribute('class', 'form-control');
        $description->addValidator(new PresenceOf(array(
        )));
        $this->add($description);


        // Full Introduction
        $full_introduction = new TextAreaElement('full_introduction');
        $full_introduction->setLabel('توضیحات کامل');
        //$full_introduction->setAttribute('placeholder', 'Enter your Full Introduction');
        $full_introduction->setAttribute('class', 'form-control');
        $full_introduction->addValidator(new PresenceOf(array(
        )));
        $this->add($full_introduction);


        // Min Price
        $min_price = new TextElement('min_price');
        $min_price->setLabel('حداقل قیمت');
        //$min_price->setAttribute('placeholder', 'Enter your Min Price');
        $min_price->setAttribute('class', 'form-control');
        $this->add($min_price);


        // Max Price
        $max_price = new TextElement('max_price');
        $max_price->setLabel('حداثر قیمت');
        //$max_price->setAttribute('placeholder', 'Enter your Max Price');
        $max_price->setAttribute('class', 'form-control');
        $this->add($max_price);


        // Min Count
        $min_count = new TextElement('min_count');
        $min_count->setLabel('حداقل تعداد');
        //$min_count->setAttribute('placeholder', 'Enter your Min Count');
        $min_count->setAttribute('class', 'form-control');
        $this->add($min_count);


        // Max Count
        $max_count = new TextElement('max_count');
        $max_count->setLabel('حداکثر تعداد');
        //$max_count->setAttribute('placeholder', 'Enter your Max Count');
        $max_count->setAttribute('class', 'form-control');
        $this->add($max_count);


        // Last Update
        $lastupdate = new TextElement('lastupdate');
        $lastupdate->setLabel('Last Update');
        //$lastupdate->setAttribute('placeholder', 'Enter your Last Update');
        $lastupdate->setAttribute('class', 'form-control');
        $this->add($lastupdate);


        // Status
        $status = new EnableDisableElement('status');
        $status->setLabel('وضعیت');
        //$status->setAttribute('placeholder', 'Enter your Status');
        $status->setAttribute('class', 'form-control');
        $status->addValidator(new PresenceOf(array(
        )));
        $this->add($status);


        // Base Cost
        $basecost = new TextElement('basecost');
        $basecost->setLabel('حداقل هزینه');
        $basecost->setFooter("در صورتی که این نحوه ارسال برای کاربر دارای حداقل هزینه ای می باشد، هزینه را در این قسمت وارد نمایید");
        //$basecost->setAttribute('placeholder', 'Enter your Base Cost');
        $basecost->setAttribute('class', 'form-control');
        $this->add($basecost);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
