/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./*.html", "./src/**/*.{js,ts,jsx,tsx}"], // Inclut le fichier HTML et les fichiers dans src
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        primary: '#db1a5a',
        secondary: '#dcdcdc',
        dark: '#131315',
        cardFill: '#18181b',
        cardStroke: '#3a3a3e',
        formIcon: '#b8b8b8',
        btnText: '#ffffff',
        formStroke: '#646464'
      },
      fontFamily: {
        inter: ['Inter', 'sans-serif'], // Définit Inter comme la police par défaut
      },
      fontWeight: {
        thin: '100',
        extraLight: '200',
        light: '300',
        normal: '400', 
        medium: '500',
        semiBold: '600',
        bold: '700',
        extraBold: '800',
        black: '900',
      },
      
    },
  },
  plugins: [
    require('flowbite/plugin')({
        datatables: true,
    }),
  ]
};


