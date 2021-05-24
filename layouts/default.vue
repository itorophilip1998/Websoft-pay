<template>
  <div>  
<!-- <link rel="shortcut icon" href="~assets/images/logo.png" type="image/x-icon"> -->
  <mainHeader/>
    <Nuxt  />   
  <mainFooter v-if="!checkLinks()"/>
  </div>
</template>

<script>
import mainHeader from './header'
import mainFooter from './footer'
export default {
  components:{
    mainHeader,
    mainFooter,
  },
 

  methods: {
    checkLinks()
    {
       if(this.$route.path=="/"){
           return false
      }  
      else{
        return true
      }
    }
  },
}
</script>
 