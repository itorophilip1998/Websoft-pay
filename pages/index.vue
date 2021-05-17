<template>
    <div class="mt-5">
        
   <main>
       <!-- background BG -->
     <div class="bgBackground">
        <div class="bgOverlay  px-md-5">
            <div class="bg text-left  pl-2 row m-0">
                <div class="col-lg-6">
                    <h1 class="bgtext d-none d-md-block" >
                        Recharge <span class="text-info">Any</span>where<small>,</small>
                        <span class="text-info">Any</span>time and <span class="text-info">Any</span>place
                    </h1>
                    <h3 class="bgtext d-block d-md-none" >
                        Recharge <span class="text-info">Any</span>where<small>,</small>
                        <span class="text-info">Any</span>time and <span class="text-info">Any</span>place
                    </h3>
                    <span class="bgsmalltext text-justify d-block">
                        Pay your bills anytime, as long as you have a bank account to fund your wallet, you can buy/sell airtime, Subscribe Data/Tv/Electricity, Transfer/recieve money and generate remitta
                    </span> 
                     <nuxt-link to="/dashboard" class="btn btn-info shadow mt-2">
                        Get Started Now>
                     </nuxt-link>
                </div>

            </div>
        </div>
     </div>



     <!-- how it works section -->
     <div class="row py-4 px-md-5 m-0">
         <div class="col-12 text-center py-0">
             <div class="title d-inline p-2  ">
                 <u>How Does It works?</u>
                <p class="lead text-center m-0">
                 Our services help you in many ways you can only imagine like paying bills at home, transfer and recieve payment accross the world </p>
               </div>
         </div>
          <div class="col-md-6 col-12 col-lg-4 mt-4 px-md-4" v-for="(item, index) in services" :key="index">
                <div :class="`card shadow mx-3  rounded-l link zoom border-${item.color}`" @click="$router.push(item.link)" > 
                    <div class="card-body text-center ">
                        <h5 class="card-icon "> 
                            <i :class="`${(item.icon=='rrr')? 'fa ':item.icon} text-${item.color}`" aria-hidden="true">
                                <strike v-if="item.icon=='rrr'">(R)</strike>
                            </i>
                        </h5>
                        <h5 :class="`card-title  px-2 text-${item.color}`">{{ item.name }}</h5>
                        <p class="card-text text-center text-dark">{{ item.details }}</p>
                    </div>
                    <!-- <div class="card-footer text-center  pt-0 rounded-l border-0  bg-white">
                        <nuxt-link :to="item.link" class=" btn  shadow btn-info rounded-l p-1 px-4">
                            Try Now
                        </nuxt-link>
                    </div> -->
                   
                </div>
          </div> 
     </div>
