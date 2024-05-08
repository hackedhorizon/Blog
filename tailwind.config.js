/** @type {import('tailwindcss').Config} */
export default {
    content: [
		"./resources/**/*.blade.php",
		 "./resources/**/*.js",
		 "./node_modules/flowbite/**/*.js",
		 "./vendor/robsontenorio/mary/src/View/Components/**/*.php"
	],
    theme: {
      extend: {
        fontFamily: {
            'primary': ['Wallpoet Regular'],
            'secondary': ['Hind Vadodara Regular'],
        },
        backgroundColor: {
            'primary-100': '#00ffbf',
            'primary-200': '#50ffc6',
            'primary-300': '#72ffcd',
            'primary-400': '#8dffd4',
            'primary-500': '#a3ffdb',
            'primary-600': '#b8ffe2',
            'surface-100': '#121212',
            'surface-200': '#282828',
            'surface-300': '#3f3f3f',
            'surface-400': '#575757',
            'surface-500': '#717171',
            'surface-600': '#8b8b8b',
            'lime-main' : '#a3e635',
            'lime-shadow': '#d3fff4ad'
        },
        colors: {
            'primary-100': '#00ffbf',
            'primary-200': '#50ffc6',
            'primary-300': '#72ffcd',
            'primary-400': '#8dffd4',
            'primary-500': '#a3ffdb',
            'primary-600': '#b8ffe2',
            'surface-100': '#121212',
            'surface-200': '#282828',
            'surface-300': '#3f3f3f',
            'surface-400': '#575757',
            'surface-500': '#717171',
            'surface-600': '#8b8b8b',
            'lime-main': '#a3e635',
            'lime-shadow': '#d3fff4ad'
        },
        screens: {
            'xs': '460px',
        },
      },
    },
    plugins: [
		require('flowbite/plugin'),
		require("daisyui")
	],
  }
