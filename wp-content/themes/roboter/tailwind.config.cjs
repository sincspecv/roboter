const buildConfig = require(`./build.config.cjs`);

// https://tailwindcss.com/docs/configuration
module.exports = {
  content: ['./index.php', './app/**/*.php', './resources/**/*.{php,vue,js}', '../../plugins/roboter-ten/resources/views/**/*.{php,vue,js}'],
  daisyui: {
    themes: [
      {
        roboter: {
          colors: buildConfig.colors
        },
      }
    ],
  },
  theme: {
    spacing: buildConfig.spacing,
    sizing: buildConfig.sizing,
    darkMode: false,
    container: {
      padding: buildConfig.spacing.md,
    },
    colors: {
      black: buildConfig.colors.black['500'],
      white: buildConfig.colors.white['50'],
      blue: buildConfig.colors.blue['500'],
      gray: buildConfig.colors.gray['200'],
      darkGray: buildConfig.colors.gray['700'],
      lightBlue: buildConfig.colors.lightBlue['500'],
      accent: buildConfig.colors.blue['300'],
      primary: buildConfig.colors.blue['500'],
      secondary: buildConfig.colors.lightBlue['500']
    },
    extend: {
      textSizes: buildConfig.textSizes,
    },
  },
  safelist: buildConfig.safelist,
  plugins: [
    require('daisyui'),
    require('@tailwindcss/typography'),
    require('@tailwindcss/aspect-ratio'),
    require('@tailwindcss/forms'),
  ],
  darkMode: 'class'
};
