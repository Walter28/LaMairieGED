import { showErrorToast } from "./showErrorToast.js"
// USER AUTH //////////////////////////////////////////////////////////////////

//Acte de naissance
const demandeActeNaissForm = document.getElementById('demandeActeNaissForm')
demandeActeNaissForm.addEventListener('submit', async e => {
    e.preventDefault()

    var currentUser = localStorage.getItem('currentUser')
    currentUser = JSON.parse(currentUser)
    const token = localStorage.getItem('authToken');

    const url_acte = 'http://localhost:8000/api/actes-de-naissance'
    const url_demande = 'http://localhost:8000/api/demandes'

    // const formData = new FormData(demandeActeNaissForm)
    // const profile_pic = document.getElementById('profile_pic').files[0]
    // const identity_card = document.getElementById('identity_card').files[0]
    // formData.append('profile_pic', profile_pic)
    // formData.append('identity_card', identity_card)
    
    // Make demande first
    const demande_body = new FormData()
    demande_body.append('user_id', currentUser.id)
    demande_body.append('type_document_id', 1)
    demande_body.append('status', 'attente')

    const res_demande = await fetch(url_demande, {
        method: 'post',
        headers : {
        'Accept' : 'application/json',
        'Authorization': `Bearer ${token}`, // Send the token
        },
        body: demande_body,
    })
        .then(res => res.json())
        .then(data => {
            console.log(data)
        })



    

    
})