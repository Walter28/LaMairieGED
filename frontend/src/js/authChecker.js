// authCheck.js

document.addEventListener('DOMContentLoaded', () => {
    // Vérifie si le token d'authentification existe dans localStorage
    const authToken = localStorage.getItem('authToken');

    if (!authToken) {
        // Si l'utilisateur n'est pas authentifié, redirigez-le vers la page de connexion
        window.location.href = '/sign-in'; // Remplacez par l'URL de votre page de connexion
    }
});
