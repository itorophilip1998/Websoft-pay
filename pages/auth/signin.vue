<template>
    <div class="pt-5">
      <loader v-if="loading"/> 
      <div class="row m-0"  >
        <div class="col-md-5  px-lg-5 pt-md-5 mt-lg-5   rounded-lg py-4">
            <form  @submit.prevent="signin()">
            <h6 class="text-info">Welcome back!</h6>   
            <div class="form-group ">
                <label for=""><i class="fa fa-envelope-o" aria-hidden="true"></i> Email</label>
                <input type="email" v-model="details.email" required class="form-control border-info " name="" id="" aria-describedby="emailHelpId" placeholder="Email">
                <small id="emailHelpId" class="form-text text-danger" v-if="error.email">{{ error.email[0] }}</small>
              </div>
    
            <div class="form-group ">
                <label for=""><i class="fa fa-lock" aria-hidden="true"></i> Password</label>
                <input type="password"  v-model="details.password" required class="form-control border-info " name="" ref="password" aria-describedby="emailHelpId" placeholder="*******">
                <i v-if="!passwordCheckData" class="fa fa-eye link password-check  text-info" @click="passwordCheck('show')" aria-hidden="true"></i> 
                <i  v-if="passwordCheckData" class="fa fa-eye-slash password-check  link text-info" @click="passwordCheck('open')" aria-hidden="true"></i>
                <small id="emailHelpId" class="form-text text-danger" v-if="error.password">{{ error.password[0] }}</small>
              </div>

              <div class="form-group"> 
               <button type="submit" class="btn btn-info mt-1 border-0 shadow rounded-l">Signin</button>
               <small><nuxt-link class="text-info d"  to="reset-verify">Forgot password</nuxt-link></small>

                <br/>
               <small>I don`t have an account <nuxt-link class="text-info d"  to="signup">Signup</nuxt-link></small>
                  
                   <div class="row m-0  text-center">
                       <div class="col-5 p-0 pt-1">
                           <hr>
                       </div>
                       <div class="col-2 p-2 text-secondary">OR</div>
                       <div class="col-5 p-0 pt-1">
                        <hr>
                       </div> 
                   </div>
                   <button @click="googleOauth()"  class="btn btn-info border-0 shadow rounded-l my-2 w-100" type="button">
                    <i class="fa fa-google" aria-hidden="true"></i>  Signin With Google
                      </button>

            <div class="text-center pt-3">
                <nuxt-link class="text-muted d"  to="/#about">About</nuxt-link> |
                <nuxt-link class="text-muted d"  to="/#contact">Contact</nuxt-link> |
                <a class="text-muted d" data-toggle="modal" data-target="#modelId" href="#">Terms/Conditions</a>
               
                
                <!-- Modal -->
                <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-info">Terms and Conditions</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>
                            <div class="modal-body text-left">
                                <terms/>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>

              </div>
            </form>
        </div>
        <div class="col-md-7 d-none d-md-inline p-0 bgload">
            <div class="overlay text-center"> 
            </div>
         </div>
      </div>  
    </div>
</template>
<script>
    
export default { 
    auth: "guest",
   
    data() {
        return {
            passwordCheckData:false,
            details:{
                email:'',
                password:'',
            },
            error:[],
            loading:false
        }
    },
    mounted() {
          let email=window.location.hash.slice(1);
          if(email){
             this.details.email=email 
          }
    },
    methods: {  
       async signin(){     
           this.loading=!this.loading  
         
         try {
            let res=  await this.$auth.loginWith('laravelJWT', { data: this.details})  
            this.$swal({ 
                icon: 'success',
                text: "Logged In Succesfully👍",
                showConfirmButton: false,
                timer: 2500
                })  

            this.loading=!this.loading         
         } catch (error) {
             this.$swal({ 
                icon: 'error',
                text: error.response.data.message,
                showConfirmButton: false,
                timer: 2500
                })
             this.loading=!this.loading  

         }   
                
        },
        googleOauth()
      { 
        window.location.href=`${hosturl}/google`
      },

        passwordCheck(data){ 
             if (data=="show") {
                 this.passwordCheckData=!this.passwordCheckData;
                 this.$refs.password.type="text"    
             }
             else{
                this.passwordCheckData=!this.passwordCheckData;
                this.$refs.password.type="password"

             }
        }
     
    },
}
</script>

<style >
    .d{
        text-decoration: underline !important;
    }
</style>