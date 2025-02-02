import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/flatpickr.js',
            ],
            refresh: true,
            publicDirectory: 'public',
        }),
    ],
    server: {
        host: '0.0.0.0',
        port: 5173,
        https: false,
        hmr: {
            host: 'localhost',
            protocol: 'ws',
        },
        watch: {
            usePolling: true,
        },
    },
    build: {
        manifest: 'manifest.json',
        outDir: 'public/build',
        assetsDir: '',
        rollupOptions: {
            output: {
                manualChunks: undefined
            }
        }
    },
});
