<?php
use RedBean_Facade as R;

/**
 * This class manages basic CRUD methods to notification subscriber
 */
Class Message {

    /* 
     * this method creates new message that belongs to a specific notification 
     */
    public static function newMessage($input, $notification, $firstOrder, $lastOrder, $date)
    {
        //if has subsribers then add into database
        if(isset($input->subscribers)) 
        {
            $assigned_users = $input->subscribers;

            $desc = ($firstOrder === $lastOrder) ?
                $input->creator . ' assigned order(' . $firstOrder['order_number']
                . ') to you at '. $date
                : $input->creator . ' assigned orders(' . $firstOrder['order_number']
                . ' - ' . $lastOrder['order_number']. ') to you at '. $date;

            foreach($assigned_users as $user) {

                $message = R::dispense('messages');
                $message->notification_id = $notification->id;
                $message->assigned_user = $user;
                $message->description = $desc;

                //save assigned user as subscriber
                R::store($message);
            }
        }
    }

}
