import "./bootstrap";
import Vue from "vue";
import ArticleLike from "./components/ArticleLike";
import ArticleTagsInput from "./components/ArticleTagsInput";
import FollowButton from "./components/FollowButton";
import PreviewImage from "./components/PreviewImage";
// import Components from "laravel-mix/src/comonents/Components";

window.Vue = require("vue").default;
Vue.component(
    "example-component",
    require("./components/ExampleComponent.vue").default
);

const app = new Vue({
    el: "#app",
    components: {
        ArticleLike,
        ArticleTagsInput,
        FollowButton,
        PreviewImage
    }
});
