<?php

require_once 'classes/connect_DB.php';
require_once 'classes/User.php';
require_once 'classes/task.php';
require_once 'classes/task_bug.php';


$db = new Database();
$pdo = $db->connect();
$task = new Task($pdo);

$id_tache = $_SESSION['id_tache'];

$tache = $task->showDetailsTask($id_tache);





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>TaskFlow - Home</title>
</head>

<body class="w-full flex-col justify-center items-center pt-5 gap-2 ">



    <div id="formContainer" class="fixed inset-0 bg-white bg-opacity-50 flex justify-center items-center hidden">
        <section
            class="bg-[#1d1d1d] opacity-85 w-full h-screen mx-2 p-2 text-sm rounded-lg shadow-md flex justify-center items-center">
            <!-- Titre de la Tâche -->
            <div class="w-[95%] mt-0 max-w-xl mx-auto bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl max-sm:text-lg font-semibold text-gray-800 mb-1">Modifier les Détails de la Tâche
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
                                <option value="en_cours" selected>En Cours</option>
                                <option value="a_faire">À Faire</option>
                                <option value="termine">Terminé</option>
                            </select>
                        </div>
                    </div>

                    <!-- Assigné à -->
                    <div class="w-full flex flex-row max-sm:flex-col gap-2 ">
                        <div class="w-1/2 max-sm:w-full">
                            <label for="assigned_to" class="font-medium text-gray-700">Assigné à</label>
                            <input type="text" id="assigned_to" name="assigned_to" value="John Doe"
                                class=" block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                        <button type="submit"
                            class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition">Sauvegarder
                        </button>
                        <button type="button"
                            class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 transition">Annuler</button>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <a href="home.php"
        class="absolute top-1 left-1 inline-flex items-center text-blue-600 hover:text-blue-800 font-medium text-lg border-2 py-2 px-4 border-blue-500 rounded-lg">
        &#10092;&#10092;
    </a>


    <section class="w-[85%] mx-auto p-6 bg-gray-200 rounded-lg shadow-md">
        <!-- Titre de la Tâche -->
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Détails de la Tâche</h2>

        <!-- Détails de la Tâche -->
        <div class="space-y-4">
            <div>
                <h3 class="font-medium text-gray-700">Titre</h3>
                <p class="text-sm text-gray-600"><?php echo $tache["title"] ?></p>
            </div>

            <div>
                <h3 class="font-medium text-gray-700">Description</h3>
                <p class="text-sm text-gray-600">
                    <?php echo $tache["description"] ?>
                </p>
            </div>

            <div class="w-full flex flex-row max-sm:flex-col gap-2 ">
                <div class="w-1/2 max-sm:w-full">
                    <h3 class="font-medium text-gray-700">Type de Tâche</h3>
                    <p class="text-sm text-gray-600">
                        <span
                            class="inline-block py-1 px-3 text-sm font-semibold text-blue-800 bg-blue-200 rounded-full">Bug</span>
                    </p>
                </div>

                <div class="w-1/2 max-sm:w-full">
                    <h3 class="font-medium text-gray-700">Statut</h3>
                    <p class="text-sm text-gray-600">
                        <?php if ($tache["status"] === "A faire") : ?>
                            <span
                                class="inline-block py-1 px-3 text-sm font-semibold text-green-800 bg-green-200 rounded-full">
                                <?php echo $tache["status"] ?>
                            </span>
                        <?php elseif ($tache["status"] === "Fini") : ?>
                            <span
                                class="inline-block py-1 px-3 text-sm font-semibold text-orange-800 bg-orange-200 rounded-full">
                                <?php echo $tache["status"] ?>
                            </span>
                        <?php elseif ($tache["status"] === "En cours") : ?>
                            <span
                                class="inline-block py-1 px-3 text-sm font-semibold text-blue-800 bg-blue-200 rounded-full">
                                <?php echo $tache["status"] ?>
                            </span>
                        <?php endif; ?>

                    </p>
                </div>
            </div>
            <div class="w-full flex flex-row max-sm:flex-col gap-2 ">

                <div class="w-1/2 max-sm:w-full">
                    <h3 class="font-medium text-gray-700">Créée par</h3>
                    <p class="text-sm text-gray-600"><?php echo $tache["id_user_create"] ?></p>
                </div>

                <div class="w-1/2 max-sm:w-full">
                    <h3 class="font-medium text-gray-700">Assigné à</h3>
                    <p class="text-sm text-gray-600"><?php echo $tache["id_user_assignee"] ?></p>
                </div>
            </div>

            <div class="w-full flex flex-row max-sm:flex-col gap-2 ">
                <div class="w-1/2 max-sm:w-full">
                    <h3 class="font-medium text-gray-700">Date de Création</h3>
                    <p class="text-sm text-gray-600"><?php echo $tache["date_create"] ?></p>
                </div>

                <div class="w-1/2 max-sm:w-full">
                    <h3 class="font-medium text-gray-700">Date de Délai</h3>
                    <p class="text-sm text-gray-600"><?php echo $tache["date_fin"] ?></p>
                </div>

            </div>

        </div>

        <!-- Actions -->
        <div class="mt-6 flex space-x-4">
            <button id="showFormButton"
                class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition">Modifier</button>
            <button class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 transition">Supprimer</button>
        </div>
    </section>



</body>
<script src="js/ajouterForm.js"></script>

</html>