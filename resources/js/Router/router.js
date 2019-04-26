import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
import Login from '../components/login/Login.vue';
import Signup from '../components/login/Signup.vue';
import Logout from '../components/logout/Logout';
import Ads from '../components/ads/Ads';


const routes = [
    { path: '/login', component: Login },
    { path: '/signup', component: Signup },
    { path: '/logout', component: Logout },
    { path: '/ads', component: Ads, name:'ads' },
  ]

const router = new VueRouter({
    routes, // short for `routes: routes`,
    hashbang: false,
    mode: 'history'

})

export default router;
