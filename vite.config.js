import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/new/app.css',
                'resources/css/guest.css',
                'resources/js/app.js',
                'resources/css/custom.css',
                'resources/css/icons.css',
                'resources/js/app.js',
                'resources/js/jquery.min.js',
                'resources/js/preline.js',
                'resources/js/simplebar.min.js',
                'resources/js/iconify-icon.min.js',
                'resources/js/quill.min.js',
            ],
            refresh: true,
        }),
    ],
});
