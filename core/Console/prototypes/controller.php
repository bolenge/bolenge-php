<?php
return 
'<?php
    namespace '.config("namespace.controller").';
    
    use Core\Controller;
    use Core\Request;
    use Core\Response;

    class ctrl extends Controller
    {
    	/**
    	 * Default method example
    	 * @param Request $req
    	 * @param Response $res
    	 */
        public function index (Request $req, Response $res) {
			// 
        }
    }
';