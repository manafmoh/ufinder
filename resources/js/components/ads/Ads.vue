<template>
    <v-container flued grid-list-md class="mt-2" >
    <v-layout row wrap>
      <v-flex xs8>

              <v-flex xs3>
                <ad
                v-for="ad in ads"
                :key="ad.path"
                :ad=ad
                ></ad>
              </v-flex>

      </v-flex>
      <v-flex xs4>
          <AdSidebar></AdSidebar>
      </v-flex>
    </v-layout>
    </v-container>
</template>

<script>
import ad from './Ad';
import AdSidebar from './AdSidebar';
export default {
    components: {ad, AdSidebar},
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
