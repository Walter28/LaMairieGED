


//=========================================================================================
    //stockage de l'url actuel dans la base
    // URL actuel
    const currentUrl = window.location.href;
    // localStorage.setItem('lastVisitedUrl', currentUrl);
    // Sauvegarder l'URL actuel dans le localStorage
    const storedUrl = localStorage.getItem('lastVisitedUrl');

    // Si l'utilisateur change de page (l'URL a changé par rapport à la dernière visite)
    // if (storedUrl && storedUrl !== currentUrl) {
    //     // Supprimer "hasLoadedOnce" car l'utilisateur a changé de page
    //     localStorage.removeItem('hasLoadedOnce');
    // }

    // Vérifier si la page est rechargée ou visitée pour la première fois
    if (!localStorage.getItem('hasLoadedOnce')) {
        // Efface la variable "pdf_to_preview" et "name_of_doc" si c'est la première visite
        // localStorage.removeItem('pdf_to_preview');
        // localStorage.removeItem('name_of_doc');
        // Indiquer que la page a été chargée une fois
        localStorage.setItem('hasLoadedOnce', 'true');
    }

    // Si l'utilisateur change de page (l'URL a changé par rapport à la dernière visite)
    if (storedUrl && storedUrl !== currentUrl) {
        // Supprimer "hasLoadedOnce" car l'utilisateur a changé de page
        localStorage.removeItem('hasLoadedOnce');
        // Efface la variable "pdf_to_preview" et "name_of_doc" si c'est la première visite
        localStorage.removeItem('pdf_to_preview');
        localStorage.removeItem('name_of_doc');
    }

    // Mettre à jour l'URL stockée à chaque chargement de page
    localStorage.setItem('lastVisitedUrl', currentUrl);
//---------------------------------------------------------------------------------------------

//=========================================================================================
// Stockage et gestion de l'URL actuelle dans le localStorage
//
// 1. Récupère l'URL actuelle de la page visitée
//    window.location.href : Retourne l'URL complète (y compris le protocole, le domaine et le chemin) 
//    de la page actuelle.
//
// 2. Stocke cette URL dans le localStorage sous la clé "lastVisitedUrl"
//    localStorage.setItem('lastVisitedUrl', currentUrl) : Sauvegarde l'URL actuelle dans le 
//    localStorage afin de pouvoir la comparer plus tard.
//
// 3. Récupère l'URL précédemment stockée (si elle existe) depuis le localStorage
//    localStorage.getItem('lastVisitedUrl') : Récupère la dernière URL sauvegardée pour vérifier 
//    si l'utilisateur a changé de page.
//
// 4. Si l'utilisateur a changé de page (l'URL actuelle est différente de l'URL précédemment stockée) :
//    - Supprime l'élément "hasLoadedOnce" du localStorage pour réinitialiser l'indicateur de 
//      rechargement de la page.
//    - Supprime les éléments "pdf_to_preview" et "name_of_doc" qui stockent des informations 
//      spécifiques à la page (comme des fichiers PDF à prévisualiser).
//
// 5. Si c'est la première visite sur la page (indiqué par l'absence de "hasLoadedOnce" dans 
//    le localStorage), on considère que la page n'a pas encore été rechargée :
//    - Supprime "pdf_to_preview" et "name_of_doc" pour effacer les informations obsolètes liées à la page.
//    - Définit "hasLoadedOnce" à true pour indiquer que la page a maintenant été chargée au moins une fois.
//
// 6. À chaque rechargement de page, l'URL actuelle est mise à jour dans le localStorage pour 
//    pouvoir être utilisée lors de la prochaine visite ou rechargement.
//---------------------------------------------------------------------------------------------
