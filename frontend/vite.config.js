import { defineConfig } from 'vite';

export default defineConfig({
  root: '.',  // Définit le dossier racine à 'frontend'
  build: {
    // outDir: 'dist',  // Dossier de sortie pour les fichiers construits
  },
  server: {
    open: true,  // Ouvre automatiquement le navigateur
    // port: 3001   // Port sur lequel le serveur de développement sera exécuté
  },
  define: {
    'console': 'console' // Ensure console is defined correctly
  }
});


