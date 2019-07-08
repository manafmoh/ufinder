<template>
<div>
    {{ awspath}}
    <img v-if="image" :src="env('AWS_URL') +'/image/' + image.filepath" :alt="adTitle" width="150px" />
</div>
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
