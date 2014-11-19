<?php

interface Orderable {

    public static function ValidateOrderCreateRequest(&$errors, $id);

    public static function GetCost($id);

    public static function getOrderObjectInfo($id);

    public static function onSuccessOrder(&$errors, $userid, $id, $orderid = null);

    public static function GetOrderTitle($id);

    public static function CheckAvailableToOrder($id);
}
