<?php 
	namespace Core\Console;

	/**
	 * 
	 */
	trait ArgsInput
	{
		/**
		 * Les différentes options prises en charge par mb::console
		 * @var array
		 */
		protected $optionsValids = [
			'make:controller',
			'make:middleware',
			'make:model',
			'--help',
			'server'
		];

		protected $helpCmd = '--help';
		protected $args;
		protected $option;

		public function launch()
		{
			$argv = $_SERVER['argv'];

			array_shift($argv);

			$this->args = $argv;
			$this->parse();
		}

		/**
		 * Permet de faire le parsing de l'argument principal
		 */
		public function parse()
		{
			$token = array_shift($this->args);
			$token = $token ? $token : $this->helpCmd;

			if (in_array($token, $this->optionsValids)) {
				$this->parseOption($token, $this->args);
			}

			console_log("\n  La commande $token n'existe pas. \n");
		}

		public function parseOption($token, $args)
		{
			new Options($token, $args);
		}
	}