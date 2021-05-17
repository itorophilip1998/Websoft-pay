import Vue from 'vue'; 
import VueSweetalert2 from 'vue-sweetalert2';
require("bootstrap");

// If you don't need the styles, do not connect
import 'sweetalert2/dist/sweetalert2.min.css'; 
Vue.use(VueSweetalert2);

window.baseurl="http://localhost:8000/api";
window.hosturl="http://localhost:8000";

// plugins/flutterwave.js 
import Flutterwave from 'vue-flutterwave'
Vue.use(Flutterwave, { publicKey: 'FLWPUBK_TEST-1b44d5feddeb5af6dd4fae786c6ad95e-X' })
window.axios = require('axios');
// live mode
let flutterHeader={headers:{
    'X-Requested-With':'XMLHttpRequest',
    'Authorization':'Bearer FLWSECK-36e950df4f9ad7a8ba223adcc855615a-X',
    'Content-Type':'application/json'
}}
 
window.localStorage.setItem('flutterHeader',JSON.stringify(flutterHeader))
import terms from '@/components/terms';
import loader from '@/components/loader';
import sidebar from '@/components/sidebar';
import mfooter from '@/components/mobilefooter'; 

export default { 
components:{
    terms,loader,mfooter,sidebar
}
}  