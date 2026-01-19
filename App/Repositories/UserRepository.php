<?php
namespace App\Repositories;

use App\Models\User;
use PDO;
use Config\Database;

class UserRepository {
    private $pdo;

    public function __construct(){
        $this->pdo = Database::getConnection();
    }

    public function save(User $user){
        $stml = $this->pdo->prepare("INSERT INTO users (email, password_hash, name) values (?, ?, ?)");
        return $stml->execute([ $user->getEmail(), $user->getPasswordHash(), $user->getName()]);
    }

    public function findByEmail($email){
        $stml = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stml->execute([$email]);
        $result = $stml->fetch(PDO::FETCH_ASSOC);
        if(!$result){
            return null;
        }
        return new User($result['email'], $result['password_hash'], $result['name'], $result['id'], $result['total_points']);
    }
}