<?php

class User
{
    private $pdo;
    private $first_name;
    private $last_name;

    // Constructeur pour initialiser la connexion à la base de données
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Valider les entrées utilisateur
    public function validateInput($first_name, $last_name)
    {
        if (empty($first_name) || empty($last_name)) {
            return "Erreur : Les champs prénom et nom ne peuvent pas être vides.";
        }

        if (!preg_match('/^[a-zA-Z\s]+$/', $first_name) || !preg_match('/^[a-zA-Z\s]+$/', $last_name)) {
            return "Erreur : Les champs prénom et nom ne doivent contenir que des lettres.";
        }

        return true;
    }

    // Ajouter ou se connecter avec un utilisateur existant
    public function loginOrCreateUser($first_name, $last_name)
    {
        $validationResult = $this->validateInput($first_name, $last_name);
        if ($validationResult !== true) {
            return $validationResult;
        }

        $sql = "SELECT * FROM user WHERE first_name = :first_name AND last_name = :last_name";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'first_name' => $first_name,
            'last_name' => $last_name
        ]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION["user_id"] = $user['id_user'];
            $_SESSION["username"] = $user['first_name'] . " " . $user['last_name'];
            header('Location: home.php');
            exit;
        } else {
            $sql = "INSERT INTO user (first_name, last_name) VALUES (:first_name, :last_name)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'first_name' => $first_name,
                'last_name' => $last_name
            ]);
            $newUserId = $this->pdo->lastInsertId();

            $_SESSION["user_id"] = $newUserId;
            $_SESSION["username"] = $first_name . " " . $last_name;
            header('Location: home.php');
            exit;
        }
    }

    public function logout(){
        unset($_SESSION["user_id"]);
        unset($_SESSION["username"]);
        header('Location: index.php');
    }


    // Lire tous les utilisateurs de la base de données
    public function getAllUsers()
    {
        $sql = "SELECT * FROM user";
        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Supprimer un utilisateur par son ID
    public function deleteUser($id_user)
    {
        $sql = "DELETE FROM user WHERE id_user = :id_user";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute(['id_user' => $id_user]);

        return "Utilisateur avec ID $id_user supprimé avec succès.";
    }
}
