const defaultTheme = require( 'tailwindcss/defaultTheme' );

/** @type {import('tailwindcss').Config} */
module.exports = {
	content: [
		'./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
		'./storage/framework/views/*.php',
		'./resources/views/**/*.blade.php',
	],
	darkMode: [ 'class', '.theme-dark' ],
	theme: {
		screens: {
			sm: '576px',
			md: '768px',
			lg: '992px',
			xl: '1200px',
			xxl: '1400px',
		},
		extend: {
			fontFamily: {
				sans: [ 'Figtree', ...defaultTheme.fontFamily.sans ],
			},
			keyframes: {
				'pulse-intense': {
					'0%, 100%': { opacity: 1 },
					'50%': { opacity: 0.2 },
				},
				'spin-grow': {
					'from': { transform: 'rotate(0) scale(1)' },
					'to': { transform: 'rotate(360deg) scale(3)' },
				},
			},
			animation: {
				'pulse-intense': 'pulse-intense 2s ease-in-out infinite',
				'spin-grow': 'spin-grow 3s ease-in-out infinite alternate',
			}
		},
	},

	plugins: [ require( '@tailwindcss/forms' ) ],
};
