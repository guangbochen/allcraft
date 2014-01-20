<?php
use RedBean_Facade as R;

/**
 * This class manages basic CRUD methods to notification subscriber
 */
Class Message {

    /* this method returns list of messages */
    public static function findByUser($offset, $limit, $username)
    {
        $messages = R::findAll('messages', 'receiver = ? Order by id desc LIMIT ?, ?', 
            array($username, (int)$offset, (int)$limit));

        $count = R::$f->begin() ->select('count(id)') 
                        ->from('messages') ->where(' receiver = ? ')
                            ->put($username)->get('row');
        $count = (int)$count['count(id)'];

        $unread = Message::countUnreadMessage($username);

        //return json array of messages if it is found
        $messages = R::exportAll($messages);
        return (array('count' => $count, 'unread_messages' => $unread, 'messages' => $messages));
    }

    private static function countUnreadMessage($username)
    {
        $unread = R::$f->begin() ->select('count(id)') 
                        ->from('messages') ->where(' receiver = ? AND is_read = 0')
                            ->put($username) ->get('row');
        $unread = (int)$unread['count(id)'];

        return $unread;
    }

    /* 
     * this method creates new message that belongs to a specific notification 
     */
    public static function newMessage($input, $notification, $firstOrder, $lastOrder, $date)
    {
        //if has subsribers then add into database
        $assigned_users = $input->subscribers;
        if(isset($assigned_users) && is_array($assigned_users)) 
        {

            $desc = ($firstOrder === $lastOrder) ?
                $input->creator . ' assigned order(' . $firstOrder['order_number']
                . ') to you at '. $date
                : $input->creator . ' assigned orders(' . $firstOrder['order_number']
                . ' - ' . $lastOrder['order_number']. ') to you at '. $date;

            foreach($assigned_users as $user) {

                $message = R::dispense('messages');
                $message->notification_id = $notification->id;
                $message->receiver = $user;
                $message->description = $desc;
                $message->is_read = false;
                $message->created_at = $date;
                $message->creator = $input->creator;

                //save assigned user as subscriber
                R::store($message);
            }
        }
    }
}