<!-- contact -->
     <div id="contactus" class="section py-5 bg-light">
        <div class="col-12 text-center p-2">
            <div class="title d-inline  my-2 ">
                <u>Let's Us Know!</u> 
                <p class="lead text-center m-0">Let us give you more details about the special app you want us. Please fill out the form below, we will attend to you!</p>
            </div>
        </div>
        <div class="mx-md-5"> 
            <div class="row m-0">
                <div class="col-xl-6 col-md-12 col-sm-12">
                    <div class="contact_form"> 
                        <form id="contactform"  action="/contact" method="post"> 
                            <div class="row m-0">
                                <div class="form-group col-12">
                                    <input type="text" name="name" id="first_name" class="form-control p-4 border-info" placeholder="FirstName LastName">
                                </div> 
                                <div class="form-group col-12">
                                    <input type="email" name="email" id="email" class="form-control p-4 border-info" placeholder="Your Email">
                                </div> 
                                <div class="col-12 form-group ">
                                    <textarea class="form-control border-info" name="message" rows="8" placeholder="Give us more details.."></textarea>
                                </div>
                                <div class="text-left  form-group  col-12 pl-3">
                                    <button type="submit" value="SEND"  id="submit" class="btn btn-info btn-radius btn-brd grd1 ">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- end col -->
				<div class="col-xl-6 col-md-12  p-0 col-sm-12">
						<div style="width: 100%"><iframe width="100%" height="411" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=Ikot%20Ekpene%20-%20Abak%20Rd,%20Ukana+(School)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe></div>

				</div>
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end section -->


       <!-- section testimonials -->
       <section class="testimonials p-3  bg-info" id="testimonials">
        <div class="col-12 text-center p-2">
            <div class="title d-inline text-white  my-2 ">
                <u>Testimonails!</u> 
                <p class="lead text-center m-0 ">Client Messages with testimonies!</p>
            </div>
        </div> 
                 <div class="testimonails">
                     <div class="row content-justify-center">
                         <div class="col-md-4 col-sm-6 zoom  m-auto">
                             <div class="card rounded-l shadow-sm my-2">
                                 <div class="card-body">
                                     <h6 class="card-title">
                                     <a href="~assets/images/testimonial5.jpg"> <img class="testimonailsImg rounded-circle" src="~assets/images/testimonial5.jpg" alt=""></a> Miracle Idiong</h6>
                                     <p class="card-text text-dark text-justify">
                                      Websoftpay has been good to me, No scam, you redraw when ever you want to redraw.
                                         
                                     </p>


                                 </div>
                             </div>

                         </div>
                         <div class="col-md-4 col-sm-6 zoom m-auto">
                         <div class="card shadow-sm rounded-l my-2">
                                 <div class="card-body">
                                     <h6 class="card-title">
                                        <a href="~assets/images/testimonial4.jpg"><img class="testimonailsImg rounded-circle" src="~assets/images/testimonial4.jpg" alt=""></a> Idorenyin Smart</h6>
                                     <p class="card-text text-dark text-justify">
                                         I recharge and i sell my airtime with websoftpay and get my money back every time i have excess airtime.
                                     </p>
                                 </div>
                             </div>
                         </div>
                         <div class="col-md-4 col-sm-6 zoom m-auto">
                         <div class="card shadow-sm rounded-l my-2">
                                 <div class="card-body">
                                     <h6 class="card-title ">
                                     <a href="~assets/images/testimonial3.jpg"><img class="testimonailsImg rounded-circle" src="~assets/images/testimonial3.jpg" alt=""></a> Ubong Keyzz</h6>
                                     <p class="card-text text-dark">Cheap charge in every device i recharge, i enjoy websoftpay with all the features available.
                                     
                                     </p>

                                   </div>
                             </div>
                         </div>
                     </div>
                 </div>
        </section>
  
 </main>
         <mfooter/> 
    </div>
</template> 
<script>
import mfooter from '@/components/mobilefooter' 
export default {
    auth: false, 
   components:
   {
       mfooter
   },
   data() {
       return {
        services:[
        {
                name:"Transfer",
                details:"Animi quia eos maxime? Aliquid itaque nulla magni qui quidem dolorum id, asperiores recusandae eaque.",
                link:'/services/transfer',
                icon:'fa fa-money',
                color:'info',
            },
            {
                name:"Airtime",
                details:"Animi quia eos maxime? Aliquid itaque nulla magni qui quidem dolorum id, asperiores recusandae eaque.",
                link:'/services/airtime',
                icon:'fa fa-phone',
                color:'danger',

            },
            {
                name:"Data",
                details:"Animi quia eos maxime? Aliquid itaque nulla magni qui quidem dolorum id, asperiores recusandae eaque.",
                link:'/services/data',
                icon:'fa fa-globe',
                color:'primary',


            }, 
            {
                name:"TV-cables",
                details:"Animi quia eos maxime? Aliquid itaque nulla magni qui quidem dolorum id, asperiores recusandae eaque.",
                link:'/services/tv',
                icon:'fa fa-television',
                color:'success',


            },
             
           
            {
                name:"Remitta",
                details:"Animi quia eos maxime? Aliquid itaque nulla magni qui quidem dolorum id, asperiores recusandae eaque.",
                link:'/services/remitta',
                icon:'rrr',
                color:'pink', 
            },
            {
                name:"Electricity",
                details:"Animi quia eos maxime? Aliquid itaque nulla magni qui quidem dolorum id, asperiores recusandae eaque.",
                link:'/services/electricity',
                icon:'fa fa-lightbulb-o',
                color:'warning',

            },
        ]
       }
   },
}
</script>

<style>
.title{
    font-size: 25px;
    text-align: center;
    font-weight: bold;
    color: var(--dark); 
}
.card-icon{
    font-size: 35px; 
}
.text-pink{
    color:var(--purple)
}
.border-pink{
    border-color:var(--purple)
}
</style>