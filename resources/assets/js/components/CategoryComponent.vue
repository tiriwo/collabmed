<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="/manage/assets">Assets</a>
                <button type="button" class="btn btn-sm btn-primary float-right" @click="initCreateCategory">
                    Add Category
                </button>
            </div>

            <div class="modal modal-lg" id="category_modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">{{ crud }} Category</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input name="name" v-model="category.name" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" v-model="category.description"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" v-if="crud==='Add'" class="btn btn-outline-primary float-left" @click="saveCategory">Save</button>
                            <button type="button" v-if="crud==='Edit'" class="btn btn-outline-primary float-left" @click="updateCategory">Update</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
          <table class="table table-light table-striped">
              <tr>
                 <th>Name</th><th>description</th><th>Manage</th>
              </tr>
              <tr v-for="category in categories">
                  <td>{{ category.name }}</td>
                  <td>{{ category.description }}</td>
                  <td><button @click="editCategory(category)" class="btn btn-outline-warning">Edit</button> </td>
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
                category:{},
                categories:[],
                crud:'Add'
            }
        },
        mounted(){
         this.getCategories();
        },
        methods:{
            getCategories(){
              axios.get('/api/categories').then(resp=>{
                   this.categories=resp.data;
              })
            },
            initCreateCategory(){
               this.category={};
               $('#category_modal').modal('show');
            },
            saveCategory(){
                axios.post('/manage/categories',this.category)
                    .then(resp=>{
                       toastr.success('category created');
                       $('#category_modal').modal('hide');

                       this.getCategories();
                    })
            },
            editCategory(category){
                this.category=category;
                this.crud='Edit';
                $('#category_modal').modal('show');
            },
            updateCategory(){
                axios.patch('/manage/categories/'+this.category.id,this.category).then(resp=>{
                    toastr.success('category updated');
                    $('#category_modal').modal('hide');
                })
            }
        }
    }
</script>
<style>
    @import "~toastr/build/toastr.css";
</style>
