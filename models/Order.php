<?php
// define database shcema
use RedBean_Facade as R;
//speed up the process of recursive query like exportAll and dup
$schema = R::$duplicationManager->getSchema();
R::$duplicationManager->setTables($schema);

Class Order {

    //this method returns list of orders
    public static function findAll() 
    {
        $orders = R::findAll('orders');

        foreach ($orders as &$order) {
            Order::getCompleteOrders($order);
        }

        //return json array of orders if it is found
        if($orders) return R::exportAll($orders);

        /* echo gettype($ordinary_orders); */
        return null;
    }


    //this method find a list of orders in pagination
    public static function findByPaging($firstNumber, $maxNumber)
    {
        $orders=R::findAll('orders', 'ORDER BY id LIMIT ?,?', array((int)($firstNumber-1), (int)$maxNumber));

        foreach ($orders as &$order) {
            Order::getCompleteOrders($order);
        }
        //return json array of orders if it is found
        if($orders) return R::exportAll($orders);

        return null;
    }

    /* find an order by name */
    public static function findOrder($orderNumber) 
    {
        $order = R::findOne('orders','orderNumber = ?', array($orderNumber));

        //return order if is found
        if($order) return json_decode($order);

        return null;
    }

    // Find orders at a specific date created
    public static function findCreatedAt($date, $limit, $offset)
    {
        // offset = 0, limit = 2 -> return 1,2
        // offset = 2, limit = 2 -> return 3,4
        // The offset increases based on limit
        $orders = R::find (
            'orders', 
            'created_at LIKE ? ORDER BY id LIMIT ?, ?', 
            array(
                "%$date%", 
                (int) $offset,
                (int)$limit
            )
        );

        if ($orders)
            return json_encode (R::exportAll ($orders));
        else
            throw new Exception ('Orders not found');
    }

    // Find orders before a provided date created
    public static function findCreatedBefore ($date, $limit, $offset)
    {
        $orders = R::find (
            'orders', 
            'DATE(created_at) < ? ORDER BY id LIMIT ?, ?',
            array (
                $date,
                (int)$offset,
                (int)$limit
            )
        );

        if ($orders)
            return json_encode(R::exportAll ($orders));
        else
            throw new Exception ('Orders not found');
    }

    private static function getCompleteOrders($order)
    {
        if($order->status_id) 
        {
            $status = R::findOne('statuses','id = ?', array($order->status_id));
            $order->ownStatus = $status;
        }
    }

    //this method create new order
    public static function createOrder($input) 
    {
        $orders = array();
        R::begin();
        try
        {
            //check input data is not empty
            if(!$input) throw new exception("empty input data");

            //get the current date in yyyy_mm_dd hh:ii:ss format
            $date = date('Y-m-d H:i:s', strtotime('now'));
            //if is an object create the object
            if(!is_array($input))
            {
                Order::dispenseNewOrder($input, $date);
            }
            else //is array of object
            {
                foreach($input as $order) 
                {
                    array_push ($orders, Order::dispenseNewOrder($order, $date));
                }
            }
            R::commit();

            return R::exportAll ($orders);
        }
        catch(Exception $e) {
            R::rollback();
            throw new Exception($e->getMessage());
        }
    }

    //this method dispense new order into orders table
    private static function dispenseNewOrder($input, $date) 
    {
        $order = R::dispense('orders');
        $order->import($input);
        $order->created_at = $date;
        $order->updated_at = $date;

        //stores the status into order
        R::store($order);
        return $order;
    }

    //this method update the order
    public static function updateOrder($input, $id) 
    {
        R::begin();
        try
        {
            if(!$input || !$id) throw new exception("empty input data");
            $order = R::findOne('orders','id = ?', array($id));
            if($order) {
                $order->import($input);
                //update the update date & time
                $date = date('Y-m-d H:i:s', strtotime('now'));
                $order->updated_at = $date;
                R::store($order);
            }
            R::commit();
        }
        catch(Exception $e) {
            R::rollback();
            throw new Exception($e->getMessage());
        }
    }

}
