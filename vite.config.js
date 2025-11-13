import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/old_app.css', 'resources/js/old_app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
