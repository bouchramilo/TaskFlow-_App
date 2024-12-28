<?php

require_once 'classes/connect_DB.php';
require_once 'classes/User.php';
require_once 'classes/task.php';
require_once 'classes/task_bug.php';
require_once 'classes/task_feature.php';


$db = new Database('localhost', 'TaskFlow_DB', 'root', 'BouchraSamar_13');
$pdo = $db->getPDO();
$task = new Task($pdo);
$utilisateur = new User($pdo);
?>


<?php
// add task +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_task_btn'])) {
    $title = htmlspecialchars(trim($_POST['title']));
    $description = htmlspecialchars(trim($_POST['description']));
    $task_type = htmlspecialchars(trim($_POST['task_type']));
    $status = htmlspecialchars(trim($_POST['status']));
    $assigned_to = intval(htmlspecialchars(trim($_POST['assigned_to'])));
    $due_date = htmlspecialchars(trim($_POST['due_date']));

    
    // if ($taskId !== false) {
        if ($task_type === "bug") {
            $taskBug = new TaskBug($pdo, $title, $description, $task_type, $status, $assigned_to, $due_date);
            $gravite = htmlspecialchars(trim($_POST['gravite']));
            if ($taskBug->addBug($gravite, $title, $description, $task_type, $status, $assigned_to, $due_date)) {
                // echo "Bug ajouté avec succès !";
            } else {
                echo "Erreur lors de l'ajout du bug.";
            }
        } elseif ($task_type === "feature") {
            $taskFeature = new TaskFeature($pdo);
            $priority = htmlspecialchars(trim($_POST['priority']));
            if ($taskFeature->addFeature($priority, $title, $description, $task_type, $status, $assigned_to, $due_date)) {
                // echo "Feature ajoutée avec succès !";
            } else {
                echo "Erreur lors de l'ajout de la feature.";
            }
        } else {
            $taskId = $task->addTask($title, $description, $task_type, $status, $assigned_to, $due_date);
            // echo "task ajouter avec succes";
        }
    // } else {
    //     echo "Erreur lors de l'ajout de la tâche.";
    // }
}

?>
