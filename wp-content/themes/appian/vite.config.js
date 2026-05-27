import { defineConfig } from "vite";
import { globSync } from "glob";
import path from "path";

const moduleCssFiles = globSync("resources/styles/modules/**/*.scss", {
  ignore: "resources/styles/modules/styleguide.scss",
});
const moduleJsFiles = globSync("resources/scripts/modules/**/*.js");

export default defineConfig({
  base: "/wp-content/themes/appian/public/",
  publicDir: false,

  server: {
    cors: true,
    headers: {
      "Access-Control-Allow-Origin": "*",
    },
    host: "localhost",
    port: 5173,
  },

  resolve: {
    alias: {
      "@scripts": path.resolve(__dirname, "./resources/scripts"),
      "@styles": path.resolve(__dirname, "./resources/styles"),
      "@images": path.resolve(__dirname, "./resources/images"),
      "@fonts": path.resolve(__dirname, "./resources/fonts"),
    },
  },

  css: {
    preprocessorOptions: {
      scss: {
        quietDeps: true,
      },
    },
  },

  build: {
    manifest: true,
    outDir: "public",
    emptyOutDir: true,
    rollupOptions: {
      input: [
        "resources/styles/app.scss",
        "resources/styles/editor.scss",
        "resources/scripts/app.js",
        "resources/scripts/editor.js",
        ...moduleCssFiles,
        ...moduleJsFiles,
      ],
      output: {
        manualChunks(id) {
          if (id.includes("node_modules/")) {
            const directories = id.split("node_modules/")[1].split("/");
            const name = directories[0].startsWith("@")
              ? `${directories[0]}/${directories[1]}`
              : directories[0];
            return `vendor/${name}`;
          }
          if (id.includes("resources/scripts/shared/")) {
            return "shared";
          }
        },
      },
    },
  },
});