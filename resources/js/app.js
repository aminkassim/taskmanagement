// import "./bootstrap";
// import { createApp } from "vue";
// import App from "./src/App.vue";
// import router from "./src/router";

// import Vue from 'vue';
// import Vuetify from 'vuetify';
// import 'vuetify/dist/vuetify.min.css';

// Vue.use(Vuetify);

// const app = new Vue({
 
//   // ...other options like router, store, render, etc.
// }).$mount('#app');

// // createApp(App).use(router).mount("#app");
import "./bootstrap";
import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import vuetify from "./vuetify";
import 'vuetify/dist/vuetify.min.css';

createApp(App).use(vuetify).use(router).mount("#app");