<template>
    <div class="pt-5 ">
      <loader v-if="loading"/>
      <div class="row m-0">
        <div class="col-md-5  px-lg-5 pt-md-5 mt-lg-3   rounded-lg py-4">
            <form @submit.prevent="verify()">
            <div class="form-group text-center "> 
            <h6 class="text-info">We just send a code to your email</h6>    

                <input required  @input="validate('a')" id="a" type="text" v-model="details.a" class="token form-control mx-lg-2"  maxlength="1"/> 
                <input required  @input="validate('b')" id="b" type="text" v-model="details.b" class="token form-control mx-lg-2" maxlength="1"/> 
                <input required  @input="validate('c')" id="c" type="text" v-model="details.c" class="token form-control mx-lg-2" maxlength="1"/> 
                <input required  @input="validate('d')" id="d" type="text" v-model="details.d" class="token form-control mx-lg-2" maxlength="1"/> 
                <input required  @input="validate('e')" id="e" type="text" v-model="details.e" class="token form-control mx-lg-2" maxlength="1"/> 
                <br>
                <small id="emailHelpId" class="form-text text-danger" v-if="error">{{ error }}</small>
              </div>
    
            
              <div class="form-group"> 
                
            <button class="btn btn-info my-2 w-100" type="submit"> Submit </button> <br>
          I didn`t get the code <a class="d text-info link" @click="resend()">Resend</a> 

            <div class="text-center pt-3 border-top mt-3">  
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
    auth: 'guest',
  
     
    mounted() {
       document.getElementById('a').focus(); 
    },
    data() {
        return { 
            details:{ 
                a:'' ,
                b:'' ,
                c:'' ,
                d:'' ,
                e:'' 
            },
            error:'', 
            loading:false
        }
    },
    methods: {
        validate(data)
        { 
             if (data=="a" && this.details.a && this.details.a !=' ') {
                this.nextData('b',data)
             }
             else if (data=="b" && this.details.b && this.details.b !=' ') {
                this.nextData('c',data)
             }  
             else if (data=="c" && this.details.c && this.details.c !=' ') {
                this.nextData('d',data)
             }  
             else if (data=="d" && this.details.d && this.details.d !=' ') {
                this.nextData('e',data)
             }  
             else if (data=="e" && this.details.e && this.details.e !=' ') {
                this.nextData('a',data)
             }  
            
            if(this.details.a && this.details.b && this.details.c && this.details.d && this.details.e)
             {  
                this.nextData('a',data);
               this.verify(); 
             }
        },
        nextData(next,current)
        {
            let p=document.getElementById(current)
            let n=document.getElementById(next)
            if(p){
                n.focus()
            } 
        },
        resend()
        {  
         let email=window.location.hash.slice(1)
          this.loading=!this.loading

         this.$axios.post(`${baseurl}/auth/signup/resend-link`,{
           email:email
           }).then((res)=>{
          this.loading=!this.loading 
           })
        },
        verify()
        {  
          this.loading=!this.loading
         let vCode=this.details.a+this.details.b+this.details.c+this.details.d+this.details.e  
         let email=window.location.hash.slice(1) 
            
             this.$axios.get(`/api/auth/verified/${email}/${vCode}`)
            .then((res)=> {  
            this.$router.push(`signin#${email}`)
          this.loading=!this.loading

            })
            .catch((error)=> {  
          this.loading=!this.loading

            if (error.response.status == 401) {
              this.error = "Invalid Code"; 
              return false;
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
.token
{
    width: 40px ;
    display:inline;

}
</style>