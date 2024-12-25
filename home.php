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
                            class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition">Ajouter
                        </button>
                        <button type="button"
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
                <p>nom prenom</p>
            </div>
            <!-- Logout Form -->
            <form action="" method="post" class="w-max flex items-center">
                <input type="hidden" name="id_user">
                <button class="bg-red-500 text-white font-medium py-2 px-4 rounded hover:bg-red-600 transition">
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


    <section class="w-[95%] h-max flex flex-row max-sm:flex-col gap-2 ">

        <!-- en attente -->
        <div class="w-1/3 h-max max-sm:w-full bg-gray-200 border-none rounded-xl p-2">
            <h2 class="text-xl font-semibold text-gray-700 mb-4 pl-4">En attente</h2>

            <div class="task text-sm bg-blue-100 border-l-4 border-blue-500 rounded-md p-4 mb-4">
                <h3 class="text-blue-500 font-semibold">Tâche Générale</h3>
                <p>Écrire la documentation de l'application</p>
                <span class="text-gray-500 text-sm">En attente</span>
                <p class="text-sm text-gray-500">Assignée à : <span class="font-bold">Alice</span></p>
            </div>

            <div class="task text-sm bg-red-100 border-l-4 border-red-500 rounded-md p-4 mb-4">
                <h3 class="text-red-600 font-semibold">Bug</h3>
                <p>Corriger le bug d'affichage sur mobile</p>
                <span class="text-red-600 text-sm">Priorité : Urgent</span>
                <p class="text-sm text-gray-500">Assignée à : <span class="font-bold">Alice</span></p>
            </div>

        </div>

        <!-- En cours -->
        <div class="w-1/3 h-max max-sm:w-full bg-gray-200 border-none rounded-xl p-2">
            <h2 class="text-xl font-semibold text-gray-700 mb-4 pl-4">En cours</h2>

            <div class="task text-sm bg-green-100 border-l-4 border-green-500 rounded-md p-4 mb-4">
                <h3 class="text-green-600 font-semibold">Feature</h3>
                <p>Ajouter un tableau Kanban pour gérer les tâches</p>
                <span class="text-gray-500 text-sm">En cours</span>
                <p class="text-sm text-gray-500">Assignée à : <span class="font-bold">Alice</span></p>
            </div>

        </div>

        <!-- Terminé -->
        <div class="w-1/3 h-max max-sm:w-full bg-gray-200 border-none rounded-xl p-2">
            <h2 class="text-xl font-semibold text-gray-700 mb-4 pl-4">Terminé</h2>

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

        </div>

    </section>

</body>
<script src="js/ajouterForm.js"></script>

</html>