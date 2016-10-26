<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class StockForm extends AtaForm {

    public function initialize() {


        // ID
        $id = new TextElement('id');
        $id->setLabel('ID');
        //$id->setAttribute('placeholder', 'Enter your ID');
        $id->setAttribute('class', 'form-control');
        $this->add($id);


        // Buy Price
        $buyprice = new TextElement('buyprice');
        $buyprice->setLabel('قیمت خرید');
        //$buyprice->setAttribute('placeholder', 'Enter your Buy Price');
        $buyprice->setAttribute('class', 'form-control');
        $buyprice->addValidator(new PresenceOf(array(
        )));
        $this->add($buyprice);


        // Sell Price
        $sellprice = new TextElement('sellprice');
        $sellprice->setLabel('قیمت فروش');
        //$sellprice->setAttribute('placeholder', 'Enter your Sell Price');
        $sellprice->setAttribute('class', 'form-control');
        $sellprice->addValidator(new PresenceOf(array(
        )));
        $this->add($sellprice);


        // Product ID
        $productid = new SelectElement('productid', Product::find(
                        array(
                            'order' => 'title ASC'
                )), array(
            "using" => array("id", "title")
        ));
        $productid->setLabel('کد محصول');
        //$productid->setAttribute('placeholder', 'Enter your Product ID');
        $productid->setAttribute('class', 'form-control');
        $productid->addValidator(new PresenceOf(array(
        )));
        $this->add($productid);


        // Total
        $total = new TextElement('total');
        $total->setLabel('تعداد');
        //$total->setAttribute('placeholder', 'Enter your Total');
        $total->setAttribute('class', 'form-control');
        $total->addValidator(new PresenceOf(array(
        )));
        $this->add($total);


        // Expire Date
        $expiredate = new TextElement('expiredate');
        $expiredate->setLabel('تاریخ انقضا');
        //$expiredate->setAttribute('placeholder', 'Enter your Expire Date');
        $expiredate->setAttribute('class', 'form-control');
        $expiredate->addValidator(new PresenceOf(array(
        )));
        $this->add($expiredate);


        // Warehouse Part ID
        $warehousepartid = new TextElement('warehousepartid');
        $warehousepartid->setLabel('کد زیرشاخه انبار');
        //$warehousepartid->setAttribute('placeholder', 'Enter your Warehouse Part ID');
        $warehousepartid->setAttribute('class', 'form-control');
        $warehousepartid->addValidator(new PresenceOf(array(
        )));
        $this->add($warehousepartid);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
