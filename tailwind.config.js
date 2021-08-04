const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors')

module.exports = {
    presets: [
            require('./vendor/ph7jack/wireui/tailwind.config.js')
    ],
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './vendor/ph7jack/wireui/resources/**/*.blade.php',
        './vendor/ph7jack/wireui/ts/**/*.ts',
        './vendor/ph7jack/wireui/src/View/**/*.php'
    ],

    theme: {
        extend: {
            colors: {
                primary: colors.indigo,
                secondary: colors.gray,
                positive: colors.emerald,
                negative: colors.red,
                warning: colors.amber,
                info: colors.blue
            },
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
