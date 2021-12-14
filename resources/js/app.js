
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import Antd from 'ant-design-vue';
Vue.use(Antd);
import 'ant-design-vue/dist/antd.css'; // or 'ant-design-vue/dist/antd.less'

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));CreateCostumerComponent.vue

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

// Costumers
Vue.component('costumers-component', require('./components/costumers/CostumerComponent.vue').default);
Vue.component('create-costumers-component', require('./components/costumers/CreateCostumerComponent.vue').default);

// Section - Articulos - 
Vue.component('section-component', require('./components/sections/SectionComponent.vue').default);
Vue.component('create-section-component', require('./components/sections/CreateSectionComponent.vue').default);

// Orders - 
Vue.component('order-component', require('./components/orders/IndexOrderComponent.vue').default);
Vue.component('create-order-component', require('./components/orders/CreateOrderComponent.vue').default);
Vue.component('edit-order-component', require('./components/orders/EditOrderComponent.vue').default);

// Invoices - 
Vue.component('invoice-component', require('./components/invoices/IndexInvoiceComponent.vue').default);
Vue.component('create-invoice-component', require('./components/invoices/CreateInvoiceComponent.vue').default);
Vue.component('edit-invoice-component', require('./components/invoices/EditInvoiceComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});
