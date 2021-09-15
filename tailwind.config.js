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
      sherif: ['Norican', 'helvetica', 'arial', 'sans-serif'],
      body: ['Roboto', 'helvetica', 'arial', 'sans-serif'],
    },
    extend: {
      backgroundImage: (theme) => ({
        'down-nav': "url('/assets/media/down.svg')",
        'down-nav-mobile': "url('/assets/media/arrow-left.svg')",
        logo: "url('/assets/media/logo_mercredi.png')",
        'logo-white': "url('/assets/media/logo_mercredi_blanc.png')",
        instagram: "url('/assets/media/instagram.svg')",
        'instagram-accent': "url('/assets/media/instagram-accent.svg')",
        facebook: "url('/assets/media/facebook.svg')",
        play: "url('/assets/media/play.svg')",
        pause: "url('/assets/media/pause.svg')",
        previous: "url('/assets/media/previous.svg')",
        next: "url('/assets/media/next.svg')",
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
