import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
        {
            name: 'copy-tinymce',
            writeBundle() {
                const fs = require('fs');
                const path = require('path');

                const source = path.resolve(__dirname, 'vendor/tinymce/tinymce');
                const destination = path.resolve(__dirname, 'public/js/tinymce');

                // Create directory if it doesn't exist
                if (!fs.existsSync(destination)) {
                    fs.mkdirSync(destination, { recursive: true });
                }

                // Copy files
                fs.cpSync(source, destination, { recursive: true });
            }
        }
    ],
    server: {
        cors: true,
    },

});