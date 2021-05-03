<template>
    <div class="pt-5 ">
      <div class="row m-0">
        <loader v-if="loading"/>
        <div class="col-md-5  px-lg-5 pt-md-5 mt-lg-3   rounded-lg py-4">
            <form @submit.prevent="reset()"> 
            <h6 class="text-info">Reset Password</h6>    
            <div v-if="message !=''" class="alert alert-danger alert-dismissible fade show" role="alert">
              <button type="button" class="close"  @click="message=''" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <span >{{ message }}</span> 
            </div>
             
            <div class="form-group ">
                <label for=""><i class="fa fa-lock" aria-hidden="true"></i> New Password</label>
                <input required minlength="5" v-model="details.password" type="password" class="form-control" name="" ref="password" aria-describedby="emailHelpId" placeholder="minimum 5 characters"> 
                <small id="emailHelpId" class="form-text text-danger" v-if="error.password">{{ error.password[0] }}</small>
              </div>
            <div class="form-group "> 
                <label for=""><i class="fa fa-lock" aria-hidden="true"></i> Confirm Password</label>
                <input required minlength="5" v-model="details.password_confirmation" type="password" class="form-control" name="" ref="password" aria-describedby="emailHelpId" placeholder="">
              </div>

              <div class="form-group"> 
                
            <button class="btn btn-info my-2 w-100"> Reset </button> 

            <div class="text-center pt-3">  
                <nuxt-link class="text-muted d"  to="/#about">About</nuxt-link> |
                <nuxt-link class="text-muted d"  to="/#contact">Contact</nuxt-link> |
                <nuxt-link class="text-muted d"  to="signin">Signin</nuxt-link> |
                <nuxt-link class="text-muted d"  to="signup">Signup</nuxt-link> 
               
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
    import terms from '@/components/terms'
    import loader from '@/components/loader'
export default { 
    auth: 'guest',
    components:{
        terms,
        loader
    },
    data() {
        return {
            passwordCheckData:false,
            details:{ 
                password:'', 
                password_confirmation:'', 
                token:'', 
                email:'', 
            },
            error:[],
            loading:false,
            message:''
        }
    },
     
    methods: {
        reset()
        {  
            this.loading=true
              this.details.token=window.location.search.slice(1)
              this.details.email=window.location.hash.slice(1)
             this.$axios.post(`${baseurl}/auth/password/reset`,this.details).then((res)=>{  
               this.$router.push(`signin#${this.details.email}`) 
 
                this.loading=false 
            }).catch((error)=> {  
            this.loading=false;
            if (error.response.status == 401) {
            this.message = "No email reset request found"; 
            }  
            if (error.response.status == 422) {
              this.error = error.response.data.errors; 
            }  
            })  
        },
         
        
    },
}
</script>

<style >
    .d{
        text-decoration: underline !important;
    }

</style>