<template>
    <div class="pt-5 mt-3 px-md-5">
        <loader v-if="loading"/>

         <div class="row m-0 ">
             <div class="col-md-4  p-md-3  ml-md-auto  d-md-block d-none">
              <sidebar/>
             </div>
             <div class="col-md-7 p-md-3 px-lg-5 mr-md-auto px-0 ">

                 <div class="row m-0 p-1">
                    <ul class=" serviceUl text-center col-12  my-3 m-0 p-0">
                        <h6 class="text-dark text-center" v-if="!airtime.name">Network Available </h6>
                        <!-- <h6 class="text-dark text-center" v-else>{{ airtime.name }} Selected</h6> -->
                        <li class="mx-md-2" @click="airtime.name='MTN'" >
                           <img src="~/assets/images/mtn.png" class="serviceLogo shadow" alt="">
                        </li>
                        <li class="mx-md-2" @click="airtime.name='AIRTLE'" >
                           <img src="~/assets/images/airtel.png"  class="serviceLogo shadow"alt="">
                        </li>
                        <li class="mx-md-2" @click="airtime.name='GLO'" >
                           <img src="~/assets/images/glo.jpeg" class="serviceLogo shadow" alt="">
                        </li>
                        <li class="mx-md-2" @click="airtime.name='9MOBILE'" >
                           <img src="~/assets/images/9mobile.jpeg" class="serviceLogo shadow" alt="">
                        </li>
                        <hr class="m-0 mt-1 ">
                   </ul>

                     <div class="col-12  p-3  border shadow  bg-info rounded-l p-2 pl-3 pb-md-3">

                          <div class="airtime" v-if="!next">
                        <span class="text-white">Buy Data Bundle NG </span>
                            <div class="airtime text-white">
                                <div class="form-group">
                                    <small class="tmuted">Network</small>
                                  <select name="bundle" id="bundle"  v-model="airtime.network" class="custom-select h-50 link  text-muted" style="height: 50px !important;">
                                      <option value="" selected>Select Bundle</option>
                                      <option v-for="(item, index) in network" :key="index" >{{ item.name }}</option>
                                  </select>
                                  <!-- <small id="helpId" class="form-text text-muted">Help text</small> -->
                                </div>
                                <div class="form-group" v-if="airtime.network">
                                    <small class="tmuted">Bundle Plan</small>
                                  <select name="bundle"  @change="selectedBundleCheck()"  id="bundle"  v-model="selectedBundle" class="custom-select h-50 link  text-muted" style="height: 50px !important;">
                                      <option value="" selected>Select Bundle</option>
                                      <template v-for="data in loadData"   >
                                        <option  :value="item" v-for="(item, index) in data.bundle" :key="index">
                                            {{ item.plan }}
                                        </option>
                                      </template>

                                  </select>
                                  <!-- <small id="helpId" class="form-text text-muted">Help text</small> -->
                                </div>
                           </div>
                           <div class="airtime text-white">
                               <small  class=" d-block tmuted">Beneficiary</small>
                               <div class="form-check d-inline mr-2">
                                   <span class="form-check-label p-1 ">
                                   <input type="radio" class="form-check-input link " @click="airtime.beneficiaryType='Self';airtime.customer=$auth.user.accounts.phone"
                                    name="beneficiary" id=""  checked >
                                   Self
                                 </span>
                               </div>
                               <div class="form-check d-inline">
                                   <span class="form-check-label p-1 ">
                                       <input type="radio" class="form-check-input link"  @click="airtime.beneficiaryType='Thirdparty';airtime.customer=''" name="beneficiary" id=""  >
                                       Thirdparty
                                     </span>
                               </div>
                           </div>
                           <div class="airtime text-white" v-if='airtime.beneficiaryType=="Thirdparty"'>
                                <div class="form-group">
                                  <input type="text"  class="form-control p-4" v-model="airtime.customer" name="" id="" aria-describedby="helpId" placeholder="Beneficiary Phone ">
                                  <!-- <small id="helpId" class="form-text text-muted">Help text</small> -->
                                </div>
                           </div>
                           <button @click="next=true" v-if="airtime.amount && airtime.customer" class="btn btn-info shadow rounded-l topup btn-sm mt-1">Next</button>
                          </div>

                          <div class="pin" v-else>
                            <small class="tmuted">Subscribe Data bundle of ₦{{ currencyFormat(airtime.amount) }} to {{ airtime.customer }}</small>

                            <div class="form-group">
                                <input type="password"  class="form-control p-4" v-model="transaction_pin" name="" id="" aria-describedby="helpId" placeholder="Transaction Pin">
                                <!-- <small id="helpId" class="form-text text-muted">Help text</small> -->
                              </div>
                            <button @click="next=false"  class="btn btn-info shadow rounded-l topup btn-sm mt-1"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
                            <button @click="loadAirtime()" v-if="transaction_pin.length==4" class="btn btn-info shadow rounded-l topup btn-sm mt-1">Proceed</button>
                          </div>
                   </div>
                 </div>

             </div>

         </div>
         <mfooter/>
    </div>
