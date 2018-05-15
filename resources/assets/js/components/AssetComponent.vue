<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#asset_modal">
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
                                <label>Name</label>
                               <textarea class="form-control" v-model="asset.description"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-primary float-left" @click="saveAsset">Save</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
        data(){
            return{
               asset:{},
               crud:'Add',
               assets:[]
            }
        },
        mounted(){
            console.log(this.initCreateAsset());
            console.log('if empty');
        },
        methods:{
            initCreateAsset(){

            },
            saveAsset(){
                console.log(this.asset);
            }
        }
}
</script>
