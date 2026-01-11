/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.php",            // PHP у корені
    "./app/**/*.php",      // PHP компоненти
    "../**/*.php",      // PHP інклуди
    "./src/js/**/*.js",    // JS файли
    "./src/css/**/*.css"   // CSS файли
  ],
  theme: {
    extend: {
      colors: {
        // тут можеш додати кастомні кольори
      },
      fontFamily: {
        'roboto': ['Roboto', 'sans-serif'],
        sans: ['Roboto', 'ui-sans-serif', 'system-ui'],
      }
    },
  },
  plugins: [],
};
