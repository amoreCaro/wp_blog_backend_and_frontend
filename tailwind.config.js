/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './**/*.php',
    './assets/src/js/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        // Основні акценти
        'brand-indigo': '#6366F1',
        'brand-turquoise': {
          500: '#53B0A1',
          600: '#418E84',
        },
        // Поверхні та межі
        'surface-dark': '#111114',
        'surface-hover': '#18181b',
        'border-light': '#1f1f22',
        'border-medium': '#262629',
        'border-hover': '#222226',
        // Текст
        'content-white': '#FFFFFF',
        'content-gray': '#CECECE',
        'content-muted': '#E6E6E6',
        'content-dimmed': '#4D4D50', 
        'content-ghost': '#333336', 
        'content-heading': '#F3F4F6',
      },
      fontFamily: {
        'roboto': ['Roboto', 'sans-serif'],
        sans: ['Roboto', 'ui-sans-serif', 'system-ui'],
      }
    },
  },
  plugins: [],
};