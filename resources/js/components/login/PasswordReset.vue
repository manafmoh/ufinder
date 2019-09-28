<template>
    <v-container>
        <div v-if="errors">
                  <ul class="alert alert-danger">
                     <li> {{errors}}</li>
                  </ul>
              </div>
        <v-form
            ref="form"
            @submit.prevent="resetPassword"
        >
            <v-text-field
            v-model="form.password"
            label="Password"
            type="password"
            required
            ></v-text-field>
            <span class="red--text" v-if="errors.password">{{errors.password[0]}}</span>

            <v-text-field
            v-model="form.password_confirmation"
            label="Confirm Password"
            type="password"
            required
            ></v-text-field>
            <span class="red--text" v-if="errors.password_confirm">{{errors.password_confirmation[0]}}</span>
            <v-text-field
            v-model="form.email"
            type="hidden"
            class="noborder"
            ></v-text-field>
            <v-text-field
            v-model="form.token"
            type="hidden"
            ></v-text-field>
            <v-btn
            color="success"
            type="submit"
            >
            Reset Password
            </v-btn>
        </v-form>
    </v-container>
</template>

<script>
import swal from 'sweetalert';
export default {
     data() {
        return {
            form: {
                email: null,
                token: null,
                password: null,
                password_confirmation: null,
            },
            errors: '',
            userData: {},
        }
    },
    created() {
        axios.get(`/api/password/find/${this.$route.params.token}`)
            .then(res => {
                this.form.email = res.data.email;
                this.form.token = res.data.token;
            })
            .catch(error => this.errors =  error.response.data.errors);
    },
    methods: {
        resetPassword() {
           //User.signup(this.form);
            axios.post('/api/password/reset', this.form)
                .then(res => {
                     swal("Reset Password!", "Your Password successfully reset, please try to login!", "success");
                    this.$router.push({name: 'login'})
                })
                //.catch(error => console.log(error.response.data));
                .catch(error => {
                    //if (error.response.status == 422){
                    this.errors = error.response.data
                     swal("Error!", error.response.data, "error");
                   // }
                });
        },
    }
}
</script>

<style>
    .noborder,  .noborder input{
        border:none;
        padding: 0;
        margin:0;
        height: 0;
    }
</style>
