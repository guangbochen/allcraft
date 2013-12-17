<?php
require_once 'helpers/json_helper.php';
require_once 'models/Order.php';

/**
 * this is interface for order implementation
 */
interface OrderMethods{
    public function findAll();
    public function findOrderBy($orderNumber);
    public function createOrder();
}

/**
 * this class implement methods that is required to order
 */
class OrderImpl implements orderMethods {
    private $app;

    /* constructor */
    public function __construct() {
        $this->app = \Slim\Slim::getInstance();
    }

    /* 
     * returns a list of order (with pagination if contains query parameters)
     */
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

    /* 
     * find and returns an order by orderNumber 
     * @id, order id
     * */
    public function findOrderBy($id) {
        try 
        {
            $order = Order::findOrder($id);
            if(!$order) throw new Exception ('order not found');
            response_json_data($order);
        }
        catch(Exception $e) 
        {
            response_json_error($this->app, 500, $e->getMessage());
        }
    }

    /* create an new order */
    public function createOrder() {
        try 
        {
            $request = $this->app->request()->getBody();
            $input   = json_decode($request);
            //validate user input
            /* $this->validateUserData($input); */
            Order::createOrder($input);
            echo json_encode(array('message' => 'create order successfully'));
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



