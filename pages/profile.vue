<template>
    <div class="pt-5 mt-3 px-md-5">
         <div class="row m-0 ">
             <div class="col-md-4  p-md-3  ml-auto  d-md-block d-none">
              <sidebar/>
             </div>
             <div class="col-md-7 p-md-3 px-lg-5 mr-auto  ">
                 <div class="row"> 
                     <div class="col-12  p-md-3 text-center p-1"> 
                         <h4 class="text-secondary">Profile Details </h4> 
                        <div class="money border shadow  bg-info rounded-l p-2 pl-3 pb-md-3">
                            <img class="img-fluid  rounded-pill" style="width:120px;height:120px" src="~assets/images/avater.png" alt="">
                         <h6 class="text-white"><i class="fa fa-user" aria-hidden="true"></i> <span class=" text-capitalize">{{ $auth.user.name }}</span></h6>
                         <h6 class="text-white"><i class="fa fa-envelope-o" aria-hidden="true"></i> <span>{{ $auth.user.email }}</span></h6>
                         <h6 class="text-white"><i class="fa fa-phone" aria-hidden="true"></i> <span>{{ $auth.user.accounts.phone }}</span></h6>
                        
                         <hr>
                         <h6 class="text-white">Account Name: <small>{{ $auth.user.accounts.account_name }}</small></h6>
                         <h6 class="text-white">Account Number: <small class=" text-capitalize">{{ $auth.user.accounts.account_number }}</small></h6>
                         <h6 class="text-white">Account Type: <small class=" text-capitalize">{{ $auth.user.accounts.account_type }}</small></h6>  
                         <hr> 
                         <h6 class="text-white">Bank Name: <small class=" text-capitalize">{{ $auth.user.accounts.bank_name }}</small></h6>
                         <h6 class="text-white">Wallet ID: <small class=" text-capitalize">{{ $auth.user.accounts.wallet_id }}</small></h6>   
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
export default {
//   auth:false,
   components:
   {
       mfooter,
       sidebar
   },
   data() {
       return { 
        seeMoney:false
       }
   },
   methods: {
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