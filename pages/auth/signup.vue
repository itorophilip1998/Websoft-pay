<template>
    <div class="pt-5 ">
      <loader v-if="loading"/>
      <div class="row m-0">
        <div class="col-md-5  px-lg-5 pt-md-5 mt-lg-3   rounded-lg py-4">
            <form @submit.prevent="signup()">
            <h6 class="text-info">Create Account</h6>
            <div class="form-group ">
                <label for=""><i class="fa fa-user-o" aria-hidden="true"></i> Name</label>
                <input type="text" minlength="5" maxlength="100"  v-model="details.name"  required class="form-control border-info" name="" id="" aria-describedby="emailHelpId" placeholder="Firstname Surname">
                <small id="emailHelpId" class="form-text text-danger" v-if="error.name">{{ error.name[0] }}</small>
              </div>
            <div class="form-group ">
                <label for=""><i class="fa fa-envelope-o" aria-hidden="true"></i> Email</label>
                <input required type="email"  maxlength="100" v-model="details.email" class="form-control border-info" name="" id="" aria-describedby="emailHelpId" placeholder="Email">
                <small id="emailHelpId" class="form-text text-danger" v-if="error.email">{{ error.email[0] }}</small>
              </div>

            <div class="form-group ">
                <label for=""><i class="fa fa-lock" aria-hidden="true"></i> Password</label>
                <input @input="passCheckerF" required minlength="7" maxlength="15" v-model="details.password" type="password" class="form-control border-info" name="" ref="password" aria-describedby="emailHelpId" placeholder="minimum 7 characters">
                <i v-if="!passwordCheckData" class="fa fa-eye link password-check  text-info" @click="passwordCheck('show')" aria-hidden="true"></i>
                <i  v-if="passwordCheckData" class="fa fa-eye-slash password-check  link text-info" @click="passwordCheck('open')" aria-hidden="true"></i>
                <Password v-if="passChecker" v-model="details.password" :strength-meter-only="true" :secureLength='5' /> 
                <small id="emailHelpId" class="form-text text-danger" v-if="error.password">{{ error.password[0] }}</small>
              </div>

              <div class="form-group ">
                <div class="form-check ">
                    <input id="my-input" @click="details.check =! details.check" class="form-check-input link" type="checkbox" name="" ref="terms" v-model="details.check" required>
                 <label for="my-input" class="form-check-label link">I accept <a class="text-muted d" data-toggle="modal" data-target="#modelId" href="#">Terms/Conditions</a></label>
                </div>
               <button class="btn btn-info mt-1 border-0 shadow rounded-l" type="submit">Signup</button>
               <br/>

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
                <nuxt-link class="text-muted d"  to="signin">Signin</nuxt-link>


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
import Password from 'vue-password-strength-meter' 

export default {
    auth: 'guest', 
    components:{
        Password
    },
    data() {
        return {
            passChecker:false,
            passwordCheckData:false,
            details:{
                name:'',
                role_id:3,
                email:'',
                password:null,
                check:false
            },
            error:[],
            loading:false
        }
    },
    mounted() {
       console.log(baseurl)

    },
    methods: { 
        passCheckerF()
        {
            (this.details.password !='')?this.passChecker=true:this.passChecker=false;
        },
      googleOauth()
      {
        window.location.href=`${hosturl}/google`
      },
        signup()
        {
            this.loading=true
            this.passChecker=false
            if(this.details.check){
             this.$axios.post(`${baseurl}/auth/signup`,this.details)
            .then((res)=> {
             this.loading=false
              this.$router.push(`/auth/verifyme#${res.data.email}`) 
            })
            .catch((error)=> {
            this.loading=false
            if (error.response.status == 422) {
              this.error = error.response.data.errors; 
            } else{
                this.$swal({ 
                icon: 'error',
                text: "Can`t create an account... try again!",
                showConfirmButton: false,
                timer: 2500
                })
            }
            })
            }
         

        },
        passwordCheck(data){
             if (data=="show") {
                 this.passwordCheckData=!this.passwordCheckData;
                 this.$refs.password.type="text";
             }
             else{
                this.passwordCheckData=!this.passwordCheckData;
                this.$refs.password.type="password";

             }
        }
    },
}
</script>

<style >
    .d{
        text-decoration: underline !important;
    }
    img.google
    {
        width: 20px;
        height: 20px;
    }

</style>
