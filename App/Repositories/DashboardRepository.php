<?php
namespace App\Repositories;

use Config\Database;
use PDO;

class DashboardRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function getUser(int $userId): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT id, name, email, total_points
             FROM users
             WHERE id = ?"
        );
        $stmt->execute([$userId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPointsHistory(int $userId): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT amount, description, balance_after, createdat
             FROM points_transactions
             WHERE user_id = ?
             ORDER BY createdat DESC"
        );
        $stmt->execute([$userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
