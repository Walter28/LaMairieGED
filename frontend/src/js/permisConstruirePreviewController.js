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
    document.getElementById('nom_demandeur').innerHTML = demande.actes_naissance.nom_demandeur
    document.getElementById('adresse_site_construction').innerHTML = demande.actes_naissance.adresse_site_construction

    
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
const nomDemandeur = demande.actes_naissance.nom_demandeur
const adresseSite = demande.actes_naissance.adresse_site_construction
const dateImpression = new Date().toLocaleDateString('fr-FR');

// Paramètres de style
doc.setFont("Arial", "normal");
doc.setFontSize(12);

// Titre principal centré
doc.setFontSize(18);
doc.setFont("Arial", "bold");
doc.text("République Démocratique du Congo", 105, 30, { align: "center" });
doc.setFontSize(16);
doc.text("Ministère de l’Urbanisme et Habitat", 105, 40, { align: "center" });

doc.setDrawColor(0, 0, 0);
doc.line(20, 45, 190, 45); // Ligne horizontale sous le titre

// Sous-titre centré
doc.setFontSize(14);
doc.text("Permis de Construire", 105, 55, { align: "center" });

// Numéro de Référence (fictif pour cet exemple)
doc.setFontSize(12);
doc.setFont("Arial", "normal");
doc.text("Numéro de Référence : ........", 20, 70);

// Contenu du permis
doc.text(`Nom du Demandeur : ${nomDemandeur}`, 20, 80);
doc.text(`Adresse du Site de Construction : ${adresseSite}`, 20, 90);

doc.text("Objet : Permis de construire pour la réalisation d’un projet de construction à usage d’habitation.", 20, 105, { maxWidth: 170, align: "justify" });

// Conditions générales
doc.text("Conditions Générales :", 20, 120);
doc.text("1. Le projet doit respecter les réglementations en vigueur en matière d'urbanisme et de construction.", 25, 130, { maxWidth: 160, align: "justify" });
doc.text("2. Le permis est valable pour une durée de 12 mois à compter de la date de signature.", 25, 140, { maxWidth: 160, align: "justify" });
doc.text("3. Toute modification du projet doit être validée par une nouvelle demande.", 25, 150, { maxWidth: 160, align: "justify" });
doc.text("4. Les travaux doivent débuter dans un délai de 6 mois, sous peine de caducité.", 25, 160, { maxWidth: 160, align: "justify" });

// Durée et validité
doc.text("Durée et Validité :", 20, 175);
doc.text("Le Permis de Construire est valable jusqu'au ........", 25, 185);

// Signature de l'autorité compétente
doc.text("Signature de l'Autorité Compétente :", 20, 200);
doc.text("Nom : ....................", 25, 210);
doc.text("Fonction : Directeur de l'Urbanisme et Habitat", 25, 220);
doc.text("Signature : ..............", 25, 230);

// Date d'impression en bas de page
doc.text(`Fait à Kinshasa, le ${dateImpression}`, 20, 250);

// Pièces jointes
doc.text("Pièces Jointes :", 20, 265);
doc.text("- Plan de situation du terrain", 25, 275);
doc.text("- Plan de construction", 25, 285);
doc.text("- Preuve de propriété", 25, 295);
doc.text("- Preuve d'identité du demandeur", 25, 305);

// Ajout de cadres pour une meilleure structure (si nécessaire)
doc.setDrawColor(0, 0, 0);
doc.rect(18, 20, 175, 275); // Cadre général

// Sauvegarde du PDF
doc.save('Permis_de_Construire.pdf');




})
