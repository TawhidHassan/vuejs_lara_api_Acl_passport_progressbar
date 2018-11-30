<template>
    <div class="container">
       
        <div class="col-xs-12 mt-5" v-if="$gate.isAdminOrAuthor()">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">User list</h3>
              <div class="box-tools">
                <a href="#" type="button" class="btn btn-success" @click="newModal">Add new <i class="fas fa-plus-square"></i></a>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody><tr>
                  <th>ID</th>
                  <th>Namw</th>
                  <th>Email</th>
                  <th>Type</th>
                  <th>Bio</th>
                  <th>Regestered at</th>
                  <th>Action</th>
                </tr>

                <tr v-for="user in users.data" :key="user.id">
                  <td>{{user.id}}</td>
                  <td>{{user.name | upText}}</td>
                  <td>{{user.email}}</td>
                  <td><span class="label label-success">{{user.type | upText}}</span></td>
                  <td>{{user.bio}}</td>
                  <td>{{user.created_at | myDate}}</td>
                  <td>
                  	<a href="#" class="btn btn-info" @click="editModal(user)">
                      <i class="fas fa-edit"></i>
                  	</a>
                  	<a href="#" class="btn btn-danger" @click="deleteUser(user.id)">
                      <i class="fas fa-trash-alt"></i>
                  	</a>
                  </td>
                </tr>
              </tbody></table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
             <!--  <pagination :data="users" @pagination-change-page="getResults"></pagination> -->
            </div>
          </div>
          <!-- /.box -->
        </div>
       <div v-if="!$gate.isAdminOrAuthor()">
            <not-found></not-found>
        </div>
       <!-- Modal -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" v-show="!editmode" id="addLabel">ADD NEW</h5>
        <h5 class="modal-title" v-show="editmode" id="addLabel">UPDATE</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form @submit.prevent="editmode ? updateuser():creatuser()">
      <div class="modal-body">
     <div class="form-group">
      <input v-model="form.name" type="text" name="name"
        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" placeholder="Enter Name">
      <has-error :form="form" field="name"></has-error>
    </div> 
    <div class="form-group">
      <input v-model="form.email" type="email" name="email"
        class="form-control" :class="{ 'is-invalid': form.errors.has('email') }" placeholder="Enter Email">
      <has-error :form="form" field="email"></has-error>
    </div>
    <div class="form-group">
      <input v-model="form.bio" type="text" name="bio"
        class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }" placeholder="Enter bio">
      <has-error :form="form" field="bio"></has-error>
    </div>
     <div class="form-group">
       <select name="type" v-model="form.type" id="type" class="form-control" :class="{'is-invalid': form.errors.has('type') }">
         <option value="">Select type</option>
         <option value="admin">Admin</option>
         <option value="user">User</option>
         <option value="author">Author</option>
       </select>
       <has-error :form="form" field="type"></has-error>  
     </div>
     <div class="form-group">
      <input v-model="form.password" type="text" name="password"
        class="form-control" :class="{ 'is-invalid': form.errors.has('password') }" placeholder="Enter password">
      <has-error :form="form" field="password"></has-error>
    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" v-show="!editmode" class="btn btn-primary">Creat</button>
        <button type="submit" v-show="editmode" class="btn btn-success">UPDATE</button>
      </div>
      </form>
    </div>
  </div>
</div>
    </div>
</template>

<script>
    export default {
      data(){
         return{
          editmode:false,
          users:{},
          form:new Form({
            id:'',
            name:'',
            email:'',
            password:'',
            type:'',
            bio:'',
            photo:''
          })
         }
      },
      methods:{
       /* for search*/
         getResults(page = 1) {
                        axios.get('api/user?page=' + page)
                            .then(response => {
                                this.users = response.data;
                            });
                },
        updateuser(){
          this.$Progress.start();
           this.form.put('api/user/'+this.form.id)
           .then(()=> {
             swal(
              'Updated!',
              'data has been Updated.',
              'success'
             )
             $('#add').modal('hide')
          Fire.$emit('AfterCreated'); /*for real time show data global Fire*/
             this.$Progress.finish();
           })
           .catch(()=>{
             this.$Progress.fail();
           });
        },
        newModal(){
          this.editmode=false;
          this.form.reset();
         $('#add').modal('show')

        },
        editModal(user){
          this.editmode=true;
          this.form.reset();
         $('#add').modal('show')
         this.form.fill(user);
        },
        creatuser(){
          this.$Progress.start();
          this.form.post('api/user')  /*api dia aivaba data save kora laga*/
          .then(()=>{
            $('#add').modal('hide') /*for close modal after input data in form*/
          Fire.$emit('AfterCreated'); /*for real time show data global Fire*/
          toast({ /*tostar notification*/
            type: 'success',
            title: 'User createdin successfully'
          })
          this.$Progress.finish();

          }) 

          .catch(()=>{
            this.$Progress.fail()
          })
          
        },
        loaduser(){
          if(this.$gate.isAdminOrAuthor()){
            axios.get("api/user").then(({data}) => (this.users=data/*.data*/));  /* ".data" is use for get all kind of information like user id*/
          }
          
        },
        deleteUser(id){
                  swal({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
         this.$Progress.start();
         if (result.value) {
         /* send requset the server*/
         this.form.delete('api/user/'+id).then(()=>{
           
            swal(
              'Deleted!',
              'data has been deleted.',
              'success'
             )
         
          Fire.$emit('AfterCreated'); /*for real time show data global Fire*/
          this.$Progress.finish();
         })   /* send requset the server*/

         .catch(()=>{
           swal("Failed!","There was something Wrong.","warning");
         });
          }
        
          

})
        }
      },
        created() {
          /*for search*/
           Fire.$on('searching',() => {
                let query = this.$parent.search;
                axios.get('api/findUser?q=' + query)
                .then((data) => {
                    this.users = data.data
                })
                .catch(() => {
                })
            })
           this.loaduser();
            /*2nd ruls is called here to real time swo data*/ 
            Fire.$on('AfterCreated',()=>{      /*()--->function*/
              this.loaduser();

            });
          
           /*2nd ruls is called here to real time swo data*/

           /**setInterval(()=>this.loaduser(),2000);*//* 2nd ruls is app.js ar moddha*/ /*for refrexsh the data to auto show data*/
        }
    }
</script>
