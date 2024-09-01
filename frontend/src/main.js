import { createApp } from "vue";
// Import custom CSS
import "./scss/style.scss";
// Import Bootstrap's JS
import * as bootstrap from "bootstrap";
// Import App
import App from "./App.vue";
// Import router
import router from "./router/router";
// Import Pinia
import { createPinia } from 'pinia';

createApp(App).use(router).use(createPinia()).mount("#app");
