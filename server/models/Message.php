<?php
// define database shcema
use RedBean_Facade as R;
//speed up the process of recursive query like exportAll and dup
$schema = R::$duplicationManager->getSchema();
R::$duplicationManager->setTables($schema);

Class Message {

    /* this method returns list of messages */
    public static function findAll() 
    {
        $messages = R::findAll('messages');

        //return json array of messages if it is found
        if($messages) return R::exportAll($messages);

        return null;
    }

    /* this method create new order */
    public static function createOrder($input) 
    {
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
                    Order::dispenseNewOrder($order, $date);
            }
            R::commit();
        }
        catch(Exception $e) {
            R::rollback();
            throw new Exception($e->getMessage());
        }
    }

    /* this method dispense new order into orders table */
    private static function dispenseNewOrder($input, $date) 
    {
        $order = R::dispense('orders');
        $order->import($input);
        $order->created_at = $date;
        $order->updated_at = $date;

        //stores the status into order
        R::store($order);
    }

}
