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
                          <small class="tmuted d-block mb-2">View my security logs</small> 
                          <button type="button" @click="viewLogs=!viewLogs" class="btn btn-sm  shadow text-white topup rounded-l">
                              <span v-if="!viewLogs">View Logs</span>
                              <span v-else>Hide Logs</span>
                          </button> 
                          <div class="logs bmuted py-3 p-1 mt-2"  v-if="viewLogs">
                              <h6 class="border-secondary "><u>Your Security Logs</u></h6>
                              <small class="d-block border border-secondary p-2 " v-for='item in logs'>
                                 You logged-in on {{ fulltime(item.created_at) }}
                             </small> 
                          </div>
                         </div>
                         <div class="form-group ">
                          <hr class="p-0 m-0 mt-1"> 
                          <small class="tmuted">Change Transaction Pin(max of 4number)</small> 
                            <div class="form-group " v-if="viewPin">  
                              <input type="password" v-model="settings.Opin"  v-if="!settings.Fpin" class="form-control mt-1 p-4" name="" id="" aria-describedby="helpId" placeholder="Old Transaction Pin">
                              <input type="password" v-model="settings.Npin" v-if="settings.Opin.length==4" class="form-control mt-1 p-4" name="" id="" aria-describedby="helpId" placeholder="New Transaction Pin">
                              <input type="password" v-model="settings.Cpin" v-if="settings.Npin.length==4 && settings.Opin.length==4" class="form-control mt-1 p-4" name="" id="" aria-describedby="helpId" placeholder="Confirm Transaction Pin"> 
                            </div>        
                          <div>
                            <button @click="viewPin=true" class="link text-white btn btn-sm shadow mt-2 topup rounded-l">Set New Pin</button>
                            <nuxt-link to="/auth/reset-verify?pin" class="link text-white btn btn-sm shadow mt-2 topup rounded-l">Forgot Pin</nuxt-link>
                          </div>
                         </div> 
                         <div class="form-group">
                          <hr class="p-0 m-0 mt-1"> 
                          <small class="tmuted">Change Password(min of 7char)</small> 
                            <div class="form-group" v-if="viewPassword"> 
                              <input type="password" v-model="settings.Opass"  class="form-control mt-1 p-4" name="" id="" aria-describedby="helpId" placeholder="Old Password">
                              <input type="password" v-model="settings.Npass" v-if="settings.Opass.length >= 7" class="form-control mt-1 p-4" name="" id="" aria-describedby="helpId" placeholder="New Password"> 
                              <input type="password" v-model="settings.Cpass" v-if="settings.Opass.length >= 7 && settings.Npass.length >= 7" class="form-control mt-1 p-4" name="" id="" aria-describedby="helpId" placeholder="Confirm Password"> 
                            </div>            
                            <div> 
                            <button @click="viewPassword=true" class="link text-white btn btn-sm shadow mt-2 topup rounded-l">Set New Password</button>
                            <nuxt-link to="/auth/reset-verify" class="link text-white btn btn-sm shadow mt-2 topup rounded-l">Forgot Password</nuxt-link>
                            </div>   
                         </div>
                         <div class="theme text-white "> 
                          <hr class="p-0 m-0 my-1">  
                          <small class="tmuted d-block mb-2">Control Theme</small> 
                          <!-- Theme -->
<!-- hello -->
                             <DarkMode>
                                <template v-slot="{ mode }">
                                    <i v-show="mode === 'light'" class="fa fa-sun-o themeIcon btn btn-sm  shadow btn-light text-muted" aria-hidden="true"> Light Theme</i>
                                    <i v-show="mode === 'dark'" class="fa fa-moon-o themeIcon btn btn-sm shadow btn-dark text-muted" aria-hidden="true"> Dark Theme</i>
                                    <i v-show="mode === 'system'" class="fa fa-shirtsinbulk themeIcon btn btn-sm shadow btn-info" aria-hidden="true"> Default Theme</i>
   
                              </template>
                              </DarkMode>
                        </div>
                        <div class="form-group p-1 pb-2">
                            <button type="button" @click="postSettings()" class="btn btn-info btn-sm   topup rounded-l shadow float-right ">Save Changes</button> 

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
import moment from 'moment'; 

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
        viewPassword:false,
        viewPin:false,
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
        },
        logs:[],
       }
   },
   mounted(){ 
    this.getLogs()
   },
   methods: {
    getLogs(){
        this.$axios.get(`/api/logs`)
            .then((res)=> {   
                this.logs=res.data
            })
    },
    postSettings(){
        this.$axios.post(`/api/settings`,this.settings)
            .then((res)=> {   
                // this.logs=res.data
            })
    },
    fulltime(time) {
            return moment(time).format(' Do MMMM YYYY, h:mm a');
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