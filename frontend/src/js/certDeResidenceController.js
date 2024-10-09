import { showErrorToast } from "./showErrorToast.js";
import { showSuccessToast } from "./showSuccessToast.js";

// USER AUTH //////////////////////////////////////////////////////////////////

// Acte de naissance
const demandeActeNaissForm = document.getElementById('demandeCertResForm');
demandeActeNaissForm.addEventListener('submit', async e => {
    e.preventDefault();

    let currentUser = localStorage.getItem('currentUser');
    currentUser = JSON.parse(currentUser);
    const token = localStorage.getItem('authToken');

    const url_demande = 'http://localhost:8000/api/demandes';

    // Create the FormData object
    const demande_body = new FormData();
    demande_body.append('user_id', currentUser.id);
    demande_body.append('type_document_id', 4);
    demande_body.append('status', 'attente');
    demande_body.append('submitting_date', new Date().toISOString());

    try {
        const response = await fetch(url_demande, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}` // Send the token
            },
            body: demande_body
        });

        const data = await response.json();

        if (response.ok) {

            const url_acte = 'http://localhost:8000/api/certificats-de-residence'
            const formData = new FormData(demandeActeNaissForm)
            formData.append('demande_id', data.id)

            // Second request
            const responseSecond = await fetch(url_acte, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: formData
            });

            const dataSecond = await responseSecond.json();

            if (responseSecond.ok) {
                // Display success toast
                showSuccessToast('Demande d\'acte de naissance soumise et traitement réussi.');
            } else {
                // Handle errors from the second request
                console.error('Error in second request:', dataSecond);

                const url_dmd = `http://localhost:8000/api/demandes/${data.id}`
                const deleteDemand = await fetch(url_dmd, {
                    method: 'delete',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    },
                    body: formData
                });

                const dataForDeleteDemand = await deleteDemand.json();
                alert(dataForDeleteDemand.message || 'Suppression de la demande avec success')
                showErrorToast(dataSecond.message || 'Une erreur est survenue lors du traitement.');
            }

        } else {
            // Handle errors
            console.error('Error:', data);
            // Optionally display error toast
            showErrorToast(data.message || 'Une erreur est survenue.');
        }

    } catch (error) {
        console.error('Error:', error);
        showErrorToast('Une erreur est survenue lors de l\'envoi de la demande.');
    }
});
