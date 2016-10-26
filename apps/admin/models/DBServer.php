<?php

class DBServer {

    /**
     * return the connection
     * @global type $mysqliu
     * @return mysqli
     */
    private static function _getConnection() {
        global $mysqliu;
        return $mysqliu;
    }

    public static function UserRevneue_GetTotalUserRevenueForProduct($userid, $producttypeid, $itemid) {
        $sql = DBServer::_getConnection();
        $stm = $sql->prepare("SELECT SUM(amount) ,user_revenue.currency FROM user_revenue JOIN profit_percent ON user_revenue.userprofitid = profit_percent.id WHERE user_revenue.userid =  ? AND profit_percent.itemtype = ? AND profit_percent.itemid = ? GROUP BY user_revenue.currency");
        $stm->bind_param("iii", $userid, $producttypeid, $itemid);

        if ($stm->execute()) {
            $stm->bind_result($amount, $currency);
            $items = array();
            while ($stm->fetch()) {
                $item = new stdClass();
                $item->Amount = $amount;
                $item->Currency = $currency;
                $items[] = $item;
            }
            return $items;
        }
        return array();
    }

    public static function Stock_GetRemainingCount($productid) {
        $sql = DBServer::_getConnection();
        $stm = $sql->prepare("SELECT SUM(total) FROM stock WHERE stock.productid = ?");
        $stm->bind_param("i", $productid);

        if ($stm->execute()) {
            $stm->bind_result($result);
            if ($stm->fetch()) {
                return $result;
            }
        }
        return 0;
    }

    public static function LoadTopSaleProducts($topSalesDay) {
        $sql = DBServer::_getConnection();
        $time = time() - ($topSalesDay * 3600 * 24 );
        $stm = $sql->prepare("SELECT invoice_products.productid FROM invoice_products WHERE invoice_products.date > " . $time . " GROUP BY invoice_products.productid  LIMIT 100");
//        $stm->bind_param("iii", $productid, $producttitle, $imageid, $imagelink);

        if ($stm->execute()) {
            $stm->bind_result($productid);
            $items = array();
            while ($stm->fetch()) {
                $items[] = $productid;
            }
            return $items;
        }
        return array();
    }

    public static function LoadUserUsualProducts($userid , $limit) {
        
        $sql = DBServer::_getConnection();
        $stm = $sql->prepare("SELECT invoice_products.productid  FROM invoice_products JOIN invoice ON invoice.userid = ? GROUP BY invoice_products.productid  LIMIT ?");
        $stm->bind_param("ii", $userid , $limit);

        if ($stm->execute()) {
            $stm->bind_result($productid);
            $items = array();
            while ($stm->fetch()) {
                $items[] = $productid;
            }
            return $items;
        }
        return array();
    }

}
