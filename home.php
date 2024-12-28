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


include "addTask.php";

?>

<?php

$utilisateur = new User($pdo);

// logout ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    $user = $utilisateur->logout();
}


// id show tache +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_tache_afficher'])) {
    $_SESSION['id_tache'] = htmlspecialchars(trim($_POST['id_tache']));
    $_SESSION['type_tache'] = htmlspecialchars(trim($_POST['type_tache']));

    echo $_SESSION['id_tache'];

    header('Location: details_task.php');
}
?>

<?php
// Afficher tous les utilisateurs +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$users = $utilisateur->getAllUsers();
?>

<?php
// Afficher tous les tâches +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$tasks = $task->getAllTasks();
?>


<!-- code html +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>TaskFlow - Home</title>
</head>

<body class="w-full flex flex-col gap-2 justify-center items-center pt-0 ">

    <!-- form add task +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
    <?php include "addForm.php"; ?>
    <!-- form add task +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

    <section class="w-full h-max flex flex-row justify-end max-sm:flex-col gap-2 px-6 mt-0 py-2 bg-[#77b7ec]">

        <div class="w-full flex justify-start ">
            <h1 class="text-3xl font-bold text-center text-blue-600">TaskFlow</h1>
        </div>
        <div class="w-full flex justify-end gap-2 ">
            <div class="w-max bg-green-500 text-white font-medium py-2 px-4 rounded-full hover:bg-green-600 transition">
                <p><?php echo $utilisateur->getUserById($_SESSION["user_id"]); ?></p>
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

    <!-- Les taches ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

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
                                <input type="hidden" name="type_tache" value="Feature">
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
                                <input type="hidden" name="type_tache" value="Bug">
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
                                <input type="hidden" name="type_tache" value="Tâche générale">
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
                                <input type="hidden" name="type_tache" value="Feature">
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
                                <input type="hidden" name="type_tache" value="Bug">
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
                                <input type="hidden" name="type_tache" value="Tâche générale">
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

            <?php foreach ($tasks as $task): ?>
                <?php if ($task['status'] === "Fini"): ?>

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
                                <input type="hidden" name="type_tache" value="Feature">
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
                                <input type="hidden" name="type_tache" value="Bug">
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
                                <input type="hidden" name="type_tache" value="Tâche générale">
                                <button name="id_tache_afficher" class="text-xs w-1/3 rounded-md bg-blue-300">Plus d'infos</button>
                            </form>
                        </div>

                    <?php endif; ?>

                <?php endif; ?>
            <?php endforeach; ?>

        </div>

    </section>

</body>
<script src="js/ajouterForm.js"></script>
<script src="js/type_task.js"></script>

</html>