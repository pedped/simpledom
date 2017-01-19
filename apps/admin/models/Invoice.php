<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;
use Phalcon\Mvc\Model\Validator\Email as Email;
use Simpledom\Core\AtaModel;

class Invoice extends AtaModel {

    public function initialize() {
        
    }

    public function getSource() {
        return 'invoice';
    }

    /**
     * ID
     * @FieldName('ID')
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return Invoice
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * User ID
     * @FieldName('User ID')
     * @var string
     */
    public $userid;

    /**
     * Set User ID
     * @param type $userid
     * @return Invoice
     */
    public function setUserid($userid) {
        $this->userid = $userid;
        return $this;
    }

    /**
     * Price
     * @FieldName('Price')
     * @var string
     */
    public $price;

    /**
     * Set Price
     * @param type $price
     * @return Invoice
     */
    public function setPrice($price) {
        $this->price = $price;
        return $this;
    }

    /**
     * Currency
     * @FieldName('Currency')
     * @var string
     */
    public $currency;

    /**
     * Set Currency
     * @param type $currency
     * @return Invoice
     */
    public function setCurrency($currency) {
        $this->currency = $currency;
        return $this;
    }

    /**
     * Status
     * @FieldName('Status')
     * @var string
     */
    public $status;

    /**
     * Set Status
     * @param type $status
     * @return Invoice
     */
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    /**
     * User Status
     * @FieldName('User Status')
     * @var string
     */
    public $user_status;

    /**
     * Set User Status
     * @param type $user_status
     * @return Invoice
     */
    public function setUser_status($user_status) {
        $this->user_status = $user_status;
        return $this;
    }

    /**
     * City ID
     * @FieldName('City ID')
     * @var string
     */
    public $cityid;

    /**
     * Set City ID
     * @param type $cityid
     * @return Invoice
     */
    public function setCityid($cityid) {
        $this->cityid = $cityid;
        return $this;
    }

    /**
     * Address
     * @FieldName('Address')
     * @var string
     */
    public $address;

    /**
     * Set Address
     * @param type $address
     * @return Invoice
     */
    public function setAddress($address) {
        $this->address = $address;
        return $this;
    }

    /**
     * User Comment
     * @FieldName('User Comment')
     * @var string
     */
    public $usercomment;

    /**
     * Set User Comment
     * @param type $usercomment
     * @return Invoice
     */
    public function setUsercomment($usercomment) {
        $this->usercomment = $usercomment;
        return $this;
    }

    /**
     * Address Longitude
     * @FieldName('Address Longitude')
     * @var string
     */
    public $address_longitude;

    /**
     * Set Address Longitude
     * @param type $address_longitude
     * @return Invoice
     */
    public function setAddress_longitude($address_longitude) {
        $this->address_longitude = $address_longitude;
        return $this;
    }

    /**
     * Address Latitude
     * @FieldName('Address Latitude')
     * @var string
     */
    public $address_latitude;

    /**
     * Set Address Latitude
     * @param type $address_latitude
     * @return Invoice
     */
    public function setAddress_latitude($address_latitude) {
        $this->address_latitude = $address_latitude;
        return $this;
    }

    /**
     * Address GPSApprox
     * @FieldName('Address GPSApprox')
     * @var string
     */
    public $address_gpsapprox;

    /**
     * Set Address GPSApprox
     * @param type $address_gpsapprox
     * @return Invoice
     */
    public function setAddress_gpsapprox($address_gpsapprox) {
        $this->address_gpsapprox = $address_gpsapprox;
        return $this;
    }

    /**
     * Date
     * @FieldName('Date')
     * @var string
     */
    public $date;

    /**
     * Set Date
     * @param type $date
     * @return Invoice
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * Phone
     * @FieldName('Phone')
     * @var string
     */
    public $phone;

    /**
     * Set Phone
     * @param type $phone
     * @return Invoice
     */
    public function setPhone($phone) {
        $this->phone = $phone;
        return $this;
    }

    /**
     * Mobile
     * @FieldName('Mobile')
     * @var string
     */
    public $mobile;

    /**
     * Set Mobile
     * @param type $mobile
     * @return Invoice
     */
    public function setMobile($mobile) {
        $this->mobile = $mobile;
        return $this;
    }

    /**
     * Deliver Date
     * @FieldName('Deliver Date')
     * @var string
     */
    public $deliverdate;

    /**
     * Set Deliver Date
     * @param type $deliverdate
     * @return Invoice
     */
    public function setDeliverdate($deliverdate) {
        $this->deliverdate = $deliverdate;
        return $this;
    }

    public function getDate() {
        return Jalali::date('Y-m-d H:m:s', $this->date);
    }

    public function getUserName() {
        return isset($this->userid) ? BaseUser::findFirst($this->userid)->getFullName() : '<no user>';
    }

