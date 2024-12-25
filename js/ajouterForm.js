// Récupérer le bouton et le formulaire
const showFormButton = document.getElementById('showFormButton');
const formContainer = document.getElementById('formContainer');

// Afficher ou masquer le formulaire
showFormButton.addEventListener('click', () => {
    formContainer.classList.toggle('hidden');
});