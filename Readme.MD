---

# 📂 LaMairieGED - Système de Gestion des Fichiers Administratifs 🏛️

Bienvenue dans **LaMairieGED**, un système de gestion des fichiers administratifs conçu pour faciliter la commande et la gestion des documents administratifs comme les actes de naissance, les certificats de décès, les certificats de résidence, et bien plus encore, directement en ligne. 🎉

## 🚀 Démarrage Rapide

Suivez ces instructions pour configurer et lancer le projet sur votre machine locale.

### Prérequis

- **Node.js** et **npm** installés ([Télécharger ici](https://nodejs.org/))
- **Composer** installé ([Télécharger ici](https://getcomposer.org/))
- **PHP** installé ([Télécharger ici](https://www.php.net/downloads.php))
- **Git** installé ([Télécharger ici](https://git-scm.com/))

### ⚙️ Installation Backend (Laravel)

1. **Clonez le dépôt :**

   ```bash
   git clone https://github.com/Walter28/LaMairieGED.git
   cd LaMairieGED/backend
   ```

2. **Installez les dépendances PHP :**

   ```bash
   composer install
   ```

3. **Configurez l'environnement :**

   Renommez le fichier `.env.example` en `.env` et configurez vos paramètres de base de données et autres configurations :

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migrer la base de données :**

   ```bash
   php artisan migrate
   ```

5. **Lancer le serveur Laravel :**

   ```bash
   php artisan serve
   ```

   Le serveur démarrera à l'adresse : [http://localhost:8000](http://localhost:8000)

### 🎨 Installation Frontend

1. **Naviguez vers le répertoire `frontend` :**

   ```bash
   cd ../frontend
   ```

2. **Installez les dépendances Node.js :**

   ```bash
   npm install
   ```

3. **Construisez les fichiers Tailwind CSS :**

   ```bash
   npm run css:build
   ```

4. **Lancez le serveur de développement Vite :**

   ```bash
   npm run dev
   ```

   Le serveur démarrera à l'adresse fournie par **Vite** (généralement [http://localhost:3000](http://localhost:3000)).

## 🧩 Structure du Projet

```
LaMairieGED/
│
├── backend/                  # Dossier Laravel pour le backend
│   ├── app/                  # Dossier des fichiers application
│   ├── public/               # Dossier des fichiers accessibles publiquement
│   └── ...                   # Autres dossiers et fichiers Laravel
│
└── frontend/                 # Dossier pour le front-end
    ├── index.html            # Fichier HTML principal
    ├── css/                  # Dossier pour les fichiers CSS
    │   └── styles.css        # Fichier CSS personnalisé
    ├── js/                   # Dossier pour les fichiers JavaScript
    │   └── scripts.js        # Fichier JavaScript personnalisé
    └── vendor/               # Dossier pour les bibliothèques tierces
        └── bootstrap/        # Dossier pour les fichiers Bootstrap
            ├── css/
            │   └── bootstrap.min.css
            └── js/
                └── bootstrap.bundle.min.js
```

## 📖 Documentation

Pour plus d'informations sur les configurations spécifiques ou les fonctionnalités avancées, consultez la documentation dans le dossier `docs`.

## 💼 Auteurs

- **Walter KRISS** | @Walter28 - Développeur Backend
- **Millenaire NIRWOTH** - Développeur Frontend

## 🛠️ Technologies Utilisées

- **PHP** avec **Laravel** pour le backend
- **Node.js** et **Vite** pour le front-end
- **Tailwind CSS** et **Bootstrap** pour le style
- **JavaScript** pour les interactions

## 📝 Contributions

Les contributions sont les bienvenues ! Merci de soumettre vos suggestions via des issues ou des pull requests sur GitHub.

## 📃 Licence

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

## 🎯 Objectifs du Projet

L'objectif principal de **LaMairieGED** est de moderniser la gestion des documents administratifs dans les mairies, offrant une solution numérique efficace et sécurisée pour les citoyens et les administrations. Nous visons à automatiser et simplifier les processus administratifs, réduisant ainsi les délais et améliorant l'accès aux services publics.

## 🎉 Remerciements

Merci à tous ceux qui ont contribué à ce projet. Nous apprécions votre soutien et votre enthousiasme !

---

✨ **Amusez-vous bien avec le développement !** ✨

---