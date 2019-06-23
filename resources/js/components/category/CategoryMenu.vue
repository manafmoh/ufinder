<template>
<div class="text-xs-center">
    <v-menu open-on-hover offset-y open-delay="500"
               v-for="(item, index) in Menus" :key="index">
        <v-btn slot="activator" color="secondary" dark @click="menuinfo(item)">{{item.title}}-{{index}}</v-btn>
        <v-list dense>
          <v-list-tile v-for="(subitem, index1) in item.sub" :key="index1" @click="subinfo(subitem)">
            <v-list-tile-title>{{ subitem.title }}-{{index1}}</v-list-tile-title>
            <v-divider></v-divider>
          </v-list-tile>
        </v-list>
      </v-menu>
</div>
</template>

<script>
export default {
    data: () => ({
   Menus: [
     {
       title: 'Menu1',
       sub: [
        { title: 'sMenu1'},
         { title: 'sMenu2'}
       ]
     },
     {
       title: 'Menu2',
       sub: [
        { title: 'sMenu3'},
         { title: 'sMenu4'}
       ]
     },
     {
       title: 'Menu3',
       sub: [
        { title: 'sMenu5'},
         { title: 'sMenu6'}
       ]
     }
   ]
  }),
  methods: {
    subinfo(subitem) {
      alert("Test "+ subitem.title)
    },
    menuinfo(liton) {
      alert("Main"+liton.title)
    }
  }
}
</script>

<style>

</style>
