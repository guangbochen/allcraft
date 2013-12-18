<?php
require_once 'helpers/json_helper.php';
require_once 'models/Message.php';

/*
 * PubNub Real-time cloud push API
 */
class PubNubImpl {
    private $app;
    private $pubnub;

    /* constructor */
    public function __construct() 
    {
        $this->app = \Slim\Slim::getInstance();

        //initlise PubNub Push API
        $this->pubnub = new \Pubnub\Pubnub(
            "pub-c-8021207d-c906-4f21-ac84-7d5773c9255b",  ## PUBLISH_KEY
            "sub-c-077f7902-66ad-11e3-b1d4-02ee2ddab7fe",  ## SUBSCRIBE_KEY
            "sec-c-Y2RjNDExZWQtMTk1YS00M2I2LWFlYmUtMzg3NjEyMjEwYTRi",  ## SECRET_KEY
            false   ## SSL_ON?
        );
    }

    /* this method find all the messages */
    public function findAll()
    {
        try 
        {
            $messages = Message::findAll();
            response_json_data($messages);
        }
        catch(Exception $e) {
            response_json_error($this->app, 500, $e->getMessage());
        }
    }

    /* this method find a specific id */
    public function findMessage($id)
    {
        try {
            $message = Message::findMessage($id);
            response_json_data($message);
        }
        catch(Exception $e) {
            response_json_error($this->app, 500, $e->getMessage());
        }
    }


    /* 
     * this method push message to the subscribe cloud API
     */
    public function push() {
        try 
        {
            //reterive json data
            $request = $this->app->request()->getBody();
            $input   = json_decode($request);

            //save messages into database
            $message_id = Message::createMessage($input);

            //generate broadcast message
            $message = array();
            $message = Message::findMessage($message_id);

            //send broadcast message
            $info = $this->pubnub->publish(array(
                'channel' => 'printee_notification', ## REQUIRED Channel to Send
                'message' => $message   ## REQUIRED Message String/Array
            ));

            response_json_data($message);
        }
        catch(Exception $e) {
            response_json_error($this->app, 500, $e->getMessage());
        }
    }
}

