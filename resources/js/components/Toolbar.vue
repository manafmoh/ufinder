<template>
    <v-toolbar>
    <!-- <v-toolbar-side-icon></v-toolbar-side-icon> -->
    <v-toolbar-title>uFinder</v-toolbar-title>
    <v-spacer></v-spacer>
    <app-notification></app-notification>
    <div class="hidden-sm-and-down">
    <router-link
        v-for="item in items.filter(item => item.show)"
        :key="item.title"
        :to="item.to" >
        <v-btn flat>{{item.title}}</v-btn>
    </router-link>
    <LoginPopup />
    </div>
  </v-toolbar>
</template>

<script>
import AppNotification from './AppNotification';
import LoginPopup from './LoginPopup';
export default {
    components: {AppNotification, LoginPopup},
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

