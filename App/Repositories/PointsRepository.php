<?php
namespace App\Repositories;

use Config\Database;
use PDO;

class PointsRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function getUserPoints(int $userId): int
    {
        $stmt = $this->pdo->prepare(
            "SELECT total_points FROM users WHERE id = ?"
        );
        $stmt->execute([$userId]);

        return (int) $stmt->fetchColumn();
    }

    public function updateUserPoints(int $userId, int $newTotal): void
    {
        $stmt = $this->pdo->prepare(
            "UPDATE users SET total_points = ? WHERE id = ?"
        );
        $stmt->execute([$newTotal, $userId]);
    }

    public function addTransaction(int $userId, int $points, string $description, int $balanceAfter): void {
        $stmt = $this->pdo->prepare(
            "INSERT INTO points_transactions
             (user_id, type, amount, description, balance_after)
             VALUES (?, 'earned', ?, ?, ?)"
        );
        $stmt->execute([$userId, $points, $description, $balanceAfter]);
    }

    public function addPoints(int $userId, int $points, string $description): int {
        return $this->changePoints($userId, $points,'earned', $description);
    }


    private function changePoints(int $userId, int $points, string $type, string $description): int {
        $current = $this->getUserPoints($userId);

        if ($type === 'redeemed' && $current < $points) {
         throw new Exception("Points insuffisants");
        }

        $newTotal = ($type === 'earned') ? $current + $points : $current - $points;

        $this->updateUserPoints($userId, $newTotal);

        $stmt = $this->pdo->prepare(
            "INSERT INTO points_transactions
            (user_id, type, amount, description, balance_after)
            VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $userId,
            $type,
            $points,
            $description,
            $newTotal
        ]);

    return $newTotal;
    }
    // public function redeemPoints(int $userId, int $points, string $description): int {
    //     return $this->changePoints($userId, $points, 'redeemed', $description);
    // }
   public function redeemPoints(int $userId, int $points, string $description): int
{
    $current = $this->getUserPoints($userId);
    if ($current < $points) {
        throw new \Exception('Points insuffisants');
    }

    $newTotal = $current - $points;
    $this->updateUserPoints($userId, $newTotal);

    $stmt = $this->pdo->prepare(
        "INSERT INTO points_transactions (user_id, type, amount, description, balance_after)
         VALUES (?, 'redeemed', ?, ?, ?)"
    );
    $stmt->execute([$userId, $points, $description, $newTotal]);

    return $newTotal;
}




}
