// tailwind.config.js
module.exports = {
  // Where Tailwind looks for class names
  content: [
    "./resources/views/**/*.blade.php",
    "./resources/js/**/*.vue",
  ],

  // Enable class-based dark mode
  darkMode: 'class',

  theme: {
    // Custom font stacks
    fontFamily: {
      sans: ['Poppins','sans-serif'],
      arabic: ['Amiri','serif'],
    },

    // Extend built-in utilities
    extend: {
      colors: {
        primary:   { DEFAULT: '#2563EB' },
        secondary: { DEFAULT: '#059669' },
        dark:      { DEFAULT: '#0F172A' },
        light:     { DEFAULT: '#F8FAFC' },
        accent:    { DEFAULT: '#D97706' },
      },
      animation: {
        'gradient-x': 'gradientX 15s ease infinite',
      },
      keyframes: {
        gradientX: {
          '0%, 100%': { 'background-position': '0% 50%' },
          '50%':      { 'background-position': '100% 50%' },
        },
      },
    },
  },

  plugins: [],
};
