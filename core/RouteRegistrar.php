<?php
    namespace Core;

    class RouteRegistrar
    {
        protected $routes = [];

		const NO_ROUTE = 1;
        
        /**
         * Permet d'ajouter une nouvelle route
         * @param string $method La méthode de la route qu'on enregistre
         * @param Route $route L'instance de \Core\Route
         */
		public function addRoute(string $method, Route $route)
		{
			if (!array_key_exists($method, $this->routes)) {
				$this->routes[$method] = [];
			}

			if (!in_array($route, $this->routes[$method])) {
				$this->routes[$method][] = $route;
			}
        }
        
        /**
		 * Renvoi toutes les routes
		 * @return array
		 */
		public function routes()
		{
			return $this->routes;
		}
    }
    