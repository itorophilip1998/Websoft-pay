<template>
    <div class="pt-5 mt-3 px-md-5">
        <loader v-if="loading"/>
         <div class="row m-0 ">
             <div class="col-md-4  p-md-3  ml-auto  d-md-block d-none">
              <sidebar/>
             </div>
             <div class="col-md-7 p-md-3 px-lg-5 mr-auto p-0 ">
                <div class="row m-0"> 
                    <div class="col-12  px-1  pb-3 mt-0 "> 
                       <div class="money border shadow  bg-info rounded-l p-2 p-lg-3 pb-md-3" >
                        <span class="text-white">Report Issues/Errors</span>  
                        <form @submit.prevent="reportPost()">     
                           <div class="form-group text-white">
                               <small class="tmuted">Error Type</small>
                               <select name="bundle"  @change="selectCheck()"  id="select"  v-model="select" class="custom-select h-50 link  text-muted" style="height: 50px !important;">
                                <option value="" selected>Select Type</option>  
                                  <option  :value="item" v-for="(item, index) in type" :key="index">
                                      {{ item }} 
                                  </option>    

                            </select> 
                           </div>  
                           <div class="form-group text-white">
                               <small class="tmuted">Description</small>
                               <textarea id="my-textarea" class="form-control" v-model="report.message" name="" rows="4" placeholder="What is your challange?"></textarea>
                           </div>  
                        <button type="submit" v-if="report.message && report.type" class="btn btn-info btn-sm mt-1 topup rounded-l shadow">Submit</button>

                         </form> 
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
        loading:false,
        seeMoney:false,
        select:"",
        report:{
            message:"",
            user_id:this.$auth.user.id,
            type:"",
        },
        type:[
        'Transfer',
        'Redraw',
        'Airtime',
        'Data Subscription',
        'TV Subscription',
        'Electricity Subscription',
        'Remitta',
        'TopUp',
        ],
       }
   },
   methods: {
    selectCheck(){
        this.report.type=this.select
    },
    reportPost(){
        this.loading=!this.loading
        this.$axios.post('/api/report',this.report).then((res)=>{
        this.loading=!this.loading 
        this.report.message=''
        this.report.type=''
        this.$swal({ 
                icon: 'success',
                text: res.data.message ,
                showConfirmButton: false,
                timer: 2500
                })
        }).catch((error)=>{
            this.loading=!this.loading
            this.$swal({ 
                icon: 'error',
                text: error.response.data.message || "Error Occured",
                showConfirmButton: false,
                timer: 2500
                })

        })
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