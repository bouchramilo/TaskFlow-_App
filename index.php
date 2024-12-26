<?php
require_once 'classes/connect_DB.php';
require_once 'classes/User.php';

$db = new Database();
$pdo = $db->connect();

$userManager = new User($pdo);

// récupération de données du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['first_name'], $_POST['last_name'])) {
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));

    // if ($userManager->validateInput($first_name, $last_name)) {
    $user = $userManager->loginOrCreateUser($first_name, $last_name);
    // }
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $id_user_delete = htmlspecialchars(trim($_POST['id_user_delete']));

    // if ($userManager->validateInput($first_name, $last_name)) {
    $user = $userManager->deleteUser($id_user_delete);
    // }
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

<body class="w-full h-screen flex flex-col justify-center items-center space-y-8 py-6 bg-gray-100">

    <!-- Formulaire pour ajouter un utilisateur -->
    <div class="login-form w-1/2 max-sm:w-full max-w-sm mx-auto bg-gray-200 p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Ajouter un Utilisateur ou bien se connecter</h2>
        <form id="loginForm" method="POST" class="space-y-4">
            <div>
                <label for="first_name" class="block text-gray-600">Nom d'utilisateur</label>
                <input type="text" id="first_name" name="first_name" class="w-full border-gray-300 rounded-lg p-2"
                    required>
            </div>
            <div>
                <label for="last_name" class="block text-gray-600">Prénom d'utilisateur</label>
                <input type="text" id="last_name" name="last_name" class="w-full border-gray-300 rounded-lg p-2"
                    required>
            </div>
            <button name="add_user" class="w-full bg-blue-500 text-white py-2 rounded-lg">Ajouter</button>
            <!-- <?php echo $message; ?> -->
        </form>
    </div>

    <!-- Liste des utilisateurs -->

    <?php
    // Afficher tous les utilisateurs
    $users = $userManager->getAllUsers();
    ?>

    <div class="users-list w-3/4 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Liste des Utilisateurs</h2>
        <table class="w-full border-collapse border border-gray-300 text-left">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2">ID</th>
                    <th class="border border-gray-300 px-4 py-2">Nom</th>
                    <th class="border border-gray-300 px-4 py-2">Prénom</th>
                    <th class="border border-gray-300 px-4 py-2">Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td class="h-14 border border-gray-300 px-4 py-2"><?= $user['id_user'] ?></td>
                        <td class="h-14 border border-gray-300 px-4 py-2"><?= $user['first_name'] ?></td>
                        <td class="h-14 border border-gray-300 px-4 py-2"><?= $user['last_name'] ?></td>
                        <td class="h-14 border border-gray-300 px-4 py-1 flex justify-center">
                            <form action="" method="post" class="w-full h-full flex justify-center">
                                <input type="hidden" name="id_user_delete" value="<?php echo $user['id_user']  ?>">
                                <button name="delete_user" class="w-max h-full bg-red-500 text-white font-medium py-2 px-4 rounded hover:bg-red-600 transition">supprimer utilisateur</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>

</html>