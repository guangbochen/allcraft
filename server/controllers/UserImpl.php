<?php
require_once 'helpers/json_helper.php';
require_once 'helpers/Authen.php';
require_once 'models/User.php';

/**
 * this class implement login and basic CRUD methods of users
 */
class UserImpl {

    private $app;

    /* constructor */
    public function __construct() {
        $this->app = \Slim\Slim::getInstance();
    }

    /* returns all users */
    public function findAll() {
        try 
        {
            $users = User::findAll();
            if(!$users) throw new Exception ('empty users');

            //return finded users
            $users = array('users' => $users);
            response_json_data($users);
        }
        catch(Exception $e) 
        {
            response_json_error($this->app, 500, $e->getMessage());
        }
    }

    /* returns an user by name */
    public function login() {
        $input = $this->app->request()->post();
        try 
        {
            //check whether session has already start
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            /* session_start(); // Add this to the top of the file */
            $this->validateUserData($input);
            $user = User::validateLogin($input['username'], $input['password']);
            if($user === false ) throw new Exception ('invalid username or password');

            $_SESSION['user'] = $user;

            //retrun the  user
            response_json_data($user);
        }
        catch(Exception $e) 
        {
            response_json_error($this->app, 401, $e->getMessage());
        }
    }

    /* update an user */
    public function updateUser() {
        $input = $this->app->request()->post();
        try 
        {
            $this->validateUserData($input);
            User::updateUser($input);
            response_json_data('update user successfully');
        }
        catch(Exception $e) 
        {
            response_json_error($this->app, 500, $e->getMessage());
        }
    }

    /* create an user */
    public function createUser() {
        $input = $this->app->request()->post();
        try 
        {
            $role = $input['role'];
            //validate user input
            $this->validateUserData($input);
            $this->validateUserRole($role);
            User::createUser($input);
            response_json_data('create user successfully');
        }
        catch(Exception $e) 
        {
            response_json_error($this->app, 500, $e->getMessage());
        }

    }

    /* delete user */
    public function deleteUser() {
        $input = $this->app->request()->post();
        try 
        {
            $id = $input['id'];
            //validate user id
            if(!$id) throw new Exception ('empty user id');
            User::deleteUser($id);
            response_json_data('delete user successfully');
        }
        catch(Exception $e) 
        {
            response_json_error($this->app, 500, $e->getMessage());
        }

    }

    /* validate username and password */
    private function validateUserData($input)
    {
        $username = $input['username'];
        $password = $input['password'];
        //check empty username and password
        if(!$username || !$password) 
            throw new Exception ('empty username or password');

        //check username and password are alphanumeric
        if(!ctype_alnum($username) || !ctype_alnum($password)) 
            throw new Exception ('invalid username or password');
    }

    /* check user role */
    private function validateUserRole($role)
    {
        if(!$role) 
            throw new Exception ('user role is undefined');
    }

}



