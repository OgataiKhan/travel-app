import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [vue()],
  build: {
    rollupOptions: {
      // Specify modules that should be treated as external
      external: [
        '@tomtom-international/web-sdk-maps',
        '@tomtom-international/web-sdk-services',
        '@tomtom-international/web-sdk-plugin-searchbox'
      ],
    },
  },
})
