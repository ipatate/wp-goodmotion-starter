module.exports = {
  mode: 'jit',
  purge: [
    './**/*.{js,jsx,ts,tsx,vue,php,twig,html}',
    '../../plugins/**/*.{js,jsx,ts,tsx,vue,php,twig,html}',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    fontFamily: {
      sans: ['Roboto', 'helvetica', 'arial', 'sans-serif'],
      display: ['Roboto', 'helvetica', 'arial', 'sans-serif'],
      body: ['Roboto', 'helvetica', 'arial', 'sans-serif'],
    },
    extend: {
      backgroundImage: (theme) => ({
        'down-nav': "url('/assets/media/down.svg')",
        'down-nav-mobile': "url('/assets/media/arrow-left.svg')",
        logo: "url('/assets/media/logo_mercredi.png')",
        'logo-white': "url('/assets/media/logo_mercredi_blanc.png')",
      }),
      colors: {
        accent: '#450B40',
      },
      typography: (theme) => ({
        DEFAULT: {
          css: {
            color: theme('colors.gray.800'),
          },
        },
      }),
    },
  },
  variants: {
    extend: {},
  },
  plugins: [require('@tailwindcss/typography')],
}
