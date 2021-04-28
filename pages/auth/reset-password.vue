<template>
    <div class="pt-5 ">
      <div class="row m-0">
        <div class="col-md-5  px-lg-5 pt-md-5 mt-lg-3   rounded-lg py-4">
            <form @submit.prevent="reset()"> 
            <h6 class="text-info">Reset Password</h6>   

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
export default { 
    // auth: 'guest',
    components:{
        terms
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
            error:[]
        }
    },
    methods: {
        reset()
        { 
             
        },
         
        
    },
}
</script>

<style >
    .d{
        text-decoration: underline !important;
    }

</style>