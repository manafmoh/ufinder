<template>
<div class="text-xs-center">
    <v-menu  offset-y open-delay="500" :close-on-click="true" v-model="togglePopover"
    :close-on-content-click="closeOnContentClick" z-index=100    >
        <v-btn slot="activator" round color="primary" dark >All Categories</v-btn>
        <v-layout flex-child wrap>
        <v-flex xs12 md4 d-flex
            v-for="item in categories"
            :key="item.name"
        >
         <v-sheet>
            <v-list row wrap>
            <v-list-group
              v-model="item.active"
              :prepend-icon="item.icon"
              no-action
              row wrap
            >
              <v-list-tile slot="activator" >
                <v-list-tile-content class="text-md-left">
                  <v-list-tile-title><b>{{ item.name }}</b></v-list-tile-title>
                </v-list-tile-content>
              </v-list-tile>
              <v-list-tile v-for="subItem in item.subcategories" :key="subItem.name"  :to="subItem.subcatpath" ripple @click="close">
                <v-list-tile-content>
                  <v-list-tile-title>{{ subItem.name }}</v-list-tile-title>
                </v-list-tile-content>
                <v-list-tile-action>
                  <v-icon>{{ subItem.slug }}</v-icon>
                </v-list-tile-action>
              </v-list-tile>
            </v-list-group>
          </v-list>
        </v-sheet>
        </v-flex>
        </v-layout>
      </v-menu>
</div>

</template>
<script>
export default {
   data () {
    return {
      categories:[],
      closeOnContentClick: false,
      togglePopover: false,
    }
  },
  created() {
     axios.get('/api/category')
            .then(
              res => {this.categories = res.data.data;
            })
            .catch(error => console.log(error));
  },
  methods: {
    close () {
      this.categories.forEach(item => {
        if (item.active) {
          _.delay(function () {
            item.active = false;
          }, 300)
          // Menu collapse and hide
            this.togglePopover = false;
          return false
        }
      })
    }
  }
}
</script>

<style>

</style>
