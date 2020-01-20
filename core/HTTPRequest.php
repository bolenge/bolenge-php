<?php
    namespace Core;

    class HTTPRequest
    {
        /**
         * Variable contenat l'erreur au cas où il y en aurait
         * @var string|int|null
         */
        protected $error = null;

        /**
         * Vérifie s'il y a une erreur dans la requête lancée
         * @return bool
         */
        public function hasError()
        {
            return !empty($this->error);
        }

        /**
         * Modifie la valeur de l'erreur
         * @param mixed $error
         * @return void
         */
        public function setError($error)
        {
            $this->error = $error;
        }

        /**
         * Renvoi l'erreur
         */
        public function error()
        {
            return $this->error;
        }

        /**
         * Gère les requêtes vers les API
         */
        public static function api()
        {
            return new APIRequest;
        }
    }
    