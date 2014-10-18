<?php

namespace Simpledom\Core\Classes;

use TransactionType;
use UserTransaction;

class Transaction {

    private $userid;

    /**
     *  Init new transction class
     * @param int $userid
     */
    public function __construct($userid) {
        $this->userid = $userid;
    }

    /**
     * check if transaction type is valid
     * @param int ID Of Trasnaction Type
     * @return boolean tranaction type is valid 
     */
    private function validateTransactionType($transactionTypeID) {

        return TransactionType::findFirst($transactionTypeID) !== FALSE;
    }

    /**
     * Get Human Readble Transaction Type
     * @param int $transactionTypeID
     */
    private function getTranactionTypeName($transactionTypeID) {
        return TransactionType::findFirst($transactionTypeID)->name;
    }

    /**
     * This function create new transaction in database and return transaction id
     * @param type $errors
     * @param double $amount Amount for transnaction
     * @param string $currency 3 character currency type
     * @param string $transactionTypeID key of the transaction type
     * @param int $itemID the item id of tranaction type, for example we if send __TRANSACTIONTYPE_ORDER, we have to use o_id [ ORDER ID ] here
     * @return int TranactionID
     */
    public function StartTransaction(&$errors, $amount, $currency, $transactionTypeID, $itemID) {

        // check if transaction type is valid
        if (!$this->validateTransactionType($transactionTypeID)) {
            $errors[] = _("Invalid Transaction Type");
            return 0;
        }

        // transaction type is valid, get transaction type name
        $transactionTypeName = $this->getTranactionTypeName($transactionTypeID);


        // Insert new tarsnaction in database
        $transaction = new UserTransaction();
        $transaction->amount = $amount;
        $transaction->cur = $currency;
        $transaction->itemid = $itemID;
        $transaction->type = $transactionTypeID;
        $transaction->typename = $transactionTypeName;
        $transaction->userid = $this->userid;
        if (!$transaction->create()) {
            $errors = array_merge($errors, $transaction->getMessages());
            return;
        }

        return $transaction->id;
    }

    /**
     * Get Transaction by ID
     * @param int $transactionID Transaction ID to receive information
     * @return UserTransaction|null
     */
//    public function GetTransaction($transactionID) {
//
//        // get information about transaction
//        $transaction = UserTransaction::findFirst($transactionID);
//
//        // check if we have found the transaction
//        if (!isset($transaction)) {
//            // we can not find this
//            return null;
//        }
//
//        // we have find the transactions, we have get information about the transaction
//        require_once 'user/class.user.php';
//        $u = new User_Manager($transaction->UserID);
//        $transaction->User = $u->GetPublicUserInfo();
//
//
//        // get infotmation about transaction type
//        switch ($transaction->Type) {
//            case __TRANSACTIONTYPE_ORDER:
//                require_once 'class.order.php';
//                $o = new Order($this->userid);
//                $order = $o->GetInfo($transaction->ItemID);
//                $transaction->Order = $order;
//                break;
//
//            default:
//                die("not GetTransaction implanted");
//                break;
//        }
//
//
//        // check if we have valid transaction
//        if (isset($transaction) && intval($transaction->TransactionID) == intval($transactionID)) {
//            // we have received correct transaction
//            return new TransactionItem($transaction);
//        } else {
//            return null;
//        }
//    }
}
