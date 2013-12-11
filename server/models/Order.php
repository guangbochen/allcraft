<?php
// define database shcema
use RedBean_Facade as R;

Class Order {

    public static function findAll() {
        $orders = R::findAll('orders');

        //return array of orders is found
        if($orders) return R::exportAll($orders);

        return null;
    }

    /* find an order by name */
    public static function findOrder($orderNumber) {
        $order = R::findOne('orders','orderNumber = ?', array($orderNumber));

        //return order if is found
        if($order) return json_decode($order);

        return null;
    }

    public static function createOrder($input) {

        R::begin();
        try
        {
            if(!$input) throw new exception("empty input");
            foreach($input as $order)
            {
                $newOrder = R::dispense('orders');
                $newOrder->import($order);
                R::store($newOrder);
            }
            R::commit();
        }
        catch(Exception $e) {
            R::rollback();
            throw new Exception($e->getMessage());
        }

    }

}
