//user logout
document.getElementById('logoutButton').addEventListener('click', async e => {
    
    // alert('login out ?')


    // Supprimer le token et les informations de l'utilisateur du localStorage
    localStorage.removeItem('authToken');
    localStorage.removeItem('currentUser');

    const res = await fetch('/logout', {
        method: 'post',
        headers : {
        'Accept' : 'application/json'
        }
    })

    // Redirection vers la page de connexion après la déconnexion
    window.location.href = '/sign-in'; // Remplacez par l'URL de votre page de connexion
    
});

async function logout2ndButton(){

    // alert('login out ?')


    // Supprimer le token et les informations de l'utilisateur du localStorage
    localStorage.removeItem('authToken');
    localStorage.removeItem('currentUser');

    const res = await fetch('/logout', {
        method: 'post',
        headers : {
        'Accept' : 'application/json'
        }
    })

    // Redirection vers la page de connexion après la déconnexion
    window.location.href = '/sign-in'; // Remplacez par l'URL de votre page de connexion

}