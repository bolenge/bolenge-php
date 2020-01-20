<?php
	use Core\Router;

    $router = new Router;

	$router->get('/', 'UsersController@index');
	// $router->get('/:id', 'UsersController@getUserById');
	$router->get('/all/:limit', 'UsersController@getAll');
	// $router->put('/:id', 'UsersController@setUserById');
	// $router->post('/:id', 'UsersController@userDataById');
	// $router->post('/createUser', 'UsersController@create');
    // $router->delete('/:id', 'UsersController@deleteUserById');
    
    return $router;