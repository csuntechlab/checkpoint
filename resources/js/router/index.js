import Vue from 'vue';
import VueRouter from 'vue-router';
import store from '../store';

import SignUp from '../views/SignUp.vue'


// INIT VUE-ROUTER
Vue.use(VueRouter);

// ROUTER MAP
const router = new VueRouter({
  routes: [
    {
      path: '/signup',
      component: SignUp,
      name: 'SignUp'
    }
  ],
});

export default router;