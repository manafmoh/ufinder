<template>
    <v-flex  xs3>
      <v-card>
        <v-card-title primary-title>
          <div>
            <h3 class="headline mb-0">
                <router-link :to="ad.path">
                    {{ad.title}}
                </router-link>

                </h3>
            <ImageThumb  :ad="ad"></ImageThumb>
            <div class="grey--text">{{ad.user}} Said {{ad.created_at}} </div>
          </div>
        </v-card-title>
        <v-card-text>
            {{ad.body | truncate(101, '...')}}
        </v-card-text>
        <v-card-actions class="white justify-center">
              <v-btn
                v-for="(social, i) in socials"
                :key="i"
                :color="social.color"
                class="white--text"
                fab
                icon
                small
              >
                <v-icon>{{ social.icon }}</v-icon>
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
