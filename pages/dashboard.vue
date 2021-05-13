<template>
    <div class="pt-5 mt-3 px-md-5">
         <div class="row m-0 px-0">
             <loader v-if="loading"/>
             <div class="col-md-4  p-md-3  ml-md-auto  d-md-block d-none">
              <sidebar/>
             </div>
             <div class="col-md-7 p-md-3 px-lg-5 mr-md-auto  px-0">
                 <div class="row m-0 px-0 mt-1"> 
                     <div class="col-12  px-1  ">  
                        <div class="inactive" v-if="!account_status">
                        <div class="alert alert-warning text-left fade show mx-1 mx-md-0" role="alert"> 
                                <strong><i class="fa fa-bell-o" aria-hidden="true"></i> Account Update:</strong> Please your account is not activated and you cannot make transactions... 
                                <a class="link text-dark d-block d-md-inline" data-toggle="modal"
                                  data-target="#activate"> <u>Activate now</u></a>  

                            </div>
                        </div> 
                         <!-- Account Update -->
                         <div class="modal fade" id="activate" tabindex="-1" role="dialog"
                         aria-labelledby="modelTitleId" aria-hidden="true">
                         <div class="modal-dialog" role="document">
                           <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="my-modal-title">Account Details</h6>
                                <button class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                             <div class="modal-body">
                               <form @submit.prevent="updateAccount()">
                                 <div v-if="!account_status" class="border-0 text-dark pb-2">
                                   <span>Transaction Pin <small class="text-danger">*</small></span> 
                                 <input type="password"
                                   oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                   maxlength="4" minlength="4"   class="form-control p-3 border-info" v-model="accounts.transaction_pin" placeholder="Secure Pin(4 digits) not bank pin" >
                                 <small id="errorNetwork" class="form-text text-danger" v-if="error.transaction_pin">{{ error.transaction_pin[0] }}</small>
                                 </div>

                                 <div class="border-0 text-dark pb-2">
                                   <span>Phone Number <small class="text-danger">*</small></span>  
                                 <input type="text"   class="form-control p-3 border-info" v-model="accounts.phone" placeholder="" >
                                 <small id="errorNetwork" class="form-text text-danger"   v-if="error.phone">{{ error.phone[0] }}</small>
                                 </div> 

                                 <div class="border-0 text-dark pb-2">
                                   <span>Account Number </span>  
                                 <input type="text" @input="validateBank()" maxlength="10" minlength="10"  class="form-control p-3 border-info" v-model="accounts.account_number" placeholder="Your bank account number" >
                                 <small id="errorNetwork" class="form-text text-danger"    v-if="error.account_number">{{ error.account_number[0] }}</small>
                                 </div> 
                                 <div class="border-0 text-dark pb-1"> 
                                   <div class="form-group m-0">  
                                       <label for="my-select">Bank Name <small class="text-danger">*</small> 
                                       <div v-if="bankLoading" class="spinner-border text-info border-1" style="width: 1rem !important;height:1rem !important;" role="status">
                                           <span class="sr-only">Loading...</span>
                                       </div>
                                       <small v-if="bankError" @click="getBanks()" class="fa fa-refresh link text-info" aria-hidden="true"></small>
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
                                   <div class="border-0 text-info p-0" >  
                                       <small v-if="accounts.account_name">{{ accounts.account_name }} </small> 
                                       <div v-if="validateAccLoading" class="spinner-border text-info border-1" style="width: 1rem !important;height:1rem !important;" role="status">
                                           <span class="sr-only">Loading...</span>
                                       </div>
                                       <small @click="" v-if="validateAccErr" class="text-danger">Can`t resolve accounts details... try again <i class="fa fa-refresh link text-info" aria-hidden="true"></i></small> 
                                </div> 
                                </div>  
                                 <button v-if="accounts.bank_name" type="submit" class="btn btn-info btn-sm mt-2 rounded-l shadow">Save Accounts</button>
                               </form>
                             </div>
                           </div>
                         </div>
                       </div>
                         <h6 class="text-info">Hello <span class="text-muted text-capitalize font-italic">{{ $auth.user.name }}</span> 😎</h6>
                        <div class="money border shadow  bg-info rounded-l p-2 pl-3 pb-md-3">
                         <div class="top" >
                            <small class="tmuted">Wallet Balance </small> 
                            <i v-if="seeMoney" @click="moneyCheck('show')" class="fa fa-eye  link" aria-hidden="true" style="color:rgb(225, 228, 230);"></i>
                            <i v-if="!seeMoney" @click="moneyCheck('hide')" class="fa fa-eye-slash  link" aria-hidden="true" style="color:rgb(225, 228, 230);"></i>
                            <i data-toggle="modal"  data-target="#activate" class="fa fa-pencil text-white link float-right p-2" aria-hidden="true"></i>
                         </div>
                            <input type="text" ref="money" :value="'₦'+ currencyFormat($auth.user.accounts.account_balance)" class="form-control  border-0 moneyText pl-0" readonly > 
                            <button data-toggle="modal" data-target="#modelId" class="btn btn-info btn-sm topup  shadow rounded-l w-25">Top-up</button>
                            <button  data-toggle="modal" data-target="#redraw"  class="btn bg-secondary btn-info text-white border-0  shadow btn-sm ml-3 rounded-l w-25">Redraw</button>
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
                                        <input  type="number" autocomplete="off" id="amount" min="1" step="1" class="form-control p-4 border-info" v-model.number="amount" placeholder="₦100 above..." @input="getAmount()"> 
                                         <small id="errorNetwork" class="form-text text-danger " style="display: none;">Poor/No Internet Connection... try again</small>  
                                        <button type="submit" class="btn btn-info btn-sm mt-2 rounded-l shadow" v-if="btn">Add Money</button>
                                        </form>
                                    </div> 
                                </div>
                            </div>
                        </div>
                          <!-- Redraw -->
                          <div class="modal fade" id="redraw" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content"> 
                                    <div class="modal-body">
                                        <form @submit.prevent="redrawMoney()" > 
                                            <div class="money" v-if="!redraw.next">
                                                <div class="border-0"> 
                                                    <span>Amount(₦)</span> 
                                                </div>
                                                <input  type="number" autocomplete="off" id="amount" min="1" step="1" class="form-control p-4 border-info" v-model.number="redraw.amount" placeholder="₦100 above..." @input="getAmount()"> 
                                                 <small id="errorNetwork" class="form-text text-danger " style="display: none;">Poor/No Internet Connection... try again</small> 
                                                <button type="button" @click="redraw.next =!redraw.next" class="btn btn-info btn-sm mt-2 rounded-l shadow" v-if="btn">Proceed</button>

                                            </div>
                                            <div class="proceed" v-else>
                                                <div class="border-0"> 
                                                    <span>Transaction Pin</span> 
                                                </div>
                                             <input  type="text" autocomplete="off"  class="form-control p-4 border-info" v-model="redraw.transaction_pin" placeholder="Enter Transaction Pin" >  
                                           <button type="submit" class="btn btn-info btn-sm mt-2 rounded-l shadow" v-if="redraw.transaction_pin.length==4">Redraw</button>

                                            </div>
                                         
                                        </form>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        

                   </div> 
                   <div class="col-12   mt-3 px-1 pb-5 mb-5">  
                    <div class="transaction shadow border-info bg-info text-white border rounded-lg">
                        <h6 class="text-white border-white bg-info   border-bottom p-2 text-center">Transaction Details</h6>
                         <table class="table  text-center text-dark " >
                             <thead  >
                                 <tr scope="row" style="color: rgba(85, 84, 84, 0.863);">
                                     <th scope="col">Beneficiary</th>
                                     <th scope="col">Type</th> 
                                     <th scope="col">Date</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <tr class="link paid" v-for="(item, index) in transactions" :key="index"  style="color: rgba(221, 237, 253, 0.863) !important;">
                                     <td  class="text-center link"  data-toggle="modal" :data-target="`#trans-${item.id}`">
                                        <small><b> 
                                         <span v-if="item.status_from_transaction!='paid'">
                                              <s style='color:rgb(243, 9, 9)'>
                                                <span style="color: rgba(85, 84, 84, 0.863);" >{{ item.beneficiary }}</span>
                                              </s>
                                        </span>
                                         <span v-else>{{ item.beneficiary }}</span>
                                        </b></small>
                                      <!-- transactions -->  
                                <div class="modal fade text-dark" :id="`trans-${item.id}`" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content modal-sm "> 
                                            <div class="modal-header text-white bg-info text-center">
                                                <h6 class="modal-title " id="my-modal-title ">{{ item.beneficiary_name }}</h6> 
                                            </div>
                                            <div class="modal-body pb-0">
                                               <ul class='text-left text-muted pl-0 ml-0 mb-0 pb-0'>
                                                   <li><b>Beneficiary:</b> {{ item.beneficiary }}</li> 
                                                   <li><b>Reference No:</b> {{ item.reference_no }}</li> 
                                                   <li><b>Amount:</b> {{ currencyFormat(item.amount) }}</li> 
                                                   <li><b>Transaction Status:</b> {{ item.status_from_transaction }}</li> 
                                                   <li><b>Status:</b> {{ item.status }}</li> 
                                                   <li><b>Transaction ID:</b> {{ item.transaction_id }}</li> 
                                                   <li><b>Transaction Type:</b> {{ item.transaction_type }}</li> 
                                                   <li><b>Date:</b> {{ fulltime(item.created_at) }}</li> 
                                                   <li ><b>Description:</b>{{ item.status_from_user }}</li>  
                                               </ul>
                                            </div> 
                                            <div class="modal-footer bg-info text-white p-1">
                                                <button class="text-white btn btn-sm shadow" data-dismiss="modal" aria-label="Close">
                                                    Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    </td>
                                     <td class="text-center"><small>{{ item.transaction_type }}</small></td> 
                                     <td class="text-center"><small><i>{{ timer(item.created_at) }}</i></small></td>  
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
import mfooter from '@/components/mobilefooter';
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
        redraw:{
            amount:"",
            transaction_pin:"",
            next:false
        },
        seeMoney:false,
        btn:false,
        validateAccErr:false,
        validateAccLoading:false,
        amount:'',
        bankLoading:false,
        accounts:{
            user_id:this.$auth.user.id,
            account_type:"individual",
            transaction_pin:"",
            account_number:"",
            phone:"",
            account_name:"",  
            bank_name:"",
            bank_code:"",
            account_status:true, 
        },
         error:[],
         banks:[],
         transactions:[],
         bankError:false,
         loading:false,
         selectedBanks:"",
         flutterHeader:JSON.parse(localStorage.getItem('flutterHeader')),
         account_status:null
       } 
   }, 
   mounted() {  
    this.getBanks();
    this.accountsDetails();
    this.getTransactions(); 
    this.account_status=this.$auth.user.accounts.account_status
   },
   methods: { 
    redrawMoney(){
        console.log('Payment in Progress')
    }  ,
         currencyFormat(amount)
         {
            return (amount).toLocaleString('en-US', { 
            currency: 'NGN',
            minimumFractionDigits: 2
            }); 
         },
       timer(time) {
            return moment(time).format('MM/DD/YY');
        },
        fulltime(time) {
            return moment(time).format(' Do MMMM YYYY, h:mm a');
        },
       getTransactions()
       {
        this.$axios.get(`/api/transaction/get-all`).then((res)=>{
                this.transactions=res.data.data
            }).catch((error)=>{
                console.log(error) 
            })
       },
        accountsDetails()
        {
            let acc=this.$auth.user.accounts;
            this.accounts={
                user_id:acc.user_id,
                account_type:acc.account_type,
                transaction_pin:acc.transaction_pin,
                account_number:acc.account_number,
                phone:acc.phone,
                account_name:acc.account_name,  
                bank_name:acc.bank_name,
                bank_code:acc.bank_code,
                account_status:this.accounts.account_status 
            } 
        },
       updateAccount()
       {
           this.loading=!this.loading
            this.$axios.put(`/api/update-account/${this.$auth.user.accounts.id}`,this.accounts).then((res)=>{
           this.loading=!this.loading
           location.reload() 
            }).catch((error)=>{
           this.loading=!this.loading 
           if (error.response.status==422) {
            this.error=error.response.data.errors
           }
           else
           {
           location.reload()  
           }
            })
       },
       validateBank()
       { 
           if (this.accounts.account_number.length==10 && this.selectedBanks) {  
            this.validateAccLoading=!this.validateAccLoading 
               axios.post('/v3/accounts/resolve',{
                   account_number:this.accounts.account_number,
                   account_bank:this.selectedBanks.code, 
                },this.flutterHeader).then((res)=>{   
                    this.accounts.bank_name=this.selectedBanks.name; 
                    this.accounts.bank_code=this.selectedBanks.code; 
                    this.accounts.account_name=res.data.data.account_name; 
                   this.validateAccErr=false 
                   this.validateAccLoading=!this.validateAccLoading 
                }).catch((error)=>{    
                   this.validateAccErr=true
                   this.validateAccLoading=!this.validateAccLoading
                   this.accounts.account_name="";  
                })   
           }
           else{
               return false;
           }
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
    makePayment() { 
        try {
             this.$launchFlutterwave({
             tx_ref: 'Tfw'+Date.now(),
             amount: this.amount,
             currency: 'NGN',
             payment_options: 'card,mobilemoney,ussd',
             customer: {
             email: this.$auth.user.email, 
             phonenumber: this.$auth.user.accounts.phone,
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
                      location.reload()
                   }).catch((error)=>{  
                      document.getElementById('errorNetwork').style.display="block"
                   }) 
 
             },
             customizations: {
             title: 'Websoft-Pay',
             description: 'Wallet top-up',
             logo:
             'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAxlBMVEX///9HuewnNFAAkNKY1vdvdogkMk7g4ea1usM7Rl+Mk6H4+PomNVLs7fCip7IlM1HCxs0yQFtpcYby+v4AktPy8/Xo9v3S7fvv+f6d2PdFt+un3Pjj9P3b8PzL6vvE5/qy4PlZv+5tx+/O0de85Pmq3vaJ0PNyyfBgwu6N0/NNvOtIU2qYnap7gpKu3viX1/MLmNVSr987pttjt+LJzNOqr7lfaHxOWG7X2d65vcYioto1ruEAiM16wuZYtuJGqNuOyOiEipnZdmOdAAAQo0lEQVR4nO1dCXuiOhtVx9pWtGqpgMimxaW4dlHbznXa/v8/9SW4AUkghMRlvjn3Pr1z52kkh/Pm3Ugwl/uHf/iH/wvIsmaYqmrZLoDTc3o9xwF/si3VNBRNlk89v0yQFUN1e7P+YNDtdocdH57/czgcgr8a9Pszx1YN7SJpaobVmw0Ar3xeB//k85sfe2z/0gNkB/2ZqxoXxVJT3Vl/6AEKepgWDjpA3vO6Tz3bvAiWsmH3+sPNvFMASgpZWsp5s9RMdzYYemmohdXMD/tt62wNVjbd4mBIY5ixNL3h4DxJKlYb0OMAeIeGfUfVTs0oBMnsbTwLN3S6M1s5Na09ZLM96ESjAQeSfec8OMrW05A7OwjoXHunDyCa/dQRQW9H8tQcNeupI4zeFqfkKKszLt4zHnp+4JwmeAD/0hXPz0en757A5xjOgDV3oYPnbcoQD15m+GQdW0ar3xHiQH1qgFde/w0As1vwH1CBdLpt45j8jF5HHLs84PT5+fDr13+/IMDP+efny6feP56Msj3ImHyS6OU9wG2+pXYA+P///gM8/8yOU3oYbREeFCy7/O/P+fy/KL0g0fnL60wV7XRkq881Ad3xA/QeHhD1UMxf1q7Q4KH0BISIDb9Ecls8fL72TEkUQXPWEUAQ8KOlt+MoyrOqAizU81LoF+DoCjBV2e1y96Gep6fn52O+VnkTVHr8qwjPe2HjB3V8mfF1q4aAJQgEZOXHX0bziXsaCgScZyEIKP7htxrVPm9+wIWyW+geLzNOHSsBBPN5RhcTkfGbS9ywBtzpefqcB0G4GM1zJciFHx+KFv9EjSNBEDZeM1IUQfD3PDnHTkExm4rqWZvoBvN1BndjCiCYzxTn8RSZ46IpIEx4XMJEhGKPsZ4y+GcyYBHyJwhCv8tEUJsJ6BgKIfjr4ZnF28g9/h0Zz+PsZXaYr9NXGrI7FNBS4+5ldvjspfY2AgIhWISiCP769Zy2lhLiRkXZKERaO5WLAryMiEBxQEp/6oogyDuZCePhNY2IApI1KKFIgsDZTOkJKn0REv4WKiHAH+qKX24LaN3nkcbaA3yq9PUM8fXy8pm9Jp73aBnaIiJheBU+zL9e19+OZRqKD1O1p9+vzy/ZaL5SimiIsNGghA+fz+u2pciRdFnWTPf79SsDyU86dyoL6P1C7CScf62nxA0WkmK3XtmDyjdVYsMvmdnswfQ8/2H8NuWeP39b8V5dMtw1a6eRKrHR+JRMgJ037A76xVZ7Om23iv1XuMYents0+2MUe80WWT5pfI3LwUYBvc7gaWqZmgwgSRL4qajT9Z9vg7JU1dxXltjyQJG6KQMOixDuhMVdKk36L0+/GEz1K9lMe5lt1Ou2bC6daHWdXsbkkKhmdTOAH7ftr8Z3ao/z8J1wcZDNZCM4bPHc9yI7z2kpviaYTzYJda/PeWuvZL+mpPhlxX5gxt7TsM1/l4SakuKnE/9x3SyOtCti+0DOTGeo89i0JpuEAw7PubAU/6Rh+LCOczVZVqHXF7Z7UE2lYlyln8WRdoritkdKbprYH/ewLcNjGJEE4a1PkaXGJN+yw1zZe09iN7gq3/TZTUy4MNgl7AtyMnuoz9QMX2zip9jMRUU3PsrygENtp+S2qfzEyE/vsD3aSgV5TcuQ3MkwmZ80zY6xN9l8ycywx0pwcJxt9LTOhshQY6x8j2KjEOZXRoYWa4/06UgHWiRKEYkMGfMZfSjej25hrqn6xSRfqrA+Liwe7zyrorrfz4m91C9CPGRt5B9PQh+yYq8TtqU+E2bE2oAqHv9YmTF9jQv/hLzUYDTSYznSMBQnpplKaNSwdvJFVb1JMKbPJI6EnrDLltB4rZMdYVUJnUZCja/N2Aqn0xjpds74vv8cn0Oy1r6nMlIfErYn/uJgf1llM1K9f9qXO2gtlCLelcpuh4mh1xZ2iIwSbjRuPOBdqdZik/CUy3CLaJOK0C5ljIZ6h/vpqvSww61GQlbK2CfVh0c9YI2H5AYpPhAyGpvR0XTP4S0yshOo/uf4aCgzJqX64OSvHoEIdlMJD0jlGRNBECzOgmFO29fGpM3QWp+1vD8PhjnldcfwCf8LBuvmhOKZMMyp26X4QqgNGTOa89Ewl9smN6STJYyFxdmswxy008/5nNyEYnWl+empk7YDTKf9vSY9/pXbjARb5xAOd5AkWSPNhy1YnBnBWChPDK4UEDyP16nRgCXv1k/RZGMGw9kRPS9uX4IAMJw80AdnUDfRI/02IX247ZxL1yiqdFeVqpixTYqBzfTXTN0r1fO7c2LvkysEY5pp5nLVMTp08kYx8AMdd7WID8xWypRGPzSg6o1aIYLaPZ2I11eVWqESGlq6vaEYeFcrRS9ZKcczTFv/6sP9Iqw3SrVaIfhvGoaF8NgaLcNCZGCBM0PdO2R/gGFUwxI1w+hIag2RgXwZ6sGHvtkYRqd6LgyDm2f+Rg11rx1IR/9GDfXQo4q/UEO94wRrsL9PQxAKQ82sC9EwRcTXh+Gt3JfCkDpr0/WncD/yQqzUos689aETrusvREPq6glUhZF+5IVoSP2IWx+2InXvhWhI28UAEjqRdt2FaEjbidKHxeiWsQvRUJtRMQQStqJPdi6EodyiYzgsTqP9tQuxUqlH8/ZxIGERObl1IRrmqPaa6MOnIvLs6kI0pErb9Pyg2EJaiJeioUmRtumdfhF9A/OlMKQ6oN4tFtEvfrkUK6U4LQNDBepoLkZDit0meqdY5M7weBomP+bW9W6rWLSRz7kUDZN3fflG2kI3OlyMhonbTXwj5c7wiBoqSa4G1E1FTDi8HIZJrkbX+yIYHtFKk7Ia3QNGWmxfsIZJZb5vpJetYfxC1PVBUQTDY2oY/3ovWDiJ8KXH1DD+6JoohsfUMH4h+tEQAD3Yd0EM5Zi3moCUbcuQc9Z2VCuNe4fZ1tHwz7yPqiEw05iFCOM9gINs1TuJhghBOoYxGxRhee+DqsavLQVrOGbUMEd+t/WeIdIuxWq4vKZi+L5Eh9IwlMqsDA1iBaUPi1sg4eLtFp3m6F0ow+ZPDaFYGdNckWymO1eKcaZvI9RKGzRbt7BDqRhW75Fxhcod1SWtDoHgzpViXM3jCr1cjWYx5aQFRn4ahu/onSlUFlQMFULQBwxbW4bRh2vA1NBFUStT7TAsV5CRVAw/KuhWusYHFUPSln19FywwC/F6grj8QmlFsxCvMfeGhiFYhui4Ed3CIDWGgwyjzw+bY4wSjYS9kD4Wt2wM3zHrorSkc27Q1+ACxj5YwIgY6QlLC3T7ZaFwlRwvqlclJobSHSYClyaUu3YJlT5guNewGC0RP0aYhXibLOICnSgVQ0yMgcGC9mQLoQ4OaIiY6TvGd9cK948sEwUoJ4hRLWPuTI0qFdoA2xnWO08HhtHErfqDmWep8RNvp1WMI/WxuolVQ7oZ4S63TLqhB2D3LATXYbEVCfrSHRrWoLmN48RoYgf5iFf/bYmGCqAh9TLM4Wso+Gj0gGlExDeM14eGc0cOis0FZvFuUZnEuMXHe5z04FopDpjh3jR0SEs3rYzwx2HNNFbF6t0I40d30yVTlOpLZA+7f6kURpqD791L0DAqIlga2OmWGuVr7K29HmMiYZDiVR07rnmzxI9oBN2TlngiEuNOQ54Gihj+EEwlu6V49YHK2KxPcHEiRHG1QO+N9D7G5KP+dVYfh9/WKA5joSKGPA1GxDuCJrXCqlyvBucqVd/Gq0I8QTjwdnITOj0jNd8XVw2CaVcmB78t03yhtYaIGNEQuNPwx7zfE62usZrcvV1XmxDV68fFzxKXAqEUK6OrcX03rvr+Ub6/Jf1uaRTIug2q42bIseeohsV2uNSXsPnJ9vqF29X9pDwej8uT+9VtJVG/wLjl1Q8c+HO1HDVqZN/0c1gKikp3LjlaCYeytk1iEy4TQY4ZM9dSqdCA8P+UAvC3/XEFMjsoYX0/D1mlPDEYfVEryjDaGsaU69GJ0BhnFLUNzXjPe4iFkkkpIdqT8hCGkZaUNE7wj8JQuTrYqJHwxSABKOH+d7A+3Ntp+MOuJ9QrjCtqq4ONKnaKd1aFt0Xr+QHCsOWGl+Lj/UkIjg5lmmzZKY6Wy71gUAx0oohxX/ogJBxCCQYzQ9VNdTDZCAXFQzcxGDLCy7q5WDF5k0IhOQMgEQR54f765jTlweTQ0WAsw+hT/ZiKKJ5f5RZXEVEMbASSGaWX+ksLgv40knqTKC4SYwYGNZC9jlnuTajK1hxk93Iigh3waNpGoCgtcAV4EkFQLFVJSXUswYCJam6b4d1/IO7vVMSFC9xalG6wJXjcPG/LsBqEJXFKjqOAk9HsNtNrYu1ugCGWIEqxfpUm9Jf28wT3poE+byGiVlkuQgRdpneQyM6uo4ENF1uKkaDxXh5Rz7TUWN7saiTp7Se2Lg4PvJ3UD8WVbLccxjdYKC1v72pIDJF6uHpzTydjrTYqPwaKx+u7JV1eVCqsxoEKGRBkWYQb7KPiZtMXgWKkWvSL8cSplmqN+5twB6AJZaQZOHkLVMeAYIs64UZh9jfehrwQfYqRRSA9lleVGJK1EphmcCHtOdYnt7FVCLgBt1cfwepfthErSoddgkpeiJCiG41F0uN4eUvoOsBycTRZ4DvGzXoZlsk1tGICfwVyg9VPuPWjuIgNpcXWoW527hGBrnTp/aYMSvMKfBXEXk34P2CWV+M6uYNbfbybwJq+Vjp4LKA5UH20nNw9hgcabqvI5kYPkDct4t2mKCJFzBdZVd8//A7EbaMC+7iVSsNvTNzVE17RIlUfF+XJcrUdCMeNYCdk8ViNtNtNB3dAIjVFP2YQY/4OU9xql5rV67ePxd14XC6Xx+O7xcfjdZWmPS1Vr9/rN3ewu+OPu6m/V5vRgbI6xVkPA0V/16K/VT8ObVJ1JklScwPwpzQX3o9rYseBOM+HIPgoSDHJTKG/OeqLoxSwBJFnKKwAFJPNFMqoHu0NfLI5hUuD26u2oaHqaCcDlZHzNwMSodhwMnxMdAPZGSabKaTo0HxPbObZmA5vgjBoDCnMFFoqny8gjYMCXQyPMBEGoIhtZWBk5PYlpFhoqi8gmkdlhmTHpKZhjq44U5VN1xcQyYW5QJ3SmOnWVMV4VWNjoKAqFWMnGw9GJSP+644zX7+9vYMZyqV4yGqbkiLUUeGqo7Tnx1zRU8EPtPS2yu1Wyzv7FOJjQvCTJWqOrsllvSjAv+wu2+b5fcpYaBa9pYL5OFZWIWXDcvZ39SgpxTajoEVr6qoK86xkRXUDLrx9pLRwv+YFk4zQIxShQiDD4jodSWiuyZt5ApfQDPWw+HzMBLuYyARSrcYdS9cyFQrXIyumFWFXhI0S8bRCMNI41aCWtqWaQE45WrhL8I3jiqlatoOwA4YuKIuJg6ym8jghmlPHdQFT1QQw4A9TBcxs15mi5CCOULFgoVisHDdEW+0AWuSPagtM5RMgKRZ1Ns6MtuByLAEgHIvlKLrcpOT4N/PzoaliOB6n60MH2UTjV1Z6U46lCQ/A/JgjyXaWZFYYFNOexvh8asAM73zMMwyQKtsZXatP76y/OAPklLisi5aemy4/PxFksCbd1CxhxnqOa48I2VBtp0fHsgUKSNu8JHY7yIphgkoByAkwa83CrGbwb9uOa8NS49RTzQIZ8oSlA6wdDrAtWFoYl7DqaCFHcT7f9vUP//APQvE/WTpJCF5tqs0AAAAASUVORK5CYII='
             }
             })
        } catch (error) {
            document.getElementById('errorNetwork').style.display='block' 
        }
     },
    getAmount()
    { 
         (this.amount >= 100 || this.redraw.amount >= 100)? this.btn=true:this.btn=false;
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
    .paid{
        color: rgb(167, 241, 238) !important;  
    } 
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