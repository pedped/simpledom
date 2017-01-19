<?php

use Phalcon\Forms\Element\Submit;
use Simpledom\Core\AtaForm;

class InvoiceStatusForm extends AtaForm {

    public function initialize() {

        // ID
        $id = new SelectElement('status', array(
            INVOICESTATUS_REQUESTED => "درخواست کاربر",
            INVOICESTATUS_PROCCESSINGINWAREHOUSE => "پردازش انبار",
            INVOICESTATUS_PACAKING => " بسته بندی",
            INVOICESTATUS_SENDING => "در حال ارسال",
            INVOICESTATUS_RECEIVED => "دریافت شده",
            INVOICESTATUS_CANCELLEDBYUSER => "انصراف کاربر",
            INVOICESTATUS_CANCELEDBYCENTER => "رد شده توسط مرکز"
        ));
        $id->setLabel('وضعیت سفارش');
        $id->setAttribute('class', 'form-control');
        $this->add($id);



        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('value', "تغییر");
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
