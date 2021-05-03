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
// 'FLWPUBK-48e3603c33549b03cea69001e2942ef5-X'