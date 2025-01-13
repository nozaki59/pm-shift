import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
    server: {
        //ローカル環境では不要
        // https: true,
    },
    build: {
        manifest: 'manifest.json',
        rollupOptions: {
            input: {
                appCss: 'resources/css/app.css',
                app: 'resources/js/app.js',
                indexCss: 'resources/css/index.css',
                index: 'resources/js/index.js',
            }
        }
    }
});
