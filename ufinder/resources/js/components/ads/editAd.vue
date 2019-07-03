<template>
<v-container>
    <v-form
        ref="form"
        @submit.prevent="updateAd"
    >
        <v-text-field
        v-model="form.title"
        label="Title"
        required
        ></v-text-field>
        <span class="red--text" v-if="errors.title">{{errors.title[0]}}</span>

        <markdown-editor v-model="form.body"></markdown-editor>

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

        <v-card-actions >
            <v-btn icon small type="submit" >
                <v-icon color="green">save</v-icon>
            </v-btn>
            <v-btn icon small @click="cancel" >
                <v-icon color="black">cancel</v-icon>
            </v-btn>
        </v-card-actions>
    </v-form>
    </v-container>
</template>

<script>
export default {
    props: ['ad'],
    data(){
        return {
            form: {
                title: null,
                category_id: null,
                body: null,
                amount: 0,
                featured: 0,
            },
            errors: {},
            fileList: [            ],
            upload: {
                name:'',url:''
            },
            isShowPic: false
        }
    },
    methods: {
        updateAd() {
            let form = new FormData();
            form.append('title', this.form.title);
            form.append('category_id', this.form.category_id);
            form.append('body', this.form.body);
            form.append('amount', this.form.amount);
            form.append('featured', this.form.featured);
            this.form =  form;
            const filesRaw = this.fileList.map(f => f.raw);
            console.log(filesRaw); return;
            for (const file of filesRaw) {
                    this.form.append('files[]', file, file.name)
                }

            axios.patch(`/api/ad/${this.ad.slug}`, this.form)
            .then(res => this.cancel())
            .catch(error => error.response.data);
        },
        cancel() {
            EventBus.$emit('cancelEditing');
        },
        handleRemove(file, fileList) {
            var filename = file.url.replace('/storage/image/','');
            if(!file.uid) return;
            let vm = this
            axios.delete('/api/upload/' + filename)
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
        }
    },
    mounted() {
        this.form = this.ad;
    },
    created() {
        this.ad.uploads.forEach(item => {
            //this.fileList.push(a);
            var title = '';
            var link = "/storage/image/"+item.filepath;
            this.fileList.push({'name' : title, 'url' : link });
            });
    }


}
</script>

<style>

</style>
