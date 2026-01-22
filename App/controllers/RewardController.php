<?php
namespace App\Controllers;

use App\Repositories\RewardRepository;
use App\Repositories\PointsRepository;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class RewardController
{
    private Environment $twig;
    private RewardRepository $rewardRepo;
    private PointsRepository $pointsRepo;

    public function __construct()
    {
        $this->rewardRepo = new RewardRepository();
        $this->pointsRepo = new PointsRepository();

        $loader = new FilesystemLoader(__DIR__ . '/../views');
        $this->twig = new Environment($loader);
        $this->twig->addGlobal('base_path', BASE_URL);
    }

    public function index(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        
        $success = $_SESSION['success'] ?? null;
        unset($_SESSION['success']);



        echo $this->twig->render('rewards.html.twig', [
            'user'    => $_SESSION['user'],
            'points'  => $_SESSION['user']['loyalty_points'],
            'rewards' => $this->rewardRepo->findAll(),
            'success' => $success,
        ]);
    }

    public function redeem(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $rewardId = (int) ($_POST['reward_id'] ?? 0);
        $reward = $this->rewardRepo->findById($rewardId);

        if (!$reward) {
            header('Location: ' . BASE_URL . '/rewards');
            exit;
        }

        $userPoints = $_SESSION['user']['loyalty_points'];

        if ($userPoints < $reward['points_required']) {
            $_SESSION['reward_error'] = 'Points insuffisants';
            header('Location: ' . BASE_URL . '/rewards');
            exit;
        }

        // Déduire les points
        $this->pointsRepo->redeemPoints(
            $_SESSION['user']['id'],
            $reward['points_required'],
            'Reward : ' . $reward['name']
        );
        $this->rewardRepo->decreaseStock($rewardId);

        // Recharger les points
        $_SESSION['user']['loyalty_points'] -= $reward['points_required'];
        $_SESSION['success'] = " Récompense accordée !";

        header('Location: ' . BASE_URL . '/rewards');
        exit;
    }
}
