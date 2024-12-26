<?php
class Database {
    private $host = 'localhost';
    private $dbname = 'TaskFlow_DB';
    private $username = 'root';
    private $password = 'BouchraSamar_13';
    private $pdo;

    public function connect() {
        if ($this->pdo == null) {
            try {
                $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->dbname};charset=utf8", $this->username, $this->password);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erreur de connexion : " . $e->getMessage());
            }
        }
        return $this->pdo;
    }
}


session_start();

?>
