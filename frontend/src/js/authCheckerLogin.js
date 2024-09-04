// Fonction pour vérifier l'authentification
function checkAuthenticationAndRedirect() {
    const authToken = localStorage.getItem('authToken');

    // Si un token est présent, rediriger vers la page d'accueil
    if (authToken) {
        window.location.href = '/acte-de-naissance'; // Remplacez par l'URL de la page d'accueil de l'utilisateur
    }
}

// Appeler la fonction au chargement de la page
document.addEventListener('DOMContentLoaded', checkAuthenticationAndRedirect);
