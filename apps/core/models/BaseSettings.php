<?php

use Simpledom\Core\AtaModel;

class BaseSettings extends AtaModel {

    public function getSource() {
        return "settings";
    }

    /**
     *
     * @var string
     */
    public $websitename;

    /**
     *
     * @var string
     */
    public $keywords;

    /**
     *
     * @var string
     */
    public $metadata;

    /**
     *
     * @var string
     */
    public $latitude;

    /**
     *
     * @var string
     */
    public $longtude;

    /**
     *
     * @var string
     */
    public $contactemail;

    /**
     *
     * @var string
     */
    public $contactphone;

    /**
     *
     * @var string
     */
    public $address;

    /**
     *
     * @var string
     */
    public $footertitle;

    /**
     *
     * @var string
     */
    public $footertext;

    /**
     *
     * @var string
     */
    public $footermenus;

    /**
     *
     * @var string
     */
    public $footerenablecontact;

    /**
     *
     * @var string
     */
    public $offline;

    /**
     *
     * @var string
     */
    public $offlinemessage;

    /**
     *
     * @var string
     */
    public $enabledisablesignup;

    /**
     *
     * @var string
     */
    public $enabledisablesignin;

    /**
     *
     * @var string
     */
    public $googleanalytics;

    /**
     *
     * @var string
     */
    public $clickyanalitics;

    /**
     *
     * @var string
     */
    public $sendpaymentreceiptbyemail;

    /**
     *
     * @var boolean
     */
    public $sendpaymentreceiptbysms;

    /**
     *
     * @var boolean
     */
    public $requestuserphoneonregister;

    /**
     *
     * @var boolean
     */
    public $requestverifiedphone;

    /**
     *
     * @var boolean
     */
    public $shownews;

    /**
     *
     * @var boolean
     */
    public $shownewsandroid;

    /**
     *
     * @var string
     */
    public $globalmessage;

    /**
     *
     * @var boolean
     */
    public $enablesearch;

    /**
     *
     * @var boolean
     */
    public $rtl;

    /**
     * 
     * @param type $parameters
     * @return BaseSettings
     */
    public static function Get() {
        return parent::findFirst();
    }

    public function getPublicResponse() {
        
    }

}
