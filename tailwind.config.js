const defaultTheme = require('tailwindcss/defaultTheme')
const plugin = require('tailwindcss/plugin')
module.exports = {
  darkMode: 'class',
content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],  theme: {
    themeVariants: ['dark'],
    customForms: (theme) => ({
      default: {
        'input, textarea': {
          '&::placeholder': {
            color: theme('colors.gray.400'),
          },
        },
      },
    }),
    extend: {
      maxHeight: {
        '0': '0',
        xl: '36rem',
      },
      fontFamily: {
        sans: ['Inter', ...defaultTheme.fontFamily.sans],
      },
      colors: {
        'primary': '#762a08',
        'text': '#ea4901',
      },
    },
  },
  variants: {
    backgroundColor: [
      'hover',
      'focus',
      'active',
      'odd',
      'dark',
      'dark:hover',
      'dark:focus',
      'dark:active',
      'dark:odd',
    ],
    display: ['responsive', 'dark'],
    textColor: [
      'focus-within',
      'hover',
      'active',
      'dark',
      'dark:focus-within',
      'dark:hover',
      'dark:active',
    ],
    placeholderColor: ['focus', 'dark', 'dark:focus'],
    borderColor: ['focus', 'hover', 'dark', 'dark:focus', 'dark:hover','checked'],
    divideColor: ['dark'],
    boxShadow: ['focus', 'dark:focus'],
    transform:['checked'],
    translate:['checked'],
    inset:['checked'],
  },
  plugins: [
    require('tailwindcss-multi-theme'),
    require('@tailwindcss/forms'),
    
  ],
}
