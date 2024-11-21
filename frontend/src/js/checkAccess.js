// Vérifier si l'utilisateur est authentifié et a le bon rôle
function checkAccess(requiredRole) {
    // Récupérer le rôle stocké (ici depuis localStorage par exemple)
    let currentUser = localStorage.getItem('currentUser');
    currentUser = JSON.parse(currentUser);
    const userRole = currentUser.role

    // alert(userRole)

    // Si l'utilisateur n'est pas connecté ou n'a pas le rôle requis
    if (!userRole || userRole !== requiredRole) {
        alert('Access Denied: You do not have the required permissions.');
        // Rediriger vers une autre page (par exemple, la page de connexion)
        window.location.href = '/acte-de-naissance.html';
    }
}

// Appel de la fonction checkAccess() sur les pages sensibles
document.addEventListener('DOMContentLoaded', function () {
    // Par exemple, protéger la route admin
    checkAccess('admin');
});
