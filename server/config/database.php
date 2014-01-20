<?php
use RedBean_Facade as R;

if (defined('ENVIRONMENT'))
{
    switch (ENVIRONMENT) {
        case 'development':
            // Local Mysql
            $db_host = 'localhost'; $db_name = 'allcraftDB'; $db_user = 'root'; $db_pass = 'root';
            break;

		case 'testing':
        case 'production':
            $db_host = 'localhost';
            $db_name = 'hoochcre_allcraft';
            $db_user = 'hoochcre_su';
            $db_pass = 'hooch12345';
            break;

        default:
            exit('The application environment is not set correctly.');
	}
}

R::setup("mysql:host=$db_host; dbname=$db_name", $db_user, $db_pass);
R::freeze(true);
