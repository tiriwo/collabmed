<template>
    <div class="container">
        <div class="row">
            <div class="modal modal-lg" id="asset_modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">{{ crud }} Asset Assignment</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">
                            <div class="form-group">
                                <label>Reason for Rejecting request</label>
                                <textarea class="form-control" v-model="item.reason"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button  type="button" class="btn btn-outline-primary float-left" @click="submitDenyAsset">Submit</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <hr class="w-100">
        <div class="row">
            <table class="table table-light table-bordered table-striped">
                <tr>
                    <th>Employee Name</th><th>Asset Requested</th><th>Manage</th>
                </tr>
                <tr v-for="item in list">
                    <td v-text="users.find(x => x.id === item.user_id).name"></td>
                    <td v-text="assets.find(x => x.id === item.asset_id).name"></td>
                    <td>
                        <button @click="allowAsset(item)" class="btn btn-sm btn-outline-success">Allow</button>
                        <button @click="denyAsset(item)" class="btn btn-sm btn-outline-danger">Deny</button>
                    </td>
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
                assets:[],
                users:[],
                item:{},
                list:[]
            }
        },
        mounted(){
            this.getList();
        },
        methods:{


            getList(){
               axios.get('/manage/list').then(resp=>{
                   this.assets=resp.data.assets;
                   this.list=resp.data.list;
                   this.users=resp.data.users;
               });
            },


            denyAsset(item){
                console.log(item);
                this.item=item;
                this.crud='Manage';
                $('#asset_modal').modal('show');
            },
            submitDenyAsset(){
                axios.post('/manage/deny-asset/',this.item).then(resp=> {
                    toastr.info('Borrowing list updated');
                    $('#asset_modal').modal('hide');
                    this.getList();
                })
            },
            allowAsset(item){
                axios.post('/manage/allow-asset/',item).then(resp=>{
                    toastr.success('Asset assigned successfully');
                    this.getList();
                })
            }
        }
    }
</script>
<style>
    @import "~toastr/build/toastr.css";
</style>
