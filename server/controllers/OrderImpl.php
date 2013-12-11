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
    /* public function updateUser(); */
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
            $orders = Order::findAll();
            if(!$orders) throw new Exception ('empty orders');
            response_json_data($orders);
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
            //validate user input
            /* $this->validateUserData($input); */
            Order::createOrder($input);
            echo json_encode(array(
                'message' => 'create order successfully',
            ));
        }
        catch(Exception $e) 
        {
            response_json_error($this->app, 500, $e->getMessage());
        }

    }

    /* /1* update an user *1/ */
    /* public function updateUser() { */
    /*     $input = $this->app->request()->post(); */
    /*     try */ 
    /*     { */
    /*         $this->validateUserData($input); */
    /*         User::updateUser($input); */
    /*         response_json_data('update user successfully'); */
    /*     } */
    /*     catch(Exception $e) */ 
    /*     { */
    /*         response_json_error($this->app, 500, $e->getMessage()); */
    /*     } */
    /* } */


    /* /1* delete user *1/ */
    /* public function deleteUser() { */
    /*     $input = $this->app->request()->post(); */
    /*     try */ 
    /*     { */
    /*         $id = $input['id']; */
    /*         //validate user id */
    /*         if(!$id) throw new Exception ('empty user id'); */
    /*         User::deleteUser($id); */
    /*         response_json_data('delete user successfully'); */
    /*     } */
    /*     catch(Exception $e) */ 
    /*     { */
    /*         response_json_error($this->app, 500, $e->getMessage()); */
    /*     } */

    /* } */

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



