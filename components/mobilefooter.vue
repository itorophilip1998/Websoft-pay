<template>
    <div class="fixed-bottom mfooter shadow bg-light border-top p-2 d-md-none d-block">
    <ul class="mfooter-ul p-0 m-0 text-center d-">  
        <li id="mdashboard" class="link shadow mclasslistHover" @click="urlget('/dashboard')"><i class="fa fa-home" aria-hidden="true"></i></li> 
        <li id="mtransfer" class="link shadow mclasslistHover"  @click="urlget('/services/transfer')">  <i class="fa fa-money" aria-hidden="true"></i> </li> 
        <li id="mairtime" class="link shadow mclasslistHover" @click="urlget('/services/airtime')"><i class="fa fa-phone" aria-hidden="true"></i></li>
        <li id="mdata" class="link shadow mclasslistHover" @click="urlget('/services/data')"><i class="fa fa-globe" aria-hidden="true"></i></li>
        <li id="mtv" class="link shadow mclasslistHover" @click="urlget('/services/tv')"><i class="fa fa-television" aria-hidden="true"></i></li>
        <li id="melectricity" class="link shadow mclasslistHover" @click="urlget('/services/electricity')"><i class="fa fa-lightbulb-o ml-1" aria-hidden="true"></i></li>
        <li id="mremitta" class="link shadow mclasslistHover" @click="urlget('/services/remitta')"><i class="fa" aria-hidden="true"><strike>(R)</strike> </i></li> 
        <li id="missues" class="link shadow mclasslistHover" @click="urlget('/issues')"><i class="fa fa-book" aria-hidden="true"></i></li>
        <li id="msettings2" class="link shadow mclasslistHover" @click="urlget('/settings')"><i class="fa fa-gear" aria-hidden="true"></i></li>
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
        display: inline !important;
        padding:2px 5px 2px 5px ;
        text-align: center;
        color:  #17a2b8;
        width: 30px;
        border: 1px solid #d6f4f8;
        border-radius: 10px; 
    }
    .mfooter-ul>li:hover
    { 
        color:  #17a2b8
    }
      
</style>