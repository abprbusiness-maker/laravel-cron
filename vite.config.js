import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            server: {
                https: true, // pastiin kalo dev server HTTPS
                host: '0.0.0.0',
                hmr: {
                    host: 'laravel-cron.zeabur.app',
                },
            },
        }),
        tailwindcss(),
    ],
});
