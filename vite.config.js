import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';
import react from '@vitejs/plugin-react';
import { fileURLToPath, URL } from 'node:url';

const ignoredWatchPaths = [
    /(^|[/\\])public([/\\]|$)/,
    /(^|[/\\])storage[/\\]framework[/\\]views([/\\]|$)/,
];

function vendorChunk(id) {
    if (!id.includes('node_modules')) {
        return undefined;
    }

    if (id.includes('react') || id.includes('react-dom') || id.includes('react-router-dom')) {
        return 'react';
    }

    if (id.includes('@tanstack/react-query')) {
        return 'query';
    }

    if (id.includes('react-hook-form') || id.includes('@hookform/resolvers') || id.includes('zod')) {
        return 'forms';
    }

    if (id.includes('framer-motion')) {
        return 'motion';
    }

    if (id.includes('lucide-react')) {
        return 'icons';
    }

    if (id.includes('zustand')) {
        return 'state';
    }

    return 'vendor';
}

export default defineConfig({
    publicDir: false,
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/main.tsx'],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        react(),
        tailwindcss(),
    ],
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('./resources/js', import.meta.url)),
        },
    },
    build: {
        chunkSizeWarningLimit: 900,
        rollupOptions: {
            output: {
                manualChunks: vendorChunk,
            },
        },
    },
    server: {
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,
        hmr: {
            host: '192.168.1.116',
            protocol: 'ws',
            port: 5173,
        },
        watch: {
            usePolling: true,
            interval: 300,
            followSymlinks: false,
            ignored: ignoredWatchPaths,
        },
    },
});
