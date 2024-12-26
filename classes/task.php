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
            $sql = "SELECT * FROM Task WHERE id_task = :id_task";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id_task' => $id_task
            ]);
            $result = $stmt->fetch();
            return $result;
        } catch (PDOException $e) {
            echo "Erreur de récupération : " . $e->getMessage();
            return false;
        }
    }

    public function getAllTasks()
    {
        $sql = "SELECT * FROM Task";
        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}



?>





<!-- ++++++++++++++++++++++++++++++++++++ -->


<?php
// class Task
// {
//     protected PDO $pdo;
//     protected string $title;
//     protected string $description;
//     protected string $task_type;
//     protected string $status;
//     protected int $assigned_to;
//     protected string $due_date;

//     public function __construct(PDO $pdo){
//         $this->pdo = $pdo;
//     }

//     // Add a new task
//     public function addTask(string $title,string $description,string $task_type,string $status,int $assigned_to,string $due_date) {
//         try {
//             // Validate task type
//             // $allowedTypes = ['generic', 'feature', 'bug'];
//             // if (!in_array($task_type, $allowedTypes)) {
//             //     throw new Exception("Invalid task type: $task_type");
//             // }

//             // Insert into the `Task` table
//             $sql = "INSERT INTO Task (title, description, id_user_create, id_user_assignee, status, date_fin) 
//                     VALUES (:title, :description, :id_user_create, :id_user_assignee, :status, :due_date)";
//             $stmt = $this->pdo->prepare($sql);
//             $stmt->execute([
//                 ':title' => $title,
//                 ':description' => $description,
//                 ':id_user_create' => $_SESSION['user_id'],
//                 ':id_user_assignee' => $assigned_to,
//                 ':status' => $status,
//                 ':due_date' => $due_date
//             ]);

//             // Get the last inserted ID
//             // $taskId = $this->pdo->lastInsertId();

//             // Insert into the specific task type table
//             // if ($task_type === 'feature') {
//             //     $this->addFeatureTask($taskId);
//             // } elseif ($task_type === 'bug') {
//             //     $this->addBugTask($taskId);
//             // }

//             // return $taskId;
//         } catch (Exception $e) {
//             // throw new Exception("Failed to add task: " . $e->getMessage());
//             echo "errrreeeeuuuur";
//         }
//     }

//     // // Add a feature task
//     // private function addFeatureTask(int $taskId, string $priority = 'moyenne'){
//     //     $sql = "INSERT INTO Task_feature (id_task, priority) VALUES (:id_task, :priority)";
//     //     $stmt = $this->pdo->prepare($sql);
//     //     $stmt->execute([':id_task' => $taskId, ':priority' => $priority]);
//     // }

//     // // Add a bug task
//     // private function addBugTask(int $taskId, string $gravite = 'moyen'){
//     //     $sql = "INSERT INTO Task_bug (id_task, gravite) VALUES (:id_task, :gravite)";
//     //     $stmt = $this->pdo->prepare($sql);
//     //     $stmt->execute([':id_task' => $taskId, ':gravite' => $gravite]);
//     // }

//     // // Retrieve all tasks
//     // public function getAllTasks(){
//     //     $sql = "SELECT * FROM Task";
//     //     $stmt = $this->pdo->query($sql);
//     //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
//     // }
// }



?>