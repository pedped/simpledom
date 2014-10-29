<?php

use Simpledom\Core\AtaModel;

class MelkSubscriber extends AtaModel {

    public function getSource() {
        return 'melksubscriber';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return MelkSubscriber
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
     * @return MelkSubscriber
     */
    public function setUserid($userid) {
        $this->userid = $userid;
        return $this;
    }

    /**
     * Melk Subscribe ID
     * @var string
     */
    public $melksubscribeitemid;

    /**
     * Set Melk Subscribe ID
     * @param type $melksubscribeitemid
     * @return MelkSubscriber
     */
    public function setMelksubscribeitemid($melksubscribeitemid) {
        $this->melksubscribeitemid = $melksubscribeitemid;
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
     * @return MelkSubscriber
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    /**
     * Order ID
     * @var string
     */
    public $orderid;

    /**
     * Set Order ID
     * @param type $orderid
     * @return MelkSubscriber
     */
    public function setOrderid($orderid) {
        $this->orderid = $orderid;
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
     * @return MelkSubscriber
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

    /**
     * 
     * @return MelkSubscribeItem
     */
    public function getSubscription() {
        return MelkSubscribeItem::findFirst($this->melksubscribeitemid);
    }

    public static function checkHasSubscriptions($userid) {
        return MelkSubscriber::find(array("userid = :userid:", "bind" => array("userid" => $userid)))->count() > 0;
    }

    /**
     * check if teh user has any valid subscription, if founded, return the MelkSubscriber ID
     * @param type $userid
     * @return boolean|integer FALSE or MelkSubscriber->ID
     */
    public static function checkHasValidDateSubscriptions($userid) {
        $subscribers = MelkSubscriber::find(array("userid = :userid:", "bind" => array("userid" => $userid)));
        foreach ($subscribers as $subscribeItem) {
            $subscription = $subscribeItem->getSubscription();
            $validdate = $subscription->validddate * (3600 * 24 ) + $subscribeItem->date;

            if ($validdate > time()) {
                // user has subscription that is valid
                return $subscribeItem->id;
            }
        }

        // we were unable to find any valid subscription
        return false;
    }

}
