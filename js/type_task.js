const task_type = document.getElementById("task_type");
    const inputGravite = document.querySelector(".inputGravite");
    const inputPriority = document.querySelector(".inputPriority");

    task_type.addEventListener("change", function () {
        // Récupérer la valeur actuelle de task_type
        const task_type_value = task_type.value;

        // Cacher tous les champs conditionnels avant d'afficher le bon
        inputGravite.classList.add('hidden');
        inputPriority.classList.add('hidden');

        // Afficher le champ correspondant à la valeur sélectionnée
        if (task_type_value === "bug") {
            inputGravite.classList.remove('hidden');
        } else if (task_type_value === "feature") {
            inputPriority.classList.remove('hidden');
        }
    });