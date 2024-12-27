<?php

require_once 'classes/connect_DB.php';
require_once 'classes/User.php';
require_once 'classes/task.php';
require_once 'classes/task_bug.php';


$db = new Database();
$pdo = $db->connect();
$task = new Task($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_task_btn'])) {
    $title = htmlspecialchars(trim($_POST['title']));
    $description = htmlspecialchars(trim($_POST['description']));
    $task_type = htmlspecialchars(trim($_POST['task_type']));
    $status = htmlspecialchars(trim($_POST['status']));
    $assigned_to = intval(htmlspecialchars(trim($_POST['assigned_to'])));
    $due_date = htmlspecialchars(trim($_POST['due_date']));


    $taskId = $task->addTask($title, $description, $task_type, $status, $assigned_to, $due_date);

    if ($taskId !== false) { // Vérification que l'insertion de la tâche principale a réussi
        if ($task_type === "bug") {
            $taskBug = new TaskBug($pdo);
            if ($taskBug->addBug($taskId, "urgent")) { // $gravite doit être récupérée du formulaire
                echo "Bug ajouté avec succès !";
            } else {
                echo "Erreur lors de l'ajout du bug.";
            }
        } elseif ($task_type === "feature") {
            $taskFeature = new TaskFeature($pdo);
            if ($taskFeature->addFeature($taskId, "moyenne")) { // $priority doit être récupérée du formulaire
                echo "Feature ajoutée avec succès !";
            } else {
                echo "Erreur lors de l'ajout de la feature.";
            }
        } else {
            echo "task ajouter avec succes";
        }
    } else {
        echo "Erreur lors de l'ajout de la tâche.";
    }
}

?>

<?php

$userManager = new User($pdo);

// récupération de données du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    $user = $userManager->logout();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['annulerAdd'])) {
    header('Location : home.php');
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_tache_afficher'])) {
    $_SESSION['id_tache'] = htmlspecialchars(trim($_POST['id_tache']));
    echo $_SESSION['id_tache'];
    header('Location: details_task.php');
}



?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>TaskFlow - Home</title>
</head>

