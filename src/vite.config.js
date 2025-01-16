import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0',
        hmr: {
            host: 'localhost',
            protocol: 'ws'  // WebSocketプロトコルを明示的に指定
        },
        watch: {
            usePolling: true  // ファイル変更の検知を確実にする
        },
        port: 5173,  // ポートを明示的に指定
    },
});
