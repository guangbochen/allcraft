<?php
// define database shcema
use RedBean_Facade as R;

//speed up the process of recursive query like exportAll and dup
$schema = R::$duplicationManager->getSchema();
R::$duplicationManager->setTables($schema);

/**
 * this class manages bsaic CRUD method of the users
 **/
Class User {
    private $name;
    private $password;
    private $role;


    /* returns all users */
    public static function findAll() {
        $users = R::findAll('users'); 

        //return array of users if is found
        if($users) return R::exportAll($users);

        return null;
    }
    
    /* find an user by name */
    public static function findUser($name) {
        $user = R::findOne('users','name = ?', array($name));

        //return user if is found
        if($user) return json_decode($user);

        return null;
    }

    public static function createUser($input)
    {
        R::begin();
        try
        {
            $user = R::dispense('users');
            $user->import($input);
            R::store($user);
            R::commit();
        }
        catch(Exception $e) {
            R::rollback();
            throw new Exception($e->getMessage());
        }

    }

    /* update an user */
    public static function updateUser($input) {
        R::begin();
        try
        {
            $user = R::findOne('users','id = ?', array($input['id']));
            $user->import($input);
            //using a selection filter to ignore extra input data (e.g gender, which is not included in the database)
            //otherwise the import will auto loading all the input data and throw an new exception if it contains any extra value.
            //And the transaction will automatically rollback to protect data integrity,
            //however this does not apply any form of validation to the bean and it should be done in the model or controller.
            /* $user->import($input, 'id, name, password'); */
            R::store($user);
            R::commit();
        }
        catch(Exception $e) {
            R::rollback();
            throw new Exception($e->getMessage());
        }
    }

    /* delete an user */
    public static function deleteUser($id) {
        R::begin();
        try
        {
            $user = R::findOne('users','id = ?', array($id));
            if(!$user) throw new Exception('user does not eixst');
            R::trash($user);
            R::commit();
        }
        catch(Exception $e) {
            R::rollback();
            throw new Exception($e->getMessage());
        }
    }


    /* validate user login via username and password */
    public static function validateLogin($name, $password)
    {
        $user = R::findOne('users','name = ?', array($name));
        if(!$user) return false;
        if(strcmp($user->password, $password) == 0) return true;
        return false;
    }

}


