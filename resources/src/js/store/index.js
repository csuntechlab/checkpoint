import Vue from 'vue';
import Vuex from 'vuex';

import Mentor from './modules/mentor';
import Organization from './modules/organization';
import Student from './modules/student';
import User from './modules/user';


//INIT VUEX
Vue.use(Vuex)


export default new Vuex.Store({
    modules: {
        Mentor,
        Organization,
        Student,
        User
    }
});
