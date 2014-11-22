<?php

use Simpledom\Core\AtaModel;

class UserPost extends AtaModel {

    public function getSource() {
        return 'userpost';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return UserPost
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
     * @return UserPost
     */
    public function setUserid($userid) {
        $this->userid = $userid;
        return $this;
    }

    /**
     * Post ID
     * @var string
     */
    public $postid;

    /**
     * Set Post ID
     * @param type $postid
     * @return UserPost
     */
    public function setPostid($postid) {
        $this->postid = $postid;
        return $this;
    }

    /**
     * Code
     * @var string
     */
    public $code;

    /**
     * Set Code
     * @param type $code
     * @return UserPost
     */
    public function setCode($code) {
        $this->code = $code;
        return $this;
    }
    
    public $phonenumber;

    /**
     *
     * @param type $parameters
     * @return UserPost
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function beforeValidationOnCreate() {
        
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

    /**
     * 
     * @return User
     */
    public function getUser() {
        return User::findFirst(array("userid = :userid:", "bind" => array("userid" => $this->userid)));
    }

    public function getUserName() {
        return $this->getUser()->getFullName();
    }

    /**
     * 
     * @return Post
     */
    public function getPost() {
        return Post::findFirst(array("id = :id:", "bind" => array("id" => $this->postid)));
    }

    public function getPostTitle() {
        return $this->getPost()->name;
    }

    /**
     * 
     * @return Organ
     */
    public function getOrgan() {
        return Organ::findFirst(array("id = :id:", "bind" => array("id" => $this->getPost()->organid)));
    }

    public function getOrganName() {
        return $this->getOrgan()->name;
    }

}
