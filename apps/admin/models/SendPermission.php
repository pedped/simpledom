<?php

use Simpledom\Core\AtaModel;

class SendPermission extends AtaModel {

    public function getSource() {
        return 'sendpermission';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return SendPermission
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * User Post From
     * @var string
     */
    public $userpost1;

    /**
     * Set User Post From
     * @param type $userpost1
     * @return SendPermission
     */
    public function setUserpost1($userpost1) {
        $this->userpost1 = $userpost1;
        return $this;
    }

    /**
     * User Post To
     * @var string
     */
    public $userpost2;

    /**
     * Set User Post To
     * @param type $userpost2
     * @return SendPermission
     */
    public function setUserpost2($userpost2) {
        $this->userpost2 = $userpost2;
        return $this;
    }

    /**
     * Can Send
     * @var string
     */
    public $cansend;

    /**
     * Set Can Send
     * @param type $cansend
     * @return SendPermission
     */
    public function setCansend($cansend) {
        $this->cansend = $cansend;
        return $this;
    }

    /**
     *
     * @param type $parameters
     * @return SendPermission
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

    public function getUserPostOneName() {
        return Post::findFirst($this->userpost1)->name;
    }

    public function getUserPostTwoName() {
        return Post::findFirst($this->userpost2)->name;
    }

    public function canSendTitle() {
        return $this->cansend ? "دارد" : "ندارد";
    }

}
