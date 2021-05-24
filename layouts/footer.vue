<template>
    <div>
       <footer  class="bg-light shadow-sm border-top" >
        <div class="container py-4">
           <div class="row m-0 ">
             <div class="col-md-6 pb-3" id="about">
               <h6 class="text-info">About</h6>
              <p>
            Websoft-pay is a semi-bank web and mobile app which uses
              modern wallet application format to get(receive) money,
              pay(transfer) money and use(bill payment) money from your
              local bank and across the world. Websoft-pay is a product
              of websoft company.
              </p>
              <p>
                <form >
                  <label for="email" class="tmuted pl-2">Subscribe For Daily Updates></label>
                  <input class="form-control p-4 rounded-pill shadow-sm" type="text" id="email" v-model="email" placeholder="Email address">
                  <button @click="subEmail()"  type="button" class="btn btn-info rounded-pill shadow subBtn">Send</button>
                </form>
              </p>
             </div>
             <div class="col-md-2 pb-3">
              <h6 class="text-info pl-3">Contact</h6>

               <ul class="p-0 footer">
                 <li>
                   <nuxt-link to="#" class="text-info dropdown-item""><i class="fa fa-facebook" aria-hidden="true"></i>&ensp;Facebook</nuxt-link>
                 </li>
                 <li>
                   <nuxt-link to="#" class="text-info dropdown-item""><i class="fa fa-instagram" aria-hidden="true"></i> Instagram</nuxt-link>
                 </li>
                 <li>
                   <nuxt-link to="#" class="text-info dropdown-item""><i class="fa fa-linkedin" aria-hidden="true"></i> Linkedin</nuxt-link>
                 </li>

               </ul>
             </div>
             <div class="col-md-4 pb-3">
              <h6 class="text-info pl-3">Services</h6>
              <nuxt-link class="dropdown-item" to="/services/redraw"><strike>N</strike>&ensp;<span>Redraw</span></nuxt-link>
                <nuxt-link class="dropdown-item" to="/services/airtime"><i class="fa fa-phone" aria-hidden="true"></i>&ensp;<span>Buy Airtime</span></nuxt-link>
                <nuxt-link class="dropdown-item" to="/services/data"><i class="fa fa-globe" aria-hidden="true"></i>&ensp;<span>Buy Data</span></nuxt-link>
                <nuxt-link class="dropdown-item" to="/services/tv"><i class="fa fa-television" aria-hidden="true"></i> <span>Tv-cables Subscription</span></nuxt-link>
                <nuxt-link class="dropdown-item" to="/services/electricity"><i class="fa fa-lightbulb-o ml-1" aria-hidden="true"></i>&ensp; <span>Electricity Subscription</span></nuxt-link>
                <nuxt-link class="dropdown-item" to="/services/remitta"><strike>(R)</strike> Remitta</nuxt-link>
                </div>

           </div>

        </div>
        <div class="col-12 border-top text-center bg-info text-white p-2">
          Copyright <i class="fa fa-copyright" aria-hidden="true"></i>2021 by Websoft<span class="tmuted">(websoft-pay v1)</span>
       </div>
       </footer>
    </div>
</template>
<script>
export default {
  data() {
    return {
      email:''
    }
  },
  methods: {
    subEmail(){
      this.loading=!this.loading
        this.$axios.post('/api/email-update',{email:this.email}).then((res)=>{
          this.loading=!this.loading
          this.$swal({
                icon: 'success',
                text: "We will get back to you soon!",
                showConfirmButton: false,
                timer: 2500
                })
                this.contact={
          name:"",
          email:"",
          message:"",
           }
        }).catch((error)=>{
          this.$swal({
                icon: 'error',
                text: error.response.data.message || "No Internet Service",
                showConfirmButton: false,
                timer: 2500
                })
             this.loading=!this.loading
        })
    }
  },
}
</script>
<style scoped>
  .subBtn{
    margin-top: -44px;
    position: absolute;
    right: 20px;
  }
</style>
