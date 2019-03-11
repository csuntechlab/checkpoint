
require('./bootstrap');

//Packages
import Vue from "vue";
import axios from "axios";
import router from "./router";
import store from "./store";

// Vuetify
import Vuetify from 'vuetify'
Vue.use(Vuetify)
// index.js or main.js
import 'vuetify/dist/vuetify.min.css' // Ensure you are using css-loader

//Components
import App from './App.vue';

//Base Urls
// axios.defaults.baseURL = url;
// axios.defaults.headers.common[''] = token;

const vm = new Vue({
    el: '#app',
    store,
    router,
    axios,
    render: h => h(App),
});


export default vm;
