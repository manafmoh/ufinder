<template>
<div>
    <img v-img:group-2="{ cursor: 'zoom-in' }" v-for="image in images" :key="image.id" :src="env('AWS_URL')+'/image/' + image.filepath" :alt="adTitle" width="150px" />
</div>
</template>

<script>
export default {
    props:['ad'],
     data() {
        return {
            images: this.ad.uploads,
            adTitle: this.ad.title
        }
    }
}
</script>

<style>

</style>
