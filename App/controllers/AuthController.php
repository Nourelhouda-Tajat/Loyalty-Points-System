<?php
namespace App\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class AuthController {
    private $twig;
    private $userRepo;

    public function __construct(){
        session_start();
        $this->userRepo = new UserRepository();
        $loader = new FilesystemLoader(__DIR__ . '/../views');
        $this->twig = new Environment($loader);
        $this->twig->addGlobal('base_path', BASE_URL);
    }

    public function registerForm(){
        echo $this->twig->render('register.html.twig');
    }

    public function register(){
        $email= $_POST['email'];
        $name= $_POST['name'];
        $pw = $_POST['password'];

        if($this->userRepo->findByEmail($email)){
            echo $this->twig->render('register.html.twig', [ 'error'=> 'Email exist']);
            return;
        }

        $passwordHashed=password_hash($pw , PASSWORD_DEFAULT);
        $user = new User( $email, $passwordHashed, $name);
        $this->userRepo->save($user);
        header('Location: ' . BASE_URL  . '/login');
    }

    

    public function loginForm() {
        echo $this->twig->render('login.html.twig');
    }

    public function login(){
        $user = $this->userRepo->findByEmail($_POST['email']);
        if($user && password_verify($_POST['password'], $user->getPasswordHash())){
            $_SESSION['user_id']= $user->getId();
            header('Location: ' . BASE_URL  . '/');
            exit;
        }else {
            echo $this->twig->render('login.html.twig',['error'=>'Email or password invalid']);
        }
    }
    public function logout(){
        session_destroy();
        header('Location: ' .BASE_URL  . '/login');
    }
}

