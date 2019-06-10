<template>
    <v-dialog max-width="600px" v-model="dialog">
        <v-btn flat slot="activator" class="success">Login</v-btn>
        <v-card>
            <v-card-title>
                <h2>Facebook</h2>
                <facebook-login></facebook-login>
            </v-card-title>
        </v-card>
    <v-btn @click="dclose" >Close</v-btn>
    </v-dialog>
</template>

<script>
import FacebookLogin from './social/FacebookLogin';
export default {
    components: {FacebookLogin},
    data() {
        return {
           dialog: false
        }
    },
    watch: {
        dialog (val) {
            !val && alert('Dialog is closing')
        }
    },
    methods: {
        dclose(){
         this.dialog= false
    }
    }
}
</script>

<style>

</style>
