<?php
    namespace App\Controllers;

    use Core\Controller;
    use Core\Request;
    use Core\Response;

    class PagesController extends Controller
    {
        public function index(Request $req, Response $res)
        {
            // $users = $this->model->findAll([], 'users');

            $res->render('pages/index', [
                'title' => 'Bienvenue sur mon petit framework',
                'users' => !empty($users) ? $users : ''
            ]);
        }
    }
    