<?php

class User extends BaseUser {

    public $username;
    public $userphone;
    public $usertype = "";
    public $city;
    public $description;

    public function getPublicResponse() {
        $item = parent::getPublicResponse();
        $item->email = $this->email;
        $item->username = $this->username;
        $item->userphone = $this->userphone;
        $item->usertype = $this->usertype;
        $item->userimage = $this->imagelink;
        $item->description = $this->description;
        $item->city = $this->city;
        return $item;
    }

    public function beforeValidationOnCreate() {
        parent::beforeValidationOnCreate();
        $this->userphone = "0";
        $this->description = "";
        $this->city = "تهران";
        $this->usertype = "بازدید کننده";
    }

}
