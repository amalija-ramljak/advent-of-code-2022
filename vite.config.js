import { defineConfig } from "vite";
import symfonyPlugin from "vite-plugin-symfony";

export default defineConfig({
  plugins: [
    symfonyPlugin(),
  ],
  build: {
    rollupOptions: {
      input: {
        app: "./assets/js/app.js",
        day: "./assets/js/day.js",
      },
    },
  },
});
