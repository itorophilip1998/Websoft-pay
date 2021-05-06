<template>
    <div class="pt-5 mt-3 px-md-5">
         <div class="row m-0 ">
            <loader v-if="loading"/>

             <div class="col-md-4  p-md-3  ml-auto  d-md-block d-none">
              <sidebar/>
             </div>
             <div class="col-md-7 p-md-3 px-lg-5 mr-auto  pb-5">
                 
                <div class="alert alert-warning alert-dismissible p-2" role="alert"> 
                    <strong><i class="fa fa-bell-o" aria-hidden="true"></i>
                     Note:
                    </strong> Bank Transfer only works for <b><u>Nigerian</u></b> bank account for now. Other countries are comming soon
                </div>  
                <ul class="nav nav-pills m-0" id="pills-tab" role="tablist">
                    <li class="nav-item border-top">
                      <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Bank Transfer</a>
                    </li>
                    <li class="nav-item border-left border-top">
                      <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Wallet Transfer</a>
                    </li> 
                  </ul>
                  <!-- bank -->
                  <div class="tab-content " id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="row"> 
                            <div class="col-12  px-3 pb-3 mt-0 col-lg-10 "> 
                               <div class="money border shadow  bg-info rounded-l p-2 p-lg-3 pb-md-3" style="border-top-left-radius: 0 !important;">
                                <small class="tmuted">Transfer to Bank</small>  
                                <form @submit.prevent="transferMoney()">   
                                   <div class="border-0 text-light pb-2">
                                       <span>Amount(₦)</span>   
                                     <input  type="number" id="amount" autocomplete="off" min="1" step="1" class="form-control p-3 border-info" v-model.number="transfer.amount" placeholder="₦100 above..." @input="getAmount()">  
                                     </div>  
       
                                   <div class="border-0 text-light pb-2">
                                     <span>Account Number </span>  
                                   <input type="text" @input="validateBank()" maxlength="10" minlength="10"  class="form-control p-3 border-info" v-model="transfer.account_number" placeholder="Beneficiary account number" > 
                                   </div>  
                                   <div class="border-0 text-light pb-2"> 
                                     <div class="form-group m-0">  
                                         <label for="my-select">Bank Name  
                                         <div v-if="bankLoading" class="spinner-border text-light border-1" style="width: 1rem !important;height:1rem !important;" role="status">
                                             <span class="sr-only">Loading...</span>
                                         </div>
                                         <small v-if="bankError" @click="getBanks()" class="fa fa-refresh link text-light" aria-hidden="true"></small>
                                         </label>
                                         <select id="my-select" @change="validateBank()" v-model="selectedBanks"   class="form-control link border-info" name="" >
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
                                         <small @click="" v-if="validateAccErr" class="text-warning">Can`t resolve accounts details... try again <i class="fa fa-refresh link text-dark" aria-hidden="true"></i></small> 
                                  </div> 
                                  </div>  
                                  <div class="form-group text-white">
                                      <label for="my-textarea">Status</label>
                                      <textarea id="my-textarea" class="form-control" v-model="transfer.narration" name="" rows="3" placeholder="Add some information"></textarea>
                                  </div>
                                   <button  type="submit" class="btn btn-info btn-sm mt-1 topup rounded-l shadow">Transfer</button>
                                 </form> 
                               </div> 
                          </div>  
                        </div>
                    </div>
                    <!-- wallet -->
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="row"> 
                            <div class="col-12  px-3 pb-3 mt-0 col-lg-10 "> 
                               <div class="money border shadow  bg-info rounded-l p-2 p-lg-3 pb-md-3" style="border-top-left-radius: 0 !important;">
                                <small class="tmuted">Transfer to Wallet</small>  
                                <form @submit.prevent="transferMoney()">   
                                   <div class="border-0 text-light pb-2">
                                       <span>Amount(₦)</span>   
                                     <input  type="number" id="amount" autocomplete="off" min="1" step="1" class="form-control p-3 border-info" v-model.number="walletTransfer.amount" placeholder="₦100 above..." @input="getAmount()">  
                                     </div>  
       
                                   <div class="border-0 text-light pb-2">
                                     <span>Wallet ID</span>  
                                   <input type="text" @input="validateWallet()" maxlength="10" minlength="10"  class="form-control p-3 border-info" v-model="walletTransfer.wallet_id" placeholder="Beneficiary wallet number" > 
                                   </div>  
                                   <div class="border-0  d-none text-light pb-2">   
                                     <div class="border-0 text-light p-0" >  
                                         <small v-if="transfer.meta.first_name" style="color: #74e9ef!important">{{ transfer.meta.first_name }}</small> 
                                         <div v-if="validateAccLoading" class="spinner-border text-light border-1" style="width: 1rem !important;height:1rem !important;" role="status">
                                             <span class="sr-only">Loading...</span>
                                         </div>
                                         <small @click="" v-if="validateAccErr" class="text-warning">Can`t resolve accounts details... try again <i class="fa fa-refresh link text-dark" aria-hidden="true"></i></small> 
                                  </div> 
                                  </div>  
                                  <div class="form-group text-white">
                                      <label for="my-textarea">Status</label>
                                      <textarea id="my-textarea" class="form-control" v-model="walletTransfer.status" name="" rows="3" placeholder="Add some information"></textarea>
                                  </div>
                                   <button  type="submit" class="btn btn-info btn-sm mt-1 topup rounded-l shadow">Transfer</button>
                                 </form> 
                               </div> 
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
    transfer:{
            account_bank:'',
            account_number:"",
            amount:"",
            narration:"",
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
        },
        banks:[],
        bankError:false,
        bankLoading:false,
        validateAccErr:false,
        validateAccLoading:false,
        selectedBanks:'',
        flutterHeader:JSON.parse(localStorage.getItem('flutterHeader')), 
        loading:false
       }
   },
   mounted() {
    this.getBanks(); 
   },
   methods: {
    validateWallet()
    {

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
                    this.validateAccErr=false 
                    this.validateAccLoading=!this.validateAccLoading 
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