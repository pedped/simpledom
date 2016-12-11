<?php

class PriceCalculator {

    public static function CalcCost($products, $delivertimemode) {


        // first, calc the products costs
        $cost = self::calcProdcutsCost($products);
        $discount = self::calcProductDiscount($products);
        
        $result = new stdClass();
        $result->totalordercosts = $cost;
        $result->shippingcosts = 0;
        $result->specialdiscount = $discount;
        $result->yourcach = 0;



        // check deliver time
        if (intval($delivertimemode) == DELIVERYTIMEMODE_UNDERONEHOUR) {
            $result->shippingcosts += 0;
        } else if (intval($delivertimemode) == DELIVERYTIMEMODE_UNDERFOURHOURS) {
            $result->shippingcosts += 0;
        }

        $result->finalcost = $result->totalordercosts + $result->shippingcosts;
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

    public static function calcProductDiscount($products) {
        $costs = 0;
        foreach ($products as $item) {
            $product = Product::findFirst(array("id = :id:", "bind" => array("id" => $item->productid)));
            if ($product->hasOff()) {
                $costs += ($product->GetInitialPrice() - $product->GetFinalPrice()) * $item->count;
            }
        }
        return $costs;
    }

}
