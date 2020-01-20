<?php
	namespace App\Middleware;

    use Core\Middleware;

    /**
     * AuthMiddleware
     */
    class AuthMiddleware extends Middleware
    {
    	public function authVerify()
    	{
    		if (!$this->req->getSession('user')) {
    			debug("Vous n'etes pas connecté");
    		}
    	}
    }
