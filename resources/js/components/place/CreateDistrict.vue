<template>
    <v-container>
        <v-form
            ref="form"
            @submit.prevent="submit"
        >
            <v-textarea
            v-model="form.name"
            label="District Name"
            required
            ></v-textarea>
            <span class="red--text" v-if="errors.name">{{errors.name[0]}}</span>
            <v-btn v-if="!editFlag"
            color="success"
            type="submit"
            >
            Create
            </v-btn>

            <v-btn v-else
            color="pink"
            type="submit"
            >
            Update
            </v-btn>
        </v-form>

        <v-card>
        <v-toolbar color="indigo" dark dense>
             <router-link to="/state" class="red--text subheading noline ">
            <v-icon>arrow_back</v-icon>
            </router-link>
          <v-toolbar-title >All District of <b v-html="districtName">{{districtName}}</b></v-toolbar-title>
        </v-toolbar>

         <v-list three-line>
            <div v-for="(district,index) in districts" :key="district.id">
            <v-list-tile>
                <v-list-tile-action>
                    <v-btn icon small @click="edit(index)">
                        <v-icon color="orange">edit</v-icon>
                    </v-btn>
                </v-list-tile-action>
                <v-list-tile-content>
                    <v-list-tile-title >
                        {{district.name}} ({{district.place_count}})
                    </v-list-tile-title>
                    <v-list-tile-sub-title >

                    </v-list-tile-sub-title>
                </v-list-tile-content>
                <v-list-tile-action>
                <v-btn small color="primary" dark :href="district.frontplacepath">Area</v-btn>
                <v-btn icon small @click="destroy(district.slug, index)">
                    <v-icon color="red">delete</v-icon>
                </v-btn>
            </v-list-tile-action>
            </v-list-tile>
            <v-divider></v-divider>
            </div>
            </v-list>

      </v-card>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            form: {
                name: null,
            },
            errors: {},
            districts: {},
            editFlag:null,
            districtName:''
        }
    },
     created() {

        if(!User.isAdmin()) {
            this.$router.push('/ads')
        }
        axios.get(`/api/state/${this.$route.params.slug}/district`)
        .then(res => {
             this.districts = res.data.data;
        })
        .catch(error => console.log(error.data))
        // Getting State Details
        axios.get(`/api/state/${this.$route.params.slug}`)
        .then(res => {
            this.districtName = res.data.data.name;
        })
        .catch(error => console.log(error.data))
    },
    methods : {
        submit() {
            if(!this.editFlag) {
                this.createDistrict();
            } else {
                this.updateDistrict()
            }
        },
        createDistrict() {
             axios.post(`/api/state/${this.$route.params.slug}/district`, this.form)
            .then(res => {
                this.districts.unshift(res.data);
                this.form.name = null;
            })
            .catch(error => console.log(error.data))
        },
        updateDistrict() {
             axios.patch(`/api/state/${this.$route.params.slug}/district/${this.editFlag}`, this.form)
            .then(res => {
                this.districts.unshift(res.data);
                this.form.name = null;
                this.editFlag = null
            })
            .catch(error => console.log(error.data))
        },
        destroy(slug, index) {
            axios.delete(`/api/state/${this.$route.params.slug}/district/${slug}`)
            .then(res => this.districts.splice(index, 1))
            .catch(error=>console.log(error))
        },
        edit(index) {
           this.form.name = this.districts[index].name;
           this.editFlag = this.districts[index].slug
           this.districts.splice(index, 1)
        },
    },
}
</script>

<style>
</style>
