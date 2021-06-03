module.exports = {
  mode: "jit",
  purge: [
    "./**/*.{js,jsx,ts,tsx,vue,php,twig,html}",
    "../../plugins/**/*.{js,jsx,ts,tsx,vue,php,twig,html}",
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
