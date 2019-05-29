<template>
    <v-container>
        <v-form
            ref="form"
            @submit.prevent="createAd"
        >
            <v-text-field
            v-model="form.title"
            label="Title"
            required
            ></v-text-field>
            <span class="red--text" v-if="errors.title">{{errors.title[0]}}</span>

            <v-autocomplete
            :items="categories"
            v-model="form.category_id"
            item-text="name"
            item-value="id"
            label="Category"
            ></v-autocomplete>

            <markdown-editor v-model="form.body"></markdown-editor>
            <v-flex xs12 class="text-xs-center text-sm-center text-md-center text-lg-center">
                    <img :src="imageUrl" height="150" v-if="imageUrl"/>
					<v-text-field label="Select Image" @click='pickFile' v-model='imageName' prepend-icon='attach_file'></v-text-field>
					<input
						type="file"
						style="display: none"
						ref="image"
						accept="image/*"
						@change="onFilePicked"
					>
			</v-flex>
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
            form: {
                title: null,
                category_id: null,
                body: null,
                amount: 0,
                featured: 0,
                image: null,
            },
            categories: [],
            errors: {},
            imageName: '',
	    	imageUrl: '',
            imageFile: '',
            fileList: [],
            upload: {
                name:'',url:''
            },
            isShowPic: false
        }

    },
    methods: {
        createAd() {
            let form = new FormData();
            form.append('image', this.imageFile);
            form.append('title', this.form.title);
            form.append('category_id', this.form.category_id);
            form.append('body', this.form.body);
            form.append('amount', this.form.amount);
            form.append('featured', this.form.featured);
            this.form =  form;
            const filesRaw = this.fileList.map(f => f.raw);
            for (const file of filesRaw) {
                    this.form.append('files[]', file, file.name)
                }
            axios.post('/api/ad', this.form, {
            headers: {
                'Content-Type': 'multipart/form-data'
                }
            })
            .then( res => {
                //Redirecting the url
                this.$router.push(res.data.path)
            })
            .catch(error => console.log(error.response.data.error));
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
            var vm = this
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
            }

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
            //console.log('Preview',file);
                this.isShowPic = true;
        },
        onChange(file, fileList, name){
            //console.log('File',fileList);
            this.fileList = fileList
            const isIMAGE = file.type === 'image/jpeg'||'image/gif'||'image/png';
            const isLt1M = file.size / 1024 / 1024 < 1;
            if (!isIMAGE) {
                this.$message.error('Upload file must be JPG format!');
            }
            if (!isLt1M) {
                this.$message.error('Upload file size can not exceed 1MB!');
            }
            return isIMAGE && isLt1M;
        }
    },
    created() {
            axios.get('/api/category')
            .then( res => this.categories = res.data.data)
            .catch(error => console.log(error))
            ;
        }
}

</script>

<style>
@import "https://unpkg.com/element-ui/lib/theme-chalk/index.css";
</style>
