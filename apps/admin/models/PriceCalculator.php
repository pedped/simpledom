<?php

class PriceCalculator {

    /**
     * 
     * @param \User $user
     * @param type $products
     * @param type $delivertimemode
     * @return \stdClass
     */
    public static function CalcCost($user, $products, $delivertimemode) {


        // first, calc the products costs
        $cost = self::calcProdcutsCost($products);
        $discount = self::calcProductDiscount($products);

        $result = new stdClass();
        $result->totalordercosts = $cost;
        $result->shippingcosts = self::GetDeliveryCost($user, $products, $delivertimemode);
        $result->specialdiscount = $discount;
        $result->yourcach = $user->totalcach;
        
        
        // calc delivercosts
        $result->delivercosts = self::GetDeliverItemsCost($user, $products);



        // check deliver time
        if (intval($delivertimemode) == DELIVERYTIMEMODE_UNDERONEHOUR) {
            $result->shippingcosts += 0;
        } else if (intval($delivertimemode) == DELIVERYTIMEMODE_UNDERFOURHOURS) {
            $result->shippingcosts += 0;
        }

        $result->finalcost = $result->totalordercosts + $result->shippingcosts - $result->yourcach;
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

    /**
     * 
     * @param \User $user
     * @param type $products
     * @param type $delivertimemode
     * @return \stdClass
     */
    public static function GetDeliveryCost($user, $products, $delivertimemode) {
        return DeliveryModeOption::findFirst(array("id = :id:", "bind" => array("id" => $delivertimemode)))->getShippingCost($user, $products);
    }

    public static function GetDeliverItemsCost($user, $products) {
        
        $items = array();
        $deliveryOptions = DeliveryModeOption::find();
        foreach ($deliveryOptions as $value) {
            $item = new stdClass();
            $item->DeliveryItemID = $value->delivery_mode_id;
            $item->DeliveryCost = $value->getShippingCost($user, $products);
            $item->DeliveryOptionID = $value->id;
            $items[] = $item;
        }
        return $items;
    }

}
