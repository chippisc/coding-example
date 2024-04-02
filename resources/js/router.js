import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/",
        component: () => import("./pages/Users.vue"),
    },
    {
        path: "/user/:userId",
        name: "showUser",
        component: () => import("./pages/ShowUser.vue"),
        props: true,
    },
    {
        path: "/users",
        component: () => import("./pages/UsersInfiniteScroll.vue"),
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
