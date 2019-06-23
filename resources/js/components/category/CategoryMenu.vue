<template>
<div class="text-xs-center">
    <v-menu  offset-y open-delay="500"
    :close-on-content-click="closeOnContentClick" z-index=100    >
        <v-btn slot="activator" color="secondary" dark @click="menuinfo(item)">MENU</v-btn>
        <v-layout flex-child wrap>
        <v-flex xs12 md4 d-flex
            v-model="item.active"
            v-for="item in items"
            :key="item.title"
        >
         <v-sheet>
            <v-list row wrap>
            <v-list-group
              v-model="item.active"
              :prepend-icon="item.action"
              no-action
              row wrap
            >
              <v-list-tile slot="activator">
                <v-list-tile-content>
                  <v-list-tile-title>{{ item.title }}</v-list-tile-title>
                </v-list-tile-content>
              </v-list-tile>
              <v-list-tile v-for="subItem in item.items" :key="subItem.title" ripple @click="close">
                <v-list-tile-content>
                  <v-list-tile-title>{{ subItem.title }}</v-list-tile-title>
                </v-list-tile-content>
                <v-list-tile-action>
                  <v-icon>{{ subItem.action }}</v-icon>
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
    closeOnContentClick: false,
      items: [
        {
          action: 'local_activity',
          title: 'Attractions',
          active: true,
          items: [
            { title: 'List Item Attractions' }
          ]
        },
        {
          action: 'restaurant',
          title: 'Dining',
          active: true,
          items: [
            { title: 'Breakfast & brunch' },
            { title: 'New American' },
            { title: 'Sushi' }
          ]
        },
        {
          action: 'school',
          title: 'Education',
          active: false,
          items: [
            { title: 'List Item' }
          ]
        },
        {
          action: 'directions_run',
          title: 'Family',
          active: false,
          items: [
            { title: 'List Item' }
          ]
        },
        {
          action: 'healing',
          title: 'Health',
          active: false,
          items: [
            { title: 'List Item' }
          ]
        },
        {
          action: 'content_cut',
          title: 'Office',
          active: false,
          items: [
            { title: 'List Item' }
          ]
        },
        {
          action: 'local_offer',
          title: 'Promotions',
          active: false,
          items: [
            { title: 'List Item' }
          ]
        },
        {
          action: 'local_offer1',
          title: 'Promotions2',
          active: false,
          items: [
            { title: 'List Item' }
          ]
        },
        {
          action: 'local_offer2',
          title: 'Promotions2',
          active: false,
          items: [
            { title: 'List Item' }
          ]
        }
      ]
    }
  },
  methods: {
    close () {
      this.items.forEach(item => {
        if (item.active) {
          _.delay(function () {
            item.active = false
          }, 300)
          return false
        }
      })
    }
  }
}
</script>

<style>

</style>
