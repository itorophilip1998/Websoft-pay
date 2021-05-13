<template>
    <div class="py-5 mt-3 px-md-5">
         <div class="row m-0 ">
             <div class="col-md-4  p-md-3  ml-auto  d-md-block d-none">
              <sidebar/>
             </div>
             <div class="col-md-7 p-md-3 px-lg-5 mr-auto  ">
                 <div class="row"> 
                     <div class="col-12  p-1 p-md-3 ">  
                        <div class="money border shadow  bg-info rounded-l p-2 pl-3 pb-md-3">
                          <span class="text-white">Settings</span> 
                            <hr>
                         <div class="form-group">
                          <small class="tmuted">Two Factor Authentication</small> 
                          <div class="form-check">
                              <input id="my-input" @click="settings.tfa=!settings.tfa" class="form-check-input link" type="checkbox" name="" value="true">
                              <label for="my-input" v-if="settings.tfa" class="form-check-label text-white">Enabled</label>
                              <label for="my-input" v-else class="form-check-label text-white">Disabled</label>
                          </div>
                         </div>
                         <div class="form-group">
                          <hr class="p-0 m-0 mt-1"> 

                          <small class="tmuted">Notify me when ever i signin</small> 
                          <div class="form-check">
                              <input id="my-input" @click="settings.loggedinNotify=!settings.loggedinNotify" class="form-check-input link" type="checkbox" name="" value="true">
                              <label for="my-input" v-if="settings.loggedinNotify" class="form-check-label text-white">Enabled</label>
                              <label for="my-input" v-else class="form-check-label text-white">Disabled</label>
                          </div>
                         </div>
                         <div class="form-group">
                          <hr class="p-0 m-0 mt-1"> 

                          <small class="tmuted">Save all my signin logs</small> 
                          <div class="form-check">
                              <input id="my-input" @click="settings.loggedinSave=!settings.loggedinSave" class="form-check-input link" type="checkbox" name="" value="true">
                              <label for="my-input" v-if="settings.loggedinSave" class="form-check-label text-white">Enabled</label>
                              <label for="my-input" v-else class="form-check-label text-white">Disabled</label>
                          </div>
                          <small class="tmuted">View sll my singin Logs</small> 
                          <button type="button" @click="viewLogs=!viewLogs" class="btn btn-sm shadow text-white topup rounded-l">
                              <span v-if="!viewLogs">View Logs</span>
                              <span v-else>Hide Logs</span>
                          </button> 
                          <div class="logs bmuted p-3"  v-if="viewLogs">
                              <h6>Your Signin details</h6>
                              <small class="d-block"> #Phone4 in lagos on 3/3/20 30pm </small>
                              <small class="d-block"> #Phone4 in lagos on 3/3/20 30pm </small>
                              <small class="d-block"> #Phone4 in lagos on 3/3/20 30pm </small>
                              <small class="d-block"> #Phone4 in lagos on 3/3/20 30pm </small>
                          </div>
                         </div>
                         <div class="form-group ">
                          <hr class="p-0 m-0 mt-1"> 
                          <small class="tmuted">Change Transaction Pin</small> 
                            <div class="form-group"> 
                              <input type="text" v-model="settings.Opin"  class="form-control mt-1" name="" id="" aria-describedby="helpId" placeholder="Old Transaction Pin">
                              <input type="text" v-model="settings.Npin" v-if="settings.Opin.length==4" class="form-control mt-1" name="" id="" aria-describedby="helpId" placeholder="New Transaction Pin">
                              <input type="text" v-model="settings.Cpin" v-if="settings.Npin.length==4" class="form-control mt-1" name="" id="" aria-describedby="helpId" placeholder="Confirm Transaction Pin">
                            </div>                      
                         </div>
                         <div class="form-group">
                          <hr class="p-0 m-0 mt-1"> 
                          <small class="tmuted">Change Password</small> 
                            <div class="form-group"> 
                              <input type="text" v-model="settings.Opass"  class="form-control mt-1" name="" id="" aria-describedby="helpId" placeholder="Old Password">
                              <input type="text" v-model="settings.Npass" v-if="settings.Opass" class="form-control mt-1" name="" id="" aria-describedby="helpId" placeholder="New Password"> 
                              <input type="text" v-model="settings.Cpass" v-if="settings.Cpass && settings.Opass" class="form-control mt-1" name="" id="" aria-describedby="helpId" placeholder="Confirm Password"> 
                            </div>                      
                         </div>
                         <button type="button" class="btn btn-info btn-sm mt-2 topup rounded-l shadow">Save Changes</button>

                         
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
        viewLogs:false,
        settings:{
            loggedinNotify:false,
            loggedinSave:false,
            tfa:false,
            Opin:'',
            Npin:'',
            Cpin:'',
            Opass:'',
            Npass:'',
            Cpass:'',
        }
       }
   },
   methods: {
    
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