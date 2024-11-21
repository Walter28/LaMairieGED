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
    document.getElementById('nom_complet_celibataire').innerHTML = demande.actes_naissance.nom_complet_celibataire
    document.getElementById('date_naissance').innerHTML = demande.actes_naissance.date_naissance
    document.getElementById('lieu_naissance').innerHTML = demande.actes_naissance.lieu_naissance
    document.getElementById('declaration_honneur').innerHTML = demande.actes_naissance.declaration_honneur
    
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
// Initialisation de jsPDF
const { jsPDF } = window.jspdf;
const doc = new jsPDF({
  orientation: 'portrait',
  unit: 'mm',
  format: 'a4',
});

// Variables dynamiques (à remplacer par les valeurs réelles)
const nomCompletCelibataire = demande.actes_naissance.nom_complet_celibataire
const dateNaissance = demande.actes_naissance.date_naissance
const lieuNaissance = demande.actes_naissance.lieu_naissance
const declarationHonneur = demande.actes_naissance.declaration_honneur
const dateImpression = new Date().toLocaleDateString('fr-FR');

// Paramètres de style
doc.setFont("Arial", "normal");
doc.setFontSize(12);

// Titre principal centré
doc.setFontSize(18);
doc.setFont("Arial", "bold");
doc.text("République Démocratique du Congo", 105, 30, { align: "center" });
doc.setFontSize(16);
doc.text("Ministère de la Justice", 105, 40, { align: "center" });

doc.setDrawColor(0, 0, 0);
doc.line(20, 45, 190, 45); // Ligne horizontale sous le titre

// Sous-titre centré
doc.setFontSize(14);
doc.text("Certificat de Célibat", 105, 55, { align: "center" });

// Contenu du certificat
doc.setFontSize(12);
doc.setFont("Arial", "normal");
doc.text("Je soussigné(e), l'Officier de l'État Civil,", 20, 75);
doc.text("atteste que :", 20, 85);

// Informations personnelles du célibataire
doc.text(`Nom complet : ${nomCompletCelibataire}`, 20, 100);
doc.text(`Date de naissance : ${dateNaissance}`, 20, 110);
doc.text(`Lieu de naissance : ${lieuNaissance}`, 20, 120);

doc.text("Déclare sur l'honneur être célibataire et ne pas être engagé(e)", 20, 135, { maxWidth: 170, align: "justify" });
doc.text("dans un mariage légalement reconnu à ce jour.", 20, 145, { maxWidth: 170, align: "justify" });

// Déclaration sur l'honneur
doc.setFont("Arial", "italic");
doc.text("Déclaration sur l'honneur :", 20, 160);
doc.setFont("Arial", "normal");
doc.text(declarationHonneur, 25, 170, { maxWidth: 160, align: "justify" });

// Date et signature
doc.setFont("Arial", "normal");
doc.text(`Fait à Kinshasa, le ${dateImpression}`, 20, 210);

doc.text("Signature de l'Officier de l'État Civil :", 20, 230);
doc.text(".................................................", 20, 240);

// Cadre général pour structurer le document
doc.setDrawColor(0, 0, 0);
doc.rect(18, 20, 175, 260); // Cadre général

// Sauvegarde du PDF
doc.save('Certificat_de_Celibat.pdf');

})
