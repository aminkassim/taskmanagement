import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/",
        component: () => import("./layouts/login.vue"),
    },
    {
        path: "/task",
        component: () => import("./layouts/tasklist.vue"),
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});