import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.jsx'
            ],
            // Tells Vite to watch and refresh when module files change
            refresh: [
                'resources/routes/**',
                'routes/**',
                'Modules/Module4/resources/views/**',
                'Modules/Module4/resources/assets/js/**',
            ],
        }),
        react(),
    ],
    // FIXED: Forces Vite to tie hot-reloading straight to your 127.0.0.1 loopback address
    // This stops the browser from mixing IPv6 [::1] paths with IPv4 origins, fixing the CORS errors.
    server: {
        host: '127.0.0.1',
        hmr: {
            host: '127.0.0.1',
        },
    },
});