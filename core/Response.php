<?php 
	namespace Core;

	use App\Config\AppConfig;

	/**
	 * Gère les réponses http à envoyer au user
	 */
	class Response extends HTTPResponse
	{
		protected $app;
		protected $vars = [];
		protected $fileView;
		protected $template = '';

		public function __construct()
		{
			$this->setTemplate(APP_LAYOUT_PAGE);
		}

		/**
		 * Permet d'ajoiuter un header dans une reponse à envoyer au user
		 * @param {string} $header Le Header à envoyer
		 * @return void
		 */
		public function addHeader($header)
		{
			header($header);
		}

		/**
		 * Modifie le message flash
		 */
		public function setFlash($value, $type = 'info')
		{
			$_SESSION['flash'] = [];

			if (is_array($value)) {

				$_SESSION['flash']['message'] = '';

				foreach ($value as $v) {
					$_SESSION['flash']['message'] .= $v . '<br />';
				}
			}else{
				$_SESSION['flash']['message'] = $value;
			}
			
			$_SESSION['flash']['type'] = $type;
		}

		/**
		 * Renvoi le message flash
		 * @return {string} $flash le message flash
		 */
		public function getFlash()
		{
			$flash = $_SESSION['flash'];
			unset($_SESSION['flash']);

			return $flash;
		}

		/**
		 * Vérifie un utilisateur a un message flash
		 * @return {bool}
		 */
		public function hasFlash()
		{
			return isset($_SESSION['flash']);
		}

		/**
		 * Permet d'ajouter une variable dans la vue
		 * @param string $var Le nom de la variable à rajouter
		 * @param void $value La valeur que va contenir la variable
		 * @return void
		 */
		public function addVar($var, $value)
		{
			if (!is_string($var) || is_numeric($var) || empty($var)) {
				throw new InvalidArgumentException('Le nom de la variable doit être une chaîne de caratères non nulle');
			}

			$this->vars[$var] = $value;
		}

		/**
		 * Permet de renvoyer la vue
		 * @param {String} $view La vue qu'il faut appeler
		 * @param {Array} $vars Un tableau des variables qu'il faut passer à la vue
		 * @return {void}
		 */
		public function render($view, $vars = [])
		{
			$vars += $this->vars;

			if (!empty($vars)) {
				extract($vars);
			}

			$this->setfileView($view);
			
			ob_start();
			require $this->fileView;
			$content = ob_get_clean();

			require $this->template;
		}

		/**
		 * Permet de faire une redirection vers un autre url
		 * @param string $url
		 */
		public function redirect($url)
		{
			$this->addHeader('Location: '.$url);
			exit;
		}

		/**
		 * Permet de renvoyer une valeur à la demande du client en format json
		 * @param $data La donnée à renvoyer
         * @param string|int $status Le status à rajouter
		 */
		public function send($data, $status = null)
		{
            $this->addHeader('Content-Type: application/json');
            
            if ($status) {
                $state = 'status'.$status;

                if (is_callable([$this, $state])) {
                    $this->$state();
                }
            }
			
			echo json_encode($data);
			die();
		}

		/**
		 * Modifier le fichier layout (le template de l'application)
		 * @param {string} $tamplate Le nom du template à mettre
		 * @return void
		 */
		public function setTemplate($template)
		{
			$this->template = './views/'.$template.'.php';
		}

		/**
		 * Permet de lancer une page d'erreur
		 * @param string $status Le status de l'erreur
		 * @param string $viewError La vue de l'erreur
		 */
		public function error($status, $viewError = false)
		{
			$error = 'status'.$status;
			$filenameError = '';

			if ($viewError) {
				$this->setFileView('errors/'.$viewError);
			}else {
				$this->setFileView('errors/'.$status);
			}

			$this->$error();

			ob_start();
			require $this->fileView;
			$content = ob_get_clean();

			require './views/error.php';
			die();
		}

		/**
		 * Ajoute le status 404 (Page Not Found) dans le header
		 * @return void
		 */
		public function status404()
		{
			$this->addHeader('HTTP/1.0 404 Not Found');
		}

		/**
		 * Ajoute le status 401 dans le header
		 */
		public function status401()
		{
			$this->addHeader('HTTP/1.0 401');
        }
        
        /**
		 * Ajoute le status 200 dans le header
		 */
		public function status200()
		{
			$this->addHeader('HTTP/1.0 200');
        }
        
        /**
		 * Ajoute le status 500 dans le header
		 */
		public function status500()
		{
			$this->addHeader('HTTP/1.0 500 Internal Server Error');
		}

		/**
		 * Modifie le fichier qui va contenir le truc à afficher
		 * @param {string} $fileView Le fichier du contenu
		 * @return void
		 */
		public function setFileView($fileView)
		{
			if (!is_string($fileView) || empty($fileView)) {
				throw new \InvalidArgumentException('La vue spécifiée est invalide', 1);
			}

			$view = './views/'.$fileView.'.php';

			if (!file_exists($view)) {
				throw new Exception('Le fichier de la view spécifiée n\'existe pas');
				
			}

			$this->fileView = $view;
		}
	}