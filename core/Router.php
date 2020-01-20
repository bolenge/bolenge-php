<?php
	namespace Core;
	
	/**
	 * Le Router : permet de gérer la routage des routes et des urls
	 */
	class Router extends RouteRegistrar
	{
		/**
		 * Renvoi la route par rapport à l'url passé en paramètre
		 * @param string $url
		 */
		public function getRoute($method, $url)
		{
			$urls = [];

			foreach ($this->routes[$method] as $route) {
				// Si la route correspond à l'URL
				if (($varsValues = $route->match($url)) !== false) {
					// Si elle a des variables

					if ($route->hasVars()) {
						$varsNames = $route->varsNames();
						$listVars = [];

						foreach ($varsValues as $key => $match) {
							if ($key !== 0) {
								$listVars[$varsNames[$key - 1]] = $match;
							}else{
								$listVars['url'] = substr($match, 1);
							}

						}

						$route->setVars($listVars);
					}else{
						
						if (count($varsValues) > 1) {
							$route->setVars(['id' => $varsValues[1]]);
						}
						
					}

					return $route;
				}
			}
		}

		/**
         * Permet de registrer une route
         * @param string $method La méthode de la route
         * @param string $uri L'url
         * @param mixed La fonction callback ou le controller@action à appeler
         */
        public function registrarRoute(string $method, string $url, $callback)
        {
            $regexCtrl = '#^([a-zA-Z]{1,})+([a-zA-Z0-9{1,}])?@([a-zA-Z]{1,})+([a-zA-Z0-9{1,}])$#';
            $regexVarUrl = '#:([a-zA-Z]{1,})+([a-zA-Z0-9_\-]{1,})?#';

            $urlRegexed = preg_replace($regexVarUrl, '([a-zA-Z0-9_\-]{1,})', $url);
            $urlRegexed .= '/?';

            if (is_callable($callback)) {
                $action = $callback;
                $controller = null;
            }else {
                if (!preg_match($regexCtrl, $callback)) {
                    throw new Exception('Le paramètre 2 doit être une fonction callback ou un controller avec une action (ex: TestController@index)');
                     
                 }

                $tab = explode('@', $callback);
                $controller = $tab[0];
                $action = $tab[1];
            }

            $vars = $this->matchVars($url);

            // debug($action);

            $this->addRoute($method, new Route($urlRegexed, $controller, $action, $vars));
		}
		
		/**
         * Permet de trouver les variables dans un url
         * @param string $url L'url en question
         * @return array $vars Les variables trouvées
         */
        public function matchVars($url)
        {
            $vars = [];

            if (preg_match('#:#', $url, $macthes)) {
                $stringVars = explode(':', $url);

                foreach ($stringVars as $key => $value) {
                    if ($key > 0) {
                        $var = explode('/', $value);
                        $vars[] = $var[0];
                    }
                }
            }

            return $vars;
        }

        /**
         * Elle enregistrement la route de la méthode GET
         * @param string $uri
         * @param mixed $callback
         */
        public function get(string $uri, $callback)
        {
            $this->registrarRoute('GET', $uri, $callback);
        }

        /**
         * Enregistre une route de la méthode POST
         * @param string $uri
         * @param mixed $callback
         */
        public function post(string $uri, $callback)
        {
            $this->registrarRoute('POST', $uri, $callback);
        }

        public function put(string $uri, $callback)
        {
            $this->registrarRoute('PUT', $uri, $callback);
        }

        /**
         * Enregistre les routes de la suppression
         * @param string $uri
         */
        public function delete(string $uri, $callback)
        {
            $this->registrarRoute('DELETE', $uri, $callback);
        }
	}

 ?>