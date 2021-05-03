<template>
    <div class="pt-5 mt-3 px-md-5">
         <div class="row m-0 ">
             <div class="col-md-4  p-md-3  ml-auto  d-md-block d-none">
              <sidebar/>
             </div>
             <div class="col-md-7 p-md-3 px-lg-5 mr-auto  ">
                 <div class="row"> 
                     <div class="col-12  p-3 "> 
                        <div class="inactive">
                            <div class="alert alert-warning text-left fade show" role="alert"> 
                                <strong><i class="fa fa-bell-o" aria-hidden="true"></i> Account Update:</strong> Please your account is not activated and you cannot make transactions... 
                                <a class="link text-dark d-block d-md-inline" data-toggle="modal"
                                  data-target="#activate"> <u>Activate now</u></a> 
                                <!-- Activate -->
                                <div class="modal fade" id="activate" tabindex="-1" role="dialog"
                                  aria-labelledby="modelTitleId" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-body">
                                        <form @submit.prevent="makePayment()">
                                          <div class="border-0 text-dark">
                                            <span>Transaction Pin <small class="text-danger">*</small></span> 
                                          <input type="text"
                                            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                            maxlength="4" minlength="4"
                                            class="form-control p-4"   v-model.number="amount" placeholder="Secure Pin(4 digits. e.g 1234) for every transaction"
                                           >
                                          <small id="errorNetwork" class="form-text text-danger" >Poor/No Internet Connection... try again</small>
                                          </div>
                                          <button type="submit" class="btn btn-info btn-sm mt-2 rounded-l shadow"
                                            v-if="btn">Add Money</button>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                            </div>
                        </div>
{{ $auth.user.accounts }}
                         <h6 class="text-info">Hello <span class="text-muted text-capitalize font-italic">{{ $auth.user.name }}</span> 😎</h6>
                        <div class="money border shadow  bg-info rounded-l p-2 pl-3 pb-md-3">
                         <small class="tmuted">Wallet Balance </small> 
                         <i v-if="seeMoney" @click="moneyCheck('show')" class="fa fa-eye tmuted link" aria-hidden="true"></i>
                         <i v-if="!seeMoney" @click="moneyCheck('hide')" class="fa fa-eye-slash tmuted link" aria-hidden="true"></i>
                             <input type="text" ref="money" :value="'₦'+$auth.user.accounts.account_balance+' .00'" class="form-control  border-0 moneyText pl-0" readonly > 
                            <button data-toggle="modal" data-target="#modelId" class="btn btn-info btn-sm topup  shadow rounded-l w-25">Top-up</button>
                            <button  @click="$router.push('/services/redraw')" class="btn bg-secondary btn-info text-white border-0  shadow btn-sm ml-3 rounded-l w-25">Redraw</button>
                        </div> 
                        
                        <!-- Topup -->
                        <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content"> 
                                    <div class="modal-body">
                                        <form @submit.prevent="makePayment()" > 
                                        <div class="border-0"> 
                                            <span>Amount(₦)</span> 
                                        </div>
                                        <input  type="number" id="amount" min="1" step="1" class="form-control p-4" v-model.number="amount" placeholder="₦100 above, e.g(10000)" @input="getAmount()"> 
                                         <small id="errorNetwork" class="form-text text-danger " style="display: none;">Poor/No Internet Connection... try again</small>  
                                        <button type="submit" class="btn btn-info btn-sm mt-2 rounded-l shadow" v-if="btn">Add Money</button>
                                        </form>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        

                   </div> 
                   <div class="col-12   mt-3 "> 
                    <div class="transaction shadow border-info bg-info text-white border rounded-lg">
                        <h6 class="text-white border-white bg-info   border-bottom p-2 text-center">Transaction Details</h6>
                         <table class="table  text-center text-dark " >
                             <thead  >
                                 <tr scope="row">
                                     <th scope="col">Beneficiary</th>
                                     <th scope="col">Type</th> 
                                     <th scope="col">Date</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <tr class="link text-white">
                                     <td class="text-center  tmuted"><small><b>089278625752</b></small></td>
                                     <td class="text-center"><small>airtime</small></td> 
                                     <td class="text-center"><small><i>20/2/2021 2:30pm</i></small></td>
                                 </tr>
                                 <tr class="link text-white">
                                     <td class="text-center text-warning"><small><b>09078925673</b></small></td>
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
//   auth:false,
   components:
   {
       mfooter,
       sidebar
   },
   data() {
       return { 
        seeMoney:false,
        btn:false,
        amount:''
       }
   },
   mounted() { 
   },
   methods: {
    makePayment() { 
        try {
             this.$launchFlutterwave({
             tx_ref: 'Tfw'+Date.now(),
             amount: this.amount,
             currency: 'NGN',
             payment_options: 'card,mobilemoney,ussd',
             customer: {
             // email: this.$auth.user.email,
             email: "itorophilip1998@gmail.com",
             phonenumber: this.$auth.user.accounts.phone || "",
             name: this.$auth.user.name
             },
             callback: function(data) {
                 window.axios = require('axios');
                 window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'; 
                 window.axios.defaults.headers.common['Authorization'] = 
                 window.localStorage.getItem('auth._token.laravelJWT');

                 console.log(axios.defaults.headers.common)
                   axios.post('/api/top-up',data).then((res)=>
                   {
                    //   location.reload() 
                   }).catch((error)=>{  
                    //   location.reload() 
                   })

 
             },
             customizations: {
             title: 'Websoft-Pay',
             description: 'Wallet top-up',
             logo:
             'data:image/png;base64,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'
             }
             })
        } catch (error) {
            document.getElementById('errorNetwork').style.display='block' 
        }
     },
    getAmount()
    { 
         (this.amount >= 100)? this.btn=true:this.btn=false;
           var inputBox = document.getElementById("amount"); 
                var invalidChars = [
                "-",
                "+",
                "e",
                ];

                inputBox.addEventListener("input", function() {
                this.value = this.value.replace(/[e\+\-]/gi, "");
                });

                inputBox.addEventListener("keydown", function(e) {
                if (invalidChars.includes(e.key)) {
                    e.preventDefault();
                }
                });
         
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
    .table thead th,.table td{ 
    border: 2px solid var(--info);
}
 
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