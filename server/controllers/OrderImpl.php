<?php
require_once 'helpers/json_helper.php';
require_once 'models/Order.php';

/**
 * this class implement methods that is required to order
 */
class OrderImpl 
{
    private $app;

    /* constructor */
    public function __construct() 
    {
        $this->app = \Slim\Slim::getInstance();
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
            echo Order::updateOrder($input, $id);
        }
        catch(Exception $e) 
        {
            response_json_error($this->app, 500, $e->getMessage());
        }
    }

    public function getLastOrderNumber() {
        try 
        {
            echo Order::findLastOrder();
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



