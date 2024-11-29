import { createApp } from "vue";
import MainPage from "./views/MainPage.vue";

window.mountMainPage = (selector) => {
    createApp(MainPage).mount(selector);
};
