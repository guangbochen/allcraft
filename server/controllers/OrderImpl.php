<?php
use RedBean_Facade as R;
require_once 'helpers/json_helper.php';
require_once 'models/Order.php';
require_once 'models/Notification.php';

/**
 * this class implement methods that is required to order
 */
class OrderImpl 
{
    private $app;
    private $pubnub;

    /* constructor */
    public function __construct() 
    {
        $this->app = \Slim\Slim::getInstance();

        //initlise PubNub 
        $this->pubnub = new \Pubnub\Pubnub(
            "pub-c-8021207d-c906-4f21-ac84-7d5773c9255b",  ## PUBLISH_KEY
            "sub-c-077f7902-66ad-11e3-b1d4-02ee2ddab7fe",  ## SUBSCRIBE_KEY
            "sec-c-Y2RjNDExZWQtMTk1YS00M2I2LWFlYmUtMzg3NjEyMjEwYTRi",  ## SECRET_KEY
            false   ## SSL_ON?
        );
    }

    /* 
     * GET: \orders
     * GET: \orders?created_at=:date&limit=:limit&offset=:offset
     * GET: \orders?created_before=:date&limit=:limit&offset=:offset
     */
    public function findOrders() 
    {
        try 
        {
            $params = $this->app->request()->params();
            if($params) 
            {
                $fields = array_to_json($params);
                $limit  = isset($fields->limit) ? $fields->limit : 5; 
                $offset = isset($fields->offset) ? $fields->offset : 0;

                if (isset($fields->created_at))
                    echo Order::findCreatedAt($fields->created_at, $limit, $offset);
                if (isset($fields->created_before))
                    echo Order::findCreatedBefore($fields->created_before, $limit, $offset);
            }
            else 
            {
                echo json_encode (Order::findAll());
            }
        }
        catch(Exception $e) 
        {
            response_json_error($this->app, 500, $e->getMessage());
        }
    }

    /* 
     * find and returns an order by orderNumber 
     * @id, order id
     */
    public function findOrderBy($id) 
    {
        try 
        {
            echo Order::findOrder($id);
        }
        catch(Exception $e) 
        {
            response_json_error($this->app, 500, $e->getMessage());
        }
    }

    /* create an new order */
    public function createOrder() 
    {
        try 
        {
            $request = $this->app->request()->getBody();
            $input   = json_decode($request);

            // create new orders
            $orders = Order::createOrder($input->orders);

            //create and push notification of new generated orders
            OrderImpl::pushGenerateNotification($input, $orders);

            echo json_encode($orders);
        }
        catch(Exception $e) 
        {
            response_json_error($this->app, 500, $e->getMessage());
        }

    }

    /* 
     * update an eixsting order 
     * @id, order id
     */
    public function updateOrder($id) 
    {
        try 
        {
            $request = $this->app->request()->getBody();
            $input   = json_decode($request);
            //validate user input
            /* echo Order::updateOrder($input, $id); */

            // create new orders
            $order = Order::updateOrder($input->orders, $id);

            //create and push notification of new generated orders
            OrderImpl::pushUpdateNotification($input, $order);

            echo json_encode($order);
        }
        catch(Exception $e) 
        {
            response_json_error($this->app, 500, $e->getMessage());
        }
    }

    /* get the last order object */
    public function getLastOrder() 
    {
        try 
        {
            echo Order::findLastOrder();
        }
        catch(Exception $e) 
        {
            response_json_error($this->app, 500, $e->getMessage());
        }

    }

    /* 
     * push method generate new order notification and
     * sends broadcast to its subscribers via Pubnub
     */
    private function pushGenerateNotification($input, $order)
    {
        try 
        {
            //save notifications into database
            $notification = Notification::createNotification($input, $order);

            // push notification to its channel's subscriber
            $info = $this->pubnub->publish(array(
                'channel' => 'allcraft_push_notification', ## REQUIRED Channel to Send
                'message' => array('description' => $notification->description )   ## REQUIRED Notification String/Array
            ));
        }
        catch(Exception $e) 
        {
            response_json_error($this->app, 500, $e->getMessage());
        }
    }

    /* 
     * push method generate new order notification and
     * sends broadcast to its subscribers via Pubnub
     */
    private function pushUpdateNotification($input, $order)
    {
        try 
        {
            //save notifications into database
            $notification = Notification::updateNotification($input, $order);

            // push notification to its channel's subscriber
            $info = $this->pubnub->publish(array(
                'channel' => 'allcraft_push_notification', ## REQUIRED Channel to Send
                'message' => array('description' => $notification->description )   ## REQUIRED Notification String/Array
            ));
        }
        catch(Exception $e) 
        {
            response_json_error($this->app, 500, $e->getMessage());
        }
    }

}



