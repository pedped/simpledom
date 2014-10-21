<?php

namespace Simpledom\Core\Classes;

use PaymentType;
use Phalcon\Text;
use ProductType;
use stdClass;
use TransactionType;
use UserOrder;

/**
 * This class used to manage orders, we use global type for orders
 *
 * @author Pedram
 */
class Order {

    private $userid;

    /**
     *
     * @var PaymentMethod 
     */
    private $paymentHandler;

    /**
     * 
     * @param int $userid The person who belong to order
     * @return Order
     */
    public function __construct($userid) {
        $this->userid = $userid;
        return $this;
    }

    public function GetOrderIDWithPaymentID($paymentType, $paymentID) {
        return UserOrder::findFirst("paymenttype  = '$paymentType' AND paymentitemid = '$paymentID'")->id;
    }

    /**
     * this function will call when the Payment Has been successfully validated and handled
     * @param type $errors
     * @param type $orderPayementType
     * @param type $paymentID
     * @return type
     */
    public function OnSuccessPayment(&$errors, $orderPayementType, $paymentID) {

        // find the orderid
        $orderid = $this->GetOrderIDWithPaymentID($orderPayementType, $paymentID);

        // check if the order id is valid, success it
        if (intval($orderid) > 0) {

            // Set Payment Cost
            $paymentHandlerName = "PaymentHandler" . Text::camelize(\PaymentType::findFirst($orderPayementType)->key);
            $paymentHandler = new $paymentHandlerName();
            $cost = $paymentHandler->getPaymentCost($errors, $paymentID);
            $order = UserOrder::findFirst($orderid);
            $order->price = $cost->Price;
            $order->pricecurrency = $cost->Currency;
            $order->save();

            return $this->OnSuccessOrder($errors, $orderid);
        } else {
            // we can not find any order that is for this payment
            $errors[] = _("We can not find any order that is for this payment");
            return false;
        }
    }

    public function UpdateOrderPaymentInfo(&$errors, $orderID, $orderUserID, $paymentType, $paymentItemID) {


        $order = UserOrder::findFirst($orderID);

        // check if we have correct userid
        if (intval($order->userid) != $orderUserID) {
            $errors[] = _("Invalid Order User ID");
            return false;
        }

        // check if order not payed before
        if (intval($order->done) == 1) {
            $errors[] = _("Invalid Request, Order has been payed before");
            return false;
        }


        // update order
        $order->paymenttype = $paymentType;
        $order->paymentitemid = $paymentItemID;
        if (!$order->save()) {
            $errors[] = _("Can not update order payment information, May Be You Want to Pay Invalid Order or You want to pay the order that you have unpayed before");
            $errors = array_merge($order->getMessages, $errors);
            return false;
        }


        // return true;
        return true;
    }

    /**
     * Create new order by creating new raw in database
     * @param type $productTypeID global type of object
     * @param int $itemID The Item ID of global Type , for example if we use Classroom Global Type, we have to use classroom id here
     * @param int $referer user id of person who refered the item as affiliate, 
     * @return int|boolean Order ID , false on unsuccess
     */
    public function CreateOrder(&$errors, $productTypeID, $itemID, $referer = null) {

        // check request before creating order
        $this->ValidateOrderCreateRequest($errors, $productTypeID, $itemID);

        // Insert new order raw to database and get the inserted order id o_id
        $order = new UserOrder();
        $order->userid = $this->userid;
        $order->type = $productTypeID;
        $order->itemid = $itemID;

        // create order
        if (!$order->create()) {
            $errors = array_merge($errors, $order->getMessages());
            $errors[] = _("Unable to create order");
            return false;
        }

        return $order->id;
    }

    /**
     * get order info
     * @param type $orderid
     * @return UserOrder
     */
    public function GetInfo($orderid) {
        return UserOrder::findFirst($orderid);
    }

    /**
     * This is a function that fetch information about the order product
     * @param int $productTypeID
     * @param int $itemID
     * @return stdClass
     */
    private function getOrderObjectInfo($productTypeID, $itemID) {

        // TODO, we have to allow orderable object find this
        $productClassName = Text::camelize(ProductType::findFirst($productTypeID)->key);
        $productable = new $productClassName();
        return $productable->getOrderObjectInfo($itemID);
    }

