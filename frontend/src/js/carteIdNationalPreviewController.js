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
    document.getElementById('nom_complet_citoyen').innerHTML = demande.actes_naissance.nom_complet_citoyen
    document.getElementById('date_naissance').innerHTML = demande.actes_naissance.date_naissance
    document.getElementById('lieu_de_naissance').innerHTML = demande.actes_naissance.lieu_de_naissance
    document.getElementById('adresse_actuelle').innerHTML = demande.actes_naissance.adresse_actuelle
    
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
    orientation: 'landscape', // Orientation paysage
    unit: 'mm',
    format: 'a4' // Format A4
});

// Dimensions de la carte d'électeur
const cardWidth = 85;
const cardHeight = 54;

// Calcul pour centrer la carte au milieu de la page A4 (210x297 mm)
const xOffset = (297 - cardWidth) / 2;
const yOffset = (210 - cardHeight) / 2;

// Variables pour les données dynamiques de la carte
const nomComplet = demande.actes_naissance.nom_complet_citoyen
const dateNaissance = demande.actes_naissance.date_naissance
const lieuNaissance = demande.actes_naissance.lieu_de_naissance
const adresseActuelle = demande.actes_naissance.adresse_actuelle
const numElecteur = "A34577707";
const origine = "Kapamay/Bukama/Haut-Lomami";
const imageURL = `http://localhost:8000/storage/${demande.actes_naissance.photo_identite}`

// Définir les styles de police
doc.setFont('helvetica', 'normal');
doc.setFontSize(8);

// Dessiner la carte d'électeur (centrée sur la page)
doc.setFillColor(240, 240, 240); // Couleur de fond gris clair pour la carte
doc.rect(xOffset, yOffset, cardWidth, cardHeight, 'F'); // Fond de la carte

// Section gauche : Texte en haut de la carte
doc.setFont('helvetica', 'bold');
doc.setFontSize(10);
doc.text("REPUBLIQUE DEMOCRATIQUE DU CONGO", xOffset + 5, yOffset + 8);
doc.setFontSize(8);
doc.text("COMMISSION ELECTORALE NATIONALE INDEPENDANTE", xOffset + 5, yOffset + 13);

// Section gauche : Informations citoyennes
doc.setFont('helvetica', 'normal');
doc.setFontSize(7);
doc.text(`Nom complet : ${nomComplet}`, xOffset + 10, yOffset + 22);
doc.text(`Date de naissance : ${dateNaissance}`, xOffset + 10, yOffset + 27);
doc.text(`Lieu de naissance : ${lieuNaissance}`, xOffset + 10, yOffset + 32);
doc.text(`Adresse actuelle : ${adresseActuelle}`, xOffset + 10, yOffset + 37);
doc.text(`N° Electeur : ${numElecteur}`, xOffset + 10, yOffset + 42);
doc.text(`Origine : ${origine}`, xOffset + 10, yOffset + 47);

// Encadrer la photo
doc.setLineWidth(0.5);
doc.rect(xOffset + 55, yOffset + 5, 25, 25); // Encadré pour la photo

// Charger et ajouter l'image du citoyen
const loadImage = (imageUrl) => {
    const img = new Image();
    img.src = imageUrl;
    img.onload = function () {
        doc.addImage(img, 'JPEG', xOffset + 55, yOffset + 5, 25, 25); // Ajouter l'image dans le cadre
        // Générer et sauvegarder le PDF après le chargement de l'image
        doc.save("Carte_Electeur.pdf");
    };
};

loadImage(imageURL);

// Section droite : Sexe, Poste Nom/Prénom, etc.
doc.setFontSize(7);
doc.text("Sexe : F", xOffset + 60, yOffset + 35);
doc.text("Post-nom/Prénom : NKOMBE / TSHIKWAKWA", xOffset + 55, yOffset + 40);
doc.text("Secteur ou Chefferie : Kapamay/Bukama/Haut-Lomami", xOffset + 55, yOffset + 45);

// Signature et lieu de délivrance
doc.setFontSize(6);
doc.text(`Lieu et date de délivrance : Selembao, le 17/08/2017`, xOffset + 5, yOffset + 52);
doc.text("Signature de l'agent", xOffset + 60, yOffset + 52);
doc.line(xOffset + 70, yOffset + 51, xOffset + 85, yOffset + 51); // Ligne pour la signature

// Sauvegarder le PDF après ajout des éléments
doc.save("Carte_Electeur.pdf");






})
