<template>
    <div class="pt-5 mt-3 px-md-5">
         <div class="row m-0 px-0 ">
            <loader v-if="loading"/>

             <div class="col-md-4  p-md-3  ml-md-auto  d-md-block d-none">
              <sidebar/>
             </div>
             <div class="col-md-7 p-md-3 px-lg-5 mr-md-auto   px-0  pb-5">
                 
                <div class="alert alert-warning alert-dismissible p-2 mx-1 mx-md-0" role="alert"> 
                    <strong><i class="fa fa-bell-o" aria-hidden="true"></i>
                     Note:
                    </strong> Bank Transfer only works for <b><u>Nigerian</u></b> bank account for now. Other countries are comming soon.
                </div>  
                <ul class="nav nav-pills m-0 px-3" id="pills-tab" role="tablist">
                    <li class="nav-item ">
                      <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Bank</a>
                    </li>
                    <li class="nav-item ">
                      <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Wallet</a>
                    </li> 
                  </ul>
                  <!-- bank -->
                  <div class="tab-content " id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="row m-0   "> 
                            <div class="col-12  px-1 pb-3 mt-0  "> 
                               <div class="money border shadow  bg-info rounded-l p-2 p-lg-3 pb-md-3" >
                                <span class="text-white">Transfer to Bank</span>  
                                <form @submit.prevent="transferMoney()">   
                                  <div v-if="!bankNext">
                                    <div class="border-0 text-light pb-2">
                                       <small class="tmuted">Amount(₦)</small>   
                                     <input  type="number" id="amount" autocomplete="off" min="1" step="1" class="form-control p-4 border-info" v-model.number="transfer.amount" placeholder="₦100 above..." @input="getAmount()">  
                                     </div>  
       
                                   <div class="border-0 text-light pb-2">
                                     <small class="tmuted">Account Number </small>  
                                   <input type="text" @input="validateBank()" maxlength="10" minlength="10"  class="form-control p-4 border-info" v-model="transfer.account_number" placeholder="Beneficiary" > 
                                   </div>  
                                   <div class="border-0 text-light pb-2"> 
                                     <div class="form-group m-0">  
                                         <small class="tmuted">Bank Name  
                                         <div v-if="bankLoading" class="spinner-border text-light border-1 " style="width: 1rem !important;height:1rem !important;" role="status">
                                             <span class="sr-only">Loading...</span>
                                         </div>
                                         <small v-if="bankError" @click="getBanks()" class="fa fa-refresh link text-light" aria-hidden="true"></small>
                                         </small>
                                         <select id="my-select" @change="validateBank()" v-model="selectedBanks"   class="custom-select link border-info" style="height:3rem !important;" name="" >
                                             <option value="">
                                                 Select Bank
                                             </option>
                                             <option  :value="item" v-for="(item, index) in banks" :key="index">
                                                 {{ item.name }}
                                             </option>
                                         </select>
                                     </div>
                                    
                                     <div class="border-0 text-light p-0" >  
                                         <small v-if="transfer.meta.first_name" style="color: #74e9ef!important">{{ transfer.meta.first_name }}</small> 
                                         <div v-if="validateAccLoading" class="spinner-border text-light border-1" style="width: 1rem !important;height:1rem !important;" role="status">
                                             <span class="sr-only">Loading...</span>
                                         </div>
                                         <small  v-if="validateAccErr" class="text-warning">Can`t resolve accounts details... try again <i @click="getBanks()" class="fa fa-refresh link text-dark" aria-hidden="true"></i></small> 
                                  </div> 
                                  </div>  
                                  <div class="form-group text-white">
                                      <small class="tmuted">Description</small>
                                      <textarea id="my-textarea" class="form-control" v-model="transfer.narration" name=""  rows="4" placeholder="Add some information"></textarea>
                                  </div>
                                   <button @click="checkNext('bank')" v-if="bankNext" class="btn btn-info btn-sm mt-1 topup rounded-l shadow">Next</button>
                                </div>

                                <div class="border-0 text-light py-2" v-else>
                                    <small class="tmuted">Transaction pin</small>   
                                  <input @input="checkProceed('bank')"  type="password" autocomplete="off" maxlength="4" minlength="4" class="form-control p-4 mb-2 border-info" v-model="transaction_pin" >  
                                 
                                  <button @click="bankNext=false"  type="submit" class="btn btn-info btn-sm mt-1 topup rounded-l shadow"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
                                  <button v-if="procceed"  type="button" data-toggle="modal" data-target="#pin"   class="btn btn-info btn-sm mt-1 topup rounded-l shadow">Proceed</button>
                                </div>
                                 </form> 
                               </div> 
                          </div>  
                        </div>
                    </div>
                    <!-- wallet -->
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="row m-0"> 
                            <div class="col-12  px-1  pb-3 mt-0 "> 
                               <div class="money border shadow  bg-info rounded-l p-2 p-lg-3 pb-md-3" >
                                <span class="text-white">Transfer to Wallet</span>  
                                <form @submit.prevent="transferMoney()">   
                                <div v-if="!next">
                                    <div class="border-0 text-light pb-2">
                                        <small class="tmuted">Amount(₦)</small>   
                                      <input  type="number" id="amount" autocomplete="off" min="1" step="1" class="form-control p-4 border-info" v-model.number="walletTransfer.amount" placeholder="₦100 above..." @input="getAmount()">  
                                      </div>  
        
                                    <div class="border-0 text-light pb-2">
                                      <small class="tmuted">Wallet ID</small>  
                                    <input type="text" @input="validateWallet()"   minlength="12" maxlength="12"  class="form-control p-4 border-info" v-model="walletTransfer.wallet_id" placeholder="Beneficiary" > 
                                    <div class="border-0  text-light p-0 m-0">   
                                     <div class="border-0 text-light p-0 m-0" >  
                                         <small v-if="walletTransfer.user" style="color: #74e9ef!important">{{ walletTransfer.user }}</small> 
                                         <div v-if="loadingUser" class="spinner-border text-light border-1" style="width: 1rem !important;height:1rem !important;" role="status">
                                             <span class="sr-only">Loading...</span>
                                         </div> 
                                  </div> 
                                  </div>  
                                    </div>  
                                   
                                   <div class="form-group text-white">
                                       <small class="tmuted">Description</small>
                                       <textarea id="my-textarea" class="form-control" v-model="walletTransfer.status" name="" rows="4" placeholder="Add some information"></textarea>
                                   </div>
                                    <button @click="checkNext('wallet')" v-if="walletNext"  type="button" class="btn btn-info btn-sm mt-1 topup rounded-l shadow">Next</button>
                                </div>
                                
                                <div class="border-0 text-light py-2" v-else>
                                    <small class="tmuted">Transaction pin</small>   
                                  <input @input="checkProceed('wallet')"  type="password" autocomplete="off" maxlength="4" minlength="4" class="form-control p-4 mb-2 border-info" v-model="transaction_pin" >  
                                 
                                  <button @click="next=false"  type="submit" class="btn btn-info btn-sm mt-1 topup rounded-l shadow"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
                                  <button v-if="procceed"  type="button" data-toggle="modal" data-target="#pin"   class="btn btn-info btn-sm mt-1 topup rounded-l shadow">Proceed</button>
                                </div>
                                 </form> 
                               </div> 
                          </div>  
                        </div>
                    </div> 
                  </div> 
                
                <!-- Modal -->
                <div class="modal fade" id="pin" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true" data-keyboard="false" data-backdrop="static">
                    <div class="modal-dialog" role="document" >
                        <div class="modal-content " >
                            <div class="modal-header" v-if="!transferSuccess && !transferError">
                                <h6 class="modal-title">Transfer Details</h6> 
                            </div>
                            <div class="modal-body p-1 p-md-2">
                                <div class="row m-0 data" v-if="!transferError && !transferSuccess" >
                                    <div class="col-6 p-0 ">
                                        <b>Beneficiary:</b> <br>
                                        <b>Beneficiary Name:</b> <br>
                                        <b>Bank Name:</b> <br>
                                        <b>Amount:</b> <br>
                                        <b>Ref Number:</b> <br> 
                                        <b>Type:</b> <br>
                                        <b>Description:</b> <br>
                                    </div>
                                    <div class="col-6 p-0">
                                        <span>{{ transferData.beneficiary }}</span> <br>
                                        <span>{{ transferData.user }}</span> <br>
                                        <span>{{ transferData.bank_name }}</span> <br>
                                        <span>₦{{ currencyFormat(transferData.amount) }}</span> <br>
                                        <span>{{ transferData.tx_ref }}</span> <br> 
                                        <span>{{ transferData.type }}</span> <br>
                                        <span >{{ transferData.status }} </span> <br>
                                    </div>
                                </div>
                                <div class="error p-0 m-0" v-if="transferError">
                                <div class="alert alert-danger m-0 text-center" role="alert">
                                    <strong>{{ ErrorInfo }}</strong> <br>
                                    <button class="btn btn-sm shadow  border-top-dark" @click="retry()">Try Again</button> 


                                </div>
                                </div>
                                <div class="success text-center p-0 m-0" v-if="transferSuccess && !transferError">
                                    <img src="~assets/images/success.png" class="my-3" style="width:70px;height: 70px;" alt=""> 
                                    <div class="alert alert-success m-0" role="alert">
                                        <strong>Transaction Successful</strong>   <br>
                                        <button class="btn btn-sm shadow" @click="retry()">Back</button> 

                                    </div>
                                </div>
                            </div>
                            <div class="border-top text-left  p-2" v-if="!transferSuccess && !transferError">
                                <button type="button" class="btn btn-secondary topup btn-sm shadow rounded-l" data-dismiss="modal">Cancel</button>
                                <button type="button" @click="storeTransfer()" class="btn  btn-info btn-sm shadow rounded-l">Transfer</button>

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
import sidebar from '@/components/sidebar';
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
    transfer:{
            account_bank:'',
            account_number:"",
            amount:"",
            narration:" ",
            reference:"",
            currency:"NGN",  
            reference:"",
            debit_currency:"NGN",
            meta:{
                first_name:'',
            }
        }, 
        walletTransfer:{
            amount:"",
            wallet_id:"",
            status:"",
            user:''
        },
        Id_num:moment().format('yyyymmdhhmmss'),
        banks:[],
        next:false,
        ErrorInfo:'',
        bankError:false,
        walletNext:false,
        bankNext:false,
        transferSuccess:false,
        transferError:false,
        bankLoading:false,
        validateAccErr:false,
        procceed:false,
        validateAccLoading:false,
        loadingUser:false,
        selectedBanks:'',
        transaction_pin:'',
        flutterHeader:JSON.parse(localStorage.getItem('flutterHeader')), 
        loading:false,
        transferData:{
            user_id:this.$auth.user.id, 
            beneficiary:'',  
            type:'',
            amount:'', 
            status:'',
            tx_ref:'',
            flw_ref:'',
            transaction_id:'',
            transaction_pin:'',
            user:'',
            bank_name:''
        }
       }
   },
   mounted() {
    this.getBanks();  
   },
   methods: {
       retry()
       {
        location.reload()
       },
    currencyFormat(amount)
         {
            return (amount).toLocaleString('en-US', { 
            currency: 'NGN',
            minimumFractionDigits: 2
            }); 
         },
    checkProceed(data)
    {
        this.procceed=false 
        if(this.transaction_pin.length == 4 )
        {
            if (data=='wallet') { 
            let w=this.walletTransfer 
                this.transferData={
                    user_id:this.$auth.user.id, 
                    beneficiary:w.wallet_id,  
                    type:data,
                    amount:w.amount, 
                    status:w.status,
                    tx_ref:'tx_ref'+ this.Id_num,
                    flw_ref:'flw_ref' + this.Id_num,
                    transaction_id:'T_id' + this.Id_num, 
                    user:w.user, 
                    bank_name:'Wallet_to_Wallet' ,
                    transaction_pin:this.transaction_pin 
                    
            } 
            this.procceed=true  
            }
            else if (data=='bank'){
            let t=this.transfer 
                this.transferData={
                    user_id:this.$auth.user.id, 
                    beneficiary:account_number,  
                    type:data,
                    amount:t.amount, 
                    status:t.narration,
                    tx_ref:t.reference,
                    flw_ref:'flw_ref' + this.Id_num,
                    transaction_id:'T_id' + this.Id_num, 
                    user:t.meta.first_name,   
            };
                this.procceed=true 
            }
        } 
    },
    checkNext(data)
    {  
        this.next=false 
        if (data=='wallet' && this.walletTransfer.wallet_id.length == 12  &&   this.walletTransfer.user !=''  &&  this.walletTransfer.status !='') {
            this.next=true
        }
        else if(data=='bank')
        {
            this.next=true

        }
    },
       storeTransfer()
       { 
           this.transferError=false
           this.transferSuccess=false 
           this.loading=!this.loading 
             this.$axios.post(`/api/transfer`,this.transferData).then((res)=>{
              this.transferSuccess=true  
              this.walletTransfer.user=res.data.data.user.name
            this.loading=!this.loading 
        }).catch((error)=>{     
            this.loading=!this.loading  
             if (error.response.status==400) {
                 this.transferError=true
                 this.ErrorInfo="Insufficent fund"
             } 
             else if(error.response.status==401) {
                 this.transferError=true ;
                 this.ErrorInfo="Invalid Transaction Pin" 
             }  
             else{
                //  location.reload()
             }
        }) 
       },
    validateWallet()
    {
         if(this.walletTransfer.wallet_id.length == 12){ 
        this.loadingUser=!this.loadingUser 
             this.$axios.get(`/api/get-wallet/${this.walletTransfer.wallet_id}`).then((res)=>{
              this.walletTransfer.user=res.data.data.user.name
              this.walletNext=true
              this.loadingUser=!this.loadingUser
             
        }).catch((error)=>{    
            this.walletTransfer.user="User not found!"
            this.loadingUser=!this.loadingUser   
        })
         }
       
    },
    transferMoney()
    { 
        this.loading =! this.loading 
        axios.post('/v3/transfers', this.transfer,this.flutterHeader).then((res)=>
        {  
            this.loading =! this.loading
            let id=res.data.data.id  
            axios.get(`/v3/transfers/${id}`,this.flutterHeader).then((res)=>{
                console.log(res)
            })
            //  this.$router.push('/callbacks/transfer')
        }).catch((error)=>{   
            this.loading =! this.loading 
            console.log(error) 
        })  
    },
    getAmount()
    {  
    var inputBox = document.getElementById("amount"); 
        var invalidChars = [  "-", "+", "e", ]; 
        inputBox.addEventListener("input", function() {
        this.value = this.value.replace(/[e\+\-]/gi, "");
        }); 
        inputBox.addEventListener("keydown", function(e) {
        if (invalidChars.includes(e.key)) {
            e.preventDefault();
        }
        });
         
    },
    getBanks()
       {  
         this.bankError=false
        this.bankLoading =! this.bankLoading 
        axios.get('/v3/banks/NG', this.flutterHeader).then((res)=>
        {  
          this.bankLoading =! this.bankLoading  
          this.banks=res.data.data 
        }).catch((error)=>{   
         this.bankLoading =! this.bankLoading  
         this.bankError=true 
        })  
       },  
    validateBank()
       { 
           if (this.transfer.account_number.length==10 && this.selectedBanks) {  
            this.validateAccLoading=!this.validateAccLoading 
               axios.post('/v3/accounts/resolve',{
                   account_number:this.transfer.account_number,
                   account_bank:this.selectedBanks.code, 
                },this.flutterHeader).then((res)=>{   
                    this.transfer.meta.first_name=res.data.data.account_name; 
                    this.transfer.account_bank=this.selectedBanks.code;  
                    this.transferData.bank_name=this.selectedBanks.name;  
                    this.validateAccErr=false 
                    this.validateAccLoading=!this.validateAccLoading 
                    this.bankNext=true
                }).catch((error)=>{    
                   this.validateAccErr=true
                   this.validateAccLoading=!this.validateAccLoading
                   this.transfer.meta.first_name="";  
                })   
           }
           else{
               return false;
           }
       },
    }
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