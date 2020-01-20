<?php
    namespace App\Controllers;

    use Core\Controller;
    use Core\Request;
    use Core\Response;

    class UsersController extends Controller
    {
        public $nom = "mb";

        public function index(Request $req, Response $res)
        {
            $res->send("Bienvenu ici");
        }

        public function getUserById()
        {

            $user = [
                'id' => 1,
                'nom' => 'Bolenge',
                'prenom' => 'Don de Dieu'
            ];

            send($user);
        }

        public function getAll(Request $req, Response $res)
        {
            $res->send([[
                'id' => 1,
                'nom' => 'Gloire'
            ],[
                'id' => 2,
                'nom' => 'Gladis'
            ]]);
        }

        public function setUserById()
        {
            $data = json_decode($_SERVER['HTTP_CONTENT']);
            send($data);
        }

        public function userDataById()
        {
            $_POST['message'] = "Bien un posting";
            send($_SERVER);
            // curl_setopt_array(
            //     CURLOPT_PUT =>
            // )
        }

        public function deleteUserById()
        {
            send('User ' . $_GET['id'] . ' supprimé avec succès');
        }
    }
    