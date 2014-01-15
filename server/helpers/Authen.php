<?php 
require_once 'helpers/json_helper.php';

    /**
     * Authorise function, used as Slim Route Middlewear
     */
    function authorize($role = "user") {
        return function () use ( $role ) {
            // Get the Slim framework object
            $app = \Slim\Slim::getInstance();
            // First, check to see if the user is logged in at all
            if(!empty($_SESSION['user'])) {
                // Next, validate the role to make sure they can access the route
                // We will assume admin role can access everything
                if($_SESSION['user']['role'] == $role || 
                    $_SESSION['user']['role'] == 'admin') {
                    //User is logged in and has the correct permissions... Nice!
                    return true;
                }
                else {
                    // If a user is logged in, but doesn't have permissions, return 403
                    $app->halt(403, '403 - Permissions forbidden!');
                }
            }
            else {
                // If a user is not logged in at all, return a 401
                $app->halt(401, '401 - Unauthorized user!');
            }
        };
    }
