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
            },
            colors: {
                'custom-dark-bg': '#2A2E3C',      // Main form/editor background
                'custom-dark-toolbar': '#323846', // Toolbar background
                'custom-dark-text': '#CBD5E1',    // Like slate-300
                'custom-dark-icon': '#94A3B8',   // Like slate-400
                'custom-accent': '#6366F1',      // Like indigo-500 or your purple
                'custom-accent-hover': '#4F46E5',// Like indigo-600
            }
        },
    },

    plugins: [
        require('@tailwindcss/forms'), // Optional: for better default form styling
        require('@tailwindcss/typography'), // Optional: for the 'prose' class
        require('@tailwindcss/aspect-ratio'), // Optional: if you use aspect ratio classes
    ],
};
