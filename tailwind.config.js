import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './**/*.html',
        './**/*.js',
        './**/*.php', // Sesuaikan dengan jenis file yang digunakan dalam proyek Anda
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            animation: {
                zoomIn: 'zoomIn 0.5s ease-in-out',
                fadeIn: 'fadeIn 1s ease-in-out',
                scrollText: 'scrollText 15s linear infinite', // Adjust duration if needed
            },
            keyframes: {
                scrollText: {
                    '0%': { left: '100%' },
                    '100%': { left: '-70%' },
                },
            },
            clipPath: {
                polygon: 'polygon(0 0, 100% 0, 0 100%)',
            },
            fontSize: {
                'xxs': '10px', // Add a new 'xxs' size
              },
        },
    },

    plugins: [forms],
};
