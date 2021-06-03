import { defineConfig } from "vite";
import liveReload from "vite-plugin-live-reload";
const { resolve, dirname, sep } = require("path");

// find theme dir name
const _path = process.cwd().split(sep);
const themeDir = _path[_path.length - 1];

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [liveReload([__dirname + "/**/*.php", __dirname + "/**/*.twig"])],
  base: `/wp-content/themes/${themeDir}/dist/`,
  root: "",
  build: {
    // output dir for production build
    outDir: resolve(__dirname, "dist"),
    emptyOutDir: true,
    manifest: true,
    target: "es5",
    rollupOptions: {
      input: resolve(__dirname, "main.js"),
    },
  },
  server: {
    cors: true,
    strictPort: true,
    port: 3000,
    https: false,
    hmr: {
      host: "localhost",
    },
  },
  resolve: {
    alias: {
      vue: "vue/dist/vue.esm-bundler.js",
    },
  },
});
