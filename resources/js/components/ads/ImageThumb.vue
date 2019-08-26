<template>
    <router-link class="noline" :to="ad.path">
    <v-img v-if="image!== undefined" :src="awspath +'/image/' + image.filepath" :alt="adTitle" width="150px" />
    </router-link>
</template>

<script>
export default {
    props:['ad'],
     data() {
        return {
            awspath: process.env.MIX_AWS_URL,
            image: this.ad.uploads[0],
            adTitle: this.ad.title
        }
    },
}
</script>

<style>

</style>
