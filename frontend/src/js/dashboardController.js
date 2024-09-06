// import save_pdf from "./save_pdf";

async function getDemande() {
    const authToken = localStorage.getItem('authToken');
    const url_demande = 'http://localhost:8000/api/demandes';

    try {
        // 1. Récupérer les demandes
        const response = await fetch(url_demande, {
            method: 'get',
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${authToken}`
            }
        });

        let demandes = await response.json();

        if (response.ok) {
            // 2. Créer des listes de promesses pour récupérer les utilisateurs, les types de documents et les actes de naissance
            const userPromises = demandes.map(demande => 
                fetch(`http://localhost:8000/api/users/${demande.user_id}`, {
                    method: 'get',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${authToken}`
                    }
                }).then(res => res.json())
            );

            const typeDocumentPromises = demandes.map(demande => 
                fetch(`http://localhost:8000/api/type_documents/${demande.type_document_id}`, {
                    method: 'get',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${authToken}`
                    }
                }).then(res => res.json())
            );

            const acteNaissancePromises = demandes.map(demande =>
                fetch(`http://localhost:8000/api/actes-de-naissance/${demande.id}`, {
                    method: 'get',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${authToken}`
                    }
                }).then(res => res.json())
            );

            // 3. Attendre que toutes les requêtes pour les utilisateurs, types de documents et actes de naissance soient terminées
            const users = await Promise.all(userPromises);
            const typeDocuments = await Promise.all(typeDocumentPromises);
            const actesNaissance = await Promise.all(acteNaissancePromises);

            // 4. Convertir les listes en objets pour une recherche plus facile
            const userMap = users.reduce((acc, user) => {
                acc[user.id] = user;
                return acc;
            }, {});

            const typeDocumentMap = typeDocuments.reduce((acc, typeDocument) => {
                acc[typeDocument.id] = typeDocument;
                return acc;
            }, {});

            const acteNaissanceMap = actesNaissance.reduce((acc, acte) => {
                acc[acte.demande_id] = acte;
                return acc;
            }, {});

            // 5. Combiner les données des demandes avec les détails des utilisateurs, types de documents et actes de naissance
            let demandesWithDetails = demandes.map(demande => ({
                ...demande,
                user: userMap[demande.user_id] || null,
                type_document: typeDocumentMap[demande.type_document_id] || null,
                acte_naissance: acteNaissanceMap[demande.id] || null
            }));

            // demandesWithDetails = JSON.stringify(demandesWithDetails)
            // Stocker les informations de l'utilisateur actuel
            localStorage.setItem('acteNaissData', JSON.stringify(demandesWithDetails));
            console.log(demandesWithDetails);


            // Maintenant, on va remplir le tableau HTML avec les données
            const tableBody = document.querySelector('#kits tbody');
            tableBody.innerHTML = ''; // Réinitialiser le contenu actuel du tableau

            demandesWithDetails.forEach(demande => {
                const row = document.createElement('tr');
                row.classList.add('bg-white', 'border-b', 'dark:bg-cardFill', 'dark:border-gray-700', 'hover:bg-gray-50', 'dark:hover:bg-gray-600');

                row.innerHTML = `
                    <td class="w-4 p-4">
                        <div class="flex items-center">
                            <input type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        </div>
                    </td>
                    <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                        <img class="w-10 h-10 rounded-full" src="http://localhost:8000/storage/${demande.user.profile_pic}" alt="Profile image">
                        <div class="ps-3">
                            <div class="text-base font-semibold">${demande.user ? demande.user.full_name : 'N/A'}</div>
                            <div class="font-normal text-gray-500">${demande.user ? demande.user.email : 'N/A'}</div>
                        </div>
                    </th>
                    <td class="px-6 py-4">
                        ${demande.type_document ? demande.type_document.nom : 'N/A'}
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-${demande.status === 'accepted' ? 'green' : 'red'}-100 text-${demande.status === 'accepted' ? 'green' : 'red'}-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-${demande.status === 'accepted' ? 'green' : 'red'}-900 dark:text-${demande.status === 'accepted' ? 'green' : 'red'}-300">${demande.status}</span>
                    </td>
                    <td class="px-6 py-4">
                        ${demande.submitting_date ? new Date(demande.submitting_date).toLocaleDateString() : 'N/A'}
                    </td>
                    <td class="px-6 py-4">
                        ${demande.traitement_date ? new Date(demande.traitement_date).toLocaleDateString() : 'N/A'}
                    </td>
                    <td class="px-6 py-4" onclick="">
                        <a href="/acte-naiss-preview?id=${demande.id}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Voir ...</a>
                    </td>
                `;

                tableBody.appendChild(row);
            });

            

        } else {
            // Gérer les erreurs
            console.error('Error:', await response.text());
        }

    } catch (error) {
        console.error('Error:', error);
    }

    


}

// Appeler la fonction au chargement de la page
document.addEventListener('DOMContentLoaded', getDemande);

