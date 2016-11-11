<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;
use Simpledom\Core\Classes\Config;

class PromotionProductForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('کد');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // By User ID
        $byuserid = new TextElement('byuserid');
        $byuserid->setLabel('توسط کاربر');
        //$byuserid->setAttribute('placeholder', 'Enter your By User ID');
        $byuserid->setAttribute('class', 'form-control');
        $this->add($byuserid);


        // Product ID
        $productid = new TagEditElement('productid');
        $productid->setAutocompleteSource(Config::getPublicUrl() . "/admin/api/listproducts");
        $productid->setLabel('کد محصول');
        //$productid->setAttribute('placeholder', 'Enter your Product ID');
        $productid->setAttribute('class', 'form-control');
        $productid->addValidator(new PresenceOf(array(
        )));
        $this->add($productid);


        // Promotion ID
        $promotionid = new TextElement('promotionid');
        $promotionid->setLabel('کد تخفیف');
        //$promotionid->setAttribute('placeholder', 'Enter your Promotion ID');
        $promotionid->setAttribute('class', 'form-control');
        $this->add($promotionid);


        // Total Order Per User
        $totalorderperuser = new TextElement('totalorderperuser');
        $totalorderperuser->setLabel('حداکثر تعداد سفارش برای هر کاربر در روز');
        //$totalorderperuser->setAttribute('placeholder', 'Enter your Total Order Per User');
        $totalorderperuser->setAttribute('class', 'form-control');
        $totalorderperuser->addValidator(new PresenceOf(array(
        )));
        $this->add($totalorderperuser);


        // Total Order
        $totalorder = new TextElement('totalorder');
        $totalorder->setLabel('حداکثر تعداد سفارش از این محصول');
        //$totalorder->setAttribute('placeholder', 'Enter your Total Order');
        $totalorder->setAttribute('class', 'form-control');
        $totalorder->addValidator(new PresenceOf(array(
        )));
        $this->add($totalorder);


        // Title
        $title = new TextElement('title');
        $title->setLabel('تیتر( اختیاری)');
        //$title->setAttribute('placeholder', 'Enter your Title');
        $title->setAttribute('class', 'form-control');
   
        $this->add($title);


        // Percent
        $percent = new TextElement('percent');
        $percent->setLabel('درصد تخفیف');
        //$percent->setAttribute('placeholder', 'Enter your Percent');
        $percent->setAttribute('class', 'form-control');
        $percent->addValidator(new PresenceOf(array(
        )));
        $this->add($percent);


        // Fee
        $fee = new TextElement('fee');
        $fee->setLabel('مفدار تخفیف');
        //$fee->setAttribute('placeholder', 'Enter your Fee');
        $fee->setAttribute('class', 'form-control');
        $fee->addValidator(new PresenceOf(array(
        )));
        $this->add($fee);


        // Status
        $status = new SelectElement('status', array(
            PROMOTION_PRODUCT_STATUS_ACTIVE => "فعال",
            PROMOTION_PRODUCT_STATUS_SUSSPEND => "معلق",
            PROMOTION_PRODUCT_STATUS_FINISHED => "پایان موجودی",
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
