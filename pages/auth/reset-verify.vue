<template>
    <div class="pt-5 ">
      <div class="row m-0">
        <div class="col-md-5  px-lg-5 pt-md-5 mt-lg-3   rounded-lg py-4">
            <form @submit.prevent="verify()">
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
export default { 
    // auth: 'guest', 
    data() {
        return {
            passwordCheckData:false,
            details:{ 
                email:'' 
            },
            error:[]
        }
    },
    methods: {
        verify()
        { 
             
        }
    }
}
</script>

<style >
    .d{
        text-decoration: underline !important;
    }

</style>