<body class="w-full flex flex-col gap-2 justify-center items-center pt-4 ">

    <!-- form add task -->
    <div id="formContainer" class="fixed inset-0 bg-white bg-opacity-50 flex justify-center items-center hidden">
        <section
            class="bg-[#1d1d1d] opacity-85 w-full h-screen mx-2 p-2 text-sm rounded-lg shadow-md flex justify-center items-center">
            <!-- Titre de la Tâche -->
            <div class="w-[95%] mt-0 max-w-xl mx-auto bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl max-sm:text-lg font-semibold text-gray-800 mb-1">Ajouter une Tâche
                </h2>
                <!-- Formulaire pour Modifier les Détails de la Tâche -->
                <form action="" method="post" class="space-y-2">
                    <!-- Titre -->
                    <div>
                        <label for="title" class="font-medium text-gray-700">Titre</label>
                        <input type="text" id="title" name="title" value="Corriger le bug d'affichage"
                            class=" block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="font-medium text-gray-700">Description</label>
                        <textarea id="description" name="description" rows="4"
                            class=" block w-full px-4 py-2 resize-none h-16 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Il y a un problème d'affichage sur la page d'accueil, il faut ajuster le CSS et tester les rendus.
                        </textarea>
                    </div>

                    <!-- Type de Tâche -->
                    <div class="w-full flex flex-row max-sm:flex-col gap-2 ">
                        <div class="w-1/2 max-sm:w-full">
                            <label for="task_type" class="font-medium text-gray-700">Type de Tâche</label>
                            <select id="task_type" name="task_type"
                                class=" block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="bug" selected>Bug</option>
                                <option value="feature">Feature</option>
                                <option value="simple">Simple</option>
                            </select>
                        </div>

                        <!-- Statut -->
                        <div class="w-1/2 max-sm:w-full">
                            <label for="status" class="font-medium text-gray-700">Statut</label>
                            <select id="status" name="status"
                                class=" block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="En cours" selected>En Cours</option>
                                <option value="A faire">À Faire</option>
                                <option value="Fini">Terminé</option>
                            </select>
                        </div>
                    </div>

                    <?php
                    // Afficher tous les utilisateurs
                    $users = $userManager->getAllUsers();
                    ?>
                    <!-- Assigné à -->
                    <div class="w-full flex flex-row max-sm:flex-col gap-2 ">
                        <div class="w-1/2 max-sm:w-full">
                            <label for="assigned_to" class="font-medium text-gray-700">Assigné à</label>
                            <select id="status" name="assigned_to"
                                class=" block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= $user['id_user'] ?>" selected><?= $user['last_name'] . ' ' . $user['first_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <!-- Date de Délai -->
                        <div class="w-1/2 max-sm:w-full">
                            <label for="due_date" class="font-medium text-gray-700">Date de Délai</label>
                            <input type="date" id="due_date" name="due_date" value="2024-12-20"
                                class=" block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-6 flex space-x-4 flex justify-end">
                        <button name="add_task_btn"
                            class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition">Ajouter
                        </button>
                        <button type="button" name="annulerAdd"
                            class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 transition">Annuler</button>
                    </div>
                </form>
            </div>
        </section>
    </div>


    <!-- Les taches -->

    <section class="w-[95%] h-max flex flex-row justify-end max-sm:flex-col gap-2 py-2">

        <div class="w-full flex justify-start ">
            <h1 class="text-3xl font-bold text-center text-blue-600">TaskFlow</h1>
        </div>
        <div class="w-full flex justify-end gap-2 ">
            <div class="w-max bg-green-500 text-white font-medium py-2 px-4 rounded-full hover:bg-green-600 transition">
                <p><?php echo $_SESSION["username"] ?></p>
            </div>
            <!-- Logout Form -->
            <form action="" method="post" class="w-max flex items-center">
                <input type="hidden" name="id_user">
                <button name="logout" class="bg-red-500 text-white font-medium py-2 px-4 rounded hover:bg-red-600 transition">
                    Logout
                </button>
            </form>
        </div>
    </section>

    <section class="w-[95%] h-max flex flex-row justify-end max-sm:flex-col gap-2 py-2">
        <!-- Button Ajouter -->
        <button id="showFormButton"
            class="bg-blue-500 text-white font-medium py-2 px-4 rounded hover:bg-blue-600 transition">
            + Ajouter
        </button>
    </section>

    <?php
    // Afficher tous les utilisateurs
    $tasks = $task->getAllTasks();
    ?>
    <section class="w-[95%] h-max flex flex-row max-sm:flex-col gap-2 ">

        <!-- en attente -->
        <div class="w-1/3 h-max max-sm:w-full bg-gray-200 border-none rounded-xl p-2">
            <h2 class="text-xl font-semibold text-gray-700 mb-4 pl-4">En attente</h2>
            <?php foreach ($tasks as $task): ?>
                <?php if ($task['status'] === "A faire"): ?>

                    <?php if (!empty($task['priority']) && in_array($task['priority'], ['faible', 'moyenne', 'elevee'])): ?>

                        <div class="task text-sm bg-green-100 border-l-4 border-green-500 rounded-md p-4 mb-4">
                            <h3 class="text-green-600 font-semibold">Feature</h3>
                            <p><?= htmlspecialchars($task['title'], ENT_QUOTES) ?></p>
                            <span class="text-gray-500 text-sm">Priorité : <?= $task['priority'] ?></span>
                            <p class="text-sm text-gray-500">Créer par : <span class="font-bold"><?= htmlspecialchars($task['creator_name'], ENT_QUOTES) ?></span></p>
                            <p class="text-sm text-gray-500">Assignée à : <span class="font-bold"><?= htmlspecialchars($task['assignee_name'], ENT_QUOTES) ?></span></p>
                            <span class="text-gray-500 text-sm">Date délai : <?= $task['date_fin'] ?? 'Non spécifiée' ?></span>
                            <form action="" method="post" class="w-full h-6 flex justify-end">
                                <input type="hidden" name="id_tache" value="<?= htmlspecialchars($task['id_task'], ENT_QUOTES) ?>">
                                <button name="id_tache_afficher" class="text-xs w-1/3 rounded-md bg-blue-300">Plus d'infos</button>
                            </form>
                        </div>

                    <?php elseif (!empty($task['gravite']) && in_array($task['gravite'], ['nonUrgent', 'moyen', 'urgent'])): ?>

                        <div class="task text-sm bg-red-100 border-l-4 border-red-500 rounded-md p-4 mb-4">
                            <h3 class="text-red-600 font-semibold">Bug</h3>
                            <p><?= htmlspecialchars($task['title'], ENT_QUOTES) ?></p>
                            <span class="text-red-600 text-sm">Gravité : <?= $task['gravite'] ?></span>
                            <p class="text-sm text-gray-500">Créer par : <span class="font-bold"><?= htmlspecialchars($task['creator_name'], ENT_QUOTES) ?></span></p>
                            <p class="text-sm text-gray-500">Assignée à : <span class="font-bold"><?= htmlspecialchars($task['assignee_name'], ENT_QUOTES) ?></span></p>
                            <span class="text-gray-500 text-sm">Date délai : <?= $task['date_fin'] ?? 'Non spécifiée' ?></span>
                            <form action="" method="post" class="w-full h-6 flex justify-end">
                                <input type="hidden" name="id_tache" value="<?= htmlspecialchars($task['id_task'], ENT_QUOTES) ?>">
                                <button name="id_tache_afficher" class="text-xs w-1/3 rounded-md bg-blue-300">Plus d'infos</button>
                            </form>
                        </div>

                    <?php else: ?>

                        <div class="task text-sm bg-blue-100 border-l-4 border-blue-500 rounded-md p-4 mb-4">
                            <h3 class="text-blue-500 font-semibold">Tâche Générale</h3>
                            <p><?= htmlspecialchars($task['title'], ENT_QUOTES) ?></p>
                            <span class="text-gray-500 text-sm"><?= $task['date_fin'] ?? 'Non spécifiée' ?></span>
                            <p class="text-sm text-gray-500">Créer par : <span class="font-bold"><?= htmlspecialchars($task['creator_name'], ENT_QUOTES) ?></span></p>
                            <p class="text-sm text-gray-500">Assignée à : <span class="font-bold"><?= htmlspecialchars($task['assignee_name'], ENT_QUOTES) ?></span></p>
                            <span class="text-gray-500 text-sm">Date délai : <?= $task['date_fin'] ?? 'Non spécifiée' ?></span>
                            <form action="" method="post" class="w-full h-6 flex justify-end">
                                <input type="hidden" name="id_tache" value="<?= htmlspecialchars($task['id_task'], ENT_QUOTES) ?>">
                                <button name="id_tache_afficher" class="text-xs w-1/3 rounded-md bg-blue-300">Plus d'infos</button>
                            </form>
                        </div>

                    <?php endif; ?>

                <?php endif; ?>
            <?php endforeach; ?>

        </div>

        <!-- En cours -->
        <div class="w-1/3 h-max max-sm:w-full bg-gray-200 border-none rounded-xl p-2">
            <h2 class="text-xl font-semibold text-gray-700 mb-4 pl-4">En cours</h2>
            <!-- <pre><?php print_r($tasks); ?></pre> -->
            <?php foreach ($tasks as $task): ?>
                <?php if ($task['status'] === "En cours"): ?>

                    <?php if (!empty($task['priority']) && in_array($task['priority'], ['faible', 'moyenne', 'elevee'])): ?>

                        <div class="task text-sm bg-green-100 border-l-4 border-green-500 rounded-md p-4 mb-4">
                            <h3 class="text-green-600 font-semibold">Feature</h3>
                            <p><?= htmlspecialchars($task['title'], ENT_QUOTES) ?></p>
                            <span class="text-gray-500 text-sm">Priorité : <?= $task['priority'] ?></span>
                            <p class="text-sm text-gray-500">Créer par : <span class="font-bold"><?= htmlspecialchars($task['creator_name'], ENT_QUOTES) ?></span></p>
                            <p class="text-sm text-gray-500">Assignée à : <span class="font-bold"><?= htmlspecialchars($task['assignee_name'], ENT_QUOTES) ?></span></p>
                            <span class="text-gray-500 text-sm">Date délai : <?= $task['date_fin'] ?? 'Non spécifiée' ?></span>
                            <form action="" method="post" class="w-full h-6 flex justify-end">
                                <input type="hidden" name="id_tache" value="<?= htmlspecialchars($task['id_task'], ENT_QUOTES) ?>">
                                <button name="id_tache_afficher" class="text-xs w-1/3 rounded-md bg-blue-300">Plus d'infos</button>
                            </form>
                        </div>

                    <?php elseif (!empty($task['gravite']) && in_array($task['gravite'], ['nonUrgent', 'moyen', 'urgent'])): ?>

                        <div class="task text-sm bg-red-100 border-l-4 border-red-500 rounded-md p-4 mb-4">
                            <h3 class="text-red-600 font-semibold">Bug</h3>
                            <p><?= htmlspecialchars($task['title'], ENT_QUOTES) ?></p>
                            <span class="text-red-600 text-sm">Gravité : <?= $task['gravite'] ?></span>
                            <p class="text-sm text-gray-500">Créer par : <span class="font-bold"><?= htmlspecialchars($task['creator_name'], ENT_QUOTES) ?></span></p>
                            <p class="text-sm text-gray-500">Assignée à : <span class="font-bold"><?= htmlspecialchars($task['assignee_name'], ENT_QUOTES) ?></span></p>
                            <span class="text-gray-500 text-sm">Date délai : <?= $task['date_fin'] ?? 'Non spécifiée' ?></span>
                            <form action="" method="post" class="w-full h-6 flex justify-end">
                                <input type="hidden" name="id_tache" value="<?= htmlspecialchars($task['id_task'], ENT_QUOTES) ?>">
                                <button name="id_tache_afficher" class="text-xs w-1/3 rounded-md bg-blue-300">Plus d'infos</button>
                            </form>
                        </div>

                    <?php else: ?>

                        <div class="task text-sm bg-blue-100 border-l-4 border-blue-500 rounded-md p-4 mb-4">
                            <h3 class="text-blue-500 font-semibold">Tâche Générale</h3>
                            <p><?= htmlspecialchars($task['title'], ENT_QUOTES) ?></p>
                            <span class="text-gray-500 text-sm"><?= $task['date_fin'] ?? 'Non spécifiée' ?></span>
                            <p class="text-sm text-gray-500">Créer par : <span class="font-bold"><?= htmlspecialchars($task['creator_name'], ENT_QUOTES) ?></span></p>
                            <p class="text-sm text-gray-500">Assignée à : <span class="font-bold"><?= htmlspecialchars($task['assignee_name'], ENT_QUOTES) ?></span></p>
                            <span class="text-gray-500 text-sm">Date délai : <?= $task['date_fin'] ?? 'Non spécifiée' ?></span>
                            <form action="" method="post" class="w-full h-6 flex justify-end">
                                <input type="hidden" name="id_tache" value="<?= htmlspecialchars($task['id_task'], ENT_QUOTES) ?>">
                                <button name="id_tache_afficher" class="text-xs w-1/3 rounded-md bg-blue-300">Plus d'infos</button>
                            </form>
                        </div>

                    <?php endif; ?>

                <?php endif; ?>
            <?php endforeach; ?>


        </div>



        <!-- Terminé -->
        <div class="w-1/3 h-max max-sm:w-full bg-gray-200 border-none rounded-xl p-2">
            <h2 class="text-xl font-semibold text-gray-700 mb-4 pl-4">Terminé</h2>

            <?php foreach ($tasks as $tache): ?>
                <?php if ($tache['status'] == "Fini"): ?>
                    <?php if (!empty($task['priority']) && in_array($task['priority'], ['faible', 'moyenne', 'elevee'])): ?>

                        <div class="task text-sm bg-green-100 border-l-4 border-green-500 rounded-md p-4 mb-4">
                            <h3 class="text-green-600 font-semibold">Feature</h3>
                            <p><?= htmlspecialchars($task['title'], ENT_QUOTES) ?></p>
                            <span class="text-gray-500 text-sm">Priorité : <?= $task['priority'] ?></span>
                            <p class="text-sm text-gray-500">Créer par : <span class="font-bold"><?= htmlspecialchars($task['creator_name'], ENT_QUOTES) ?></span></p>
                            <p class="text-sm text-gray-500">Assignée à : <span class="font-bold"><?= htmlspecialchars($task['assignee_name'], ENT_QUOTES) ?></span></p>
                            <span class="text-gray-500 text-sm">Date délai : <?= $task['date_fin'] ?? 'Non spécifiée' ?></span>
                            <form action="" method="post" class="w-full h-6 flex justify-end">
                                <input type="hidden" name="id_tache" value="<?= htmlspecialchars($task['id_task'], ENT_QUOTES) ?>">
                                <button name="id_tache_afficher" class="text-xs w-1/3 rounded-md bg-blue-300">Plus d'infos</button>
                            </form>
                        </div>

                    <?php elseif (!empty($task['gravite']) && in_array($task['gravite'], ['nonUrgent', 'moyen', 'urgent'])): ?>

                        <div class="task text-sm bg-red-100 border-l-4 border-red-500 rounded-md p-4 mb-4">
                            <h3 class="text-red-600 font-semibold">Bug</h3>
                            <p><?= htmlspecialchars($task['title'], ENT_QUOTES) ?></p>
                            <span class="text-red-600 text-sm">Gravité : <?= $task['gravite'] ?></span>
                            <p class="text-sm text-gray-500">Créer par : <span class="font-bold"><?= htmlspecialchars($task['creator_name'], ENT_QUOTES) ?></span></p>
                            <p class="text-sm text-gray-500">Assignée à : <span class="font-bold"><?= htmlspecialchars($task['assignee_name'], ENT_QUOTES) ?></span></p>
                            <span class="text-gray-500 text-sm">Date délai : <?= $task['date_fin'] ?? 'Non spécifiée' ?></span>
                            <form action="" method="post" class="w-full h-6 flex justify-end">
                                <input type="hidden" name="id_tache" value="<?= htmlspecialchars($task['id_task'], ENT_QUOTES) ?>">
                                <button name="id_tache_afficher" class="text-xs w-1/3 rounded-md bg-blue-300">Plus d'infos</button>
                            </form>
                        </div>

                    <?php else: ?>

                        <div class="task text-sm bg-blue-100 border-l-4 border-blue-500 rounded-md p-4 mb-4">
                            <h3 class="text-blue-500 font-semibold">Tâche Générale</h3>
                            <p><?= htmlspecialchars($task['title'], ENT_QUOTES) ?></p>
                            <span class="text-gray-500 text-sm"><?= $task['date_fin'] ?? 'Non spécifiée' ?></span>
                            <p class="text-sm text-gray-500">Créer par : <span class="font-bold"><?= htmlspecialchars($task['creator_name'], ENT_QUOTES) ?></span></p>
                            <p class="text-sm text-gray-500">Assignée à : <span class="font-bold"><?= htmlspecialchars($task['assignee_name'], ENT_QUOTES) ?></span></p>
                            <span class="text-gray-500 text-sm">Date délai : <?= $task['date_fin'] ?? 'Non spécifiée' ?></span>
                            <form action="" method="post" class="w-full h-6 flex justify-end">
                                <input type="hidden" name="id_tache" value="<?= htmlspecialchars($task['id_task'], ENT_QUOTES) ?>">
                                <button name="id_tache_afficher" class="text-xs w-1/3 rounded-md bg-blue-300">Plus d'infos</button>
                            </form>
                        </div>

                    <?php endif; ?>

                <?php endif; ?>
            <?php endforeach; ?>


            <div class="task text-sm bg-green-100 border-l-4 border-green-500 rounded-md p-4 mb-4">
                <h3 class="text-green-600 font-semibold">Feature</h3>
                <p>Ajouter un tableau Kanban pour gérer les tâches</p>
                <span class="text-gray-500 text-sm">Terminé</span>
                <p class="text-sm text-gray-500">Assignée à : <span class="font-bold">Alice</span></p>
            </div>

            <div class="task text-sm bg-blue-100 border-l-4 border-blue-500 rounded-md p-4 mb-4">
                <h3 class="text-blue-500 font-semibold">Tâche Générale</h3>
                <p>Mettre à jour le logo de l'application</p>
                <span class="text-gray-500 text-sm">Terminé</span>
                <p class="text-sm text-gray-500">Assignée à : <span class="font-bold">Alice</span></p>
            </div>

            <div class="task text-sm bg-red-100 border-l-4 border-red-500 rounded-md p-4 mb-4">
                <h3 class="text-red-600 font-semibold">Bug</h3>
                <p>Corriger le bug d'affichage sur mobile</p>
                <span class="text-red-600 text-sm">Priorité : Urgent</span>
                <p class="text-sm text-gray-500">Assignée à : <span class="font-bold">Alice</span></p>
            </div>
        </div>

    </section>

</body>
<script src="js/ajouterForm.js"></script>

</html>