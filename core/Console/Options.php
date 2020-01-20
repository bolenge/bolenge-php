<?php
	namespace Core\Console;

	define('PATH_CTRLS', config('path.controllers'));
	define('PATH_MDDLW', config('path.middlewares'));
	
	
	/**
	 * Permet de gérer chaque option argumentée
	 */
	class Options extends Commands
	{
		use MakeCommands;

		/**
		 * Le path de controllers
		 * @var string
		 */
		const CTRLS_PATH = PATH_CTRLS;
		const MDDLW_PATH = PATH_MDDLW;

		protected $helpsCommands = [
			'make' => [
				'controller' => 'Crée une nouvelle class controller',
				'model' => 'Crée une nouvelle class model',
				'middleware' => 'Crée une nouvelle class middleware'
			],
			'server' => 'Permet de lancer le serveur'
		];
		
		public function __construct($token, array $args)
		{
			$this->invokeOption($token, $args);
		}

		/**
		 * Permet d'appeler une option
		 */
		public function invokeOption(string $option, $args)
		{
			$optionBrute = $option;
			$option = preg_replace('#^\-\-#', '', $option);
			$option = preg_match('#:#', $option) ? explode(':', $option) : $option;

			$method = is_array($option) ? $option[0].ucfirst($option[1]) : $option;

			if (is_callable([$this, $method])) {
				$this->$method($args);
			}else {
				console_log("\n  La commande $optionBrute n'est plus supportée ! \n");
			}
		}

		/**
		 * Le help principal de mb shell
		 * @param array $args
		 */
		public function help(array $args = null)
		{
			$espace = "		";
			$helps = $this->helpsCommands;
			$output = FRAMEWORK_NAME.' '.FRAMEWORK_VERSION." \n\n";
			$output .= "Usage : \n command [options] [arguments] \n\n";
			$output .= "Options : \n  -h, --help".$espace." Affiche le message d'aide \n";
			$output .= "Commandes valides : \n ";

			foreach ($helps as $parent => $chield) {
				$output .= $parent."\n ";

				if (is_array($chield)) {
					foreach ($chield as $cmd => $desc) {
						$output .= " ".make_cmd_space($parent.':'.$cmd).$desc."\n ";
					}
				}
			}

			console_log($output);
		}

		/**
		 * Permet de lancer le serveur
		 */
		public function server($args = null)
		{
			if (!empty($args)) {
				$port = array_shift($args);
				$port = preg_match('#port=#', $port) ? $port : DEFAULT_SERVER_PORT;
				$port = preg_match('#=#', $port) ? explode('=', $port)[1] : DEFAULT_SERVER_PORT;
				$port = is_numeric($port) ? $port : DEFAULT_SERVER_PORT;
			}else {
				$port = DEFAULT_SERVER_PORT;
			}

			echo shell_exec("echo Bolenge-PHP Server is listen on http://localhost:$port");
			shell_exec("php -S localhost:$port");
		}
	}