    /**
     *
     * @param type $parameters
     * @return Invoice
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
        $this->status = INVOICESTATUS_REQUESTED;
        $this->user_status = INVOICEUSERSTATUS_REQUESTED;
    }

    public function beforeValidationOnSave() {
        
    }

    public function afterFetch() {
        
    }

    public $deliverytimemode;

    public function getPublicResponse() {

        $result = new stdClass();
        $result->ID = $this->id;
        $result->UserID = $this->userid;
        $result->Price = $this->price;
        $result->Currency = $this->currency;
        $result->Status = $this->status;
        $result->UserStatus = $this->user_status;
        $result->CityID = $this->cityid;
        $result->Address = $this->address;
        $result->UserComment = $this->usercomment;
        $result->AddressLongitude = isset($this->address_longitude) ? $this->address_longitude : 0;
        $result->AddressLatitude = isset($this->address_latitude) ? $this->address_latitude : 0;
        $result->AddressGPSApprox = isset($this->address_gpsapprox) ? $this->address_gpsapprox : 0;
        $result->Date = $this->date;
        $result->Phone = $this->phone;
        $result->Mobile = $this->mobile;
        $result->DeliverDate = isset($this->deliverdate) ? $this->deliverdate : 0;
        $result->DeliveryTimeMode = $this->deliverytimemode;
        $result->Products = array();
        $result->Name = $this->getUserName();

        $k = $this->getProductList();
        foreach ($k as $item) {
            $result->Products[] = $item->getPublicResponse();
        }

//        var_dump(( (time() - $this->date) > 3600 ? 3600 : (time() - $this->date) ));
//        die();
        // check remaining time
        switch ($this->deliverytimemode) {
            case DELIVERYTIMEMODE_UNDERONEHOUR:
                // we have to make the request under one hour
                $result->RemainingTime = 3600 - ( (time() - $this->date) > 3600 ? 3600 : (time() - $this->date) ) - (3600 * 3 + 1800);
                break;
            case DELIVERYTIMEMODE_UNDERFOURHOURS:
                // we have to make the request under one hour
                $result->RemainingTime = 14400 - ( (time() - $this->date) > 14400 ? 14400 : (time() - $this->date) ) - (3600 * 3 + 1800);
                break;
        }


        return $result;
    }

    //public function validation()
    //{
    //return $this->validationHasFailed() != true;
    //}




    public $totalpurchase;
    public $delivercost;
    public $offcost;
    public $gift;
    public $giftcalced;
    public $printuserid;
    public $printdate;
    public $warehouseid;

    public function columnMap() {
        // Keys are the real names in the table and
        // the values their names in the application
        return array('id' => 'id',
            'userid' => 'userid',
            'price' => 'price',
            'currency' => 'currency',
            'status' => 'status',
            'user_status' => 'user_status',
            'cityid' => 'cityid',
            'address' => 'address',
            'usercomment' => 'usercomment',
            'address_longitude' => 'address_longitude',
            'address_latitude' => 'address_latitude',
            'address_gpsapprox' => 'address_gpsapprox',
            'date' => 'date',
            'phone' => 'phone',
            'mobile' => 'mobile',
            'deliverdate' => 'deliverdate',
            'deliverytimemode' => 'deliverytimemode',
            'totalpurchase' => 'totalpurchase',
            'delivercost' => 'delivercost',
            'offcost' => 'offcost',
            'gift' => 'gift',
            'printuserid' => 'printuserid',
            'printdate' => 'printdate',
            'warehouseid' => 'warehouseid',
        );
    }

    public function getStatusTitle() {
        switch ($this->status) {
            case INVOICESTATUS_REQUESTED:
                return "پردازش دفتری";
            case INVOICESTATUS_PROCCESSINGINWAREHOUSE:
                return "پردازش انبار";
            case INVOICESTATUS_PACAKING:
                return "بسته بندی";
            case INVOICESTATUS_SENDING:
                return "در حال ارسال";
            case INVOICESTATUS_RECEIVED:
                return "دریافت شده";
            case INVOICESTATUS_CANCELLEDBYUSER:
                return "رد شده توسط کاربر";
            case INVOICESTATUS_CANCELEDBYCENTER:
                return "رد شده توسط مرکز";
            default :
                return "<هشدار : این وضعیت تعریف نشده>";
        }
    }

    public function getStatusLabel() {
        switch ($this->status) {
            case INVOICESTATUS_REQUESTED:
                return "<span class='label label-default'>" . $this->getStatusTitle() . "</span>";
            case INVOICESTATUS_PROCCESSINGINWAREHOUSE:
                return "<span class='label label-info'>" . $this->getStatusTitle() . "</span>";
            case INVOICESTATUS_PACAKING:
                return "<span class='label label-primary'>" . $this->getStatusTitle() . "</span>";
            case INVOICESTATUS_SENDING:
                return "<span class='label label-warning'>" . $this->getStatusTitle() . "</span>";
            case INVOICESTATUS_RECEIVED:
                return "<span class='label label-success'>" . $this->getStatusTitle() . "</span>";
            case INVOICESTATUS_CANCELLEDBYUSER:
                return "<span class='label label-danger'>" . $this->getStatusTitle() . "</span>";
            case INVOICESTATUS_CANCELEDBYCENTER:
                return "<span class='label label-dark'>" . $this->getStatusTitle() . "</span>";
            default :
                return "<هشدار : این وضعیت تعریف نشده>";
        }
    }

    public function getProductList() {
        return InvoiceProducts::find(array("invoiceid = :id:", "bind" => array("id" => $this->id)));
    }

}
