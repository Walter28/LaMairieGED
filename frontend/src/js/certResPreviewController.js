document.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    let id =  parseInt(params.get('id'));
    // alert(id)
    // Vérifie si le token d'authentification existe dans localStorage
    let demande = localStorage.getItem("actesData")
    demande = JSON.parse(demande)
    demande =  demande.find(dmd => dmd.id === id);
    console.log(demande)



    ///champ prelemprir
    //document.getElementById('profile_pic').src=`http://localhost:8000/storage/${demande.users.profile_pic}`
    document.getElementById('profile_pic_user').src=`http://localhost:8000/storage/${demande.users.profile_pic}`
    document.getElementById('full_name').innerHTML = demande.users.full_name
    document.getElementById('full_name2').innerHTML = demande.users.full_name
    // document.getElementById('email').innerHTML = demande.users.email
    document.getElementById('birth_place').innerHTML = demande.users.birth_place
    document.getElementById('birth_date').innerHTML = demande.users.birth_date
    document.getElementById('nationalite').innerHTML = demande.users.nationality
    document.getElementById('address').innerHTML = demande.users.address
    
    //donnee fournies
    document.getElementById('nom_complet_du_resident').innerHTML = demande.actes_naissance.nom_complet_du_resident
    document.getElementById('adresse_actuelle_de_la_residence').innerHTML = demande.actes_naissance.adresse_actuelle_de_la_residence
    document.getElementById('declaration_sur_l_honneur').innerHTML = demande.actes_naissance.declaration_sur_l_honneur

    
});


// TELECHARGEMENT DE L'ACTE
const download = document.getElementById('download')
download.addEventListener('click', (e)=>{

    const params = new URLSearchParams(window.location.search);
    let id =  parseInt(params.get('id'));
    // alert(id)
    // Vérifie si le token d'authentification existe dans localStorage
    let demande = localStorage.getItem("actesData")
    demande = JSON.parse(demande)
    demande =  demande.find(dmd => dmd.id === id);
    console.log(demande)


    // Initialiser jsPDF
// Initialiser jsPDF
const { jsPDF } = window.jspdf;
const doc = new jsPDF({
    orientation: 'portrait',
    unit: 'mm',
    format: 'a4',
});

// Variables fournies
const nomResident = demande.actes_naissance.nom_complet_du_resident
const adresseResident = demande.actes_naissance.adresse_actuelle_de_la_residence
const declarationHonneur = demande.actes_naissance.declaration_sur_l_honneur

const ville = 'Goma';
const commune = 'Mbunya';

// Date d'impression (date actuelle)
const today = new Date();
const dateImpression = today.toLocaleDateString();

// Définir la police
doc.setFont('helvetica', 'normal');
doc.setFontSize(12);

// Titre principal
doc.setFontSize(16);
doc.setFont('helvetica', 'bold');
doc.text('République Démocratique du Congo', 105, 20, { align: 'center' });
doc.text('Ville de ' + ville, 105, 30, { align: 'center' });
doc.text('Mairie de ' + commune, 105, 40, { align: 'center' });
doc.text('Service de l\'État Civil', 105, 50, { align: 'center' });
doc.setFontSize(18);
doc.text('CERTIFICAT DE RÉSIDENCE', 105, 60, { align: 'center' });

// Corps du certificat
doc.setFontSize(12);
doc.setFont('helvetica', 'normal');
doc.text(
    `Nous, soussigné(e), __________, Officier de l'État Civil, autorisé(e) par la loi à délivrer des certificats de résidence dans la Commune de ${commune}, certifions par la présente que :`,
    20, 80, { maxWidth: 170 }
);
doc.text(`- Nom complet du résident : ${nomResident}`, 20, 100);
doc.text(`- Adresse actuelle de résidence : ${adresseResident}`, 20, 110);

// Déclaration sur l'honneur
doc.text('Déclaration sur l\'honneur :', 20, 130);
doc.text(
    `Je soussigné(e), ${nomResident}, atteste sur l’honneur que j'occupe le domicile situé à l'adresse indiquée ci-dessus. Je déclare que toutes les informations fournies dans ce certificat sont exactes et conformes à la réalité. Je suis conscient(e) des sanctions prévues en cas de fausses déclarations conformément aux lois de la République Démocratique du Congo.`,
    20, 140, { maxWidth: 170 }
);

// Signatures et date
doc.text(`Fait à ${ville}, le ${dateImpression}`, 20, 180);
doc.text('Signature du résident', 20, 200);
doc.text('______________________', 20, 205);
doc.text('Signature de l\'officier de l\'État Civil', 120, 200);
doc.text('______________________', 120, 205);

// Footer
doc.setFontSize(10);
doc.text('Cachet officiel :', 20, 240);
doc.text('______________________', 20, 245);

// Générer et afficher le PDF
doc.save(`Certificat_de_Residence_${nomResident}.pdf`);





})
