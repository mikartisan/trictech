/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.{html,php}",
    "./**/*.{html,php}",
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {
      screens: {
        'xs': {'min': '320px', 'max': '639px'},
      },
    },
  },
  plugins: [
    require('flowbite/plugin')
  ],
}
