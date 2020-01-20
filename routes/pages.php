<?php
    use Core\Router;
    use Core\Request;
    use Core\Response;

    $router = new Router;

    $router->get('/', 'PagesController@index');
    $router->get('/contact', function (Request $req, Response $res) {
        $res->render('pages/contact', [
            'title' => 'page contact'
        ]);
    });

    $router->get('/about', function (Request $req, Response $res) {
        $res->render('pages/about', [
            'title' => 'Page About us'
        ]);
    });

    return $router;