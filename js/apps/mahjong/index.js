import { createApp } from "vue";
import mahjong from "./views/GameBoard.vue";

window.mountmahjong = (selector) => {
    createApp(mahjong).mount(selector);
};