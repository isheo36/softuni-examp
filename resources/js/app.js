require('./bootstrap');
import Vue from 'vue'
import VueRouter from 'vue-router'
import store from './store'

//import BootstrapVue from 'bootstrap-vue' //Importing  
//Vue.use(BootstrapVue) // Telling Vue to use this in whole application

Vue.use(VueRouter)

import App from './views/App'
import Hello from './views/Hello'
import Patients from './views/Patients'
import UsersIndex from './views/UsersIndex'
import UsersEdit from './views/UsersEdit'
import AddReport from './views/AddReport'
import Login from './views/Login'
import Logout from './views/Logout'
import Register from './views/Register'

Vue.component('pagination', require('laravel-vue-pagination'));

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/addreport',
            name: 'addreport',
            component: AddReport
        },
        {
            path: '/',
            name: 'patients',
            component: Patients
        },
        {
            path: '/hello',
            name: 'hello',
            component: Hello,
        },
        {
            path: '/users',
            name: 'users.index',
            component: UsersIndex,
        },
        {
            path: '/users/:id/edit',
            name: 'users.edit',
            component: UsersEdit,
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
        },
        {
            path: '/logout',
            name: 'logout',
            component: Logout,
        },
        {
            path: '/register',
            name: 'register',
            component: Register,
        },
    ],
});

router.beforeEach((to, from, next) => {
    // redirect to login page if not logged in and trying to access a restricted page
    const publicPages = ['/login','/register'];
    const authRequired = !publicPages.includes(to.path);
    const loggedIn = localStorage.getItem('token');
  
    if (authRequired && !loggedIn) {
      return next('/login');
    }
  
    next();
  })

const app = new Vue({
    el: '#app',
    store,
    components: { App },
    router,
});
