<template>
    <div class="mfooter bg-white   d-md-block d-none border-info border rounded-l">
    <ul class="p-0 m-0 text-left shadow p-2 ">  
                <li class="dropdown-item link mb-3" @click="urlget('/dashboard')"><i class="fa fa-home" aria-hidden="true"></i>&ensp; <span>Home</span></li>
                <li class="dropdown-item link mb-3" @click="urlget('/services/redraw')"><strike>N</strike>&emsp;<span>Redraw</span></li>
                <li class="dropdown-item link mb-3" @click="urlget('/services/airtime')"><i class="fa fa-phone" aria-hidden="true"></i>&emsp;<span>Buy Airtime</span></li>
                <li class="dropdown-item link mb-3" @click="urlget('/services/data')"><i class="fa fa-globe" aria-hidden="true"></i>&emsp;<span>Buy Data</span></li>
                <li class="dropdown-item link mb-3" @click="urlget('/services/tv')"><i class="fa fa-television" aria-hidden="true"></i>&ensp; <span>Tv-cables Subscription</span></li>
                <li class="dropdown-item link mb-3" @click="urlget('/services/electricity')"><i class="fa fa-lightbulb-o ml-1" aria-hidden="true"></i> &ensp; <span>Electricity Subscription</span></li>
                <li class="dropdown-item link mb-3" @click="urlget('/services/remitta')"><strike>(R)</strike>&ensp; Remitta</li>
                <li class="dropdown-item link mb-3" @click="urlget('/services/remitta')"><i class="fa fa-book" aria-hidden="true"></i> &ensp; Report Issues/Errors</li>
           
    </ul>

    </div>
</template>

<script>
export default {
    methods: {
     urlget(data)
     {  
      this.$router.push(data)
     }, 
  },

}
</script>
<style >
 
</style>