</template>

<script>
import mfooter from '@/components/mobilefooter'
import sidebar from '@/components/sidebar'
import moment from 'moment';

export default {
//   auth:false,
   components:
   {
       mfooter,
       sidebar
   },
   data() {
       return {
           airtime:{
                country:"NG",
                name:"",
                amount:"",
                beneficiaryType:'',
                customer:this.$auth.user.accounts.phone,
                reference:'',
                type:"AIRTIME",
                recurrence: "ONCE",
                network:'',
           },
         flutterHeader:JSON.parse(localStorage.getItem('flutterHeader')),
        seeMoney:false,
        loading:false,
        next:false,
        transaction_pin:"",
        selectedBundle:"",
        network:[
            {
                    name:'AIRTEL'
            },
            {
                    name:'MTN'
            },
            {
                    name:'9MOBILE'
            },
            {
                    name:'GLO'
            },
        ],
        bundles:[
            {
               network:"MTN" ,
               bundle:[
                   {
                       price:100,
                       plan:"100mb daily plan",
                   },
                   {
                       price:200,
                       plan:"200mb 3days plan",
                   },
                   {
                       price:300,
                       plan:"1GB weekly plan",
                   },
                   {
                       price:500,
                       plan:"1.5GB monthly plan",
                   },
               ]
            },
            {
               network:"GLO" ,
               bundle:[
                   {
                       price:100,
                       plan:"100mb daily plan",
                   },
                   {
                       price:200,
                       plan:"200mb 3days plan",
                   },
                   {
                       price:300,
                       plan:"1GB weekly plan",
                   },
                   {
                       price:500,
                       plan:"1.5GB monthly plan",
                   },
               ]
            },
            {
               network:"9MOBILE" ,
               bundle:[
                   {
                       price:100,
                       plan:"100mb daily plan",
                   },
                   {
                       price:200,
                       plan:"200mb 3days plan",
                   },
                   {
                       price:300,
                       plan:"1GB weekly plan",
                   },
                   {
                       price:500,
                       plan:"1.5GB monthly plan",
                   },
               ]
            },
            {
               network:"AIRTEL" ,
               bundle:[
                   {
                       price:100,
                       plan:"100mb daily plan",
                   },
                   {
                       price:200,
                       plan:"200mb 3days plan",
                   },
                   {
                       price:300,
                       plan:"1GB weekly plan",
                   },
                   {
                       price:500,
                       plan:"1.5GB monthly plan",
                   },
               ]
            },
        ],
       }
   },
   computed:{
    loadData(){
        return this.bundles.filter((item)=>{
           return item.network.match(this.airtime.network)
        })
    }
   },
   methods: {
    selectedBundleCheck()
    {
        this.airtime.amount=this.selectedBundle.price
        // this.airtime.amount=this.selectedBundle.price
        console.log(this.selectedBundle)
    },
    currencyFormat(amount)
         {
            return (amount).toLocaleString('en-US', {
            currency: 'NGN',
            minimumFractionDigits: 2
            });
         },
       loadAirtime()
       {
            this.$axios.post('/api/verifypin',{'transaction_pin':this.transaction_pin}).then((res)=>{
            this.airtime.reference='AT-'+moment(Date()).format('hhmmssmmm')
            this.loading=!this.loading
               axios.post('/v3/bills', this.airtime,this.flutterHeader).then((res)=>{
               this.loading=!this.loading;
                }).catch((error)=>{
                    this.loading=!this.loading
                   if(error.response.status==400)
                   {
                    this.$swal({
                    icon: 'error',
                    text: error.response.data.message,
                    showConfirmButton: false,
                    timer: 2500
                    })
                   }else{
                    this.$swal({
                    icon: 'error',
                    text: "No Network or poor internet connection",
                    showConfirmButton: false,
                    timer: 2500
                    })
                   }

                })
           }).catch((error)=>{
            if(error.response.status==401)
                   {
                    this.$swal({
                    icon: 'error',
                    text: error.response.data.message,
                    showConfirmButton: false,
                    timer: 2500
                    })
                   }
           })


       },
    moneyCheck(data){
             if (data=="show") {
                 this.seeMoney=!this.seeMoney;
                 this.$refs.money.type="text"
             }
             else{
                this.seeMoney=!this.seeMoney;
                this.$refs.money.type="password"
             }
        }
   },
}
</script>

<style>

    .moneyText{
        font-size: 35px;
        cursor: default;
        color: rgb(250, 250, 250) !important;
    }
    .moneyText:focus{
        color: rgb(250, 250, 250) !important;
    }
    th,td{
        padding: 1px !important;
    }
    .topup
    {
        background:rgba(7, 81, 104, 0.596) !important;
        border: none !important;
    }
    .topup:hover
    {
        background:rgba(4, 46, 59, 0.596) !important;
    }
</style>
