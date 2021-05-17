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
                              <input  @click="settings.tfa=!settings.tfa" class="form-check-input link" type="checkbox" name="tfa" id="tfa" value="true">
                              <label for="tfa" v-if="settings.tfa" class="form-check-label text-white link">Enabled</label>
                              <label for="tfa" v-else class="form-check-label text-white link">Disabled</label>
                          </div>
                         </div>
                         <div class="form-group">
                          <hr class="p-0 m-0 mt-1"> 

                          <small class="tmuted">Notify me when ever i signin</small> 
                          <div class="form-check">
                              <input  @click="settings.loggedinNotify=!settings.loggedinNotify" class="form-check-input link" type="checkbox" name="loggedinNotify" id="loggedinNotify" value="true">
                              <label for="loggedinNotify" v-if="settings.loggedinNotify" class="form-check-label text-white link">Enabled</label>
                              <label for="loggedinNotify" v-else class="form-check-label text-white link">Disabled</label>
                          </div>
                         </div>
                         <div class="form-group">
                          <hr class="p-0 m-0 mt-1"> 

                          <small class="tmuted">Save all my signin logs</small> 
                          <div class="form-check">
                              <input   @click="settings.loggedinSave=!settings.loggedinSave" class="form-check-input link" type="checkbox" name="loggedinSave" id="loggedinSave" value="true">
                              <label for="loggedinSave" v-if="settings.loggedinSave" class="form-check-label text-white link">Enabled</label>
                              <label for="loggedinSave" v-else class="form-check-label text-white link">Disabled</label>
                          </div>
                          <hr class="p-0 m-0 my-1"> 
                          <small class="tmuted d-block">View my security logs</small> 
                          <button type="button" @click="viewLogs=!viewLogs" class="btn btn-sm shadow text-white topup rounded-l">
                              <span v-if="!viewLogs">View Logs</span>
                              <span v-else>Hide Logs</span>
                          </button> 
                          <div class="logs bmuted py-3 pl-1 mt-2"  v-if="viewLogs">
                              <h6 class="border-secondary "><u>Your Security Logs</u></h6>
                              <small class="d-block border border-secondary p-2"> #Phone4 in lagos on 3/3/20 30pm </small>
                              <small class="d-block border border-secondary p-2"> #Phone4 in lagos on 3/3/20 30pm </small>
                              <small class="d-block border border-secondary p-2"> #Phone4 in lagos on 3/3/20 30pm </small>
                              <small class="d-block border border-secondary p-2"> #Phone4 in lagos on 3/3/20 30pm </small>
                          </div>
                         </div>
                         <div class="form-group ">
                          <hr class="p-0 m-0 mt-1"> 
                          <small class="tmuted">Change Transaction Pin/Forgot Pin</small> 
                            <div class="form-group"> 
                                 <div class="form-check text-white">
                                     <label class="form-check-label link">
                                     <input type="radio" @click="settings.Fpin=true" class="form-check-input link" name="pin" id="pintru" value="checkedValue" checked>
                                     I have Pin
                                   </label>
                                 </div>
                                 <div class="form-check text-white">
                                     <label class="form-check-label link">
                                     <input type="radio" @click="settings.Fpin=false" class="form-check-input link" name="pin" id="npintru" value="checkedValue" >
                                    Forgoten Pin
                                   </label>
                                 </div>
                              <input type="text" v-model="settings.Opin"  v-if="!settings.Fpin" class="form-control mt-1" name="" id="" aria-describedby="helpId" placeholder="Old Transaction Pin">
                              <input type="text" v-model="settings.Npin" v-if="settings.Opin.length==4 || settings.Fpin" class="form-control mt-1" name="" id="" aria-describedby="helpId" placeholder="New Transaction Pin">
                              <input type="text" v-model="settings.Cpin" v-if="settings.Npin.length==4 && settings.Opin.length==4 || settings.Fpin" class="form-control mt-1" name="" id="" aria-describedby="helpId" placeholder="Confirm Transaction Pin"> 
                            </div>                      
                         </div>
                         <div class="form-group">
                          <hr class="p-0 m-0 mt-1"> 
                          <small class="tmuted">Change Password</small> 
                            <div class="form-group"> 
                              <input type="text" v-model="settings.Opass"  class="form-control mt-1" name="" id="" aria-describedby="helpId" placeholder="Old Password">
                              <input type="text" v-model="settings.Npass" v-if="settings.Opass" class="form-control mt-1" name="" id="" aria-describedby="helpId" placeholder="New Password"> 
                              <input type="text" v-model="settings.Cpass" v-if="settings.Opass && settings.Npass" class="form-control mt-1" name="" id="" aria-describedby="helpId" placeholder="Confirm Password"> 
                              <nuxt-link to="/auth/reset-verify" class="link text-white btn btn-sm shadow mt-1">Forgot Password</nuxt-link>
                            </div>                      
                         </div>
                         <div class="theme text-white "> 
                          <hr class="p-0 m-0 my-1">  
                          <small class="tmuted d-block mb-2">Control Theme</small> 

                             <DarkMode>
                                <template v-slot="{ mode }">
                                    <i v-show="mode === 'light'" class="fa fa-sun-o themeIcon btn btn-sm  shadow btn-light text-muted" aria-hidden="true"> Light Theme</i>
                                    <i v-show="mode === 'dark'" class="fa fa-moon-o themeIcon btn btn-sm shadow btn-dark text-muted" aria-hidden="true"> Dark Theme</i>
                                    <i v-show="mode === 'system'" class="fa fa-shirtsinbulk themeIcon btn btn-sm shadow btn-info" aria-hidden="true"> Default Theme</i>
   
                              </template>
                              </DarkMode>
                        </div>
                        <div class="form-group p-1">
                            <button type="button" class="btn btn-info btn-sm  topup rounded-l shadow float-right ">Save Changes</button> 

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
import { DarkMode } from '@vue-a11y/dark-mode'

export default {
//   auth:false,
   components:
   {
       mfooter,
       sidebar,
       DarkMode

   },
   data() {
       return { 
        viewLogs:false,
        settings:{
            loggedinNotify:false,
            loggedinSave:false,
            tfa:false,
            Fpin:false, 
            Opin:'',
            Npin:'',
            Cpin:'',
            Opass:'',
            Npass:'',   
            Cpass:'',
        }
       }
   },
   mounted(){ 

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