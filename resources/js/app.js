import Vue from 'vue';
import VueRouter from 'vue-router';
import axios from 'axios';
import VueAxios from 'vue-axios';
import VueTruncate from 'vue-truncate-filter';
import App from './App.vue';
import Home from './views/Home.vue';
import Register from './views/Register.vue';
import Login from './views/Login.vue';
import List from "./views/List";
import Search from "./views/Search";
import Details from "./views/Details";

Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.use(VueTruncate);

axios.defaults.baseURL = '/api';

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/register',
            name: 'register',
            component: Register,
            meta: {
                auth: false
            }
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
            meta: {
                auth: false
            }
        },
        {
            path: '/list',
            name: 'list',
            component: List,
            meta: {
                auth: true
            }
        },
        {
            path: '/details/:id/:bookType',
            name: 'details',
            component: Details,
            meta: {
                auth: true
            }
        },
        {
            path: '/search',
            name: 'search',
            component: Search,
            meta: {
                auth: true
            }
        }
    ]
});

Vue.router = router;

Vue.use(require('@websanova/vue-auth'), {
  auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
  http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
  router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
});

//App.router = Vue.router

//new Vue(App).$mount('#app');
const app = new Vue({
    el: '#app',
    components: { App },
    router,
});
