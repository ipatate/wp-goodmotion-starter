import { defineConfig } from 'vite'
import liveReload from 'vite-plugin-live-reload'
const { resolve } = require('path')

// https://vitejs.dev/config/
export default defineConfig({
    plugins: [
        liveReload([__dirname+'/**/*.php', __dirname+'/**/*.twig'])
    ],
    root: '',
    build: {
        // output dir for production build
        outDir: resolve(__dirname, 'dist'),
        emptyOutDir: true,
        manifest: true,
        target: 'es5',
        rollupOptions: {
            input: resolve(__dirname, 'main.js'),
        }
    },
    server: {
        cors: true,
        strictPort: true,
        port: 3000,
        https: false,
        hmr: {
            host: 'localhost',
        },
    },
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js'
        }
    }
})
