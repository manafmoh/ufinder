<template>
<div>
    <v-toolbar :class="{'toolbar-height-inc': $vuetify.breakpoint.xsOnly}">
    <!-- <v-toolbar-side-icon></v-toolbar-side-icon> -->
    <v-toolbar-title>
        <router-link to="/" class="toolbar-title"><v-img alt="uFinder" :src="`/images/logo.png`" width="138" height="53" /></router-link>
    </v-toolbar-title>
     <template v-slot:extension >
      <v-toolbar-title class="flex white--text" :class="{'removemargin-left': $vuetify.breakpoint.xsOnly}">
        <v-layout row wrap>
        <v-expansion-panel
        v-model="panel"
        expand
        xs12 sm12
        class="panel"
        >
      <v-expansion-panel-content >
        <template v-slot:header>
          <!--<div>Item</div>-->
        </template>
        <v-layout  row wrap justify-left>
             <v-flex class="text-xs-left" xs2 sm2  :class="{'toolbar-linebreak': $vuetify.breakpoint.xsOnly}">
                <CategoryMenu  />
            </v-flex>
         <v-flex xs4 sm4 :class="{'toolbar-linebreak': $vuetify.breakpoint.xsOnly}">
                 <v-autocomplete
                :items="places"
                v-model="placesmodel"
                item-text="place"
                item-value="placeSlug"
                label="Area.."
                :search-input.sync="placessearch"
                @change="onPlaceClick">
                </v-autocomplete>
          </v-flex>
          <v-flex xs6 sm6 class="pl-5" :class="{'toolbar-linebreak': $vuetify.breakpoint.xsOnly}">
                 <v-combobox
                 prepend-icon="search"
                 append-icon="cancel"
                :items="results"
                v-model="model"
                item-text="name"
                item-value="name"
                label="Search..."
                :search-input.sync="search"
                @change="onSearchClick">
                </v-combobox>
          </v-flex>
        </v-layout>
      </v-expansion-panel-content>
    </v-expansion-panel>
          </v-layout>
      </v-toolbar-title>
    </template>

    <v-spacer></v-spacer>
    <app-notification></app-notification>
    <router-link color="white" class="noline"
        key="addpost"
        :to="postlink" >
        <v-btn color="error" dark >Place Your Ad</v-btn>
    </router-link>
    <LoginPopup />
    <div class="hidden-sm-and-down">
    <router-link color="white" class="noline"
        v-for="item in items.filter(item => item.show)"
        :key="item.title"
        :to="item.to" >
        <v-btn outline color="indigo">{{item.title}}</v-btn>
    </router-link>

    </div>
    <v-menu class="hidden-md-and-up">
        <v-toolbar-side-icon slot="activator"></v-toolbar-side-icon>
        <v-list>
          <v-list-tile v-for="item in items.filter(item => item.show)"
             :key="item.title"
                :to="item.to">
            <v-list-tile-content>
              <v-list-tile-title>{{item.title}}</v-list-tile-title>
             </v-list-tile-content>
          </v-list-tile>
        </v-list>
      </v-menu>
    </v-toolbar>


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
            panel: [true],
            search:'',
            model:'',
            placesmodel:'',
            placessearch:'',
            isLoading: false,
            results: [],
            places:[{'place':'Choose Location'}],
            items: [
                {title: 'All Ads', to: '/ads', show:true},
                //{title: 'Free Post', to: '/post', show:User.loggedIn()},
                {title: 'Category', to: '/category', show:User.isAdmin()},
                {title: 'State', to: '/state', show:User.loggedIn()},
                // {title: 'Login', to: '/login', show:!User.loggedIn()},
                // {title: 'Logout', to: '/logout', show:User.loggedIn()}
            ],

            postlink: User.loggedIn()?'/post':'/login',
        }
    },
    computed: {
        is_screen_small() {
            return this.$vuetify.breakpoint.xsOnly
        },
    },
    created() {
        EventBus.$on('logout', ()=>{
            User.loggedOut();
        });
        axios.get('/api/places')
        .then( res => {
             res.data.forEach(element => {
                 this.places.push(
                     {
                         'place': element.place+","+element.district+","+element.state,
                         'placeSlug': element.place_slug+","+element.district_slug+","+element.state_slug
                    });
            });
            })
        .catch(error => console.log(error))
        ;
    },
    watch: {
      search (val) {
          // this.search == val are same
       // Items have already been loaded
       // if (this.results.length > 0) return

        // Items have already been requested
       // if (this.isLoading) return

        //this.isLoading = true

        // Lazily load input items
        if(val == null || val.length < 3) return;
         //EventBus.$emit('ShowLoading');
         axios.get('/api/search',{params: {'search': val}}).then(response => {
              //EventBus.$emit('CloseLoading');
          this.results = response.data; //console.log(this.results);
         })
        .catch(err => {
            console.log(err)
        })
        .finally(() => (this.isLoading = false))
      },
      placessearch (val) {
        if(val == null || val.length < 3) return;
         //EventBus.$emit('ShowLoading');
         axios.get('/api/places',{params: {'place': val}}).then(response => {
          //this.results = response.data;
           //this.places = [];
            //EventBus.$emit('CloseLoading');
           response.data.forEach(element => {
                 this.places.push(
                     {
                         'place': element.place+","+element.district+","+element.state,
                         'placeSlug': element.place_slug+","+element.district_slug+","+element.state_slug
                     }

                     );
            });
         })
        .catch(err => {
            console.log(err)
        })
      }
    },
    methods: {
        onSearchClick(search) {
            EventBus.$emit('SearchAd', search);
        },
        onPlaceClick(places) {
            EventBus.$emit('SearchPlaceAd', places);
        }
      },
}
</script>

<style>

</style>

