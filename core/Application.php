<?php
    namespace Core;

    use App\Config\AppConfig;
    
    class Application
    {
        /**
         * L'instance de la classe Router
         * @var Router
         */
        protected $router;

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

        public function __construct()
        {
            $this->router = new Router;
            $this->req = new Request;
            $this->res = new Response;
        }

        /**
         * Méthode chargée d'appeler les pages ou modules qu'il faut par rapport aux route
         * @param string $prefixeUri Le prefixe de l'uri en cours
         * @param Router $router L'instance du router
         */
        public function use(string $prefixeUri, Router $router)
        {
            $regex = '#^'.$prefixeUri.'#';

            if ($prefixeUri === '/') {
                if ($route = $router->getRoute($this->req->method(), $this->req->uri())) {
                    
                    $this->getController($route);
                }else {
                    $this->req->setError('404');
                    return false;
                }
            }else {
                if (preg_match($regex, $this->req->uri(), $matches)) {
                    $url = preg_replace($regex, '', $this->req->uri());
                    $url = empty($url) ? '/' : $url;

                    $route = $router->getRoute($this->req->method(), $url);
                    
                    if ($route) {
                        $this->getController($route);
                    }else {
                        $this->req->setError('404');
                    }
                }

                return false;
            }
        }

        /**
         * Renvoi l'instance du Router
         * @return Router
         */
        public function router()
        {
            return $this->router;
        }

        /**
         * Charger de lancer le controller par rapport à la route trouvée
         * @param Route $route L'instance de la Core\Route
         */
        public function getController(Route $route)
        {
            if ($route->vars()) {
				if (count($route->vars()) > 0) {
					$_GET = array_merge($_GET, $route->vars());
				}
            }

            $action = $route->action();
            
            if (is_callable($action) && $route->controller() == null) {
                
                $action($this->req, $this->res);
            }else {
                $controllerClass = config('namespace.controller').'\\'.ucfirst($route->controller());
                if (!class_exists($controllerClass)) {
                    throw new \Exception("La classe $controllerClass n'existe pas");
                }

                return new $controllerClass($route->action(), $this->req, $this->res);
            }
        }

        /**
         * Rajoute un middleware dans l'application
         * @param string|null $middleware Le nom du middleware à appeler
         * @param \Closure $callback La fonction callback à appeler
         */
        public function middleware($middleware = null, $callback)
        {
            if (!empty($middleware)) {
                $Middleware = config('namespace.middleware').'\\'.ucfirst($middleware).'Middleware';

                if (!class_exists($Middleware)) {
                    throw new \Exception('Le Middleware '.$Middleware.'n\'existe pas');
                }
                
                /**
                 * @param Middleware
                 */
                $callback(new $Middleware($this->req, $this->res));
            }else {
                /**
                 * @param Request
                 * @param Response
                 */
                $callback($this->req, $this->res);
            }
        }

        public static function basePath()
        {
            return $_SERVER['DOCUMENT_ROOT'] ? $_SERVER['DOCUMENT_ROOT'] : '.';
        }
    }
    