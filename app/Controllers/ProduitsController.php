<?php
    namespace App\Controllers;

    use Core\Controller;

    class ProduitsController extends Controller
    {
        public function create()
        {
            \send("Création de produit");
        }
    }
    