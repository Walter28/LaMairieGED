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
    document.getElementById('husband_full_name').innerHTML = demande.actes_naissance.husband_full_name
    document.getElementById('marry_full_name').innerHTML = demande.actes_naissance.marry_full_name
    document.getElementById('wedding_place').innerHTML = demande.actes_naissance.wedding_place
    document.getElementById('wedding_date').innerHTML = demande.actes_naissance.wedding_date

    
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

    // Variables pour remplacer les données
    const nomEpoux = demande.actes_naissance.husband_full_name
    const nomEpouse = demande.actes_naissance.marry_full_name
    const lieuMariage = demande.actes_naissance.wedding_place
    const dateMariage = demande.actes_naissance.wedding_date
    // Obtenir la date actuelle pour l'impression
    const dateImpression = new Date().toLocaleDateString('fr-FR'); // Format: DD/MM/YYYY

    // Titre principal centré
    doc.setFontSize(14);
    doc.setFont("times", "bold");
    doc.text("RÉPUBLIQUE DÉMOCRATIQUE DU CONGO", 105, 20, { align: "center" });
    doc.text("Province de ...", 105, 30, { align: "center" });
    doc.text("Commune de ...", 105, 40, { align: "center" });
    doc.text("Bureau de l'État Civil", 105, 50, { align: "center" });

    // Saut de ligne
    doc.setFont("times", "normal");
    doc.setFontSize(12);
    doc.text("ACTE DE MARIAGE", 105, 70, { align: "center" });

    // Contenu du document
    doc.setFontSize(10);
    doc.text(`L'an deux mille ..., le ${dateMariage} à ${lieuMariage}, devant nous, M. Jean-Baptiste Kalombo,`, 15, 90);
    doc.text("officier de l'État civil de la Commune de ..., ont comparu en notre bureau :", 15, 97);

    // Informations sur l'époux
    doc.text(`1. ${nomEpoux}, né le ... à ..., de nationalité ..., domicilié à ..., profession ...,`, 15, 107);
    doc.text("fils de M. ... et de Mme ..., ici présent pour contracter mariage.", 15, 114);

    // Informations sur l'épouse
    doc.text(`2. ${nomEpouse}, née le ... à ..., de nationalité ..., domiciliée à ..., profession ...,`, 15, 124);
    doc.text("fille de M. ... et de Mme ..., ici présente pour contracter mariage.", 15, 131);

    // Déclaration de mariage
    doc.text("Les futurs époux, après avoir été publiquement interrogés, ont déclaré devant nous et en", 15, 141);
    doc.text("présence des témoins, leur volonté expresse de se prendre pour époux et de s'unir", 15, 148);
    doc.text("par les liens du mariage conformément aux lois de la République Démocratique du Congo.", 15, 155);

    // Citations des époux
    doc.text(`${nomEpoux} : "Je prends pour épouse ${nomEpouse}"`, 15, 165);
    doc.text(`${nomEpouse} : "Je prends pour époux ${nomEpoux}"`, 15, 172);

    // Validation par l'officier d'état civil
    doc.text("En vertu de cette déclaration, nous, M. Jean-Baptiste Kalombo, les avons déclarés unis", 15, 182);
    doc.text("par le mariage.", 15, 189);

    // Témoins
    doc.text("Fait en présence des témoins suivants :", 15, 199);
    doc.text("- M. ..., né le ..., résidant à ..., profession ...", 15, 209);
    doc.text("- Mme ..., née le ..., résidant à ..., profession ...", 15, 216);

    // Signatures
    doc.setFont("times", "bold");
    doc.text("Signatures :", 15, 235);

    doc.setFont("times", "normal");
    doc.text(`${nomEpoux} (époux)`, 35, 245);
    doc.text(`${nomEpouse} (épouse)`, 85, 245);
    doc.text("Jean-Baptiste Kalombo (Officier de l'État civil)", 135, 245);
    doc.text("Témoin 1 : ...", 35, 255);
    doc.text("Témoin 2 : ...", 85, 255);

    // Date d'impression
    doc.text(`Fait à Goma, le ${dateImpression}`, 15, 275);

    // Sauvegarder le document
    doc.save("Acte_de_Mariage.pdf");



})