    /**
     * Check if it is valid to procces order with this payment type
     * @param type $payementTypeID
     * @return boolean order type is valid to proccess
     */
    private function CheckPaymentType($payementTypeID) {
        $paymenttype = PaymentType::findFirst($payementTypeID);
        return isset($paymenttype) && $paymenttype->enable == 1;
    }

    /**
     * Check if we have not payed this order id before or the orderid exists in database
     * @param string $errors
     * @param type $orderID
     * @return boolean Wheter we are able to proccess pay for this order id
     */
    private function validateOrderToPay(&$errors, $orderID) {

        //TODO
        return true;
//        $userorder = UserOrder::findFirst($orderID);
//        return $userorder->count() > 0 && $userorder->paymenttype
//        return;
    }

    public static function ValidateOrderPayed($order) {
        return isset($order->Payment) && ($order->Payment->Info->Info->Payed == true);
    }

    /**
     * Fetch amoutn and currency about the order
     * @param type $orderid
     * @return type
     */
    public function GetOrderAmountCurrency($orderid) {
        $userorder = UserOrder::findFirst($orderid);
        $productTypeID = $userorder->type;
        $productClassName = Text::camelize(ProductType::findFirst($productTypeID)->key);
        $productable = new $productClassName();
        return $productable->GetCost($userorder->itemid);
    }

    /**
     * Start start to pay the order
     * @param type $errors
     * @param type $orderid
     * @param type $paymentTypeID __ORDERPAYMENTTYPE_*
     * @return boolean
     */
    public function PayOrder(&$errors, $orderid, $paymentTypeID) {

        // check if order type is valid to proccess
        if (!$this->CheckPaymentType($paymentTypeID)) {
            $errors[] = _("The payment method is disabled and you are not able to proccess with this payment method");
            return false;
        }


        // Order type is valid and can be proccess, Check if order id is valid and exist
        if (!$this->validateOrderToPay($errors, $orderid)) {
            // invalid order proccess
            return false;
        }

        // get amount and currency of the order
        $info = $this->GetOrderAmountCurrency($orderid);

        // we are able to prccess order, Create new transaction for its
        $transaction = new Transaction($this->userid);
        $tTypeID = TransactionType::findFirst("key = 'order'")->id;
        $transactionID = $transaction->StartTransaction($errors, $info->Price, $info->Currency, $tTypeID, $orderid);

        // check for errors
        if (count($errors) > 0) {
            return false;
        }

        // check if transactionID is valid
        if (intval($transactionID) > 0) {
            // valid transaction id, we have to start payment for itemid
            $paymentHandlerKey = PaymentType::findFirst($paymentTypeID)->key;
            $paymentHandlerName = "PaymentHandler" . Text::camelize($paymentHandlerKey);
            $this->paymentHandler = new $paymentHandlerName();
            $this->paymentHandler->StartPayment($errors, $this->userid, $info->Price, $info->Currency, $transactionID, $orderid);
        } else {

            // invalid transaction id
            $errors[] = _("Unable to create new payment transaction");
        }
    }

    /**
     * This function called when an order has been successfully payed, we will get the product to user here 
     * @param string $errors
     * @param type $orderid
     * @return boolean
     */
    public function OnSuccessOrder(&$errors, $orderid) {

        $order = UserOrder::findFirst($orderid);
        $result = $order->setPayed();


        // save order info
        if (!$result) {
            $errors[] = "unable to set order as payed order";
            $errors = array_merge($errors, $order->getMessages());
            return false;
        }


        // now we have to get the item and call the onSuccessOrder
        $productTypeName = Text::camelize(ProductType::findFirst($order->type)->key);
        $productTypeName::onSuccessOrder($errors, $order->userid, $order->itemid);

        return true;
    }

    /**
     * When user want to start an order, we check here if the user need to create this order or not, also we check if the user is validated to create order or not
     * @param type $errors
     * @param type $productTypeID
     * @param type $itemID
     */
    public function ValidateOrderCreateRequest(&$errors, $productTypeID, $itemID) {


        $type = ProductType::findFirst($productTypeID);
        // TODO, we have to allow orderable object find this
        $productClassName = Text::camelize(ProductType::findFirst($productTypeID)->key);
        $productable = new $productClassName();
        return $productable->ValidateOrderCreateRequest($errors, $itemID);
    }

}
