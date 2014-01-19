<?php
use RedBean_Facade as R;
require_once 'models/Message.php';
//speed up the process of recursive query like exportAll and dup
$schema = R::$duplicationManager->getSchema();
R::$duplicationManager->setTables($schema);

/* 
 * this class manages basic CRUD methods of notifications
 */
Class Notification {

    /* this method returns list of notifications */
    public static function findAll($offset, $limit)
    {
        /* $notifications = R::findAll('notifications', 'Order by id desc'); */
        $notifications = R::findAll('notifications', 'Order by id desc LIMIT ?, ?', 
            array((int)($offset-1), (int)$limit));
        /* $notifications = R::findAll('notifications', 'Order by id desc LIMIT ?, ?', */ 
        /*     array((int)1, (int)5)); */

        foreach ($notifications as $notification) {
            Notification::getCompleteNotification($notification);
        }

        //return json array of notifications if it is found
        return R::exportAll($notifications);
    }


    /* this method find a specific notification by id */
    public static function findNotification($id)
    {
        $notification = R::findOne('notifications','id = ?', array($id));
        if($notification) {
            Notification::getCompleteNotification($notification);
        }

        return R::exportAll($notification);
    }

    /* this method reterives a complete notifications with its owned subscribers */
    private static function getCompleteNotification($notification)
    {
        $subscribers = R::findAll('messages', 'notification_id = ?', array($notification->id));
        if($subscribers) {
            $notification->ownSubscribers = $subscribers;
        }
    }

    /* this method create new notification */
    public static function createNotification($input, $orders) 
    {
        R::begin();
        try
        {
            //check input data is not empty
            if(!$input) throw new exception("empty input data");

            //get the current date in yyyy_mm_dd hh:ii:ss format
            $date = date('Y-m-d H:i:s', strtotime('now'));
            $notification = Notification::dispenseNewNotification($input, $date, $orders);

            R::commit();
            return $notification; ## return new generated notification id
        }
        catch(Exception $e) {
            R::rollback();
            throw new Exception($e->getMessage());
        }
    }

    /* this method dispense new notification and add it into database*/
    private static function dispenseNewNotification($input, $date, $orders)
    {
        $notification = R::dispense('notifications');
        $notification->import($input, 'creator, number_of_orders');
        $notification->created_at = $date;

        // using saved orders instead of raw input orders data due to order number auto-correction
        $firstOrder = current($orders);
        $lastOrder  = end($orders);

        //add description to the notification
        $desc = (count($orders) > 1) ?
            $input->creator . ' generated ' . $input->number_of_orders 
            . ' orders(' . $firstOrder['order_number']
            . ' - ' . $lastOrder['order_number']. ') at '. $date
            : $input->creator . ' generated ' . $input->number_of_orders 
            . ' order (' . $firstOrder['order_number'] . ') at '. $date;
        $notification->description = $desc;

        //stores notification
        R::store($notification);
        
        //create new subscribers that belongs to the notification
        Message::newMessage($input, $notification, $firstOrder, $lastOrder, $date);

        return $notification;
    }

}
