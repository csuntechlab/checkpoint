
require('./bootstrap');

//Packages
import Vue from "vue";
import axios from "axios";
import router from "./router";
import store from "./store";

//Components
import App from './App.vue';

//Base Urls
// axios.defaults.baseURL = url;
// axios.defaults.headers.common[''] = token;

const vm = new Vue({
    store,
    router,
    render: h => h(App),
});


export default vm;
