const buildConfig = require(`./build.config.cjs`);

// https://tailwindcss.com/docs/configuration
module.exports = {
  content: ['./index.php', './app/**/*.php', './resources/**/*.{php,vue,js}', '../../plugins/roboter-ten/views/**/*.{php,vue,js}'],
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
    extend: {
      textSizes: buildConfig.textSizes,
      colors: buildConfig.colors
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
