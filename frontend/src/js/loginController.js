import { showErrorToast } from "./showErrorToast.js"
// USER AUTH //////////////////////////////////////////////////////////////////

//user resgister
const sigInForm = document.getElementById('sigInForm')
sigInForm.addEventListener('submit', async e => {
    e.preventDefault()

    const login = 'http://localhost:8000/api/login'

    const formData = new FormData(sigInForm)
    const readable_data = Object.fromEntries(formData)

    const res = await fetch(login, {
        method: 'post',
        headers : {
        'Accept' : 'application/json'
        },
        body: formData,
    })
        .then(res => res.json())
        .then(data => {
            console.log(data)

            if (data.access_token) {
                // Stocker le access_token dans localStorage
                localStorage.setItem('authToken', data.access_token);

                // Stocker les informations de l'utilisateur actuel
                localStorage.setItem('currentUser', JSON.stringify(data.user));

                // Redirection ou autre action après l'enregistrement
                console.log('Utilisateur enregistré avec succès.');
                window.location.href = '/acte-de-naissance'; // Remplacez par l'URL de votre tableau de bord
            } else {
                console.error('Il ya eu une erreur lors de l\'enregistrement de l\'utilisateur');

                // alert(data.message)
                // const errorMessages = Object.values(data.errors).flat();
                // errorMessages.forEach(message => showErrorToast(message));
                showErrorToast(data.message)
            }

            
        
        })
        .catch(error => console.error('Error:', error));

    // if (!res.ok) {
    //     alert(res)
    //     const errorMessages = Object.values(data.errors).flat();
    //     errorMessages.forEach(message => showToast(message));
    // }
    
})