// Base Imports
import Vue from 'vue';
import Vuelidate from 'vuelidate'
import router from './router';
import store from './store';
import checkpoint from './config';


//Axios
import axios from 'axios';
axios.defaults.baseURL = checkpoint.url;
axios.defaults.headers.common['X-CSRF-Token'] = checkpoint.token;

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

// Vuelidate
Vue.use(Vuelidate)

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
