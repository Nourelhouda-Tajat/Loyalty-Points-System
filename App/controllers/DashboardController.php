<?php
namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use App\Repositories\DashboardRepository;



class DashboardController
{
    private $twig;
    private DashboardRepository $repo;
    public function __construct(){
        $loader=new FilesystemLoader (__DIR__ . '/../views');
        $this->twig = new Environment($loader);
        $this->repo = new DashboardRepository();
        $this->twig->addGlobal('base_path', BASE_URL);

    }
    public function index(): void
    {
        // if (!isset($_SESSION['user'])) {
        //     header('Location: ' . BASE_URL . '/login');
        //     exit;
        // }

        $userId = $_SESSION['user']['id'];

        echo $this->twig->render('dashboard.html.twig', [
            'user' => $this->repo->getUser($userId),
            'history' => $this->repo->getPointsHistory($userId)
        ]);
    }
}
