<div id="formContainer" class="fixed inset-0 bg-white bg-opacity-50 flex justify-center items-center hidden">
        <section
            class="bg-[#1d1d1d] opacity-85 w-full h-screen mx-2 p-2 text-sm rounded-lg shadow-md flex justify-center items-center">
            <!-- Titre de la Tâche -->
            <div class="w-[95%] mt-0 max-w-xl mx-auto bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-2xl max-sm:text-lg font-semibold text-gray-800 mb-1">Ajouter une Tâche
                </h2>
                <!-- Formulaire pour ajouter une Tâche -->
                <form action="" method="post" class="space-y-2">
                    <!-- Titre -->
                    <div>
                        <label for="title" class="font-medium text-gray-700">Titre</label>
                        <input type="text" id="title" name="title" value=""
                            class=" block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="font-medium text-gray-700">Description</label>
                        <textarea id="description" name="description"
                            class=" block w-full px-4 py-2 resize-none h-16 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </textarea>
                    </div>

                    <!-- Type de Tâche -->
                    <div class="w-full flex flex-row max-sm:flex-col gap-2 ">
                        <div class="w-1/2 max-sm:w-full">
                            <label for="task_type" class="font-medium text-gray-700">Type de Tâche</label>
                            <select id="task_type" name="task_type"
                                class=" block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="simple" selected>Simple</option>
                                <option value="bug">Bug</option>
                                <option value="feature">Feature</option>
                            </select>
                        </div>
                        <!-- start partie cacher 'gravite' et 'priority'***********************************  -->
                        <div class="inputGravite w-1/2 max-sm:w-full hidden">
                            <label for="task_type" class="font-medium text-gray-700">Gravité : </label>
                            <select id="bug_gravite" name="gravite"
                                class=" block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="urgent" selected>Urgent</option>
                                <option value="moyen">Moyen</option>
                                <option value="nonUrgent">Non urgent</option>
                            </select>
                        </div>

                        <div class="inputPriority w-1/2 max-sm:w-full hidden">
                            <label for="task_type" class="font-medium text-gray-700">Priorité : </label>
                            <select id="feature_priority" name="priority"
                                class=" block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="elevee" selected>elevée</option>
                                <option value="moyenne">Moyenne</option>
                                <option value="faible">Faible</option>
                            </select>
                        </div>
                        <!-- end partie cacher 'gravite' et 'priority'***********************************  -->

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
                            <input type="date" id="due_date" name="due_date" value="2024-12-31"
                                class=" block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-6 flex space-x-4 flex justify-end">
                        <button name="add_task_btn"
                            class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition">Ajouter
                        </button>
                        <form action="home.php" method="post">
                            <button name="annulerAdd"
                                class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 transition">Annuler</button>
                        </form>
                    </div>
                </form>
            </div>
        </section>
    </div>