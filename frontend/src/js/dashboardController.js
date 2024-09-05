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

            console.log(demandesWithDetails);

            // 6. Ajouter les données au tableau HTML
            const tableBody = document.querySelector('#kits tbody');
            tableBody.innerHTML = ''; // Clear previous content

            demandesWithDetails.forEach(demande => {
                const row = document.createElement('tr');

                // Utiliser l'identifiant de la demande pour rendre les identifiants uniques
                const uniqueId = demande.id;

                // Colonne Nom complet
                const fullNameCell = document.createElement('td');
                fullNameCell.classList.add('font-medium', 'text-gray-900', 'whitespace-nowrap', 'dark:text-white');
                fullNameCell.innerText = demande.user ? demande.user.full_name : 'N/A';
                row.appendChild(fullNameCell);

                // Colonne Demande
                const demandeCell = document.createElement('td');
                demandeCell.innerText = demande.type_document ? demande.type_document.nom : 'N/A';
                row.appendChild(demandeCell);

                // Colonne Label
                const labelCell = document.createElement('td');
                const labelSpan = document.createElement('span');
                labelSpan.classList.add('bg-green-100', 'text-green-800', 'text-xs', 'font-medium', 'me-2', 'px-2.5', 'py-0.5', 'rounded-full', 'dark:bg-green-900', 'dark:text-green-300');
                labelSpan.innerText = demande.status;
                labelCell.appendChild(labelSpan);
                row.appendChild(labelCell);

                // Colonne Date de Demande
                const submittingDateCell = document.createElement('td');
                submittingDateCell.innerText = demande.submitting_date;
                row.appendChild(submittingDateCell);

                // Colonne Date de Récupération
                const traitementDateCell = document.createElement('td');
                traitementDateCell.innerText = demande.traitement_date || 'En cours';
                row.appendChild(traitementDateCell);

                // Colonne Action (boutons d'action)
                const actionCell = document.createElement('td');
                const button = document.createElement('button');
                button.id = 'dropdownMenuIconButton';
                button.setAttribute('data-dropdown-toggle', `dropdownDots${uniqueId}`);
                button.classList.add('inline-flex', 'items-center', 'p-1', 'text-sm', 'font-light', 'text-center', 'text-gray-900', 'rounded-lg', 'hover:bg-gray-100', 'focus:ring-4', 'focus:outline-none', 'dark:text-white', 'focus:ring-gray-50', 'dark:hover:bg-gray-700', 'dark:focus:ring-gray-600');
                button.type = 'button';

                // Créer le menu dropdown
                const dropdown = document.createElement('div');
                dropdown.id = `dropdownDots${uniqueId}`;
                dropdown.classList.add('hidden', 'z-10', 'w-44', 'bg-white', 'divide-y', 'divide-gray-100', 'rounded-lg', 'shadow', 'dark:bg-gray-700', 'dark:divide-gray-600');

                // Menu items
                dropdown.innerHTML = `
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconButton">
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Earnings</a>
                    </li>
                    </ul>
                    <div class="py-2">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Separated link</a>
                    </div>
                `;


                


                // SVG inside button
                button.innerHTML = `
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
                        <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
                    </svg>
                `;
                
                actionCell.appendChild(button);
                actionCell.appendChild(dropdown);
                row.appendChild(actionCell);

                // Ajouter la ligne à la table
                tableBody.appendChild(row);
                // Ajouter le bouton et le dropdown à la cellule
                // actionCell.appendChild(button);
                // tableBody.appendChild(dropdown);
                // row.appendChild(actionCell);
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
