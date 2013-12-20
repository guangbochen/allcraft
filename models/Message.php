<?php
// define database shcema
use RedBean_Facade as R;
require_once 'models/Subscriber.php';
//speed up the process of recursive query like exportAll and dup
$schema = R::$duplicationManager->getSchema();
R::$duplicationManager->setTables($schema);

Class Message {

    /* this method returns list of messages */
    public static function findAll() 
    {
        $messages = R::findAll('messages');

        foreach ($messages as $message) {
            Message::getCompleteMessage($message);
        }

        //return json array of messages if it is found
        return R::exportAll($messages);

        return null;
    }


    /* this method find a specific message by id */
    public static function findMessage($id)
    {
        $message = R::findOne('messages','id = ?', array($id));
        if($message) Message::getCompleteMessage($message);

        return R::exportAll($message);

    }

    /* this method reterives a complete messages with its owned subscribers */
    private static function getCompleteMessage($message)
    {
        $subscribers = R::findAll('subscribers', 'message_id = ?', array($message->id));
        /* var_dump($subscribers); */
        if($subscribers) $message->ownSubscribers = $subscribers;
    }


    /* this method create new message */
    public static function createMessage($input) 
    {
        R::begin();
        try
        {
            //check input data is not empty
            if(!$input) throw new exception("empty input data");

            //get the current date in yyyy_mm_dd hh:ii:ss format
            $date = date('Y-m-d H:i:s', strtotime('now'));

            //if is an object create the object
            $message_id = Message::dispenseNewMessage($input, $date);
            R::commit();

            return $message_id;
        }
        catch(Exception $e) {
            R::rollback();
            throw new Exception($e->getMessage());
        }
    }

    /* this method dispense new order into orders table */
    private static function dispenseNewMessage($input, $date)
    {
        $message = R::dispense('messages');
        $message->import($input, 'username, is_creator');
        $message->created_at = $date;

        //add description to the message
        $desc = isset($input->number_of_orders) ? $input->number_of_orders . ' new orders has been created' :  'Order has been updated';
        $message->description = $desc;

        //stores message
        R::store($message);
        
        //create new subscribers that belongs to the message
        Subscriber::createSubscriber($input, $message->id);

        return $message->id;
    }

}
