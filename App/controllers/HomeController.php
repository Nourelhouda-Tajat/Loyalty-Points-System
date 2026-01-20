<?php
namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class HomeController {
    private $twig;
    public function __construct(){
        $loader=new FilesystemLoader (__DIR__ . '/../views');
        $this->twig = new Environment($loader);
    }

    public function index(){
        $user = isset($_SESSION['user_id']) ? ['name'=>'Visiteur','loyal_points'=> null] : ['name'=>'Invité', 'loyalty_points'=>0];

        echo $this->twig->render('index.html.twig', ['user'=> $user]);
    }
}


?>