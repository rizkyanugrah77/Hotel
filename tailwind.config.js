import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                inter: ['Inter', ...defaultTheme.fontFamily.sans],
                poppins: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                background: '#ffffff',
                foreground: '#09090b',
                primary: '#A61B1B',
                accent: {
                    DEFAULT: '#D4AF37',
                    700: '#B5952F'
                }
            },
            backgroundImage: {
                'gradient-primary': 'linear-gradient(to right, #A61B1B, #E53E3E)',
                'gradient-accent': 'linear-gradient(to right, #D4AF37, #FDE047)',
                'gradient-hero': 'linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.7))',
            },
            boxShadow: {
                'soft': '0 4px 20px -2px rgba(0, 0, 0, 0.05)',
                'soft-xl': '0 20px 25px -5px rgba(0, 0, 0, 0.1)',
                'red': '0 4px 14px 0 rgba(166, 27, 27, 0.39)',
                'gold': '0 4px 14px 0 rgba(212, 175, 55, 0.39)',
            }
        },
    },

    plugins: [forms],
};
