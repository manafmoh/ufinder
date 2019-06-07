<template>
    <v-dialog max-width="600px">
        <v-btn flat slot="activator" class="success">Login</v-btn>
        <v-card>
            <v-card-title>
                <h2>Facebook</h2>
                <facebook-login></facebook-login>
            </v-card-title>
        </v-card>
    </v-dialog>
</template>

<script>
import FacebookLogin from './social/FacebookLogin';
export default {
    components: {FacebookLogin},
}
</script>

<style>

</style>
