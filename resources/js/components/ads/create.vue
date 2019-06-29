<template>
    <v-container>
        <v-form ref="form" @submit.prevent="createAd" id="formAd" >
            <v-text-field
                v-model="title"
                label="Title"
                required
            ></v-text-field>
            <span class="red--text" v-if="errors.title">{{errors.title[0]}}</span>

            <v-flex xs12 sm6 d-flex>
            <v-autocomplete
                :items="categories"
                v-model="category_id"
                item-text="name"
                item-value="categories.id"
                label="Category"
                :return-object="true"
                required
                @change="onSubCategoryClick">
                </v-autocomplete>
                <span class="red--text" v-if="errors.category_id">{{errors.category_id[0]}}</span>
            </v-flex>
            <!--<v-dialog  max-width="600px" v-model="subcategoryDialog" >
                <v-btn v-for="subitem in subcategories" :key="subitem.slug" @click="setSubcategory(subitem)">
                    {{subitem.name}}</v-btn>
            </v-dialog>-->
            <v-flex xs12 sm6 d-flex>
                <v-select
                v-model="subcategory_id"
                :items="subcategories"
                label="Sub Category"
                item-text="name"
                item-value="id"
                required>
                </v-select>
                <span class="red--text" v-if="errors.subcategory_id">{{errors.subcategory_id[0]}}</span>
            </v-flex>

            <v-flex xs12 sm6 d-flex>
                <v-autocomplete
                :items="states"
                v-model="state_id"
                item-text="name"
                item-value="states.id"
                label="State"
                :return-object="true"
                required
                @change="onDistrictClick">
                </v-autocomplete>
                <span class="red--text" v-if="errors.state_id">{{errors.state_id[0]}}</span>
            </v-flex>
            <v-flex xs12 sm6 d-flex>
                <v-autocomplete
                :items="districts"
                v-model="district_id"
                item-text="name"
                item-value="district.id"
                label="District"
                :return-object="true"
                required
                @change="onPlaceClick">
                </v-autocomplete>
                <span class="red--text" v-if="errors.district_id">{{errors.district_id[0]}}</span>
            </v-flex>
            <v-flex xs12 sm6 d-flex>
                <v-autocomplete
                :items="places"
                v-model="place_id"
                item-text="name"
                item-value="id"
                label="City"
                required
               >
                </v-autocomplete>
                <span class="red--text" v-if="errors.place_id">{{errors.place_id[0]}}</span>
            </v-flex>
            <markdown-editor v-model="body"></markdown-editor>

            <el-dialog  :visible.sync="isShowPic" size="small">
            <span>
                <img :src="upload.url">
                </span>
                <span slot="footer" class="dialog-footer">
            </span>
            </el-dialog>
            <el-upload
                    class="upload-demo"
                    action="api/upload"
                    accept="image/jpeg,image/gif,image/png"
                    list-type="picture-card"
                    ref="uploads"
                    :on-preview="handlePreview"
                    :auto-upload="false"
                    :on-success="handleSuccess"
                    :on-remove="handleRemove"
                    :before-upload="onBeforeUpload"
                    :on-change="onChange"
                    multiple
                    :limit="3"
                    :on-exceed="handleExceed"
                    :file-list="fileList">
                <el-button size="small" type="primary">Click to upload</el-button>
                <div slot="tip" class="el-upload__tip">jpg/png files with a size less than 500kb</div>
            </el-upload>
                    <!--<input
						type="file"
						style="display: none"
						ref="image"
						accept="image/*"
						@change="onFilePicked"
					> -->
            <v-checkbox
                v-model="featured"
                :label="`Featured`"
            ></v-checkbox>
            <v-radio-group v-model="post_type">
                <v-radio
                    label="Sell"
                    color="red"
                    value="sell"
                ></v-radio>
                <v-radio
                    label="Buy"
                    color="green"
                    value="buy"
                ></v-radio>
            </v-radio-group>
            <v-text-field
                v-model="amount"
                label="Amount"
                required
            ></v-text-field>
            <span class="red--text" v-if="errors.amount">{{errors.amount[0]}}</span>
            <v-btn
                color="success"
                type="submit"
            >
            Create
            </v-btn>
        </v-form>
    </v-container>
</template>


