<?php
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


class HomeController{
    
    public function index(){
        $loader = new filesystemLoader(__DIR__ . '/../views');
        $twig = new Environment($loader);
        echo $this->twig->render('home.twig');
    }
}

?>