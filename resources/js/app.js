import "./bootstrap";
import { createApp } from "vue";
import Users from "../components/Users.vue";
import { ZiggyVue } from "ziggy-js";

const app = createApp();

app.component("users", Users);
app.use(ZiggyVue);
app.mount("#app");
