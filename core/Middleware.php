<?php
    namespace Core;

    /**
     * Le Middleware principal
     */
    class Middleware
    {
        /**
         * L'instance de Core\Request
         * @var Request
         */
        protected $req;

        /**
         * L'instance de Core\Response
         * @var Response
         */
        protected $res;

        public function __construct(Request $req, Response $res)
        {
            $this->req = $req;
            $this->res = $res;
        }
    }
    