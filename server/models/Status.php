<?php
// define database shcema
use RedBean_Facade as R;

/**
 * this class manages basic CRUD method of the statuses
 **/
Class Status {

    /* returns all statuses */
    public static function findAll() {
        $status = R::findAll('statuses'); 

        //return array of status if is found
        if($status) return R::exportAll($status);

        return null;
    }
    
    /* find an status by id */
    public static function findStatus($id) {
        $status = R::findOne('statuses','id = ?', array($id));

        //return status if is found
        if($status) return json_decode($status);

        return null;
    }


    /* this method create a new status */
    public static function createStatus($input)
    {
        R::begin();
        try
        {
            $status = R::dispense('statuses');
            $status->import($input);
            R::store($status);
            R::commit();
            return $status;
        }
        catch(Exception $e) {
            R::rollback();
            throw new Exception($e->getMessage());
        }

    }

    /* this method update the status by id */
    public static function updateStatus($input, $id) {
        R::begin();
        try
        {
            $status = R::findOne('statuses','id = ?', array($id));
            $status->import($input);
            R::store($status);
            R::commit();
            return $status;
        }
        catch(Exception $e) {
            R::rollback();
            throw new Exception($e->getMessage());
        }
    }

    /* this method delete an status */
    public static function deleteStatus($id) {
        R::begin();
        try
        {
            $status = R::findOne('statuses','id = ?', array($id));
            if(!$status) throw new Exception('status does not eixst');
            R::trash($status);
            R::commit();
        }
        catch(Exception $e) {
            R::rollback();
            throw new Exception($e->getMessage());
        }
    }

}


