import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/css/app.css',
                'resources/css/contact.css',
                'resources/css/politiques.css',
                'resources/css/comments.css',
                'resources/css/catalogue.css',
                'resources/css/pasapas.css',
                'resources/css/cart.css',
                'resources/css/gammes.css',
                'resources/css/backoffice.css',
                'resources/css/connection.css',
                'resources/css/edit.css',
            ],
            refresh: true,
        }),
    ],
});
