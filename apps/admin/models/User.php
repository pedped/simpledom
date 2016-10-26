<?php

class User extends BaseUser {

    /**
     * Register Date
     * @FieldName('Register Date')
     * @var string
     */
    public $registerdate;

    /**
     * Set Register Date
     * @param type $registerdate
     * @return Users
     */
    public function setRegisterdate($registerdate) {
        $this->registerdate = $registerdate;
        return $this;
    }

    public function getOrderTracks($limit = 1) {

        // find the user invoices
        $parameters = array("userid = :userid:",
            "order" => "id DESC",
            "bind" => array(
                "userid" => $this->userid));
        if (isset($limit)) {
            $parameters["limit"] = $limit;
        }

        $invoices = Invoice::find($parameters);

        // load the invoices
        return $invoices;
    }

    public function hasOrderInProgress() {
        $progressstatus = array();
        $progressstatus[] = INVOICESTATUS_SENDING;
        $progressstatus[] = INVOICESTATUS_PACAKING;
        $progressstatus[] = INVOICESTATUS_REQUESTED;
        $progressstatus[] = INVOICESTATUS_PROCCESSINGINWAREHOUSE;
        return Invoice::count(array("userid = :userid: AND status IN (" . implode(", ", $progressstatus) . ")", "bind" => array("userid" => $this->userid)));
    }

}
