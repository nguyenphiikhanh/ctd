/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

Vue.component('Login', require('./src/components/Login.vue').default);
Vue.component('header-dropdown', require('./src/components/layouts/HeaderDropdown.vue').default);
Vue.component('Sidebar', require('./src/components/layouts/Sidebar.vue').default);
Vue.component('LoadMore', require('./src/components/globalComponents/LoadMore.vue').default);


// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Vue from "vue";

import store from "./src/store";
import router from "./src/router";

//global components
import VueLoading from "vuejs-loading-plugin"; // loading
Vue.use(VueLoading, {
    dark: true,
    loading: false,
    text: 'Vui lòng chờ...',
    background: "#ffffffa6",
});

import Toast from "vue-toastification"; // Toastify
import "vue-toastification/dist/index.css";
Vue.use(Toast, {
    transition: "Vue-Toastification__fade",
    maxToasts: 20,
    newestOnTop: true
});

import 'vue2-datepicker/index.css'; // Datepicker

import VueSweetalert2 from 'vue-sweetalert2'; // Sweetalert2
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2);

const app = new Vue({
    store,
    router,
}).$mount('#app');
