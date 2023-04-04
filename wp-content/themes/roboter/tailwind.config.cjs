// https://tailwindcss.com/docs/configuration
module.exports = {
  content: ['./index.php', './app/**/*.php', './resources/**/*.{php,vue,js}'],
  theme: {
    extend: {
      colors: {
        blue: {
          50: "#E4EDF6",
          100: "#C9DAED",
          200: "#93B5DC",
          300: "#6293CB",
          400: "#396FAD",
          500: "#274C77",
          600: "#1F3E60",
          700: "#182F49",
          800: "#0F1E2E",
          900: "#080F17"
        },
        lightBlue: {
          50: "#F1F6F9",
          100: "#DFEAF1",
          200: "#BFD5E3",
          300: "#9FC0D5",
          400: "#7FAAC7",
          500: "#6096BA",
          600: "#44799D",
          700: "#335B75",
          800: "#223D4E",
          900: "#111E27"
        },
        white: {
          50: "#FCFDFD",
          100: "#F9FAFB",
          200: "#F6F8F9",
          300: "#F0F3F5",
          400: "#EDF1F3",
          500: "#E7ECEF",
          600: "#AFC0CA",
          700: "#7592A3",
          800: "#4B6371",
          900: "#253037"
        },
        gray: {
          50: "#F2F2F2",
          100: "#E8E8E8",
          200: "#D1D2D1",
          300: "#BABBB9",
          400: "#A1A29F",
          500: "#8B8C89",
          600: "#6E6F6C",
          700: "#555553",
          800: "#383937",
          900: "#1C1C1C"
        },
        black: {
          50: "#E8E8E8",
          100: "#D1D1D1",
          200: "#A3A3A3",
          300: "#787878",
          400: "#4A4A4A",
          500: "#1C1C1C",
          600: "#171717",
          700: "#121212",
          800: "#0A0A0A",
          900: "#050505"
        }
      },
    },
  },
  plugins: [
    require("daisyui"),
  ],
  darkMode: 'class'
};
