<?php
require_once 'helpers/json_helper.php';
require_once 'models/Status.php';

/**
 * this is interface for user implementation
 */
interface StatusMethods{
    public function findAll();
    public function findStatusBy($id);
    public function updateStatus($id);
    public function createStatus();
    public function deleteStatus($id);
}

/**
 * this class implement methods that is related to users
 */
class StatusImpl implements statusMethods {
    private $app;

    /* constructor */
    public function __construct() {
        $this->app = \Slim\Slim::getInstance();
    }

    /* returns all statuses */
    public function findAll() {
        try 
        {
            $status = Status::findAll();
            if(!$status) throw new Exception ('empty statuses');

            //return finded statuses
            response_json_data($status);
        }
        catch(Exception $e) 
        {
            response_json_error($this->app, 500, $e->getMessage());
        }
    }

    /* find an status by id */
    public function findStatusBy($id) {
        try 
        {
            $status = Status::findStatus($id);
            if(!$status) throw new Exception ('status not found');

            //retrun an finded status 
            response_json_data($status);
        }
        catch(Exception $e) 
        {
            response_json_error($this->app, 500, $e->getMessage());
        }
    }

    /* update an status */
    public function updateStatus($id) {
        try 
        {
            $request = $this->app->request()->getBody();
            $input   = json_decode($request);
            $this->validateStatus($input);
            $status = Status::updateStatus($input, $id);
            response_json_data($status);
        }
        catch(Exception $e) 
        {
            response_json_error($this->app, 500, $e->getMessage());
        }
    }

    /* create new status */
    public function createStatus() {
        try 
        {
            $request = $this->app->request()->getBody();
            $input   = json_decode($request);
            //validate user input
            $this->validateStatus($input);
            Status::createStatus($input);
            response_json_data('update status successfully');
        }
        catch(Exception $e) 
        {
            response_json_error($this->app, 500, $e->getMessage());
        }

    }

    /* delete user */
    public function deleteStatus($id) {
        $input = $this->app->request()->post();
        try 
        {
            $id = $input['id'];
            //validate user id
            if(!$id) throw new Exception ('empty status id');
            Status::deleteStatus($id);
            response_json_data('delete status successfully');
        }
        catch(Exception $e) 
        {
            response_json_error($this->app, 500, $e->getMessage());
        }

    }

    /* validate new status */
    private function validateStatus($input)
    {
        $status = $input->status;
        $description = $input->description;
        //check empty status and description
        if(!$status || !$description) 
            throw new Exception ('empty status or description');
    }

}



