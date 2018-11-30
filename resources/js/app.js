
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import moment from 'moment';   /*it is for display readable date*/
import { Form, HasError, AlertError } from 'vform'
window.Form=Form;

import Gate from"./Gate"; /*for authintication*/
Vue.prototype.$gate=new Gate(window.user);

/*for pagination globale use*/
Vue.component('pagination', require('laravel-vue-pagination'));

import VueProgressBar from 'vue-progressbar' /*its for progressbar*/
/*sweet aleart*/
import swal from 'sweetalert2';
window.swal=swal;
const toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});
window.toast=toast;

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

import VueRouter from 'vue-router'
Vue.use(VueRouter)

let routes = [
  { path: '/dashbord', component:require('./components/Dashbord.vue')},
  { path: '/developer', component:require('./components/Developer.vue')},
  { path: '/profile', component:require('./components/Profile.vue') },
  { path: '/users', component:require('./components/Users.vue') },
  { path: '*', component:require('./components/Notfound.vue') }
]

const router = new VueRouter({
  mode:'history',	
  routes 
})
/*vue progressbar*/
Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '10px'
})

/*globale fillter*/
Vue.filter('upText', function(text){
  return text.charAt(0).toUpperCase()+text.slice(1);
});
 /*data fillter for display date humane readable*/
 Vue.filter('myDate', function(created){
  return moment(created).format('MMMM Do YYYY, h:mm:ss a');
});

/*2nd ruls to display data real time*/
window.Fire=new Vue();/* global regester to use */

/*2nd ruls to display data real time*/

Vue.component('dashbord-component', require('./components/Dashbord.vue'));

// const files = require.context('./', true, /\.vue$/i)

// files.keys().map(key => {
//     return Vue.component(_.last(key.split('/')).split('.')[0], files(key))
// })

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);
/*for not found page*/
Vue.component(
    'not-found',
    require('./components/Notfound.vue')
);


const app = new Vue({
	  el: '#app',
    router,
    /*for search*/
    data:{
        search: ''
    },
    methods:{
        searchit: _.debounce(() => {
            Fire.$emit('searching');
        },1000),
         printme() {
            window.print();
        }
      }

});
