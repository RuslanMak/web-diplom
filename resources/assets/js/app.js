
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// QR code https://github.com/gruhn/vue-qrcode-reader
import Vue from "vue";
import VueQrcodeReader from "vue-qrcode-reader";
Vue.use(VueQrcodeReader);

import VueQRCodeComponent from 'vue-qrcode-component'
Vue.component('qr-code', VueQRCodeComponent);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('halls-component', require('./components/HallsComponent.vue'));
Vue.component('admin-hall-places-component', require('./components/AdminHallPlacesComponent.vue'));
Vue.component('admin-main-component', require('./components/AdminMainComponent.vue'));
Vue.component('admin-prices-component', require('./components/AdminPricesComponent.vue'));
Vue.component('admin-movie-time-component', require('./components/AdminMovieTimeComponent.vue'));
Vue.component('admin-hall-edit-component', require('./components/AdminHallEditComponent.vue'));
Vue.component('read-qr-code-component', require('./components/QrReaderComponent.vue'));
Vue.component('generate-qr-code-component', require('./components/QrGenerateComponent.vue'));
Vue.component('client-home-component', require('./components/ClientComponent.vue'));
Vue.component('client-home-days-component', require('./components/ClientDaysComponent.vue'));
Vue.component('client-home-movi-component', require('./components/ClientMoviComponent.vue'));
Vue.component('client-home-hall-times-component', require('./components/ClientHallAndTimesComponent.vue'));
Vue.component('admin-hall-places-show-component', require('./components/AdminHallPlacesShowComponent.vue'));

const app = new Vue({
    el: '#app'
});

//тогл клик на админку
const headers = Array.from(document.querySelectorAll('.conf-step__header'));
headers.forEach(header => header.addEventListener('click', () => {
    header.classList.toggle('conf-step__header_closed');
    header.classList.toggle('conf-step__header_opened');
}));

