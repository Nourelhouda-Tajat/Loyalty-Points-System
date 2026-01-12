<?php
class Database
{
    private static $connection = null;

    public static function getConnection()
    {
        if (self::$connection === null) {
            $host = 'localhost';
            $dbname = 'photosphere';
            $username = 'root';
            $password = ''; 

            try {
                self::$connection = new PDO("mysql:host=$host;port=3307;dbname=$dbname;", $username, $password);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "it's not working!!!!";
                die("Erreur connexion : " . $e->getMessage());
            }
        }

        return self::$connection;
    }
}

// $pdo = Database::getConnection();
// echo "Connecté à la base de données !<br>";


// $result = $pdo->query("SELECT 'Hello' as test");
// $data = $result->fetch();
// echo $data['test'];