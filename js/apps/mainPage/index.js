import { createApp } from "vue";
import mainPage from "./views/MainPage.vue";

window.mountmainPage = (selector) => {
    createApp(mainPage).mount(selector);
};
