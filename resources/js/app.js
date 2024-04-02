import "./bootstrap";
import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import Heading from "./components/Heading.vue";
import MainContent from "./components/MainContent.vue";

const app = createApp(App);

app.component("Heading", Heading);
app.component("MainContent", MainContent);
app.use(router).mount("#app");
