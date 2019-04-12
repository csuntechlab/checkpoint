// Base Imports
import Vue from 'vue';
import router from './router';
import store from './store';
import checkpoint from './config';


//Axios
import axios from 'axios';
axios.defaults.baseURL = checkpoint.url;
axios.defaults.headers.common[''] = checkpoint.token;
// Vuetify
import Vuetify from 'vuetify';
Vue.use(Vuetify);

//Components
import App from './App.vue';

const vm = new Vue({
    el: '#app',
    store,
    router,
    axios,
    render: h => h(App),
});

export default vm;
