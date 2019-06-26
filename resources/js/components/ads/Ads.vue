<template>
    <v-container flued grid-list-md class="mt-2" >
    <v-layout row wrap>
      <v-flex xs12>
          <v-card>
            <v-toolbar flat>
            <v-btn icon>
                <v-icon>arrow_back</v-icon>
            </v-btn>
            <v-toolbar-title>Albums</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon>
                <v-icon>search</v-icon>
            </v-btn>
            </v-toolbar>
            <v-subheader>May</v-subheader>
            <v-container fluid grid-list-sm>
            <v-layout row wrap>
                <ad
                v-for="ad in ads"
                :key="ad.path"
                :ad=ad
                ></ad>
            </v-layout>
            </v-container>
          </v-card>
      </v-flex>
      <v-flex xs12>
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
        let route = this.$route.fullPath;
        let pathPrams = route.split('/');
        switch (pathPrams[1]) {
        case 'c':
            axios.get(`/api/ad/${this.$route.params.slug}/category`)
            .then(res => {this.ads = res.data.data; })
            .catch(error => console.log(error.response.data));
           break;
        case 'sc':
            let catPrams = this.$route.params.slug.split('_');
            axios.get(`/api/ad/${catPrams[0]}/${catPrams[1]}/subcategory`)
            .then(res => {this.ads = res.data.data; })
            .catch(error => console.log(error.response.data));
            break;
        default:
             axios.get('/api/ad')
            .then(res => {this.ads = res.data.data; })
            .catch(error => console.log(error.response.data));
        }

    },

    methods:{

    }

}
</script>

<style>

</style>