<script src="https://unpkg.com/element-ui/lib/index.js"></script>
<script>
export default {
    components: {

    },
    data(){
        return {

                title: null,
                category_id: null,
                subcategory_id:null,
                state_id:null,
                district_id:null,
                place_id:null,
                body: '',
                amount: 0,
                featured: true,
                post_type: 'sell',


            categories: [],
            errors: {},
            imageName: '',
	    	imageUrl: '',
            imageFile: '',
            fileList: [],
            upload: {
                name:'',url:''
            },
            isShowPic: false,
            subcategoryDialog:false,
            subcategories:[],
            subCatName:null,
            states:[],
            districts:[],
            places:[]
        }

    },

    methods: {
        createAd() {
            let CatId=null;
            if (this.category_id == null || typeof this.category_id == "undefined" ) {
                //console.log('NULL');
            } else {
                //console.log(this.category_id['id']);
                 if(this.category_id['id']){
                    CatId = this.category_id['id'];
                }
            }



            let form = new FormData();
            form.append('title', this.title);
            form.append('category_id', CatId );
            form.append('subcategory_id', this.subcategory_id);
            form.append('body', this.body);
            form.append('amount', this.amount);
            form.append('featured', this.featured);
            //this.form =  form;
            const filesRaw = this.fileList.map(f => f.raw);
            for (const file of filesRaw) {
                    form.append('files[]', file, file.name)
                }

            axios({
                    method: 'post',
                    url: '/api/ad' ,
                    data: form,
                    config: { headers: {'Content-Type': 'multipart/form-data' }}
                }).then( res => {
                //Redirecting the url
                this.$router.push(res.data.path)
            })
            .catch(error => {
                this.errors =  error.response.data.errors;
                //console.log('ERROR ',this.errors)
                });
        },
        pickFile () {
            this.$refs.image.click ()
        },

		onFilePicked (e) {
            const files = e.target.files
			if(files[0] !== undefined) {
				this.imageName = files[0].name
				if(this.imageName.lastIndexOf('.') <= 0) {
					return
				}
				const fr = new FileReader ()
				fr.readAsDataURL(files[0])
				fr.addEventListener('load', () => {
					this.imageUrl = fr.result
					this.imageFile = files[0] // this is an image file that can be sent to server...
                    //this.form.image = this.imageFile;
                    //console.log(this.imageFile);
                })
			} else {
				this.imageName = ''
				this.imageFile = ''
				this.imageUrl = ''
			}
        },
         handleRemove(file, fileList) {
            if(!file.uid) return;
            let vm = this
            axios.delete('/api/upload/' + file.uid)
                .then(function () {
                    let index = _.findIndex(vm.fileList, ['uid', file.uid])
                    vm.$delete(vm.fileList, index)
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        handleSuccess(response, file, fileList) {
           /* var vm = this
            _.map(response, function (data) {
                file['uid'] = data
                //console.log('IMG', data);
            })
            vm.fileList = fileList;
            //console.log(file);
            if(file.status == 'success'){
            //Save the data returned from the back end
                this.upload.url = file.url;
                this.upload.name = file.name;
            }*/

        },
        handleExceed(files, fileList) {
            this.$message.warning(`The limit is 3, you selected ${files.length} files this time, add up to ${files.length + fileList.length} totally`);
        },
        beforeRemove(file, fileList) {
            return this.$confirm(`do you really want to delete ${ file.name }？`);
        },
        onBeforeUpload(file)  {
            const isIMAGE = file.type === 'image/jpeg'||'image/gif'||'image/png';
            const isLt1M = file.size / 1024 / 1024 < 1;
            if (!isIMAGE) {
                this.$message.error('Upload file must be JPG format!');
            }
            if (!isLt1M) {
                this.$message.error('Upload file size can not exceed 1MB!');
            }
            return isIMAGE && isLt1M;
        },
        handlePreview(file) {
            //console.log('Preview',file.url);
            this.upload.url = file.url
            this.upload.name = file.name
            this.isShowPic = true;
        },
        onChange(file, fileList, name){
            //console.log('File',fileList);
            const isIMAGE = file.type === 'image/jpeg'||'image/gif'||'image/png';
            const isLt1M = file.size / 1024 / 1024 < 1;
            if (!isIMAGE) {
                this.$message.error('Upload file must be JPG format!');
            }
            if (!isLt1M) {
                this.$message.error('Upload file size can not exceed 1MB!');
            }
            if(isIMAGE && isLt1M) {
                this.fileList = fileList;
                return true;
            }
            fileList.pop()
            return false;
        },
        onSubCategoryClick(categoryArr) {
            //this.subcategoryDialog=true;
             axios.get(`/api/category/${categoryArr['slug']}/subcategory`)
                .then( res => this.subcategories = res.data.data)
                .catch(error => console.log(error));
        },
        setSubcategory(subcat) {
            //this.form.subcategory_id = subcat.id;
            //this.subCatName = subcat.name;
            //this.subcategoryDialog=false;
        },
        onDistrictClick(stateArr) {
             axios.get(`/api/state/${stateArr['slug']}/district`)
                .then( res => this.districts = res.data.data)
                .catch(error => console.log(error));
        },
        onPlaceClick(districtArr) { //console.log(districtArr);
             axios.get(`/api${districtArr['placepath']}`)
                .then( res => this.districts = res.data.data)
                .catch(error => console.log(error));
        },
    },
    created() {
            axios.get('/api/category')
            .then( res => this.categories = res.data.data)
            .catch(error => console.log(error));

             axios.get('/api/state')
            .then( res => this.states = res.data.data)
            .catch(error => console.log(error));
        }
}

</script>

<style>
@import "https://unpkg.com/element-ui/lib/theme-chalk/index.css";
</style>
