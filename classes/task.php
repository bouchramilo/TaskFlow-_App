<?php
class Task
{
    protected PDO $pdo;
    protected string $title;
    protected string $description;
    protected string $task_type;
    protected string $status;
    protected int $assigned_to;
    protected string $due_date;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function addTask(string $title, string $description, string $task_type, string $status, int $assigned_to, string $due_date)
    {
        try {
            $sql = "INSERT INTO Task (title, description, id_user_create, id_user_assignee, status, date_fin) 
                    VALUES (:title, :description, :id_user_create, :id_user_assignee, :status, :due_date)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':title' => $title,
                ':description' => $description,
                ':id_user_create' => $_SESSION['user_id'],
                ':id_user_assignee' => $assigned_to,
                ':status' => $status,
                ':due_date' => $due_date
            ]);

            // Vérifier le nombre de lignes affectées
            if ($stmt->rowCount() > 0) {
                return $this->pdo->lastInsertId();
            } else {
                // Afficher les informations d'erreur plus précises
                print_r($stmt->errorInfo()); // Affiche le tableau d'erreurs PDO
                return false; // Échec
            }
        } catch (PDOException $e) { // Type d'exception plus précis
            echo "Erreur d'insertion : " . $e->getMessage(); // Message d'erreur plus clair
            return false; // Échec
        }
    }

    public function showDetailsTask(int $id_task)
    {
        try {
            $sql = "SELECT 
                t.id_task,
                t.title,
                t.description,
                t.id_user_create,
                t.id_user_assignee,
                t.status,
                DATE_FORMAT(t.date_fin, '%d/%m/%Y') as date_fin,
                DATE_FORMAT(t.date_create, '%d/%m/%Y') as date_create,
                tf.priority,
                tb.gravite,
                concat(uc.first_name , ' ' , uc.last_name) AS creator_name,
                concat(ua.first_name , ' ' , ua.last_name) AS assignee_name
            FROM Task t
            LEFT JOIN Task_feature tf ON t.id_task = tf.id_task
            LEFT JOIN Task_bug tb ON t.id_task = tb.id_task
            LEFT JOIN User uc ON t.id_user_create = uc.id_user
            LEFT JOIN User ua ON t.id_user_assignee = ua.id_user
                WHERE t.id_task = :id_task";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':id_task' => $id_task]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            echo "Erreur de récupération : " . $e->getMessage();
            return false;
        }
    }


    public function getAllTasks()
    {
        try {
            $sql = "
            SELECT 
                t.id_task,
                t.title,
                t.description,
                t.id_user_create,
                t.id_user_assignee,
                t.status,
                DATE_FORMAT(t.date_fin, '%d/%m/%Y') as date_fin,
                DATE_FORMAT(t.date_create, '%d/%m/%Y') as date_create,
                tf.priority,
                tb.gravite,
                concat(uc.first_name , ' ' , uc.last_name) AS creator_name,
                concat(ua.first_name , ' ' , ua.last_name) AS assignee_name
            FROM Task t
            LEFT JOIN Task_feature tf ON t.id_task = tf.id_task
            LEFT JOIN Task_bug tb ON t.id_task = tb.id_task
            LEFT JOIN User uc ON t.id_user_create = uc.id_user
            LEFT JOIN User ua ON t.id_user_assignee = ua.id_user
        ";
            $stmt = $this->pdo->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            echo "Erreur de récupération : " . $e->getMessage();
            return false;
        }
    }

    public function deleteTask(int $id_task)
    {
        try {
            $sql = "DELETE FROM Task WHERE id_task = :id_task";
            $stmt = $this->pdo->prepare($sql);

            $stmt->execute(['id_task' => $id_task]);

            header('Location: home.php');
            exit;
        } catch (PDOException $e) {
            echo "Erreur de récupération deletedeletedeletedeletedelete : " . $e->getMessage();
        }
    }

    public function updateTask(int $id_task_update, string $title, string $description, string $task_type, string $status, int $assigned_to, string $due_date){
    try {
        $sql = "UPDATE Task 
                SET title = :title, 
                    description = :description, 
                    id_user_assignee = :id_user_assignee, 
                    status = :status, 
                    date_fin = :due_date 
                WHERE id_task = :id_task_update";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':id_user_assignee' => $assigned_to,
            ':status' => $status,
            ':due_date' => $due_date,
            ':id_task_update' => $id_task_update
        ]);

        if ($stmt->rowCount() > 0) {
            return true; // Succès
        } else {
            // Afficher une erreur si aucune ligne n'est affectée
            echo "Aucune mise à jour effectuée.";
            print_r($stmt->errorInfo());
            return false;
        }
    } catch (PDOException $e) {
        // Gestion des erreurs PDO
        echo "Erreur lors de la mise à jour : " . $e->getMessage();
        return false;
    }
}


}



?>





<!-- ++++++++++++++++++++++++++++++++++++ -->