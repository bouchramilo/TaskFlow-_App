


<?php

require_once 'classes/task.php';

class TaskBug extends Task
{
    private $id_tache ;
    private $gravite;
    public function addBug(string $gravite, string $title, string $description, string $task_type, string $status, int $assigned_to, string $due_date)
    {
        try {

            $taskId = parent::addTask($title, $description, $task_type, $status, $assigned_to, $due_date);

            $sql = "INSERT INTO Task_bug (id_task, gravite) VALUES (:id_task, :gravite)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id_task' => $taskId,
                ':gravite' => $gravite
            ]);

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Erreur d'insertion Bug : " . $e->getMessage();
            return false;
        }
    }
    

    public function updateGravite(int $id_task, int $gravite)
    {
        try {

            $sql = "UPDATE Task_bug SET gravite = :gravite WHERE id_task = :id_task";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':gravite' => $gravite,
                ':id_task' => $id_task
            ]);

            return true;
        } catch (PDOException $e) {
            echo "Erreur de updating gravite bug : " . $e->getMessage();
            return false;
        }
    }

    public function deleteBug(int $id_task)
    {
        try {

            $sql = "DELETE FROM Task_bug WHERE id_task = :id_task";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id_task' => $id_task
            ]);

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Erreur de suppression Bug : " . $e->getMessage();
            return false;
        }
    }

    public function getIdTask(){
        return $this->id_tache ;
    }
    
    public function setIdTask($value){
        $this->id_tache = $value ;
    }

    public function getGravite(){
        return $this->gravite ;
    }
    
    public function setGravite($value){
        $this->gravite = $value ;
    }
}
?>