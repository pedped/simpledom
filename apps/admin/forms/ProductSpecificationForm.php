<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class ProductSpecificationForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('کد');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Product ID
        $productid = new ProductSelectElement('productid');
        $productid->setLabel('نام محصول( محصولات)');
        //$productid->setAttribute('placeholder', 'Enter your Product ID');
        $productid->setAttribute('class', 'form-control');
        $productid->addValidator(new PresenceOf(array(
        )));
        $this->add($productid);


        // Title
        $title = new TextElement('title');
        $title->setLabel('تیتر');
        //$title->setAttribute('placeholder', 'Enter your Title');
        $title->setAttribute('class', 'form-control');
        $title->addValidator(new PresenceOf(array(
        )));
        $this->add($title);


        // Value
        $value = new TextAreaElement('value');
        $value->setLabel('توضیحات');
        //$value->setAttribute('placeholder', 'Enter your Value');
        $value->setAttribute('class', 'form-control');
        $value->addValidator(new PresenceOf(array(
        )));
        $this->add($value);


        // Order ID
        $orderid = new TextElement('orderid');
        $orderid->setLabel('Order ID');
        //$orderid->setAttribute('placeholder', 'Enter your Order ID');
        $orderid->setAttribute('class', 'form-control');
        $orderid->setDefault(0);
        $this->add($orderid);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute("value", 'ارسال');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
