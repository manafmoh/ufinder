import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
import Login from '../components/login/Login.vue';
import Signup from '../components/login/Signup.vue';
import Logout from '../components/logout/Logout';
import Ads from '../components/ads/Ads';
import AdSingle from '../components/ads/Single';
import AdCreate  from '../components/ads/create.vue';
import CreateCategory from '../components/category/CreateCategory.vue';
import CreateSubcategory from '../components/category/CreateSubcategory.vue';
import CreateState from '../components/place/CreateState.vue';
import CreateDistrict from '../components/place/CreateDistrict.vue';
import CreatePlace from '../components/place/CreatePlace.vue';

const routes = [
    { path: '/', component: Ads, name:'ads' },
    { path: '/login', component: Login },
    { path: '/signup', component: Signup },
    { path: '/logout', component: Logout },
    { path: '/ads', component: Ads, name:'ads' },
    { path: '/ad/:slug', component: AdSingle},
    { path: '/c/:slug', component: Ads },
    { path: '/sc/:slug', component: Ads},
    { path: '/post', component: AdCreate},
    { path: '/category', component: CreateCategory},
    { path: '/category/:slug/subcategory', component: CreateSubcategory},
    { path: '/state', component: CreateState},
    { path: '/state/:slug/district', component: CreateDistrict},
    { path: '/area/:state/:district', component: CreatePlace},
  ]

const router = new VueRouter({
    routes, // short for `routes: routes`,
    hashbang: false,
    mode: 'history'

})

export default router;
