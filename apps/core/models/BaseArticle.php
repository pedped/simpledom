<?php

use Simpledom\Core\AtaModel;

class BaseArticle extends AtaModel {

    public function getSource() {
        return 'article';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return BaseArticle
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
     * @return BaseArticle
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
     * @return BaseArticle
     */
    public function setText($text) {
        $this->text = $text;
        return $this;
    }

    /**
     * User ID
     * @var string
     */
    public $userid;

    /**
     * Set User ID
     * @param type $userid
     * @return BaseArticle
     */
    public function setUserid($userid) {
        $this->userid = $userid;
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
     * @return BaseArticle
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * Approved
     * @var string
     */
    public $approved;

    /**
     * Set Approved
     * @param type $approved
     * @return BaseArticle
     */
    public function setApproved($approved) {
        $this->approved = $approved;
        return $this;
    }

    /**
     * Delete
     * @var string
     */
    public $delete;

    /**
     * Set Delete
     * @param type $delete
     * @return BaseArticle
     */
    public function setDelete($delete) {
        $this->delete = $delete;
        return $this;
    }

    public $link;

    public function getDate() {
        return date('Y-m-d H:i:s', $this->date);
    }

    public function getUserName() {
        return isset($this->userid) ? BaseUser::findFirst($this->userid)->getFullName() : '<no user>';
    }

    /**
     *
     * @param type $parameters
     * @return BaseArticle
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

}
