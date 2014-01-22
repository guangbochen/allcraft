<?php
require_once 'helpers/json_helper.php';
require_once 'models/Notification.php';

/*
 * This class manages basic CRUD methods of Notifications and it pushes a broadcast
 * notifications to its client when new notifications is created
 */
class NotificationImpl {
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

    /* this method find all the notifications */
    public function findAll()
    {
        try 
        {
            $params = $this->app->request()->params();
            $fields = array_to_json($params);

            //get request url parmameters
            $offset = isset($fields->offset) ? $fields->offset : 0;
            $limit  = isset($fields->limit) ? $fields->limit : 5; 
            $notifications = Notification::findAll($offset, $limit);
            response_json_data($notifications);
        }
        catch(Exception $e) {
            response_json_error($this->app, 500, $e->getMessage());
        }
    }

    /* this method find a specific notification by id */
    public function findNotification($id)
    {
        try {
            $notification = Notification::findNotification($id);
            response_json_data($notification);
        }
        catch(Exception $e) {
            response_json_error($this->app, 500, $e->getMessage());
        }
    }

    /*
     * this method create new notification and push the notification
     * to its subscribed client through Pubnub cloud API
     */
    public function push() {
        try 
        {
            //reterive json data
            $request = $this->app->request()->getBody();
            $input   = json_decode($request);

            //save notifications into database
            $notification_id = Notification::createNotification($input);

            //generate broadcast notification
            $notification = array();
            $notification = Notification::findNotification($notification_id);

            //send broadcast notification
            $info = $this->pubnub->publish(array(
                'channel' => 'printee_notification', ## REQUIRED Channel to Send
                'notification' => $notification   ## REQUIRED Notification String/Array
            ));

            response_json_data($notification);
        }
        catch(Exception $e) {
            response_json_error($this->app, 500, $e->getMessage());
        }
    }
}

