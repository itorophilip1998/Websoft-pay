<template>
    <div class="mfooter bg-white   d-md-block d-none border-0  rounded-l">
    <ul class="p-0 m-0 text-left shadow ">  
                <li class="dropdown-item link p-3 border " id="dashboard" @click="urlget('/dashboard')"><i class="fa fa-home" aria-hidden="true"></i>&ensp; <span>Dashboard</span></li>
                <li class="dropdown-item link p-3 border" id="transfer" @click="urlget('/services/transfer')"><i class="fa fa-money" aria-hidden="true"></i>&ensp;<span>Transfer</span></li>
                <li class="dropdown-item link p-3 border" id="redraw" @click="urlget('/services/redraw')"><strike>N</strike>&emsp;<span>Redraw</span></li>
                <li class="dropdown-item link p-3 border " id="airtime" @click="urlget('/services/airtime')"><i class="fa fa-phone" aria-hidden="true"></i>&emsp;<span>Buy Airtime</span></li>
                <li class="dropdown-item link p-3 border" id="data" @click="urlget('/services/data')"><i class="fa fa-globe" aria-hidden="true"></i>&emsp;<span>Buy Data</span></li>
                <li class="dropdown-item link p-3 border" id="tv" @click="urlget('/services/tv')"><i class="fa fa-television" aria-hidden="true"></i>&ensp; <span>Tv-cables Subscription</span></li>
                <li class="dropdown-item link p-3 border" id="electricity" @click="urlget('/services/electricity')"><i class="fa fa-lightbulb-o ml-1" aria-hidden="true"></i> &ensp; <span>Electricity Subscription</span></li>
                <li class="dropdown-item link p-3 border" id="remitta" @click="urlget('/services/remitta')"><strike>(R)</strike>&ensp; Remitta</li>
                <li class="dropdown-item link p-3 border" id="issues" @click="urlget('/issues')"><i class="fa fa-book" aria-hidden="true"></i> &ensp; Report Issues/Errors</li>
                <li class="dropdown-item link p-3 border" id="settings" @click="urlget('/settings')"><i class="fa fa-gear" aria-hidden="true"></i> &ensp; Settings</li>
    </ul>

    </div>
</template>

<script>
export default {
    data() {
        return {
            getRoute:this.$route.path
        }
    },
    mounted() { 
        this.check(this.$route.path)  
        },
    methods: {
        check(routes)
        {   
            let dashboard=document.getElementById("dashboard") 
            let transfer=document.getElementById("transfer") 
            let redraw=document.getElementById("redraw") 
            let airtime=document.getElementById("airtime") 
            let data=document.getElementById("data") 
            let tv=document.getElementById("tv") 
            let electricity=document.getElementById("electricity") 
            let remitta=document.getElementById("remitta") 
            let issues=document.getElementById("issues") 
            let settings=document.getElementById("settings") 

            switch (routes) {
                case '/dashboard':
                dashboard.classList.add('classList','shadow-sm') 
                    break;
                case '/services/transfer':
                transfer.classList.add('classList','shadow-sm') 
                    break;
                case '/services/redraw':
                redraw.classList.add('classList','shadow-sm') 
                    break;
                case '/services/airtime':
                airtime.classList.add('classList','shadow-sm') 
                    break;
                case '/services/data':
                data.classList.add('classList','shadow-sm') 
                    break;
                case '/services/tv':
                tv.classList.add('classList','shadow-sm') 
                    break;
                case '/services/electricity':
                electricity.classList.add('classList','shadow-sm') 
                    break; 
                case '/services/remitta':
                remitta.classList.add('classList','shadow-sm') 
                    break;
                case '/services/electricity':
                electricity.classList.add('classList','shadow-sm') 
                    break;
                case '/issues':
                issues.classList.add('classList','shadow-sm') 
                    break;
                case '/settings':
                settings.classList.add('classList','shadow-sm') 
                    break; 
                default:
                    break;
            }
            
        },
      
     urlget(data)
     {   
      this.$router.push(data)
     }, 
  },

}
</script>
<style >
 

</style>