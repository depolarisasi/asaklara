import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                heading: ['Space Grotesk', ...defaultTheme.fontFamily.sans],
                body: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // ASAK Agency brand colors via CSS variables
                asak: {
                    gold: 'var(--color-asak-gold)',
                    'gold-hover': 'var(--color-asak-gold-hover)',
                    'gold-muted': 'var(--color-asak-gold-muted)',
                },
                admin: {
                    bg: 'var(--admin-bg)',
                    sidebar: 'var(--admin-sidebar)',
                    card: 'var(--admin-card)',
                    border: 'var(--admin-border)',
                    'border-muted': 'var(--admin-border-muted)',
                    text: 'var(--admin-text)',
                    'text-muted': 'var(--admin-text-muted)',
                    'text-dim': 'var(--admin-text-dim)',
                },
                primary: {
                    DEFAULT: 'rgb(var(--color-primary) / <alpha-value>)',
                    foreground: 'rgb(var(--color-primary-foreground) / <alpha-value>)',
                },
                background: 'rgb(var(--color-background) / <alpha-value>)',
                foreground: 'rgb(var(--color-foreground) / <alpha-value>)',
                muted: {
                    DEFAULT: 'rgb(var(--color-muted) / <alpha-value>)',
                    foreground: 'rgb(var(--color-muted-foreground) / <alpha-value>)',
                },
                border: 'rgb(var(--color-border) / <alpha-value>)',
                card: 'rgb(var(--color-card) / <alpha-value>)',
            },
            borderRadius: {
                '2xl': '1rem',
                '3xl': '1.5rem',
            },
        },
    },

    plugins: [forms],
};
