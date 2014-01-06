<?php
require_once 'helpers/json_helper.php';
require_once 'models/Order.php';

/**
 * this class manages searching methods of orders
 */
class SearchImpl {
    private $app;

    /* constructor */
    public function __construct() {
        $this->app = \Slim\Slim::getInstance();
    }

    /* returns all users */
    public function searchOrders() {
        try 
        {
            $params = $this->app->request()->params();
            /* $params = $_SERVER['QUERY_STRING']; */
            if($params) 
            {
                $fields = array_to_json($params);
                $query  = $fields->q;
                echo json_encode(Order::searchOrders($query));
            }
            else
            {
                SearchImpl::emptyQueryString();
            }
        }
        catch(Exception $e) 
        {
            response_json_error($this->app, 500, $e->getMessage());
        }
    }

    private function emptyQueryString()
    {
        throw new Exception('empty string of searching query');
    }

}



