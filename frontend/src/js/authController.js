import { showErrorToast } from "./showErrorToast.js"
// USER AUTH //////////////////////////////////////////////////////////////////

//user resgister
const signUpForm = document.getElementById('signUpForm')
signUpForm.addEventListener('submit', async e => {
    e.preventDefault()

    const url = 'https://jsonplaceholder.typicode.com/users'
    const url2 = 'http://localhost:8000/api/demandes'
    const url_register = 'http://localhost:8000/api/register'

    const formData = new FormData(signUpForm)
    const profile_pic = document.getElementById('profile_pic').files[0]
    const identity_card = document.getElementById('identity_card').files[0]
    formData.append('profile_pic', profile_pic)
    formData.append('identity_card', identity_card)
    const readable_data = Object.fromEntries(formData)

    const res = await fetch(url_register, {
        method: 'post',
        headers : {
        'Accept' : 'application/json'
        },
        body: formData,
    })
        .then(res => res.json())
        .then(data => {
            console.log(data)

            if (data.token) {
                // Stocker le token dans localStorage
                localStorage.setItem('authToken', data.token);

                // Stocker les informations de l'utilisateur actuel
                localStorage.setItem('currentUser', JSON.stringify(data.user));

                // Redirection ou autre action après l'enregistrement
                console.log('Utilisateur enregistré avec succès.');
                window.location.href = '/acte-de-naissance'; // Remplacez par l'URL de votre tableau de bord
            } else {
                console.error('Il ya eu une erreur lors de l\'enregistrement de l\'utilisateur');

                alert(data.message)
                const errorMessages = Object.values(data.errors).flat();
                errorMessages.forEach(message => showErrorToast(message));
            }

            
        
        })
        .catch(error => console.error('Error:', error));

    // if (!res.ok) {
    //     alert(res)
    //     const errorMessages = Object.values(data.errors).flat();
    //     errorMessages.forEach(message => showToast(message));
    // }
    
})