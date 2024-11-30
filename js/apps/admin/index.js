import { createApp } from "vue";
import admin from "./views/Admin.vue";

window.mountadmin = (selector) => {
    createApp(admin).mount(selector);
};