<template>
    <v-container>
        <v-form
            ref="form"
            @submit.prevent="forgot"
        >
            <v-text-field
            v-model="form.email"
            label="Email"
            required
            ></v-text-field>
            <span class="red--text" v-if="errors.email">{{errors.email[0]}}</span>

            <v-btn
            color="success"
            type="submit"
            >
            Forgot Password
            </v-btn>
        </v-form>
        <v-btn color="blue" @click="showLogin" flat>Login</v-btn>
    </v-container>
</template>

<script>
import swal from 'sweetalert';
export default {
     data() {
        return {
            form: {
                email: null,
            },
            errors: {

            }
        }
    },
    created() {

    },
    methods: {
        forgot() {
            EventBus.$emit('ShowLoading');
           //User.signup(this.form);
            axios.post('/api/password/create', this.form)
                .then(res => {
                    EventBus.$emit('CloseLoading');
                    swal("Forgot Password!", "Your Password has sent to your email address", "success");
                })
                //.catch(error => console.log(error.response.data));
                .catch(error => {
                    //this.errors =  error.response.data.errors
                     EventBus.$emit('CloseLoading');
                     swal("Error!", error.response.data, "error");
                    });
        },
        showLogin() {
            EventBus.$emit('ShowLogin', true);
        }
    }
}
</script>

<style>

</style>
