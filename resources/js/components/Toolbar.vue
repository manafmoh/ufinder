<template>
<div>
    <v-toolbar>
    <!-- <v-toolbar-side-icon></v-toolbar-side-icon> -->
    <v-toolbar-title>
        <router-link to="/" class="toolbar-title"><v-img alt="uFinder" :src="`images/logo.png`" width="138" height="53" /></router-link>
    </v-toolbar-title>
    <v-spacer></v-spacer>
    <app-notification></app-notification>
    <div class="hidden-sm-and-down">
    <router-link color="white" class="noline"
        v-for="item in items.filter(item => item.show)"
        :key="item.title"
        :to="item.to" >
        <v-btn outline color="indigo">{{item.title}}</v-btn>
    </router-link>
    <LoginPopup />
    </div>
    </v-toolbar>
    <!--
    <v-expansion-panel>
        <v-expansion-panel-content >
        <div slot='header'><h6>Headline</h6></div>
        <div>
            Coming soon
        </div>
        </v-expansion-panel-content>
    </v-expansion-panel>-->
    <CategoryMenu class="text-sm-left" />
</div>
</template>

<script>
import AppNotification from './AppNotification';
import LoginPopup from './LoginPopup';
import CategoryMenu from './category/CategoryMenu'
export default {
    components: {AppNotification, LoginPopup, CategoryMenu},
    data(){
        return {
            items: [
                {title: 'All Ads', to: '/ads', show:true},
                {title: 'Free Post', to: '/post', show:User.loggedIn()},
                {title: 'Category', to: '/category', show:User.isAdmin()},
                {title: 'Login', to: '/login', show:!User.loggedIn()},
                {title: 'Logout', to: '/logout', show:User.loggedIn()}
            ]
        }
    },
    created() {
        EventBus.$on('logout', ()=>{
            User.loggedOut();
        });
    }
}
</script>

<style>

</style>

