<?php
use RedBean_Facade as R;
//speed up the process of recursive query like exportall and dup
$schema = R::$duplicationManager->getSchema();
R::$duplicationManager->setTables($schema);

/**
 * this class manages basic CRUD method of the files
 **/
Class Files {

    /* returns all files */
    public static function findAll() {
        $files = R::findAll('files'); 

        //return array of files if is found
        return R::exportAll($files);
    }
    
    /* find an files by id */
    public static function findFilesBy($id) {
        $files = R::findAll('files','order_number = ?', array($id));

        //return finded files
        return R::exportAll($files);
    }

    /* this method add new file */
    public static function addFile(array $file, array $options)
    {
        R::begin();
        try
        {
            //check input data is not empty
            if(!$file) throw new exception("empty input data");

            //get the current date in yyyy_mm_dd hh:ii:ss format
            $date = date('Y-m-d H:i:s', strtotime('now'));

            $new_file = R::dispense('files');
            $file_path = $options['root_path'].$file['name'];
            $new_file->download_url = $file_path;
            $new_file->name = $file['name'];
            $size = Files::human_filesize($file['size']);
            /* $new_file->size = $file['size']; */
            $new_file->size = $size;
            $new_file->uploaded_at = $date;
            $new_file->order_number = 'ACxxxxx';

            //stores the status into order
            R::store($new_file);
            R::commit();
            return $new_file;
        }
        catch(Exception $e) {
            R::rollback();
            throw new Exception($e->getMessage());
        }
    }

    /* this method delete an files */
    public static function deleteFile($id) 
    {
        R::begin();
        try
        {
            $files = R::findOne('files','id = ?', array($id));
            if(!$files) throw new Exception('files does not eixst');
            R::trash($files);
            R::commit();
        }
        catch(Exception $e) {
            R::rollback();
            throw new Exception($e->getMessage());
        }
    }

    private static function human_filesize($bytes, $decimals = 2) 
    {
        $sz = 'BKMGTP';
        $factor = floor((strlen($bytes) - 1) / 3);
        $size = sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
        if($factor != 0) $size = $size . 'B';
        return $size;
    }

}


