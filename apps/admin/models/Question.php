<?php

use Simpledom\Core\AtaModel;

class Question extends AtaModel {

    public function getSource() {
        return 'question';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return Question
     */
    public function setId($id) {
        $this->id = $id;
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
     * @return Question
     */
    public function setUserid($userid) {
        $this->userid = $userid;
        return $this;
    }

    /**
     * Moshaver ID
     * @var string
     */
    public $moshaverid;

    /**
     * Set Moshaver ID
     * @param type $moshaverid
     * @return Question
     */
    public function setMoshaverid($moshaverid) {
        $this->moshaverid = $moshaverid;
        return $this;
    }

    /**
     * Question
     * @var string
     */
    public $question;

    /**
     * Set Question
     * @param type $question
     * @return Question
     */
    public function setQuestion($question) {
        $this->question = $question;
        return $this;
    }

    /**
     * About Yourself
     * @var string
     */
    public $aboutyourself;

    /**
     * Set About Yourself
     * @param type $aboutyourself
     * @return Question
     */
    public function setAboutyourself($aboutyourself) {
        $this->aboutyourself = $aboutyourself;
        return $this;
    }

    /**
     * Disorder History
     * @var string
     */
    public $disorderhistory;

    /**
     * Set Disorder History
     * @param type $disorderhistory
     * @return Question
     */
    public function setDisorderhistory($disorderhistory) {
        $this->disorderhistory = $disorderhistory;
        return $this;
    }

    /**
     * Using Tablet
     * @var string
     */
    public $usingtablet;

    /**
     * Set Using Tablet
     * @param type $usingtablet
     * @return Question
     */
    public function setUsingtablet($usingtablet) {
        $this->usingtablet = $usingtablet;
        return $this;
    }

    /**
     * City ID
     * @var string
     */
    public $cityid;

    /**
     * Set City ID
     * @param type $cityid
     * @return Question
     */
    public function setCityid($cityid) {
        $this->cityid = $cityid;
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
     * @return Question
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    public function getDate() {
        return date('Y-m-d H:m:s', $this->date);
    }

    public function getUserName() {
        return isset($this->userid) ? BaseUser::findFirst($this->userid)->getFullName() : '<no user>';
    }

    /**
     *
     * @param type $parameters
     * @return Question
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
