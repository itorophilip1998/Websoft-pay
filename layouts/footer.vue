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
             </div>
             <div class="col-md-2 pb-3">
              <h6 class="text-info pl-3">Contact Us</h6>

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
       </footer>
    </div>
</template>
 
