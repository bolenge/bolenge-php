<?php
	require './bootstrap/include.php';

	// debug(config('namespace.middleware'));

	$app = app();
	
	// Initilisation des routes
	$usersRouter 	= require './routes/users.php';
	$pagesRouter 	= require './routes/pages.php';

	// Instance des routes
	$app->use('/', $pagesRouter);
	$app->use('/users', $usersRouter);

	// Les middlewares
	// Middleware gérant ou traquant les erreurs
	$app->middleware('errors', function ($middleware) {
		$middleware->getError();
	});

	$app->middleware('auth', function ($middleware) {
		$middleware->authVerify();
	});