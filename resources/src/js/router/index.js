import Vue from 'vue';
import VueRouter from 'vue-router';
import store from '../store';

import signup from './views/signup/index.vue'
import admin from './views/admin/index.vue'
import login from './views/login/index.vue'
import programs from './views/programs/index.vue'
import mentors from './views/mentors/index.vue'
import scholars from './views/scholars/index.vue'

// INIT VUE-ROUTER
Vue.use(VueRouter);

// ROUTER MAP
const router = new VueRouter({
  routes: [
    {
        path: '/',
        redirect: '/login'
    },
    {
      path: '/signup',
      component: signup,
      name: 'signup'
    },
    {
      path: '/admin',
      component: admin,
      name: 'admin'
    },
    {
      path: '/login',
      component: login,
      name: 'login'
    },
    {
        path: '/programs',
        component: programs,
        name: 'programs'
    },
    {
        path: '/mentors',
        component: mentors,
        name: 'mentors'
    },
    {
        path: '/scholars',
        component: scholars,
        name: 'scholars'
    },
  ],
});

// router.beforeEach(() => {
//     if(!store.state.User.sessionActive) {
//         router.push('/login');
//     }
// });

export default router;
