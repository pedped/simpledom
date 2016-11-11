<?php

class PriceCalculator {

    public static function CalcCost($products, $delivertimemode) {


        // first, calc the products costs
        $cost = self::calcProdcutsCost($products);

        $result = new stdClass();
        $result->totalordercosts = $cost;
        $result->shippingcosts = $cost * 3 / 100;
        $result->specialdiscount = 0;
        $result->yourcach = 0;

        // check deliver time
        if (intval($delivertimemode) == DELIVERYTIMEMODE_UNDERONEHOUR) {
            $result->shippingcosts += 10000;
        } else if (intval($delivertimemode) == DELIVERYTIMEMODE_UNDERFOURHOURS) {
            $result->shippingcosts += 0;
        }

        $result->finalcost = $result->totalordercosts + $result->shippingcosts + $result->specialdiscount + $result->yourcach;
        return $result;
    }

    public static function calcProdcutsCost($products) {

        $costs = 0;
        foreach ($products as $item) {
            $product = Product::findFirst(array("id = :id:", "bind" => array("id" => $item->productid)));
            $costs += $product->GetFinalPrice() * $item->count;
        }
        return $costs;
    }

}
