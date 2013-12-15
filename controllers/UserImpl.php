<?php
require_once 'helpers/json_helper.php';
require_once 'models/User.php';

/**
 * this is interface for user implementation
 */
interface UserMethods{
    public function findAll();
    public function findUser($name);
    public function updateUser();
    public function createUser();
    public function deleteUser();
}

/**
 * this class implement methods that is related to users
 */
class UserImpl implements UserMethods {
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
    public function findUser($name) {
        try 
        {
            $user = User::findUser($name);
            if(!$user) throw new Exception ('user not found');

            //retrun an finded user
            $user = array('user' => $user);
            response_json_data($user);
        }
        catch(Exception $e) 
        {
            response_json_error($this->app, 500, $e->getMessage());
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
        $username = $input['name'];
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



