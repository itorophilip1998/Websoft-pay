<template>
    <div class="pt-5 mt-3 px-md-5">
         <div class="row m-0 ">
             <div class="col-md-4  p-md-3  ml-auto  d-md-block d-none">
              <sidebar/>
             </div>
             <div class="col-md-7 p-md-3 px-lg-5 mr-auto  ">
                 <div class="row"> 
                     <div class="col-12  p-3 "> 
                         <h6 class="text-info">Hello <span class="text-muted text-capitalize font-italic">{{ $auth.user.name }}</span> 😎</h6>
                        <div class="money border shadow  bg-info rounded-l p-2 pl-3 pb-md-3">
                         <small class="tmuted">Wallet Balance </small> 
                         <i v-if="seeMoney" @click="moneyCheck('show')" class="fa fa-eye tmuted link" aria-hidden="true"></i>
                         <i v-if="!seeMoney" @click="moneyCheck('hide')" class="fa fa-eye-slash tmuted link" aria-hidden="true"></i>
                             <input type="text" ref="money" :value="'₦'+$auth.user.accounts.account_balance+' .00'" class="form-control  border-0 moneyText pl-0" readonly > 
                            <button  @click="$router.push('/services/transfer')" class="btn btn-info btn-sm topup  shadow rounded-l w-25">Top-up</button>
                            <button  @click="$router.push('/services/redraw')" class="btn bg-secondary btn-info text-white border-0  shadow btn-sm ml-3 rounded-l w-25">Redraw</button>
                        </div>

                   </div> 
                   <div class="col-12   mt-3 "> 
                    <div class="transaction shadow border-info border rounded-lg">
                        <h6 class="text-info border-info  border-bottom p-2 text-center">Transactions Details</h6>
                         <table class="table table-light text-center   text-muted  ">
                             <thead   >
                                 <tr >
                                     <th>Beneficiary</th>
                                     <th>Type</th>
                                     <th>Date</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <tr class="text-danger link">
                                     <td class="text-center"><small>089278625752</small></td>
                                     <td class="text-center"><small>airtime</small></td>
                                     <td class="text-center"><small><i>20/2/2021 2:30pm</i></small></td>
                                 </tr>
                                 <tr class="text-success link">
                                     <td class="text-center"><small>09078925673</small></td>
                                     <td class="text-center"><small>Data</small></td>
                                     <td class="text-center"><small><i>20/2/2021 2:30pm</i></small></td>
                                 </tr>
 
                            
                             </tbody> 
                              
                         </table>
                         <div class="row m-0 pl-3 border-top border-info text-center">
                             <small class="col-12 p-0 m-0 text-success"><i class="fa fa-circle " aria-hidden="true"></i> Successful &emsp;</small>
                             <small class="col-12 p-0 m-0 text-danger"><i class="fa fa-circle " aria-hidden="true"></i> Unsuccessful</small>
                         </div>
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