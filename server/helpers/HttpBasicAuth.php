<?php
/**
 * HTTP Basic Authentication
 * to require HTTP basic auth for all routes.
 */
require_once 'models/User.php';
class HttpBasicAuth extends \Slim\Middleware 
{
    /**
     * @var string
     */

 
    /**
     * Constructor
     * @param string $realm, The HTTP Authentication realm
     */
    public function __construct( $realm = 'Requires Login') 
    {
        $this->realm = $realm;
    }
 
    /**
    * Call
    *
    * This method will check the HTTP request headers for previous authentication. If
    * the request has already authenticated, the next middleware is called. Otherwise,
    * a 401 Authentication Required response is returned to the client.
    */
    public function call() 
    {
        $req = $this->app->request();
        $res = $this->app->response();
        $authUser = $req->headers('PHP_AUTH_USER');
        $authPass = $req->headers('PHP_AUTH_PW');
        if ($this->authenticate($authUser, $authPass)) {
            $this->next->call();
        }
        else {
            $this->deny_access();
        }
    }

    /**
     * Authenticate 
     * @param string $username, The HTTP Authentication username
     * @param string $password, The HTTP Authentication password     
     */
    protected function authenticate($username, $password) 
    {
        if(!ctype_alnum($username)) 
            return false;

        if(isset($username) && isset($password))
        {
            // Check database here with $username and $password
            if(User::validateLogin($username, $password))
                return true;
        }
        else 
            return false;
    }

    /**
     * Deny Access
     */   
    protected function deny_access() 
    {
        $res = $this->app->response();
        $res->status(401);
        $res->header('WWW-Authenticate', sprintf('Basic realm="%s"', $this->realm));
    }

}
