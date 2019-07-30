<template>
    <v-flex (xs12 sm4 md3 lg3 xl2)>
      <v-card>
        <v-card-title class="primary-title pb-0">
            <h3 class="headline mb-0">
                <router-link class="noline black--text" :to="ad.path">
                    {{ad.title}}
                </router-link>
                </h3>
        </v-card-title>
        <v-card-title class="align-center justify-center">
            <ImageThumb :ad="ad"></ImageThumb>
        </v-card-title>
        <v-card-text class="pt-0  pb-0">
            <h4 class="black--text headline">Rs. {{ad.amount}}</h4>
            {{ad.body | truncate(101, '...')}}
        </v-card-text>
        <v-card-actions class="white justify-center">
            <div style="line-height:10px" class="grey--text">{{ad.user}} Posted {{ad.created_at}} </div>
              <v-spacer></v-spacer>
                <v-btn icon>
                    <v-icon>favorite</v-icon>
                </v-btn>
                <v-btn icon>
                     <v-icon>share</v-icon>
                </v-btn>
            </v-card-actions>
      </v-card>
    </v-flex>
</template>

<script>
import ImageThumb from './ImageThumb'
export default {
    components: { ImageThumb},
    props:['ad'],
    data() {
        return {
            socials: [
            {
            icon: 'fab fa-facebook',
            color: 'indigo'
            },
            {
            icon: 'fab fa-linkedin',
            color: 'cyan darken-1'
            },
            {
            icon: 'fab fa-instagram',
            color: 'red lighten-3'
            }
        ]
        }
    }

}
</script>

<style>

</style>
