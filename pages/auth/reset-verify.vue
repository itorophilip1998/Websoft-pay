<template>
    <div class="pt-5 ">
      <loader v-if="loading"/>
      <div class="row m-0">
        <div class="col-md-5  px-lg-5 pt-md-5 mt-lg-3   rounded-lg py-4" >
           <div class="alert alert-primary alert-dismissible fade show p-2" role="alert" v-if="email!='404' && message">
            
            <strong><i class="fa fa-bell-o text-info" aria-hidden="true"></i> Hello {{ details.email }}!</strong> We have send a reset link to your email address 📩.<br>
            <hr>
            I didn`t receive it 
            <button @click="verify()"  class="btn btn-sm btn-info link rounded-lg">Resent</button> 
          </div>

           <div class="alert alert-danger alert-dismissible fade show p-2" role="alert" v-if="email=='404' && message">
            
            <strong><i class="fa fa-bell-o text-danger" aria-hidden="true"></i> Hello {{ details.email }}!</strong> We can`t find your email address 📩.<br>
            <hr> 
            <button @click="email='';message=false"  class="btn btn-sm btn-danger link rounded-lg">Confirm</button> 
          </div>  

            <form @submit.prevent="verify()" v-if="!message">
            <h6 class="text-info">Verify Your Email</h6>    
            <div class="form-group ">
                <label for=""><i class="fa fa-envelope-o" aria-hidden="true"></i> Email</label>
                <input required type="email" v-model="details.email" class="form-control" name="" id="" aria-describedby="emailHelpId" placeholder="Email">
                <small id="emailHelpId" class="form-text text-danger" v-if="error.email">{{ error.email[0] }}</small>
              </div>
    
            
              <div class="form-group"> 
                
            <button class="btn btn-info my-2 w-100"> Submit </button> 

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
  import loader from '@/components/loader'
export default { 
    auth: false,
    components:{ 
        loader
    },
    data() {
        return {
            passwordCheckData:false,
            details:{ 
                email:'' ,
                pin_reset:false,
            },
            error:[],
            loading:false,
            message:false,
            email:''

        }
    },
    mounted() {
       this.details.email=(window.location.hash.slice(1))?
       window.location.hash.slice(1):
       "";
       this.details.pin_reset=(window.location.search.slice(1)=="pin") ? true:false; 
    },
    methods: {
        verify()
        { 
          let email=this.details.email
          this.loading=!this.loading
            this.$router.push(`#${email}`)
            this.$axios.post(`/api/auth/password/email`,this.details)
            .then((res)=> {  
             this.loading=!this.loading
             this.message=true

            })
            .catch((error)=> { 
          this.loading=!this.loading
             this.message=true

            if (error.response.status == 422) {
              this.error = error.response.data.errors; 
            } 
            if (error.response.status == 401) {
              this.email = "404"; 
            } 
            })
        }
    }
}
</script>

<style >
    .d{
        text-decoration: underline !important;
    }

</style>