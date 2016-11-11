<?php

use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class InvoiceForm extends AtaForm {

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


        // Price
        $price = new TextElement('price');
        $price->setLabel('مجموع قیمت');
        //$price->setAttribute('placeholder', 'Enter your Price');
        $price->setAttribute('class', 'form-control');
        $this->add($price);


        // Currency
        $currency = new TextElement('currency');
        $currency->setLabel('واحد');
        //$currency->setAttribute('placeholder', 'Enter your Currency');
        $currency->setAttribute('class', 'form-control');
        $this->add($currency);


        // Status
        $status = new TextElement('status');
        $status->setLabel('وضعیت سفارش');
        //$status->setAttribute('placeholder', 'Enter your Status');
        $status->setAttribute('class', 'form-control');
        $this->add($status);


        // User Status
        $user_status = new TextElement('user_status');
        $user_status->setLabel('وضعیت کاربر');
        //$user_status->setAttribute('placeholder', 'Enter your User Status');
        $user_status->setAttribute('class', 'form-control');
        $this->add($user_status);


        // City ID
        $cityid = new TextElement('cityid');
        $cityid->setLabel('شهر');
        //$cityid->setAttribute('placeholder', 'Enter your City ID');
        $cityid->setAttribute('class', 'form-control');
        $this->add($cityid);


        // Address
        $address = new TextElement('address');
        $address->setLabel('آدرس');
        //$address->setAttribute('placeholder', 'Enter your Address');
        $address->setAttribute('class', 'form-control');
        $address->addValidator(new PresenceOf(array(
        )));
        $this->add($address);


        // User Comment
        $usercomment = new TextElement('usercomment');
        $usercomment->setLabel('توضیحات کاربر');
        //$usercomment->setAttribute('placeholder', 'Enter your User Comment');
        $usercomment->setAttribute('class', 'form-control');
        $usercomment->addValidator(new PresenceOf(array(
        )));
        $this->add($usercomment);


        // Address Longitude
        $address_longitude = new TextElement('address_longitude');
        $address_longitude->setLabel('طول جغرافیایی');
        //$address_longitude->setAttribute('placeholder', 'Enter your Address Longitude');
        $address_longitude->setAttribute('class', 'form-control');
        $this->add($address_longitude);


        // Address Latitude
        $address_latitude = new TextElement('address_latitude');
        $address_latitude->setLabel('عرض جغرافیایی');
        //$address_latitude->setAttribute('placeholder', 'Enter your Address Latitude');
        $address_latitude->setAttribute('class', 'form-control');
        $this->add($address_latitude);


        // Address GPSApprox
        $address_gpsapprox = new TextElement('address_gpsapprox');
        $address_gpsapprox->setLabel('محدوده جی پی اس');
        //$address_gpsapprox->setAttribute('placeholder', 'Enter your Address GPSApprox');
        $address_gpsapprox->setAttribute('class', 'form-control');
        $this->add($address_gpsapprox);


        // Phone
        $phone = new TextElement('phone');
        $phone->setLabel('شماره تماس');
        //$phone->setAttribute('placeholder', 'Enter your Phone');
        $phone->setAttribute('class', 'form-control');
        $this->add($phone);


        // Mobile
        $mobile = new TextElement('mobile');
        $mobile->setLabel('شماره موبایل');
        //$mobile->setAttribute('placeholder', 'Enter your Mobile');
        $mobile->setAttribute('class', 'form-control');
        $this->add($mobile);


        // Deliver Date
        $deliverdate = new TextElement('deliverdate');
        $deliverdate->setLabel('تاریخ تحویل');
        //$deliverdate->setAttribute('placeholder', 'Enter your Deliver Date');
        $deliverdate->setAttribute('class', 'form-control');
        $this->add($deliverdate);


        // Deliver Date
        $map = new MapElement('map');
        $map->setMarkTitle("موقعیت سفارش دهنده");
        $map->setMarkDescription("موقعیت سفارش دهنده");
        $map->setLabel('موقعیت روی نقشه');
        $this->add($map);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $submit->setAttribute('value', 'تغییر');
        $this->add($submit);
    }

}
