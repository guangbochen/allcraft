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
            $limit      = isset($fields->limit) ? $fields->limit : 10; 
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
}



