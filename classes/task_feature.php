
<?php

require_once 'classes/task.php';

class TaskFeature extends Task
{
    private $id_tache ;
    private $priority;
    public function addFeature(string $priority, string $title, string $description, string $task_type, string $status, int $assigned_to, string $due_date)
    {
        try {

            $taskId = parent::addTask($title, $description, $task_type, $status, $assigned_to, $due_date);

            $sql = "INSERT INTO Task_feature (id_task, priority) VALUES (:id_task, :priority)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id_task' => $taskId,
                ':priority' => $priority
            ]);

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Erreur d'insertion Feature : " . $e->getMessage();
            return false;
        }
    }
    


    public function updatePriority(int $id_task, int $priority)
    {
        try {

            $sql = "UPDATE Task_feature SET priority = :priority WHERE id_task = :id_task";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':priority' => $priority,
                ':id_task' => $id_task
            ]);

            return true;
        } catch (PDOException $e) {
            echo "Erreur de updating priority feature : " . $e->getMessage();
            return false;
        }
    }

    public function deleteFeature(int $id_task)
    {
        try {

            $sql = "DELETE FROM Task_feature WHERE id_task = :id_task";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':id_task' => $id_task
            ]);

            return true;
        } catch (PDOException $e) {
            echo "Erreur de suppression feature : " . $e->getMessage();
            return false;
        }
    }

    public function getIdTask(){
        return $this->id_tache ;
    }
    
    public function setIdTask($value){
        $this->id_tache = $value ;
    }

    public function getPriority(){
        return $this->priority ;
    }
    
    public function setPriority($value){
        $this->priority = $value ;
    }
}
?>


