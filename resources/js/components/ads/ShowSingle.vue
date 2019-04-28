<template>
 <v-card>
     <v-container fluid>
         <v-card-title primary-title>
          <div>
            <h3 class="headline">
                    {{ad.title}}
                </h3>
            <div class="grey--text">{{ad.user}} Said {{ad.created_at}} </div>
          </div>
          <v-spacer></v-spacer>
          <v-btn color="teal">5 Replies</v-btn>
        </v-card-title>
        <v-card-text v-html="body"></v-card-text>
        <v-card-actions v-if="ownad">
            <v-btn icon small @click="edit" >
                <v-icon color="orange">edit</v-icon>
            </v-btn>
            <v-btn icon small @click="destroy" >
                <v-icon color="red">delete</v-icon>
            </v-btn>
        </v-card-actions>
     </v-container>
      </v-card>
</template>

<script>
export default {
    props:['ad'],
    computed: {
        body() {
            return md.parse(this.ad.body)
        }
    },
    data() {
        return {
            ownad: User.ownAd(this.ad.user_id)
        }
    },
    methods: {
        destroy() {
            axios.delete(`/api/ad/${this.ad.slug}`)
            .then(res => this.$router.push('/ads'))
            .catch(error => console.log(error.response.data))
        },
        edit() {
            EventBus.$emit('startEdit')
        }
    }
}
</script>

<style>

</style>
