/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./app/View/Components/**/*.php",
        "./app/Livewire/**/*.php",
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        // Mary UI
        "./vendor/robsontenorio/mary/src/View/Components/**/*.php",
    ],
    theme: {
        extend: {},
    },
    plugins: [require("daisyui")],
};
