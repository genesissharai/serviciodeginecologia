import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/vendor/fontawesome-free/css/all.min.css',
                'resources/scss/sb-admin-2.scss',
                'resources/img/undraw_profile_1.svg',
                'resources/img/undraw_profile_2.svg',
                'resources/img/undraw_profile_3.svg',
                'resources/img/undraw_posting_photo.svg',
                'resources/img/undraw_profile.svg',
                'resources/img/undraw_rocker.svg',
                "resources/img/logo-hospital-raul-leoni.jpg",
                "resources/img/foto-hospital-raul-leoni-1.jpg",
                "resources/img/foto-hospital-raul-leoni-2.jpeg",
                "resources/img/foto-hospital-raul-leoni-3.jpeg",
                "resources/img/foto-hospital-raul-leoni-4.jpeg",
                "resources/img/foto-hospital-raul-leoni-5.jpeg",
                "resources/img/foto-hospital-raul-leoni-6.jpeg",
                "resources/img/foto-hospital-raul-leoni-7.jpeg",
                "resources/img/foto-hospital-raul-leoni-8.jpeg",
                'resources/vendor/jquery/jquery.min.js',
                'resources/vendor/jquery-easing/jquery.easing.min.js',
                'resources/vendor/bootstrap/js/bootstrap.bundle.min.js',
                'resources/js/sb-admin-2.min.js',
            ],
            refresh: true,
        }),
    ],
});
