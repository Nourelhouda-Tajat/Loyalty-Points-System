<?php
namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class HomeController {
    private $twig;
    public function __construct(){
        $loader=new FilesystemLoader (__DIR__ . '/../views');
        $this->twig = new Environment($loader);
        $this->twig->addGlobal('base_path', BASE_URL);

    }

    public function index(){
        echo $this->twig->render('index.html.twig');
    }
}


?>