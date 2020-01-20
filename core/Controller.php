<?php
    namespace Core;

    use Utils\Util;

    class Controller
    {
        /**
         * L'instance de Core\Model
         * @var Model
         */
        protected $model;

        public function __construct($action, Request $req, Response $res)
        {
            $this->loadModel();

            if (is_callable([$this, $action])) {
                $this->$action($req, $res);
            }else {
                throw new \Exception('L\'action à appeler n\'existe pas dans le controller '.get_class($this));
                
            }
        }

        /**
         * Permet de charger le model par defaut avec le Model
         */
        public function loadModel()
        {
            $ctrl = \get_class($this);
            $tab = explode('\\', $ctrl);

            if (count($tab) == 3) {
                $ctrlName = $tab[2];
                $modelName = explode('Controller', $ctrlName)[0];
                $Model = 'App\\Models\\'.ucfirst($modelName).'Model';

                if (class_exists($Model)) {
                    $this->model = new $Model;
                    return true;
                }
            }

            return false;
        }
    }
    