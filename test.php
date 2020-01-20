<?php
	$result = shell_exec('echo Bonjour');

	die($result);

	// protected $helpsCommands = [
	// 		'make' => [
	// 			'controller' => [
	// 				'description' => 'Crée une nouvelle class controller',
	// 				'usage' => 'make:controller [options] <name>',
	// 				'arguments' => [
	// 					'name' => [
	// 						'description' => 'Le nom de la class controller à créer'
	// 					]
	// 				],
	// 				'options' => [
	// 					'-h' => 'Affiche ce message d\'aide'
	// 				]
	// 			],
	// 			'model' => [
	// 				'description' => 'Crée une nouvelle class model',
	// 				'usage' => 'make:model [options] <name>'
	// 			],
	// 			'middleware' => 'Crée une nouvelle class middleware'
	// 		],
	// 		'server' => ''
	// 	];