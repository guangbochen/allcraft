<?php
require_once 'helpers/json_helper.php';
require_once 'models/Message.php';

/**
 * this class implement login and basic CRUD methods of messages
 */
class MessageImpl {

    private $app;

    /* constructor */
    public function __construct() {
        $this->app = \Slim\Slim::getInstance();
    }

    /* returns messages that belongs to the user*/
    public function findByUser() {
        try 
        {
            $params = $this->app->request()->params();
            $fields = array_to_json($params);

            //get request url parmameters
            $offset     = isset($fields->offset) ? $fields->offset : 0;
            $limit      = isset($fields->limit) ? $fields->limit : 7; 
            $receiver   = isset($fields->receiver) ? $fields->receiver : 'none'; 

            $messages = Message::findByUser($offset, $limit, $receiver);

            //return finded users
            response_json_data($messages);
        }
        catch(Exception $e) 
        {
            response_json_error($this->app, 500, $e->getMessage());
        }
    }

    /**
     * this function marks all unread message as read
     */
    public function setAllMessagesAsRead() {
        try 
        {
            $request = $this->app->request()->getBody();
            $input   = json_decode($request);

            if(!$input) throw new Exception('empty input');

            // set all messages as read
            Message::setAllMessagesAsRead($input);

            //return the latest messages after updating
            $offset     = isset($input->offset) ? $input->offset : 0;
            $limit      = isset($input->limit) ? $input->limit : 7; 
            $messages = Message::findByUser($offset, $limit, $input->username);

            echo json_encode($messages);
        }
        catch(Exception $e) 
        {
            response_json_error($this->app, 500, $e->getMessage());
        }
    }
}



