module.exports = {
  purge: [
    "./**/*.php",
    "./**/*.twig",
    "./**/*.js",
    "../../plugins/**/*.php",
    "../../plugins/**/*.js",
  ],

  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {},
  },
  variants: {
    extend: {},
  },
  plugins: [],
};
