<template>
    <div class="pt-5 mt-3 px-md-5">
         <div class="row m-0">
             <div class="col-md-5  p-md-3   d-md-block d-none">
              <sidebar/>
             </div>
             <div class="col-md-7 p-md-3 px-lg-5  ">
                 <div class="row">
                     <div class="col-12  p-3">
                         <h6 class="text-info">Hello <span class="text-muted">Itoro Emmanuel!</span></h6>
                        <div class="money border shadow  border-info rounded-l p-2 pl-3">
                         <small class="text-muted">Wallet Total Amount</small> 
                         <i v-if="seeMoney" @click="moneyCheck('show')" class="fa fa-eye text-info link" aria-hidden="true"></i>
                         <i v-if="!seeMoney" @click="moneyCheck('hide')" class="fa fa-eye-slash text-muted link" aria-hidden="true"></i>
                             <input type="text" ref="money" v-model="amount" class="form-control border-0 moneyText pl-0" readonly > 
                            <button class="btn btn-info btn-sm  shadow rounded-l w-25">Top-up</button>
                            <button class="btn btn-outline-info shadow btn-sm ml-3 rounded-l w-25">Redraw</button>
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
   components:
   {
       mfooter,
       sidebar
   },
   data() {
       return {
        amount:"200,00000000.00",
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
    .form-control:disabled, .form-control[readonly]
    {
         background-color:white !important
    }
    .moneyText{
        font-size: 35px;
        cursor: default;
        color: rgb(172, 169, 169) !important;
    }
    th,td{
        padding: 1px !important;
    } 
</style>    