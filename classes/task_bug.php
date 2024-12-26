<?php
class TaskFeature extends Task
{
    public function addFeature(int $taskId, string $priority)
    {
        try {
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
}
?>





<?php

class TaskBug extends Task
{
    public function addBug(int $taskId, string $gravite)
    {
        try {
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
}
?>