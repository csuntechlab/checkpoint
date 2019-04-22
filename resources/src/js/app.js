// Base Imports
import Vue from 'vue';
import Vuelidate from 'vuelidate'
import router from './router';
import store from './store';
import checkpoint from './config';


// Vue file upload
const VueUploadComponent = require('vue-upload-component')
Vue.component('file-upload', VueUploadComponent)

//Axios
import axios from 'axios';
axios.defaults.baseURL = checkpoint.url;
axios.defaults.headers.common['X-CSRF-Token'] = checkpoint.token;

// Vuetify
import Vuetify from 'vuetify';
Vue.use(Vuetify);

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
