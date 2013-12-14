<?php
require_once 'helpers/json_helper.php';
require_once 'models/Order.php';

/**
 * this is interface for user implementation
 */
interface OrderMethods{
    public function findAll();
    public function findOrderBy($orderNumber);
    public function createOrder();
}

/**
 * this class implement methods that is related to users
 */
class OrderImpl implements orderMethods {
    private $app;

    /* constructor */
    public function __construct() {
        $this->app = \Slim\Slim::getInstance();
    }

    /* returns all users */
    public function findAll() {
        try 
        {
            if(isset($_SERVER['QUERY_STRING']))
            {
                if(!($_GET['index']) || !($_GET['max']))
                    throw new Exception("Invalid URL parameters");
                $index = $_GET['index'];
                $max = $_GET['max'];
                $orders = Order::findByPaging($index, $max);
                if(!$orders) throw new Exception ('empty orders');
                response_json_data($orders);
            }
            else
            {
                $orders = Order::findAll();
                if(!$orders) throw new Exception ('empty orders');
                response_json_data($orders);
            }

        }
        catch(Exception $e) 
        {
            response_json_error($this->app, 500, $e->getMessage());
        }
    }

    /* returns an user by name */
    public function findOrderBy($orderNumber) {
        try 
        {
            $order = Order::findOrder($orderNumber);
            if(!$order) throw new Exception ('order not found');
            response_json_data($order);
        }
        catch(Exception $e) 
        {
            response_json_error($this->app, 500, $e->getMessage());
        }
    }

    /* create an user */
    public function createOrder() {
        try 
        {
            $request = $this->app->request()->getBody();
            $input   = json_decode($request);
            echo json_encode (Order::createOrder($input));
        }
        catch(Exception $e) 
        {
            response_json_error($this->app, 500, $e->getMessage());
        }

    }

    /* update an user */
    public function updateOrder($id) {
        try 
        {
            $request = $this->app->request()->getBody();
            $input   = json_decode($request);
            //validate user input
            /* $this->validateUserData($input); */
            Order::updateOrder($input, $id);
            echo json_encode(array('message' => 'update order successfully'));
        }
        catch(Exception $e) 
        {
            response_json_error($this->app, 500, $e->getMessage());
        }
    }

    /* /1* validate username and password *1/ */
    /* private function validateUserData($input) */
    /* { */
    /*     $username = $input['name']; */
    /*     $password = $input['password']; */
    /*     //check empty username and password */
    /*     if(!$username || !$password) */ 
    /*         throw new Exception ('empty username or password'); */

    /*     //check username and password are alphanumeric */
    /*     if(!ctype_alnum($username) || !ctype_alnum($password)) */ 
    /*         throw new Exception ('invalid username or password'); */
    /* } */

    /* /1* check user role *1/ */
    /* private function validateUserRole($role) */
    /* { */
    /*     if(!$role) */ 
    /*         throw new Exception ('user role is undefined'); */
    /* } */

}



