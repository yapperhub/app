import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: ['./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php', './storage/framework/views/*.php', './resources/views/**/*.blade.php'],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        }, colors: {
            ...defaultTheme.colors,
            primary: {
                50: "#A7C6DA",
                100: "#95BACF",
                200: "#6E9DB7",
                300: "#477F9F",
                400: "#205287",
                500: "#00356E",
                600: "#002F63",
                700: "#002657",
                800: "#001F4C",
                900: "#001941",
            },
            secondary: {
                50: "#F9F5F7",
                100: "#F2EBEF",
                200: "#E0D2DB",
                300: "#CEB9C7",
                400: "#AB859F",
                500: "#885176",
                600: "#7A4769",
                700: "#6C3C5C",
                800: "#5E324F",
                900: "#512744",
            },

        }
    },

    plugins: [forms],
};
