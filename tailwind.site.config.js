const defaultTheme = require( 'tailwindcss/defaultTheme' );

/** @type {import('tailwindcss').Config} */
module.exports = {
	content: [
		'./resources/views/layout/*.blade.php',
		'./resources/views/components/*.blade.php',
		'./resources/views/index.blade.php',
		'./resources/views/vendor/**/*.blade.php',
	],

	theme: {
		container: {
			center: true,
		},
		screens: {
			sm: '576px',
			md: '768px',
			lg: '992px',
			xl: '1170px',
		},
		fontSize: {
			xs: '0.625rem', // 10px
			sm: '0.75rem', // 12px
			lg: [ '1.0625rem', '1.47em' ], // 17px
			xl: [ '1.125rem', '1.47em' ], // 18px
			'2xl': [ '1.25rem', '1em' ], // 20px
		},
		boxShadow: {
			'xs': '0 1px 11px rgb(0 0 0 / 6%)',
			'sm': '0 3px 6px rgb(0 0 0 / 16%)',
			'lg': '0 15px 33px rgb(0 0 0 / 5%)',
			'xl': '0 20px 50px rgb(0 0 0 / 20%)',
		},
		extend: {
			colors: {
				'body-bg': '#fafafc',
				'body': '#656F7E',
				'heading': '#1E2227',
				'border': 'rgb(0 0 0 / 6%)',
				'box-icon-bg': '#F2F2F2',
			},
			keyframes: {
				'pulse-intense': {
					'0%, 100%': { opacity: 1, transform: 'scale(1)' },
					'50%': { opacity: 0.5, transform: 'scale(0.75)' },
				},
				'hue-rotate': {
					'0%': { filter: 'hue-rotate(0deg)' },
					'100%': { filter: 'hue-rotate(360deg)' },
				},
			},
			animation: {
				'pulse-intense': 'pulse-intense 2s ease-in-out infinite',
				'hue-rotate': 'hue-rotate 1.9s linear infinite',
			},
			opacity: {
				15: '0.15'
			},
			backgroundOpacity: {
				15: '0.15'
			},
			borderOpacity: {
				15: '0.15'
			},
			fontFamily: {
				oneset: [ 'Oneset', 'sans-serif' ],
				golos: [ '"Golos Text"', 'sans-serif' ],
			},
		},
	},

	plugins: [],
};
