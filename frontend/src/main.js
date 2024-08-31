import { createApp } from "vue";
// Import custom CSS
import "./scss/style.scss";
// Import Bootstrap's JS
import * as bootstrap from "bootstrap";
// Import Pinia
import { createPinia } from 'pinia';
// Import App
import App from "./App.vue";
// Import router
import router from "./router/router";

createApp(App).use(createPinia()).use(router).mount("#app");
