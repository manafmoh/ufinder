<template>
    <v-container>
        <v-form
            ref="form"
            @submit.prevent="submit"
        >
            <v-textarea
            v-model="form.name"
            label="Sub Category Name"
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
          <v-toolbar-title >All Sub Category of <b v-html="categoryName">{{categoryName}}</b></v-toolbar-title>
        </v-toolbar>
         <v-list three-line>
            <div v-for="(category,index) in categories" :key="category.id">
            <v-list-tile>
                <v-list-tile-action>
                    <v-btn icon small @click="edit(index)">
                        <v-icon color="orange">edit</v-icon>
                    </v-btn>
                </v-list-tile-action>
                <v-list-tile-content>
                    <v-list-tile-title >
                        {{category.name}}
                    </v-list-tile-title>
                    <v-list-tile-sub-title >

                    </v-list-tile-sub-title>
                </v-list-tile-content>
                <v-list-tile-action>
                <v-btn icon small @click="destroy(category.slug, index)">
                    <v-icon color="red">delete</v-icon>
                </v-btn>
            </v-list-tile-action>
            </v-list-tile>
            <v-divider></v-divider>
            </div>
            </v-list>
            <router-link to="/category">
                    BACK TO CATEGORY
                </router-link>
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
            categories: {},
            editFlag:null,
            categoryName:''
        }
    },
     created() {

        if(!User.isAdmin()) {
            this.$router.push('/ads')
        }
        axios.get(`/api/category/${this.$route.params.slug}/subcategory`)
        .then(res => {
             this.categories = res.data.data;
        })
        .catch(error => console.log(error.data))

        // Getting Category Details
        axios.get(`/api/category/${this.$route.params.slug}`)
        .then(res => {
            this.categoryName = res.data.data.name;
        })
        .catch(error => console.log(error.data))
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
             axios.post(`/api/category/${this.$route.params.slug}/subcategory`, this.form)
            .then(res => {
                this.categories.unshift(res.data);
                this.form.name = null;
            })
            .catch(error => console.log(error.data))
        },
        updateCategory() {
             axios.patch(`/api/category/${this.$route.params.slug}/subcategory/${this.editFlag}`, this.form)
            .then(res => {
                this.categories.unshift(res.data);
                this.form.name = null;
                this.editFlag = null
            })
            .catch(error => console.log(error.data))
        },
        destroy(slug, index) {
            axios.delete(`/api/category/${this.$route.params.slug}/subcategory/${slug}`)
            .then(res => this.categories.splice(index, 1))
            .catch(error=>console.log(error))
        },
        edit(index) {
           this.form.name = this.categories[index].name;
           this.editFlag = this.categories[index].slug
           this.categories.splice(index, 1)
        },
        saveSubCat(catslug) {

        },
    },
}
</script>

<style>
</style>
