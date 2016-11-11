<?php

use Phalcon\Forms\Element\Date;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class PromotionForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('کد استراتژی تخفیف');
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


        // By User ID
        $byuserid = new TextElement('byuserid');
        $byuserid->setLabel('توسط کاربر');
        //$byuserid->setAttribute('placeholder', 'Enter your By User ID');
        $byuserid->setAttribute('class', 'form-control');
        $this->add($byuserid);


        // End Date
        $end_date = new Date('end_date');
        $end_date->setLabel('تاریخ پایان');
        //$end_date->setAttribute('placeholder', 'Enter your End Date');
        $end_date->setAttribute('class', 'form-control');
        $end_date->addValidator(new PresenceOf(array(
        )));
        $this->add($end_date);


        // Total
        $total = new TextElement('total');
        $total->setLabel('حداکثر تعداد استفاده');
        //$total->setAttribute('placeholder', 'Enter your Total');
        $total->setAttribute('class', 'form-control');
        $total->addValidator(new PresenceOf(array(
        )));
        $this->add($total);


        // Default Percent
        $default_percent = new TextElement('default_percent');
        $default_percent->setLabel('درصد تخفیف پیش فرض');
        //$default_percent->setAttribute('placeholder', 'Enter your Default Percent');
        $default_percent->setAttribute('class', 'form-control');
        $default_percent->addValidator(new PresenceOf(array(
        )));
        $this->add($default_percent);


        // Default Fee
        $default_fee = new TextElement('default_fee');
        $default_fee->setLabel('مقدار تخفیف پیش فرض');
        //$default_fee->setAttribute('placeholder', 'Enter your Default Fee');
        $default_fee->setAttribute('class', 'form-control');
        $default_fee->addValidator(new PresenceOf(array(
        )));
        $this->add($default_fee);


        // Status
        $status = new SelectElement('status', array(
            PROMOTION_STATUS_SUSSPEND => "معلق",
            PROMOTION_STATUS_ACTIVE => "فعال",
            PROMOTION_STATUS_FINISHEDBYDATE => "غیر فعال - پایان مدت زمان",
            PROMOTION_STATUS_FINISHEDBYTOTALORDER => "غیر فعال - رسیدن به محدودیت تعداد"
        ));
        $status->setLabel('وضعیت');
        //$status->setAttribute('placeholder', 'Enter your Status');
        $status->setAttribute('class', 'form-control');
        $status->addValidator(new PresenceOf(array(
        )));
        $this->add($status);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
