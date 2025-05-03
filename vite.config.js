import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/ts/app.ts', 'resources/css/app.css'],
            refresh: true,
        }),
    ],
});