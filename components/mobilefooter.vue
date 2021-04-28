<template>
    <div class="fixed-bottom mfooter shadow bg-light border-top p-2 d-md-none d-block">
    <ul class="mfooter-ul p-0 m-0 text-center">  
        <li class="link shadow" @click="urlget('/dashboard')"><i class="fa fa-home" aria-hidden="true"></i></li> 
        <li class="link shadow"  @click="urlget('/services/transfer')">  <i class="fa fa-money" aria-hidden="true"></i> </li>
        <li class="link shadow" @click="urlget('/services/redraw')"><i class="fa " aria-hidden="true"><strike>N</strike></i></li>
        <li class="link shadow" @click="urlget('/services/airtime')"><i class="fa fa-phone" aria-hidden="true"></i></li>
        <li class="link shadow" @click="urlget('/services/data')"><i class="fa fa-globe" aria-hidden="true"></i></li>
        <li class="link shadow" @click="urlget('/services/tv')"><i class="fa fa-television" aria-hidden="true"></i></li>
        <li class="link shadow" @click="urlget('/services/electricity')"><i class="fa fa-lightbulb-o ml-1" aria-hidden="true"></i></li>
        <li class="link shadow" @click="urlget('/services/remitta')"><i class="fa" aria-hidden="true"><strike>(R)</strike> </i></li>
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
    .mfooter-ul>li
    {
        display: inline-block;
        padding:2px 5px 2px 5px ;
        text-align: center;
        color:  #17a2b8;
        width: 30px;
        border: 1px solid #d3e6e9;
        border-radius: 10px; 
    }
    .mfooter-ul>li:hover
    { 
        color:  #17a2b8
    }
     
</style>