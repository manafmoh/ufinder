<template>
<div>
    <v-toolbar>
    <!-- <v-toolbar-side-icon></v-toolbar-side-icon> -->
    <v-toolbar-title>
        <router-link to="/" class="toolbar-title"><v-img alt="uFinder" :src="`/images/logo.png`" width="138" height="53" /></router-link>
    </v-toolbar-title>
     <template v-slot:extension >
      <v-toolbar-title class="flex white--text">
          <v-layout row wrap>
                <v-flex xs3 sm3 >
                 <CategoryMenu class="text-sm-left" />
                </v-flex>
          <v-flex xs6 sm9>
              <v-form @keyup.native.enter="submit">
                <v-text-field prepend-icon="search" class="text-sm-right"
                v-model="search" v-on:keyup="getSearchData"
                solo append-icon="cancel" hide-details single-line></v-text-field>
               <div class="panel-footer" v-if="results.length"><ul class="list-group"><li class="list-group-item" v-for="result in results">@{{ result.category_name }}</li></ul></div>
                   
              </v-form>
          </v-flex>
          </v-layout>
      </v-toolbar-title>
    </template>

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
            search: '',
            results: [],
            items: [
                {title: 'All Ads', to: '/ads', show:true},
                {title: 'Free Post', to: '/post', show:User.loggedIn()},
                {title: 'Category', to: '/category', show:User.isAdmin()},
                // {title: 'Login', to: '/login', show:!User.loggedIn()},
                // {title: 'Logout', to: '/logout', show:User.loggedIn()}
            ]
        }
    },
    created() {
        EventBus.$on('logout', ()=>{
            User.loggedOut();
        });
    },
    methods: {
        getSearchData(){
        this.results = [];
        if(this.search.length > 0){
         axios.get('api/search',{params: {search: this.search}}).then(response => {
          this.results = response.data; //console.log(this.results);
         });
        }
       }
      },
}
</script>

<style>

</style>

