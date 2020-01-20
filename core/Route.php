<?php
	namespace Core;

	/**
	 * Route
	 * @description : Gère toutes les routes
	 */
	class Route
	{
		protected $action;
		protected $controller;
		public $url;
		protected $varsNames;
		protected $vars;

		public function __construct($url, $controller, $action, array $varsNames)
		{
			// \debug($action);
			$this->setUrl($url);
			$this->setController($controller);
			$this->setAction($action);
			$this->setVarsNames($varsNames);
		}

		/**
		 * Renvoi le pathinfo
		 * @return {string} $pathInfo
		 */
		public static function request()
		{
			$donnees = [];

			if (isset($_SERVER['PATH_INFO'])) {
				return $_SERVER['PATH_INFO'];

			}else{
				return '/';
			}
			
		}

		/**
		 * Vérifie si la route contient des variables
		 * @return {bool}
		 */
		public function hasVars()
		{
			return !empty($this->varsNames);
		}

		/**
		 * Vérifie si l'url saisi correspond à l'une de nos urls (routes) du ficheir "routes.xml"
		 * @param {string} $url L'url de l'utilisateur
		 * @return {object} $matches
		 */
		public function match($url)
		{

			if (preg_match('#^' . $this->url . '$#',$url, $matches)) {
				// debug($matches);
				for ($i=0; $i < count($matches); $i++) { 
					if ($i > 0 && is_paire($i)) {
						$matches[$i] = preg_replace('#_#', '', $matches[$i]);
					}
				}
		
				return $matches;
			}else{
				return false;
			}
		}

		/**
		 * Modifie l'action saisi par l'utilisateur
		 * @param {string} $action L'action à ajouter
		 * @return void
		 */
		public function setAction($action)
		{
			$this->action = $action;
		}

		/**
		 * Modifie l'url
		 * @param {string} $url
		 * @return void
		 */
		public function setUrl($url)
		{
			if (is_string($url)) {
				$this->url = $url;
			}
		}

		/**
		 * Modifie le controller
		 * @param {string} $controller Le controlleur à ajouter
		 * @return void
		 */
		public function setController($controller)
		{
			if (is_string($controller)) {
				$this->controller = $controller;
			}
		}

		/**
		 * Modifie le nom des variables envoyées oar le user
		 * @param {array} $varsNames Les noms de différentes variables
		 * @param {void}
		 */
		public function setVarsNames(array $varsNames)
		{
			$this->varsNames = $varsNames;
		}

		/**
		 * Modifie les varaibles
		 * @param {string} $vars
		 */
		public function setVars($vars)
		{
			$this->vars = $vars;
		}

		/**
		 * Renvoi l'action qu'il faut
		 * @return void
		 */
		public function action()
		{
			return $this->action;
		}

		/**
		 * Renvoi le controller
		 * @return {object} $controller
		 */
		public function controller()
		{
			return $this->controller;
		}

		/**
		 * Renvoi les différentes que vous avez
		 * @return {string} $vars
		 */
		public function vars()
		{
			return $this->vars;
		}

		/**
		 * Renvoi les noms des variables
		 * @return {object} $varsNames
		 */
		public function varsNames()
		{
			return $this->varsNames;
		}
	}

 ?>