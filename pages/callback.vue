<template>
    <div>
          <loader/>  
    </div>
</template>
<script>
 import loader from '@/components/loader' 
export default { 
   auth: "guest",
   components:{ 
        loader
    },
   data() {
       return {     
           details:{
                email:'',
                password:'',
            },
       }
   },
    
    mounted(){
        const params=new URLSearchParams(window.location.search)   
    this.details= {
        email:params.get('e'),
        password:params.get('p')
    } 
    this.signin()
   }, 
methods: {
    async signin(){    
           this.loading=!this.loading  
         try {
            let res=  await this.$auth.loginWith('laravelJWT', { data: this.details}) 
            this.loading=!this.loading     
             location.href='/dashboard' 
         } catch (error) {
             this.loading=!this.loading  
             location.href='/auth/signin'
         }    
        },
},
}
</script>