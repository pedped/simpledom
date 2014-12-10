<?php

use Simpledom\Core\AtaModel;

class BaseAgreement extends AtaModel {

    public function getSource() {
        return 'agreement';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return BaseAgreement
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Title
     * @var string
     */
    public $title;

    /**
     * Set Title
     * @param type $title
     * @return BaseAgreement
     */
    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    /**
     * Text
     * @var string
     */
    public $text;

    /**
     * Set Text
     * @param type $text
     * @return BaseAgreement
     */
    public function setText($text) {
        $this->text = $text;
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
     * @return BaseAgreement
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    public function getDate() {
        return date('Y-m-d H:i:s', $this->date);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

}
