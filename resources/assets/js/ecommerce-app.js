/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./forge-bootstrap');
import Forge from './ecommerce';

window.Vue = require('vue');
window.Event = new class {
    constructor() {
        this.vue = new Vue();
    }

    fire(event, data = null) {
        this.vue.$emit(event, data);
    }

    listen(event, callback) {
        this.vue.$on(event, callback);
    }
}
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('e-product', require('./components/ecommerce/Product.vue'));

Vue.component('e-products', require('./components/ecommerce/Products.vue'));

const app = new Vue({
    el: '#app',
    mounted() {
        let forge = new Forge('horizontal', 'iconized');  // vertical/horizontal - default/iconized
        forge.init();
    }
});
