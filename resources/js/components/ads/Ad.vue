<template>
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
            {{ad.body}}
        </v-card-text>

      </v-card>
</template>

<script>
import ImageThumb from './ImageThumb'
export default {
    components: { ImageThumb},
    props:['ad'],

}
</script>

<style>

</style>
