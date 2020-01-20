<?php
	namespace Core;

	session_start();
	 
	/**
	 * Gère les différentes requêtes http que l'utilisateur aura lancé
	 */
	class Request extends HTTPRequest
	{
		protected $bodyFiledsEmpty = [];
		protected $bodyErrorFields;

		public function isAuthentificated()
		{
			return isset($_SESSION['auth']) && $_SESSION['auth'] === true;
		}

		public function isAdmin()
		{
			return isset($_SESSION['admin']) ? $_SESSION['admin'] : false;
		}

		public function setAuthentificated($authenticated = true)
		{
			if (!is_bool($authenticated)) {
				throw new \InvalidArgumentException('La valeur spécifiée à la méthode User::setAuthentificated() doit être un boolean');
			}

			$_SESSION['auth'] = $authenticated;
		}

		/**
		 * Sert de renvoyer une session
		 * @param string $key La clé de la session
		 */
		public function getSession($key)
		{
			return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
		}

		/**
		 * Sert de renvoyer le tableau de toutes les sessions
		 * @return array $_SESSION
		 */
		public function getAllSession()
		{
			return $_SESSION;
		}

		/**
		 * Detruit toutes les sessions
		 * @return array $_SESSION
		 */
		public function destrySessions()
		{
			$_SESSION = [];
		}

		/**
		 * Sert de modifier la valeur d'une session
		 * @param string $key La clé de la session
		 * @param string $value La valeur de la session
		 * @return void
		 */
		public function setSession($key, $value)
		{
			$_SESSION[$key] = $value;
		}


		/**
		 * Sert de renvoyer un cookie
		 * @param {string} $key La clé du cookie
		 * @return $cookie
		 */
		public function getCookie($key)
		{
			return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
		}

		/**
		 * Modifie ou crée un cookie
		 * @param {string} $key la clé du cookie en question
		 * @param {string} $value La valeur du cookie
		 * @param {number} $days Le nombre de jour
		 * @param {bool} $secure L'activation de la sécurité ou pas
		 * @return void
		 */
		public function setCookie($key, $value, $days = 365, $secure = true)
		{
			$temps = time() + $days * 24 * 3600;

			if ($secure) {
				setcookie($key, $value, $temps, null, null, false, true);
			}else{
				setcookie($key, $value, $temps);
			}
		}

		/**
		 * Vérifie un cookie existe
		 * @param {strign} $key La clé du cookie en question
		 * @return {bool} $cookie
		 */
		public function cookieExists($key)
		{
			return isset($_COOKIE[$key]);
		}

		/**
		 * Permet de renvoyer une variable GET
		 * @param {string} $key La clé de la variable en question
		 * @return {any} $_GET[$key] La valeur trouvée
		 */
		public function get($key = null)
		{
			if ($key) {
				return isset($_GET[$key]) ? $_GET[$key] : null;
			}else {
				return !empty($_GET) ? $_GET : null;
			}
		}

		/**
		 * Permet de renvoyer une variable GET
		 * @param string $key La clé de la variable en question
		 * @return void $_GET[$key] La valeur trouvée
		 */
		public function params($key = null)
		{
			if ($key) {
				return isset($_GET[$key]) ? $_GET[$key] : null;
			}else {
				return !empty($_GET) ? $_GET : null;
			}
			
		}

		/**
		 * Véfirie si une variable GET existe
		 * @param {string} $key La clé de la variable
		 * @return {bool}
		 */
		public function getExists($key)
		{
			return isset($_GET[$key]);
		}

		/**
		 * Renvoi la variable POST
		 * @param {string} $key La clé du POST en question
		 * @return {any} $post
		 */
		public function post($key = null)
		{
			if ($key) {
				return isset($_POST[$key]) ? $_POST[$key] : null;
			}else {
				return !empty($_POST) ? $_POST : null;
			}
			
		}

		/**
		 * Renvoi la variable POST
		 * @param string $key La clé du POST en question
		 * @return array $post
		 */
		public function body($key = null)
		{
			if ($key) {
				return isset($_POST[$key]) ? $_POST[$key] : null;
			}else {
				return !empty($_POST) ? $_POST : null;
			}
			
		}

		/**
		 * Renvoi la variable FILES
		 * @param {string} $key La clé du FILES en question
		 * @return {any} $post
		 */
		public function files($key = null)
		{
			if ($key) {
				return isset($_FILES[$key]) ? $_FILES[$key] : null;
			}else {
				return !empty($_FILES) ? $_FILES : null;
			}
			
		}

		/**
		 * Vérifie la variable POST existe
		 * @param {string} $key La clé de la variable en question
		 * @return {bool}
		 */
		public function postExists($key)
		{
			return isset($_POST[$key]);
		}

		// explode(delimiter, string)

		/**
		 * Permet de renvoyer la méthode de la requête envoyée
		 * @return string $method
		 */
		public function method()
		{
			return $_SERVER['REQUEST_METHOD'];
		}

		/**
		 * Renvoi le request uri de la page où on est
		 */
		public static function requestUri()
		{
			return $_SERVER['REQUEST_URI'];
		}

		/**
		 * Renvoi le uri de la requête envoyée
		 * @return string $uri
		 */
		public function uri()
		{
			return $_SERVER['REQUEST_URI'];
		}

		/**
		 * Vérifie si les champs d'un formulaire ne sont pas vides
		 * @param {array} $fields Le tableau des champs du formulaire
		 * @return {bool}
		 */
		public function postNotEmpty($fields = [])
		{
			if (count($fields) != 0) {
                foreach ($fields as $field) {
                    if (empty($_POST[$field]) || trim($_POST[$field]) == "") {
                        return false;
                    }
                }
                
                return true;
            }
		}

		/**
		 * Modifie une valeur du tableau $_POST
		 * @param string $key La clé du POST en question
		 * @param string $value La valeur à insérer
		 * @return string $_POST[$key]
		 */
		public function setBody($key, $value)
		{
			$_POST = array_merge($_POST, [$key => $value]);

			return $_POST[$key];
		}

		/**
		 * Supprime une valeur du tableau $_POST
		 * @param string $key La clé du POST en question
		 * @param string $value La valeur à supprimer
		 */
		public function unsetBody($key)
		{
			if (isset($_POST[$key])) {
				unset($_POST[$key]);
			}
		}

		/**
		 * Supprime des valeurs du tableau $_POST
		 * @param string $keys Les clés du POST en question
		 * @param string $value La valeur à supprimer
		 */
		public function unsetBodies($keys = [])
		{
			if (!is_array($keys)) {
				throw new Exception("Le paramètre doit être un tableau");
				
			}else {
				foreach ($keys as $key) {
					if (isset($_POST[$key])) {
						unset($_POST[$key]);
					}
				}
			}
		}

		/**
		 * Ajoute des valeurs dans le tableau $_POST
		 * @param string $key La clé du POST en question
		 * @param string $value La valeur à insérer
		 * @return string $_POST[$key]
		 */
		public function setBodies($data)
		{
			if (!is_array($data)) {
				throw new Exception("La variable du paramètre doit être un tableau associatif");
				
			}

			$_POST = array_merge($_POST, $data);
		}

		/**
		 * Vérifie si les champs d'un formulaire ne sont pas vides
		 * @param array $fields Le tableau des champs du formulaire
		 * @return bool
		 */
		public function bodyNotEmpty($fields = [])
		{
			if (count($fields) != 0) {
                foreach ($fields as $field) {
                    if (empty($_POST[$field]) || trim($_POST[$field]) == "") {
						$this->bodyFiledsEmpty[] = $field;
                    }
				}
				
				if (!empty($this->bodyFiledsEmpty)) {
					return false;
				}
                
                return true;
            }
		}
		
		/**
		 * Renvoi les erreurs sur les champs qui sont vides
		 */
		public function getBodyErrorFields()
		{
			if (!empty($this->bodyFiledsEmpty)) {
				$error = count($this->bodyFiledsEmpty) == 1 
						? 'Le champ ' . $this->bodyFiledsEmpty[0] . ' est obligatoire'
						: 'Les champs ' . \implode(', ', $this->bodyFiledsEmpty) . ' sont obligatoires';
				
				return $error;
			}

			return null;
		}

		/**
		 * Vérifie si les champs renseigner et ceux demandés
		 * @param array $fields_form Le tableau des champs du formulaire
		 * @param array $fields_required Le tableau des champs demandés
		 * @return bool
		 */
		public function bodyFieldsRequired(array $fields_form, array $fields_required)
		{
			if (count($fields_form) != 0 && count($fields_form) != 0) {
				
                foreach ($fields_form as $field) {
					if (!in_array($field, $fields_required)) {
						return false;
					}
                }
                
                return true;
            }
		}

		/**
		 * Vérifie si les champs des données de la méthode GET ne sont pas vides
		 * @param {array} $fields Le tableau des champs
		 * @return {bool}
		 */
		public function getNotEmpty($fields = [])
		{
			if (count($fields) != 0) {
                foreach ($fields as $field) {
                    if (empty($_GET[$field]) || trim($_GET[$field]) == "") {
                        return false;
                    }
                }
                
                return true;
            }
		}

		/**
		 * Vérifie si les champs des données de la méthode GET ne sont pas vides
		 * @param array $fields Le tableau des champs
		 * @return bool
		 */
		public function paramsNotEmpty($fields = [])
		{
			if (count($fields) != 0) {
                foreach ($fields as $field) {
                    if (empty($_GET[$field]) || trim($_GET[$field]) == "") {
                        return false;
                    }
                }
                
                return true;
            }
		}

		/**
		* Vérifie si une requête envoyée est en ajax ou pas
		* @return boolean
		*/
		public function isAjax()
		{
			if ($this->body('ajax') || $this->params('ajax')) {
				return true;
			}

			return false;
		}
	}