<template>
    <div class="container">
        <hr class="w-100">
        <div class="row card">
            <div class="card-header">
              <h5 class="card-title text-center">Available Assets</h5>
            </div>
            <div class="card-body">
              <table class="table table-light table-bordered table-striped">
                <tr>
                    <th>Name</th><th>description<th>Request</th>
                </tr>
                <tr v-for="asset in assets">
                    <td>{{ asset.name }}</td>
                    <td>{{ asset.description }}</td>
                    <td><button @click="borrowAsset(asset)" class="btn btn-sm btn-outline-warning">Borrow</button> </td>
                </tr>
            </table>
            </div>
        </div>
        <hr class="w-100">
        <div class="row card">
            <div class="card-header">
               <h5 class="card-title text-center">Assets pending approval</h5>
            </div>
            <div class="card-body">
              <table class="table table-light table-bordered table-striped">
                <tr>
                    <th>Name</th><th>description<th>Request</th>
                </tr>
                <tr v-for="asset in pending">
                    <td>{{ asset.name }}</td>
                    <td>{{ asset.description }}</td>
                    <td><button @click="cancelBorrowRequest(asset)" class="btn btn-sm btn-outline-danger">Cancel</button> </td>
                </tr>
            </table>
           </div>
        </div>
        <hr class="w-100">
        <div class="row card">
            <div class="card-header">
                <h5 class="card-title text-center">Assets Under Your possession</h5>
            </div>
            <div class="card-body">
                <table class="table table-light table-bordered table-striped">
                    <tr>
                        <th>Name</th><th>description</th>
                    </tr>
                    <tr v-for="asset in borrowed">
                        <td>{{ asset.name }}</td>
                        <td>{{ asset.description }}</td>
                    </tr>
                </table>
            </div>
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
                assets:[],
                pending:[],
                borrowed:[]
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
                axios.get('/user/getAssets').then(resp=>{
                    this.assets=resp.data.available;
                    this.pending=resp.data.pending;
                    this.borrowed=resp.data.borrowed;
                })
            },
            borrowAsset(asset){
                axios.post('/user/request',asset).then(resp=>{
                    toastr.success('Your request for '+asset.name+' has been sent');
                    this.getAssets();
                })
            },
            cancelBorrowRequest(asset){
              axios.post('/user/cancel-request',asset).then(resp=>{
                  this.getAssets();
                  toastr.warning('You have cancelled your request for '+asset.name)
              })
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
