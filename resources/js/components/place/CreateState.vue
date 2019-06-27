<template>
    <v-container>
        <v-form
            ref="form"
            @submit.prevent="submit"
        >
            <v-text-field
            v-model="form.name"
            label="State"
            required
            ></v-text-field>
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
          <v-toolbar-title>All States</v-toolbar-title>
        </v-toolbar>
         <v-list three-line>
            <div v-for="(state,index) in states" :key="state.id">
            <v-list-tile>
                <v-list-tile-action>
                    <v-btn icon small @click="edit(index)">
                        <v-icon color="orange">edit</v-icon>
                    </v-btn>
                </v-list-tile-action>
                <v-list-tile-content>
                    <v-list-tile-title >
                        {{state.name}}
                    </v-list-tile-title>
                    <v-list-tile-sub-title >

                    </v-list-tile-sub-title>
                </v-list-tile-content>
                <v-list-tile-action>
                <v-btn small color="primary" dark :href="state.districtpath">District</v-btn>
                <v-btn icon small @click="destroy(state.slug, index)">
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
            states: {},
            editFlag:null,
        }
    },
     created() {

        if(!User.isAdmin()) {
            this.$router.push('/ads')
        }
        axios.get('/api/state')
        .then(res => this.states = res.data.data)
        .then(error => console.log(error.data))
    },
    methods : {
        submit() {
            if(!this.editFlag) {
                this.createCategory();
            } else {
                this.updateCategory()
            }
        },
        createCategory() {
             axios.post('/api/state', this.form)
            .then(res => {
                this.states.unshift(res.data);
                this.form.name = null;
            })
            .catch(error => console.log(error.data))
        },
        updateCategory() {
             axios.patch(`/api/state/${this.editFlag}`, this.form)
            .then(res => {
                this.states.unshift(res.data);
                this.form.name = null;
                this.editFlag = null
            })
            .catch(error => console.log(error.data))
        },
        destroy(slug, index) {
            axios.delete(`/api/state/${slug}`)
            .then(res => this.states.splice(index, 1))
            .catch(error=>console.log(error))
        },
        edit(index) {
           this.form.name = this.states[index].name;
           this.editFlag = this.states[index].slug
           this.states.splice(index, 1)
        },
        saveSubCat(catslug) {

        },
    },
}
</script>

<style>
</style>
