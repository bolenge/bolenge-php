<?php
	define('DS', DIRECTORY_SEPARATOR);
	
    // Charge les config de l'application
    $app_config = require './app/config/app.php';
    $db_config = require './app/config/database.php';

    keys_array_to_constantes($app_config);
    keys_array_to_constantes($db_config);