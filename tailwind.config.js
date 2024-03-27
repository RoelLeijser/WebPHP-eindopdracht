import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
const colors = require('tailwindcss/colors');

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
            },
            colors: {
                transparent: 'transparent',
                current: 'currentColor',
                green: colors.green,
                blue: colors.blue,
                teal: colors.teal,
                red: {
                    300: '#fca5a5',
                    500: '#ef4444',
    
                },
                gray: colors.gray,
                indigo: colors.indigo,
                white: colors.white,
            },
        },
    },

    plugins: [forms],
};
