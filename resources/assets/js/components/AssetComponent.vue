<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <button type="button" class="btn btn-primary float-right" @click="initCreateAsset">
                Add Asset
            </button>
            </div>

            <div class="modal modal-lg" id="asset_modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">{{ crud }} Asset</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">
                           <div class="form-group">
                               <label>Name</label>
                               <input name="name" v-model="asset.name" class="form-control"/>
                           </div>
                            <div class="form-group">
                                <label>Description</label>
                               <textarea class="form-control" v-model="asset.description"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Category</label>
                                <select id="category" v-model="asset.category_id" class="form-control" placeholder="select category">
                                  <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button v-if="crud==='Add'" type="button" class="btn btn-outline-primary float-left" @click="saveAsset">Save</button>
                            <button v-if="crud==='Edit'" type="button" class="btn btn-outline-primary float-left" @click="updateAsset">Save</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <hr class="w-100">
        <div class="row">
            <table class="table table-light table-bordered table-striped">
                <tr>
                    <th>Name</th><th>description</th>Category<th>Manage</th>
                </tr>
                <tr v-for="asset in assets">
                    <td>{{ asset.name }}</td>
                    <td>{{ asset.description }}</td>
                    <td v-text="categories.find(x => x.id === asset.category_id).name"></td>
                    <td><button @click="editAsset(asset)" class="btn btn-outline-warning">Edit</button> </td>
                </tr>

            </table>
        </div>
    </div>
</template>

<script>
import toastr from 'toastr';
export default {
        data(){
            return{
               asset:{},
               crud:'Add',
               categories:[],
                test:'me',
               assets:[]
            }
        },
        mounted(){
            this.getCategories();
            this.getAssets();
        },
        methods:{
            initCreateAsset(){
                this.asset={};
                this.crud='Add';
                $('#asset_modal').modal('show');
            },
            saveAsset(){
               axios.post('/manage/assets',this.asset).then(resp=>{
                   toastr.success('Asset Added');
                   $('#asset_modal').modal('hide');
                   this.getAssets();
               })
            },
            getCategories(){
                axios.get('/api/categories').then(resp=>{
                    this.categories=resp.data;
                })
            },
            getAssets(){
                axios.get('/api/assets').then(resp=>{
                    this.assets=resp.data;
                })
            },
            editAsset(asset){
               this.asset=asset;
               this.crud='Edit';
               $('#asset_modal').modal('show');
            },
            updateAsset(){
                axios.patch('/manage/assets/'+this.asset.id,this.asset).then(resp=> {
                    toastr.success('Asset Details Updated');
                    $('#asset_modal').modal('hide');
                })
            },
            getCategory(category_id){
              axios.get('/manage/categories/'+category_id).then(resp=>{
                 return resp.data.category.name
              })
            }
        }
}
</script>
<style>
    @import "~toastr/build/toastr.css";
</style>
