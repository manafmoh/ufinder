<template>
    <div v-if="ad">
        <edit-ad
        v-if="editing"
        :ad = ad
        ></edit-ad>

        <show-single v-else
        :ad = ad
        ></show-single>

    </div>
</template>

<script>
import ShowSingle from './ShowSingle'
import EditAd from './editAd'
export default {
    components: {ShowSingle, EditAd},
    data() {
        return {
            ad:null,
            editing: false
        }
    },
    created() {
        this.listen();
        axios.get(`/api/ad/${this.$route.params.slug}`)
        .then(res => this.ad = res.data.data)
        .catch(error => console.log(error.data.error));
    },
    methods: {
        listen(){
            EventBus.$on('startEdit', ()=> {
                this.editing = true;
            })
            EventBus.$on('cancelEditing', ()=> {
                this.editing = false;
            })
        }

    }
}
</script>

<style>

</style>
