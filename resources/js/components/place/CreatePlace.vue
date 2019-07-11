<template>
    <v-container>
        <v-form
            ref="form"
            @submit.prevent="submit"
        >
            <v-textarea
            v-model="form.name"
            label="Area Name"
            required
            ></v-textarea>
            <v-textarea
            v-model="form.pincode"
            label="Area Pincode"
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
            <router-link :to="`/state/${this.$route.params.state}/district`" class="subheading noline ">
            <v-icon>arrow_back</v-icon>
            </router-link>
          <v-toolbar-title >All District of <b v-html="placeName">{{placeName}}</b></v-toolbar-title>
        </v-toolbar>
         <v-list three-line>
            <div v-for="(place,index) in places" :key="place.id">
            <v-list-tile>
                <v-list-tile-action>
                    <v-btn icon small @click="edit(index)">
                        <v-icon color="orange">edit</v-icon>
                    </v-btn>
                </v-list-tile-action>
                <v-list-tile-content>
                    <v-list-tile-title >
                        {{place.name}}
                    </v-list-tile-title>
                    <v-list-tile-sub-title >
                        {{place.pincode}}
                    </v-list-tile-sub-title>
                </v-list-tile-content>
                <v-list-tile-action>
                <v-btn icon small @click="destroy(place.slug, index)">
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
                pincode: null,
            },
            errors: {},
            places: {},
            editFlag:null,
            placeName:''
        }
    },
     created() {

        if(!User.isAdmin()) {
            this.$router.push('/ads')
        }
        axios.get(`/api/state/${this.$route.params.state}/${this.$route.params.district}/place`)
        .then(res => {
             this.places = res.data.data;
             this.placeName = this.places[0].district;
        })
        .catch(error => console.log(error.data))
        // Getting District Details
        axios.get(`/api/state/${this.$route.params.state}/district/${this.$route.params.district}`)
        .then(res => {
            this.placeName = res.data.data.name;
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
             axios.post(`/api/state/${this.$route.params.state}/${this.$route.params.district}/place`, this.form)
            .then(res => {
                this.places.unshift(res.data);
                this.form.name = null;
                this.form.pincode = null;
            })
            .catch(error => console.log(error.data))
        },
        updateDistrict() {
             axios.patch(`/api/state/${this.$route.params.state}/${this.$route.params.district}/place/${this.editFlag}`, this.form)
            .then(res => {
                this.places.unshift(res.data);
                this.form.name = null;
                this.form.pincode = null;
                this.editFlag = null
            })
            .catch(error => console.log(error.data))
        },
        destroy(slug, index) {
            axios.delete(`/api/state/${this.$route.params.state}/${this.$route.params.district}/place/${slug}`)
            .then(res => this.places.splice(index, 1))
            .catch(error=>console.log(error))
        },
        edit(index) {
           this.form.name = this.places[index].name;
           this.form.pincode = this.places[index].pincode;
           this.editFlag = this.places[index].slug
           this.places.splice(index, 1)
        },
    },
}
</script>

<style>
</style>
