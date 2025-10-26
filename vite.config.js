import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import path from 'path';

// ✅ Use ESM-friendly dynamic import for fs
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
        {
            name: 'copy-tinymce',
            // only run on build
            apply: 'build',
            async writeBundle() {
                // Import fs dynamically so Vite doesn’t try to bundle it
                const fs = await import('fs');

                const source = path.resolve('vendor/tinymce/tinymce');
                const destination = path.resolve('public/js/tinymce');

                // Create directory if it doesn't exist
                if (!fs.existsSync(destination)) {
                    fs.mkdirSync(destination, { recursive: true });
                }

                // Copy TinyMCE assets
                fs.cpSync(source, destination, { recursive: true });
                console.log('✅ TinyMCE copied successfully.');
            },
        },
    ],
    server: {
        cors: true,
    },
});
