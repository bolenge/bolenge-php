<?php
    namespace App\Middleware;

    use Core\Middleware;

    /**
     * Le Middleware des erreurs
     */
    class ErrorsMiddleware extends Middleware
    {
        /**
         * Renvoi l'erreur au cas où il y aurait
         */
        public function getError()
        {
            if ($this->req->hasError()) {
                $error = 'getError'.$this->req->error();
                $this->$error();
            }

            return false;
        }

        /**
         * Renvoi l'erreur 404
         */
        public function getError404()
        {
            if (APP_TYPE === 'api') {
                $this->res->send(['error' => 'Error 404 Not Found Route'], '404');
            }
            
            $this->res->error('404');
        }
    }
    