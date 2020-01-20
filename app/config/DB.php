<?php
    namespace App\Config;

    /**
	 * Classe contenant la configuration de la bse de données
	 */
	class DB
	{
		static $debug = 1;
		static $databases = [
			'default' => [
				'host'		=> DB_HOST,
				'database'	=> DB_DATABASE,
				'login'		=> DB_USERNAME,
				'password'	=> DB_PASSWORD
			]
		];
	}