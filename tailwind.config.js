/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        arcane: { DEFAULT: '#5865F2' },   // Azul Arcano
        mystic: { DEFAULT: '#7B4AEE' },   // Roxo Místico
        victory: { DEFAULT: '#3DDC84' },  // Verde Vitória
        prestige: { DEFAULT: '#F2C94C' }, // Dourado Prestígio
        background: { light: '#F5F7FA' }, // Cinza Luminoso
        obsidian: { DEFAULT: '#1A1C1F' }, // Cinza Obsidiana
        danger: { DEFAULT: '#E74C3C' }    // Vermelho Crítico
      },
      fontFamily: {
          sans: ['Figtree', 'sans-serif'],
      }
    },
  },
  plugins: [],
}