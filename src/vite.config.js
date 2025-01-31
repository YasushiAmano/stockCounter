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
    }
});
