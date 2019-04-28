<template>
    <v-container flued grid-list-md >
    <v-layout row wrap>
      <v-flex xs8>
       <ad
       v-for="ad in ads"
       :key="ad.path"
       :ad=ad
       ></ad>
      </v-flex>
      sidebar
    </v-layout>
    </v-container>
</template>

<script>
import ad from './Ad';
export default {
    components: {ad},
    data() {
        return {
            ads: {}
        }
    },
    created() {
        axios.get('/api/ad')
            .then(res => {this.ads = res.data.data; })
            .catch(error => console.log(error.response.data));
    }

}
</script>

<style>

</style>
