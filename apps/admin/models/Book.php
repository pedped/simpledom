<?php

class Book implements Orderable {

    public static function GetCost($id) {
        $item = new stdClass();
        $item->Price = 150000;
        $item->Currency = "IRR";
        return $item;
    }

    public static function ValidateOrderCreateRequest(&$errors, $id) {
        return true;
    }

    public static function getOrderObjectInfo($id) {
        $item = new stdClass();
        $item->title = "hello";
        $item->description = "this is a good description";
        $item->Cost = new stdClass();
        $item->Cost->Price = 10;
        $item->Cost->Currency = "IRR";
        return $item;
    }

    public static function onSuccessOrder(&$errors, $userid, $id) {
        var_dump("AND YES, ORDER PAYED SUCCESSFULLY");
    }

    public static function GetOrderTitle($id) {
        return "Benjamin Button Book";
    }

    public static function CheckAvailableToOrder($id) {
        return true;
    }

}
