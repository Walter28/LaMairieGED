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
    document.getElementById('nom_complet_defunt').innerHTML = demande.actes_naissance.nom_complet_defunt
    document.getElementById('date_de_deces').innerHTML = demande.actes_naissance.date_de_deces
    document.getElementById('lieu_de_deces').innerHTML = demande.actes_naissance.lieu_de_deces

    
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
const { jsPDF } = window.jspdf;
const doc = new jsPDF({
    orientation: 'portrait',
    unit: 'mm',
    format: 'a4',
});

// Importer la police "Inter" ou une police sans-serif disponible
doc.setFont('helvetica', 'normal');

// Données fournies
const nomCompletDefunt = demande.actes_naissance.nom_complet_defunt
const dateDeDeces = demande.actes_naissance.date_de_deces
const lieuDeces = demande.actes_naissance.lieu_de_deces

// Fonction pour obtenir la date actuelle (date d'impression)
const currentDate = new Date();
const day = String(currentDate.getDate()).padStart(2, '0');
const month = String(currentDate.getMonth() + 1).padStart(2, '0');
const year = currentDate.getFullYear();
const dateNow = `${day}/${month}/${year}`;

// Titre principal (centré)
doc.setFontSize(14);
doc.setFont('helvetica', 'bold');
doc.text('RÉPUBLIQUE DÉMOCRATIQUE DU CONGO', 105, 20, { align: 'center' });
doc.text('Province de ...', 105, 30, { align: 'center' });
doc.text('Commune de ...', 105, 40, { align: 'center' });
doc.text('Bureau de l\'État Civil', 105, 50, { align: 'center' });

// Certificat de décès - Titre principal
doc.setFontSize(16);
doc.text('CERTIFICAT DE DÉCÈS', 105, 70, { align: 'center' });

// Corps du texte (justifié et bien espacé)
doc.setFontSize(12);
doc.setFont('helvetica', 'normal');
doc.text('Nous, soussigné, Jean-Baptiste Kalombo, officier de l\'État civil', 20, 90);
doc.text('de la commune de ..., province de ..., certifions par la présente que :', 20, 100);

doc.text(`Le nommé(e) ${nomCompletDefunt},`, 20, 115);
doc.text('(nom complet du défunt)', 20, 125);

doc.text(`est décédé(e) le ${dateDeDeces}, à ${lieuDeces}.`, 20, 135);
doc.text('(date de décès)', 20, 145);
doc.text('(lieu de décès)', 20, 155);

doc.text('La personne susnommée est décédée à ..................................,', 20, 165);
doc.text('selon les informations fournies par les membres de la famille et les autorités compétentes.', 20, 175);

doc.text('Cause du décès :', 20, 190);
doc.text('Le certificat médical délivré par l\'hôpital de ..., signé par le Docteur ...,', 20, 200);
doc.text('atteste que le décès est survenu des suites de ...................................', 20, 210);

doc.text('Enregistrement :', 20, 230);
doc.text('Le décès a été enregistré sous le numéro d\'acte ..................,', 20, 240);
doc.text('à la date du .................... par notre bureau.', 20, 250);

// Témoins (justifiés)
doc.text('Témoins du décès :', 20, 270);
doc.text('- M. .........................................................', 20, 280);
doc.text('  (né le ............, domicilié à ............, profession : .........)', 20, 290);

doc.text('- Mme .........................................................', 20, 300);
doc.text('  (née le ............, domiciliée à ............, profession : .........)', 20, 310);

// Signatures et date d'impression (centré)
doc.setFont('helvetica', 'bold');
doc.text('Signatures :', 20, 330);
doc.setFont('helvetica', 'normal');
doc.text('Le présent acte a été dressé en conformité avec les lois de la République', 20, 340);
doc.text('Démocratique du Congo. Fait à ..........................., le ' + dateNow + '.', 20, 350);

doc.setFont('helvetica', 'bold');
doc.text('Jean-Baptiste Kalombo', 105, 370, { align: 'center' });
doc.setFont('helvetica', 'normal');
doc.text('Officier de l\'État civil, Commune de ...', 105, 380, { align: 'center' });

// Date d'impression
doc.text('Ce document a été imprimé le ' + dateNow, 105, 400, { align: 'center' });

// Générer le PDF
doc.save('certificat_de_deces.pdf');




})
