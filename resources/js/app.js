import "./bootstrap";
import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import vuetify from "./vuetify";
import 'vuetify/dist/vuetify.min.css';

createApp(App).use(vuetify).use(router).mount("#app");