<?php
namespace APP\Controllers;

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
        $loader = new FilesystemLoader(__DIR__ . '/../Views');
        $this->twig = new Environment($loader);
    }

    public function registerForm(){
        echo $this->twig->render('register.html.twig');
    }

    public function register(){
        $passwordHashed=password_hash($_POST['password'], PASSWORD_DEFAULT);
        $user = new User(
            $_POST['email'],
            $passwordHashed,
            $_POST['name']
        );
        $this->userRepo->save($user);
        header('Location: /login');
    }

    public function loginForm() {
        echo $this->twig->render('login.html.twig');
    }

    public function login(){
        $user = $this->userRepo->findByEmail($_POST['email']);
        if($user && password_verify($_POST['password'], $user->getPasswordHash())){
            $_SESSION['user_id']= $user->getId();
            header('Location: /');
        }else {
            echo "Email or password invalid";
        }
    }
    public function logout(){
        session_destroy();
        header('Location: /Loyalty Points System/public/login');
    }
}

