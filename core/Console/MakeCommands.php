<?php 
	namespace Core\Console;

	/**
	 * Class gérant les différentes commandes de make
	 */
	trait MakeCommands
	{
		/**
		 * Permet de créer un nouveau controller
		 * @param array $args Les arguments sur le controller à créer
		 */
		public function makeController(array $args)
		{
			if (!empty($args)) {
				$ctrlName = array_shift($args);
				$fileCtrl = $ctrlName.'.php';
				$ctrl = require PROTOTYPE_FILES_PATH.DS.'controller.php';
				$ctrl = str_replace('ctrl', $ctrlName, $ctrl);

				if (!file_exists(self::CTRLS_PATH.DS.$fileCtrl)) {
					if ($this->make(self::CTRLS_PATH, $fileCtrl, $ctrl)) {
						console_log("\n  Le controller ".$ctrlName." a été créé avec succès. ".MB_START_ON." \n");
					}else {
						console_log("\n  Impossible de créer ce controller. \n");
					}
				}else {
					console_log("\n  Le controller ".$ctrlName." existe déjà. \n");
				}
			}else {
				console_log("\n  Veuillez spécifier le nom du controller à créer à la fin \n  Ex: php mb make:controller PagesController \n");
			}
		}

		/**
		 * Permet de créer un nouveau controller
		 * @param array $args Les arguments sur le controller à créer
		 */
		public function makeMiddleware(array $args)
		{
			if (!empty($args)) {
				$middlewareName = array_shift($args);
				$fileMiddleware = $middlewareName.'.php';
				$middleware = require PROTOTYPE_FILES_PATH.DS.'middleware.php';
				$middleware = str_replace('mddlware', $middlewareName, $middleware);

				if (!file_exists(self::MDDLW_PATH.DS.$fileMiddleware)) {
					if ($this->make(self::MDDLW_PATH, $fileMiddleware, $middleware)) {
						console_log("\n  Le middleware ".$middlewareName." a été créé avec succès. ".MB_START_ON." \n");
					}else {
						console_log("\n  Impossible de créer ce middleware. \n");
					}
				}else {
					console_log("\n  Le middleware ".$middlewareName." existe déjà. \n");
				}
			}else {
				console_log("\n  Veuillez spécifier le nom du middleware à créer à la fin \n  Ex: php mb make:middleware PagesMiddleware \n");
			}
		}
	}