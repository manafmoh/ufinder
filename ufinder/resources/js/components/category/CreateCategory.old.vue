<template>
    <v-container>
        <v-form
            ref="form"
            @submit.prevent="submit"
        >
            <v-text-field
            v-model="form.name"
            label="Category Name"
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
          <v-toolbar-title>All Category</v-toolbar-title>
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
                        <v-combobox
                            v-model="model[category.slug]"
                            :filter="filter"
                            :hide-no-data="!search"
                            :items="items[category.slug]"
                            :search-input.sync="search"
                            hide-selected
                            label="Search for an option"
                            multiple
                            small-chips
                            solo
                        >
                            <template v-slot:no-data>
                            <v-list-item>
                                <span class="subheading">Create</span>
                                <v-chip
                                :color="`${colors[nonce - 1]} lighten-3`"
                                label
                                small
                                >
                                {{ search }}
                                </v-chip>
                            </v-list-item>
                            </template>
                            <template v-slot:selection="{ item, parent, selected }">
                            <v-chip
                                v-if="item === Object(item)"
                                :color="`${item.color} lighten-3`"
                                :selected="selected"
                                label
                                small
                            >
                                <span class="pr-2">
                                {{ item.text }}
                                </span>
                                <v-icon
                                small
                                @click="parent.selectItem(item)"
                                >close</v-icon>
                            </v-chip>
                            </template>
                            <template v-slot:item="{ index, item }">
                            <v-list-item-content>
                                <v-text-field
                                v-if="editing === item"
                                v-model="editing.text"
                                autofocus
                                flat
                                background-color="transparent"
                                hide-details
                                solo
                                @keyup.enter="editChip(index, item)"
                                ></v-text-field>
                                <v-chip
                                v-else
                                :color="`${item.color} lighten-3`"
                                dark
                                label
                                small
                                >
                                {{ item.text }}
                                </v-chip>
                            </v-list-item-content>
                            <v-spacer></v-spacer>
                            <v-list-item-action @click.stop>
                                <v-btn
                                icon
                                @click.stop.prevent="editChip(index, item)"
                                >
                                <v-icon>{{ editing !== item ? 'edit' : 'check' }}</v-icon>
                                </v-btn>
                            </v-list-item-action>
                            </template>
                        </v-combobox>


                    </v-list-tile-sub-title>
                </v-list-tile-content>
                <v-list-tile-action>
                <v-btn  small @click="saveSubCat(category.slug)">
                    Save Sub Cat
                </v-btn>
                <v-btn icon small @click="destroy(category.slug, index)">
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
            categories: {},
            editFlag:null,


            //
            activator: null,
            attach: null,
            colors: ['green', 'purple', 'indigo', 'cyan', 'teal', 'orange'],
            editing: null,
            index: -1,
            //[{"fruit": {"fruitName": "apple"}, "vegetable":[{"vegetableName": "carrot" }]}]

            /*items: [
                { header: 'Select an option or create one' },
                {
                text: 'Foo',
                color: 'blue',
                },
                {
                text: 'Bar',
                color: 'red',
                },
            ],*/
             items: {
                cat2:[
                     { header: 'Select an option or create one' },
                    {
                    text: 'Foo1',
                    color: 'blue',
                    }],
                category:[
                     { header: 'Select an option or create one' },
                    {
                    text: 'Test2',
                    color: 'green',
                    }]
            },
            nonce: 1,
            menu: false,
            model: {
                cat2:[{
                    text: 'Foo',
                    color: 'blue',
                    }],
                category:[{
                    text: 'Test',
                    color: 'green',
                    }]
            }
            ,
            x: 0,
            search: null,
            y: 0,
        }
    },
     created() {

        if(!User.isAdmin()) {
            this.$router.push('/ads')
        }

        axios.get('/api/category')
        .then(res => this.categories = res.data.data)
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
             axios.post('/api/category', this.form)
            .then(res => {
                this.categories.unshift(res.data);
                this.form.name = null;
            })
            .catch(error => console.log(error.data))
        },
        updateCategory() {
             axios.patch(`/api/category/${this.editFlag}`, this.form)
            .then(res => {
                this.categories.unshift(res.data);
                this.form.name = null;
            })
            .catch(error => console.log(error.data))
        },
        destroy(slug, index) {
            axios.delete(`/api/category/${slug}`)
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
        //v-combobox
        editChip (index, item) { console.log('Val ',item.text);
            if (!this.editing) {
            this.editing = item
            this.index = index
            } else {
            this.editing = null
            this.index = -1
            }
        },
        filter (item, queryText, itemText) {
            if (item.header) return false

            const hasValue = val => val != null ? val : ''

            const text = hasValue(itemText)
            const query = hasValue(queryText)

            return text.toString()
            .toLowerCase()
            .indexOf(query.toString().toLowerCase()) > -1
        },

    }, watch: {
      model (val, prev) {
        if (val.length === prev.length) return

        this.model = val.map(v => {
          if (typeof v === 'string') {
            v = {
              text: v,
              color: this.colors[this.nonce - 1],
            }

            this.items.push(v)

            this.nonce++
          }
          return v
        })
      },
    },
}
</script>

<style>
</style>
