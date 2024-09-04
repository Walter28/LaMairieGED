//show toast
// Fonction pour afficher un toast d'erreur
export function showSuccessToast(message) {
    const toastTemplate = document.getElementById('toast-template-success');
    const toastContainer = document.getElementById('toast-container');
    const successSound = document.getElementById('success-sound');

    // Cloner le template
    const toast = toastTemplate.cloneNode(true);
    toast.classList.remove('hidden');
    toast.classList.add('flex');
    toast.querySelector('.text-sm').textContent = message;

    // Ajouter le toast au conteneur
    toastContainer.appendChild(toast);

    // Jouer le son d'erreur
    successSound.play();

    // Supprimer le toast après 3 secondes
    setTimeout(() => {
        toast.classList.add('toast-exit');
        setTimeout(() => {
            toast.remove();
        }, 500); // Durée de l'animation de disparition
    }, 3000); // Temps avant la disparition (3 secondes)
}