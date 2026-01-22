<?php
namespace App\Repositories;

use Config\Database;
use PDO;

class RewardRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM rewards");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM rewards WHERE id = ?");
        $stmt->execute([$id]);
        $reward = $stmt->fetch(PDO::FETCH_ASSOC);

        return $reward ?: null;
    }
    public function decreaseStock(int $rewardId): void
{
    $stmt = $this->pdo->prepare(
        "UPDATE rewards SET stock = stock - 1 WHERE id = ? AND stock > 0"
    );
    $stmt->execute([$rewardId]);
}

}
