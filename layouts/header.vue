<template>
    <div >
      
         <nav class="navbar navbar-expand-md shadow  fixed-top navbar-light bg-light">
        <span   class="navbar-brand link" @click="urlget('/')">
        <!-- <img class="logo" src="~assets/images/logo.png" alt=""> -->
        <span >
        <strong class="text-secondary">
          Websoft-<span class="text-info">pay</span>
        </strong>
        </span>
        </span> 

        <div  class="dropdown d-md-none d-inline ml-auto"  v-if="$auth.loggedIn && activeClick"> 
          <i class="fa fa-user text-info link p-2" aria-hidden="true"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i> 
            <div class="dropdown-menu logoutPanel p-0 rounded-l" aria-labelledby="my-dropdown"> 
              <span @click="logoutMe()" class="dropdown-item  text-center link py-3 rounded-l logoutItems" href="#">logout</span>
            </div>
          </div> 

        <button v-if="activeClick" @click="activeClick=!activeClick" class="navbar-toggler d-lg-none border-0" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
            aria-expanded="false" aria-label="Toggle navigation">
          <span class="fa fa-bars"></span>
        </button>
        <button  v-if="!activeClick" @click="activeClick =! activeClick" class="navbar-toggler d-lg-none border-0" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="fa fa-close"></span> 
        </button>
        <div  class="collapse navbar-collapse" id="collapsibleNavId">
          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item">
              <span  class="nav-link link" @click="urlget('/dashboard')">{{($auth.loggedIn)? "Dashboard" : "Home"}}</span>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle " href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Services</a>
              <div class="dropdown-menu bg-light border-0 shadow " aria-labelledby="dropdownId"> 
                <span class="dropdown-item link"  @click="urlget('/services/transfer')"><i class="fa fa-money" aria-hidden="true"></i> <span>Transfer</span></span>
                <span class="dropdown-item link" @click="urlget('/services/redraw')"><strike>N</strike>&ensp;<span>Redraw</span></span>
                <span class="dropdown-item link" @click="urlget('/services/airtime')"><i class="fa fa-phone" aria-hidden="true"></i>&ensp;<span>Buy Airtime</span></span>
                <span class="dropdown-item link" @click="urlget('/services/data')"><i class="fa fa-globe" aria-hidden="true"></i>&ensp;<span>Buy Data</span></span>
                <span class="dropdown-item link" @click="urlget('/services/tv')"><i class="fa fa-television" aria-hidden="true"></i> <span>Tv-cables Subscription</span></span>
                <span class="dropdown-item link" @click="urlget('/services/electricity')"><i class="fa fa-lightbulb-o ml-1" aria-hidden="true"></i>&ensp; <span>Electricity Subscription</span></span>
                <span class="dropdown-item link" @click="urlget('/services/remitta')"><strike>(R)</strike> Remitta</span>
              </div>
            </li>
              <li class="nav-item">
              <span class="nav-link link" @click="urlget('/#contactus')">Contact Us</span>
            </li>
              <li class="nav-item">
              <span class="nav-link link" @click="urlget('/#about')">About</span>
            </li> 
          </ul>
          <form class="form-inline my-2 my-lg-0" v-if="!$auth.loggedIn">
            <span @click="urlget('/auth/signup')" class="btn btn-p shadow-sm rounded-l  btn-outline-info my-2 my-sm-0 btn-sm mx-1 rounded-lg" >Signup</span>
            <span @click="urlget('/auth/signin')" class="btn btn-p shadow-sm  rounded-l btn-info my-2 my-sm-0 btn-sm mx-1 rounded-lg" >Signin</span>
          </form>
          <form v-else>
          <div class="dropdown d-none d-md-inline"> 
          <i class="fa fa-user text-info link p-2" aria-hidden="true"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i> 
            <div class="dropdown-menu logoutPanel p-0 rounded-l" aria-labelledby="my-dropdown"> 
              <span @click="$auth.logout()" class="dropdown-item  text-center link py-3 rounded-l logoutItems" href="#">logout</span>
            </div>
          </div>
           
          </form>
        </div>
      </nav>
    </div>
</template>
<script>
export default {
  data() {
    return {
      activeClick:true
    }
  },
  methods: {
    logoutMe(){ 
       this.activeClick==false
      this.$auth.logout()
    },
     urlget(data)
     { 
      let collapsibleNavId= document.getElementById('collapsibleNavId') 
      collapsibleNavId.classList.remove('show') 
      this.activeClick=!this.activeClick 
      this.$router.push(data)
     }
  },
}
</script>
<style>
  .closeIcon{
    font-weight: bold;
    font-family: Corbel;
    font-size: 25px;
  }
  .iconClick:hover{
    color:#17a2b8
  }
</style>