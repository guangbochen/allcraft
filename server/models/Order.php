<?php
use RedBean_Facade as R;
//speed up the process of recursive query like exportAll and dup
$schema = R::$duplicationManager->getSchema();
R::$duplicationManager->setTables($schema);

/* 
 * this class manages basic CRUD implementation of the order 
 */
Class Order {

    /* this method returns list of orders */
    public static function findAll()
    {
        $orders = R::findAll('orders', 'Order By id desc');

        /* foreach ($orders as $order) { */
        /*     Order::getCompleteOrders($order); */
        /* } */
        //return json array of orders if it is found
        return R::exportAll($orders);
    }

    /* this method find a list of orders in pagination */
    public static function findByPaging($firstNumber, $maxNumber)
    {
        $orders=R::findAll('orders', 'ORDER BY id desc LIMIT ?,?', array((int)($firstNumber-1), (int)$maxNumber));

        /* foreach ($orders as $order) { */
        /*     Order::getCompleteOrders($order); */
        /* } */
        //return json array of orders if it is found
        return R::exportAll($orders);
    }

    /* find an order by id */
    public static function findOrder($id) 
    {
        $order = R::findOne('orders','id = ?', array($id));

        //return order if is found
        return $order;
    }

    // Find orders at a specific date created
    public static function findCreatedAt($date, $limit, $offset)
    {
        // offset = 0, limit = 2 -> return 1,2
        // offset = 2, limit = 2 -> return 3,4
        // The offset increases based on limit
        $orders = R::find (
            'orders', 
            'created_at LIKE ? ORDER BY id desc LIMIT ?, ?', 
            array(
                "%$date%", 
                (int) $offset,
                (int)$limit
            )
        );

        $orders = Order::newDateFormat($orders);

        return json_encode (R::exportAll ($orders));
    }

    // Find orders before a provided date created
    public static function findCreatedBefore ($date, $limit, $offset)
    {
        $orders = R::find (
            'orders', 
            'DATE(created_at) < ? ORDER BY id desc LIMIT ?, ?',
            array (
                $date,
                (int)$offset,
                (int)$limit
            )
        );
        $orders = Order::newDateFormat($orders);

        return json_encode(R::exportAll ($orders));
    }

    /* this method returns a full order with its mapped entities */
    private static function newDateFormat($orders)
    {
        foreach ($orders as $order) {
            $newDate = date("Y-m-d g:i a", strtotime($order->created_at));
            $order->created_at = $newDate;
        }
        return $orders;
    }

    /* this method create new order */
    public static function createOrder($input) 
    {
        R::begin();
        try
        {
            $orders = array();
            //check input data is not empty
            if(!$input) throw new exception("empty input data");

            //get the current date in yyyy_mm_dd hh:ii:ss format
            $date = date('Y-m-d H:i:s', strtotime('now'));

            //get last orderNumber 
            $lastOrder= Order::findLastOrder();
            $lastId = (int)$lastOrder['id'];

            //if is an object create the object
            if(!is_array($input))
            {
                $orders = Order::dispenseNewOrder($input, $date, ++$lastId);
                $orders = json_decode($orders);
            }
            else //els is array of object
            {
                foreach($input as $order) 
                    array_push ($orders, Order::dispenseNewOrder($order, $date, ++$lastId));
                $orders = R::exportAll ($orders);
            }

            R::commit();
            return $orders;
        }
        catch(Exception $e) {
            R::rollback();
            throw new Exception($e->getMessage());
        }
    }

    /* this method dispense new order into orders table */
    private static function dispenseNewOrder($input, $date, $lastId) 
    {
        $order = R::dispense('orders');
        $order->import($input);
        $order->created_at = $date;
        $order->updated_at = $date;
        //add auto generated unique order number
        $orderNumber = Order::generateOrderNo($lastId);
        $order->order_number = $orderNumber;

        //stores the status into order
        R::store($order);
        return $order;
    }

    /* this method generate unique order number for each order */
    private static function generateOrderNo($id) 
    {
        $length = 5;
        $number = str_pad((int)$id,$length,"0",STR_PAD_LEFT);
        $orderNumber = 'AC'. $number;
        return $orderNumber;
    }

    /* this method update the order */
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
            return $order;
        }
        catch(Exception $e) {
            R::rollback();
            throw new Exception($e->getMessage());
        }
    }

    /* find the last order */
    public static function findLastOrder() 
    {
        $order = R::findLast('orders');
        //return order if is found
        return $order;
    }

    /* this method searching orders by query */
    public static function searchOrders($query)
    {
        $orders = R::findAll('orders', 
            'order_number = ? OR status = ? OR customer = ? Order By id desc',
            array($query, $query , $query));

        //return json array of orders if it is found
        return R::exportAll($orders);
    }

}
