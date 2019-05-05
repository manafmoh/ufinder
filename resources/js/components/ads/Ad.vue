<template>
      <v-card>
        <v-card-title primary-title>
          <div>
            <h3 class="headline mb-0">
                <router-link :to="ad.path">
                    {{ad.title}}
                </router-link>

                </h3>
            <div class="grey--text">{{ad.user}} Said {{ad.created_at}} </div>
          </div>
        </v-card-title>
        <v-card-text>
            {{ad.body}}
        </v-card-text>

      </v-card>
</template>

<script>
export default {
    props:['ad'],

}
</script>

<style>

</style>
