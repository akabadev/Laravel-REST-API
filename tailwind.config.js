const colors = require("tailwindcss/colors")

module.exports = {
    purge: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    darkMode: 'class', // falsewebpack.mix.js or 'media' or 'class'
    theme: {
        extend: {
            colors: {
                ...colors,
                up: {
                    DEFAULT: "f59100"
                }
            },

        },
    },
    variants: {
        extend: {},
    },
    plugins: [
        require('@tailwindcss/typography')
    ],
}
