<?php

use Simpledom\Core\AtaModel;

class BaseCachChangeReason extends AtaModel {

    public function getSource() {
        return 'cachchangereason';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return BaseCachChangeReason
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Name
     * @var string
     */
    public $name;

    /**
     * Set Name
     * @param type $name
     * @return BaseCachChangeReason
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * Description
     * @var string
     */
    public $description;

    /**
     * Set Description
     * @param type $description
     * @return BaseCachChangeReason
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * Date
     * @var string
     */
    public $date;

    /**
     * Set Date
     * @param type $date
     * @return BaseCachChangeReason
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    public function getDate() {
        return date('Y-m-d H:m:s', $this->date);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

}
