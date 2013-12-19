<?php
use RedBean_Facade as R;

/**
 * This class manages basic CRUD methods to message subscriber
 */
Class Subscriber {

    /* 
     * this method creates new subscribers that belongs to a specific message 
     */
    public static function createSubscriber($input, $message_id)
    {
        //if has subsribers then add into database
        if(isset($input->subscribers)) 
        {
            $assigned_users = $input->subscribers;

            foreach($assigned_users as $user) {

                //save assigned user as subscriber
                $subscriber = R::dispense('subscribers');
                $subscriber->message_id = $message_id;
                $subscriber->assigned_user = $user;
                R::store($subscriber);
            }
        }
    }

}
