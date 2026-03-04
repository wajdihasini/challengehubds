<?php
class Database {

    private static $instance = null;
    private $pdo;

    private function __construct() {
        $host = "localhost";
        $user = "root";
        $pass = "";
        $dbname = "challengehub";

        try {
            // 1. Connexion sans spécifier la base de données
            $this->pdo = new PDO("mysql:host=$host;charset=utf8", $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // 2. Création de la base de données si elle n'existe pas
            $this->pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8 COLLATE utf8_general_ci");
            $this->pdo->exec("USE `$dbname` ");

            // 3. Vérifier si les tables existent (ex: table users)
            $query = $this->pdo->query("SHOW TABLES LIKE 'users'");
            if ($query->rowCount() == 0) {
                // Charger le script SQL
                $sqlFile = __DIR__ . '/../database.sql';
                if (file_exists($sqlFile)) {
                    $sql = file_get_contents($sqlFile);
                    $this->pdo->exec($sql);
                }
            }
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if(self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }
}