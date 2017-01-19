<?php

use Phalcon\Mvc\Model\Behavior\SoftDelete;
use Phalcon\Mvc\Model\Validator\Email as Email;
use Simpledom\Core\AtaModel;

class Cachchangereason extends AtaModel {

    public function initialize() {
        
    }

    public function getSource() {
        return 'cachchangereason';
    }

    /**
     * کد
     * @FieldName('کد')
     * @var string
     */
    public $id;

    /**
     * Set کد
     * @param type $id
     * @return Cachchangereason
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * نام
     * @FieldName('نام')
     * @var string
     */
    public $name;

    /**
     * Set نام
     * @param type $name
     * @return Cachchangereason
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * توضیحات
     * @FieldName('توضیحات')
     * @var string
     */
    public $description;

    /**
     * Set توضیحات
     * @param type $description
     * @return Cachchangereason
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * تاریخ
     * @FieldName('تاریخ')
     * @var string
     */
    public $date;

    /**
     * Set تاریخ
     * @param type $date
     * @return Cachchangereason
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * افزایشی
     * @FieldName('افزایشی')
     * @var string
     */
    public $increase;

    /**
     * Set افزایشی
     * @param type $increase
     * @return Cachchangereason
     */
    public function setIncrease($increase) {
        $this->increase = $increase;
        return $this;
    }

    /**
     * هدیه می باشد
     * @FieldName('هدیه می باشد')
     * @var string
     */
    public $isgift;

    /**
     * Set هدیه می باشد
     * @param type $isgift
     * @return Cachchangereason
     */
    public function setIsgift($isgift) {
        $this->isgift = $isgift;
        return $this;
    }

    /**
     * تصویر
     * @FieldName('تصویر')
     * @var string
     */
    public $imageid;

    /**
     * Set تصویر
     * @param type $imageid
     * @return Cachchangereason
     */
    public function setImageid($imageid) {
        $this->imageid = $imageid;
        return $this;
    }

    public function getDate() {
        return date('Y-m-d H:m:s', $this->date);
    }

    public function getUserName() {
        return isset($this->userid) ? BaseUser::findFirst($this->userid)->getFullName() : '<no user>';
    }

    /**
     * return the image object
     * @return BaseImage
     */
    public function getImage() {
        return Image::findFirst($this->imageid);
    }

    /**
     * return the image link
     * @return String imagelink
     */
    public function getImageLink() {
        return $this->getImage()->link;
    }

    /**
     *
     * @param type $parameters
     * @return Cachchangereason
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
    }

    public function beforeValidationOnSave() {
        
    }

    public function afterFetch() {
        
    }

    public function getPublicResponse() {

        $result = new stdClass();
        $result->ID = $this->id;
        $result->Name = $this->name;
        $result->Description = $this->description;
        $result->Date = $this->date;
        $result->Increase = $this->increase;
        $result->Isgift = $this->isgift;
        $result->ImageID = $this->imageid;
        $result->Amount = $this->amount;


        return $result;
    }

//public function validation()
//{
//return $this->validationHasFailed() != true;
//}




    public function getIncreaseTag() {
        switch ($this->increase) {
            case 1:
                return "<span class='label label-success'>افزایشی</span>";
            case 0:
                return "<span class='label label-danger'>کاهشی</span>";
        }
    }

    public function getGiftTag() {
        switch ($this->isgift) {
            case 1:
                return "<span class='label label-success'>بله</span>";
            case 0:
                return "<span class='label label-danger'>خیر</span>";
        }
    }

    public function getImageLinkTag() {
        if ($this->imageid > 0) {
            return "<img style='max-width: 100px;'  src='" . $this->getImageLink() . "' />";
        } else {
            return "";
        }
    }

    public $amount;

    public function columnMap() {
        // Keys are the real names in the table and
        // the values their names in the application
        return array(
            'id' => 'id',
            'name' => 'name',
            'description' => 'description',
            'date' => 'date',
            'increase' => 'increase',
            'isgift' => 'isgift',
            'imageid' => 'imageid',
            'amount' => 'amount',
        );
    }

}
