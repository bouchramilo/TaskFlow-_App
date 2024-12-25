<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>TaskFlow - Home</title>
</head>

<body class="w-full h-screen flex justify-center items-center ">

    <div class="login-form w-1/2 max-sm:w-full max-w-sm mx-auto bg-gray-200 p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Connexion</h2>
        <form id="loginForm" method="POST" class="space-y-4">
            <div>
                <label for="first_name" class="block text-gray-600">Nom d'utilisateur</label>
                <input type="text" id="first_name" name="first_name" class="w-full border-gray-300 rounded-lg p-2"
                    required>
            </div>
            <div>
                <label for="last_name" class="block text-gray-600">Prénom d'utilisateur : </label>
                <input type="text" id="last_name" name="last_name" class="w-full border-gray-300 rounded-lg p-2"
                    required>
            </div>
            <button name="login" class="w-full bg-blue-500 text-white py-2 rounded-lg">Se connecter</button>
        </form>
    </div>

</body>

</html>