<template>
    <div class="row">
        <div class="s12 col">
            <div v-if="showAlert">
              <alert :type="alertType">{{ alertText }}</alert>
            </div>
        </div>
        <div class="col s12 m6 l5 xl4 mr-top-10 pos-invoice">

            <nav>
                <div class="nav-wrapper">
                  <a href="#!" class="brand-logo" style="padding-left: 15px;">Factura</a>
                  <ul class="right hide-on-med-and-down">
                    <li><a href="#" @click.prevent="showSearch('client')"><i class="material-icons mini-icons">search</i></a></li>
                    <li><a href="#"><i class="material-icons mini-icons">view_module</i></a></li>
                    <li><a href="#"><i class="material-icons mini-icons">refresh</i></a></li>
                    <li><a href="#"><i class="material-icons mini-icons">more_vert</i></a></li>
                  </ul>
                </div>
                <div class="nav-wrapper" style="margin: 0 auto; padding: 0 24px;">
                  <form>
                    <div class="input-field">
                      <input id="searchCustomer" placeholder="buscar..." type="search" v-model="searchCustomer" ref="searchCustomer" v-on:blur="searchBlur" v-bind:class="{'active-search': activeSearch}">
                      <label class="label-icon" for="searchCustomer"><i class="material-icons mini-icons" v-bind:class="{'active-icon-search': activeSearch}">search</i></label>
                      <i class="material-icons mini-icons" @click="hideSearch()" v-bind:class="{'active-icon-search': activeSearch}">close</i>
                    </div>
                  </form>
                </div>
            </nav>

            <div class="card-panel">

                <div class="row" v-show="activeSearch"  style="margin-top: 12px !important;">

                    <div class="col s12" style="padding: 0;">

                        <ul class="collection with-header">
                            <li class="collection-header">
                                <a class="waves-effect waves-light btn" style="height: 30px; line-height: 30px; padding: 0 20px;" href="#!" @click.prevent="openCustomer()">
                                    <i class="material-icons right" style="height: 30px; line-height: 30px;">add</i>
                                    Nuevo
                                </a>
                            </li>

                            <li class="collection-item" v-for="c in clients">
                                <div>
                                    <a href="#!" @click.prevent="openCustomer(c)" class="secondary-content" style="float: left;">
                                        <i class="material-icons" style="font-size: 16px; margin-right: 8px;">edit</i>
                                    </a>
                                    {{ c.document + ' - ' + c.name }}
                                    <a href="#!" @click.prevent="selectCustomer(c)" class="secondary-content">
                                        <i class="material-icons" style="color: #4faf4f;">check</i>
                                    </a>
                                </div>
                            </li>
                        </ul>

                    </div>
                </div>

                <div class="row">

                    <div class="col s12 m6">
                        <h5>Número # {{ invoice.number }}</h5>
                    </div>

                    <div class="col s12 m6" style="padding-top: 15px;">
                        <h6>
                            <strong>Fecha:</strong> {{ invoice.date }}
                            <br>
                            <strong>Hora:</strong> {{ invoice.time }}
                        </h6>
                    </div>

                </div>

                <div class="divider"></div>

                <div class="row">

                    <div class="col s12 m6">
                        <h6><strong>Cédula/Rif:</strong> {{ invoice.client.document }}</h6>
                    </div>

                    <div class="col s12 m6">
                        <h6><strong>Nombre:</strong> {{ invoice.client.name }}</h6>
                    </div>

                </div>

                <div class="row">

                    <div class="col s12 m6">
                        <H6><strong>Dirección:</strong> {{ invoice.client.address.address_1 }}</H6>
                    </div>

                    <div class="col s12 m6">
                        <H6><strong>Teléfono:</strong> {{ invoice.client.phone }}</H6>
                    </div>
                    
                </div>

                <div class="divider"></div>

                <div class="row">
                    <div class="col s12">
                        <h5 v-show="invoice.lines.length == 0">No hay productos en la factura</h5>
                        <table class="bordered highlight invoice-lines" v-show="invoice.lines.length > 0">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th class="right">Precio</th>
                                    <th class="center">Cant</th>
                                    <th></th>
                                    <th class="right">Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="(line, index) in invoice.lines">
                                    <td>{{ line.product.code + ' - ' + line.product.name }}</td>
                                    <td class="right">{{ line.price }}</td>
                                    <td style="text-align: center;vertical-align: top;">{{ line.qty }}</td>
                                    <td style="text-align: center;vertical-align: top;">
                                        <button class="btn waves-effect waves-light green btn-invoice-line" type="button" name="action" @click="increaseQty(index)">
                                            <i class="material-icons">add</i>
                                        </button>
                                        <button class="btn waves-effect waves-light orange btn-invoice-line" type="button" name="action" @click="decreaseQty(index)">
                                            <i class="material-icons">remove</i>
                                        </button>
                                    </td>
                                    <td class="right">{{ line.subtotal }}</td>
                                    <td style="text-align: center;vertical-align: top;">
                                        <button class="btn waves-effect waves-light red btn-invoice-line" type="button" name="action" @click="removeLine(index)">
                                            <i class="material-icons">clear</i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Subtotal</th>
                                    <th class="right">{{ invoice.subtotal }}</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Impuesto</th>
                                    <th class="right">{{ invoice.tax }}</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Total</th>
                                    <th class="right">{{ invoice.total }}</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col s12 m6 l7 xl8 mr-top-10">
            <div class="card-panel">

                <div class="row box-title">
                    <div class="col s12">
                        <h5 class="content-headline">Productos</h5>
                    </div>
                </div>

                <div class="row">

                    <div class="col s12">
                        <button type="button" v-for="category in mainCategories" class="waves-effect waves-light btn blue" style="margin-right: 10px; margin-bottom: 10px; font-size: 12px; height: 24px; line-height: 24px;" @click="categoryFilter(category)">
                            {{category.name}}
                        </button>
                    </div>

                    <div class="col s12">
                        <button type="button" v-for="category in categories" class="waves-effect waves-light btn" style="margin-right: 10px; margin-bottom: 10px; font-size: 12px; height: 24px; line-height: 24px;" @click="categoryFilter(category)">
                            {{category.name}}
                        </button>
                    </div>

                </div>

                <div class="row">
                    <div class="col s12">
                        <div class="row">
                            <div class="input-field col s12 m12 l6">
                                <input id="searchProduct" type="text" class="" v-model="searchProduct">
                                <label for="searchProduct">Código / Nombre</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div v-for="product in products" class="col s6 m6 l4 xl2">
                            <div class="card z-depth-5">
                                <div class="card-image">
                                    <div class="img-gallary-section" style="margin-bottom: 0px; padding: 5px;">
                                        <img :src="product.image" class="materialboxed responsive-img" style="height: 190px;"/></div>
                                    <!-- height: 266px; -->
                                </div>
                                <div class="card-content" style="padding: 5px 10px; height: 55px;">
                                    <span class="card-title activator grey-text text-darken-4" style="font-size: 15px; font-weight: 400; line-height: 16px; text-align: center;">
                                        {{ product.name }}
                                    </span>
                                </div>
                                <div class="card-action" style="padding: 10px 10px;">
                                    <div class="row">
                                        <div class="col s12">
                                            <p class="primary-text center" style="font-weight: bold; line-height: 0.5rem;">{{ product.price }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12" style="text-align: center;">
                                            <button class="btn waves-effect waves-light green responsive center" type="button" name="action" style="height: 23px; line-height: 14px; padding: 5px; font-size: 13px; font-weight: 600;" @click="addLine(product)">
                                                Agregar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-reveal">
                                    <span class="card-title grey-text text-darken-4">{{ product.name }}<i class="material-icons right">close</i></span>
                                    <p>{{ product.description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col s3">

                    </div>

                    <div class="col s9">

                    </div>

                </div>

            </div>
        </div>

      <!-- Modal Structure -->
   
      <div id="customer-modal" class="modal modal-fixed-footer medium">
        <div class="modal-content">
          <div class="col s12">
            <h5>Cliente</h5>
          </div>
          <form @submit.prevent="isNotValidateCustomer" name="callback" class="col s12">
            <div class="input-field">
              <input type="text" id="customer-document" name="customer-document" v-model="client.document">
              <label for="role-name" v-bind:class="{'active': editingCustomer || creatingCustomer}">Cédula/Rif</label>
            </div>
            <div class="input-field">
              <input type="text" id="customer-name" name="customer-name" v-model="client.name">
              <label for="role-name">Nombre</label>
            </div>
            <div class="input-field">
              <input type="text" id="customer-phone" name="customer-phone" v-model="client.phone">
              <label for="role-label">Teléfono</label>
            </div>
            <div class="input-field">
              <input type="text" id="customer-address" name="customer-address" v-model="client.address.address_1">
              <label for="role-name">Dirección</label>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Cerrar</a>
          <a href="#!" class="btn-flat" :disabled="isNotValidateCustomer" @click="updateCustomer()" v-show="editingCustomer">Editar</a>
          <a href="#!" class="btn-flat" :disabled="isNotValidateCustomer" @click="createCustomer()" v-show="creatingCustomer">Crear</a>
        </div>
      </div>

    </div>
</template>
<script>

import { tableData } from '../../mixins/tableMixin';

export default {

    mixins: [tableData],

    data() {

        return {
            
            invoice: {
            
                number: '005632485',

                date: '06/11/2019',

                time: '14:06:03',

                client: {
                    address: {}
                },
            
                lines: [],

                subtotal: 0.00,
                tax: 0.00,
                total: 0.00
            },

            client: {
                document: '',
                name: '',
                phone: '',
                address: {
                    address_1: ''
                }
            }, 

            clients: [],

            categories: [],

            mainCategories: [
                {
                    id: null,
                    name: 'Todos'
                }
            ],

            products: [],

            searchProduct: '',

            searchCustomer: '',

            activeSearch: false,

            editingCustomer: false,

            creatingCustomer: false,
        };
    },

    watch: {
            
        searchProduct: function (value) {

            var filter = value == '' ? '' : '&q-or=name|code:has:' + value;
            let params = '?fields=id,code,name,price,image,description&paginate=off' + filter;
            let uri = `/api/admin/products/products` + params;

            axios.get(uri).then((response) => {
                    let res = response.data;
                    if (res.success) {
                        this.products = res.data;
                    }
                })
                .catch(error => console.log(error));
        },

        searchCustomer: function (value) {

            var filter = value == '' ? '' : '&q-or=document|name:has:' + value;
            let params = '?paginate=off&fields=id,document,name,phone,address,address_1&limit=4' + filter;
            let uri = `/api/admin/sales/customers` + params;
            axios.get(uri).then((response) => {
                    let res = response.data;
                    if (res.success) {
                        this.clients = res.data;
                    }
                })
                .catch(error => console.log(error));
        },
    
    },

    mounted() {

        let vm = this;
        vm.getCategories();
        vm.getProducts();
        $('#customer-modal').modal({
            dismissible: false,
            ready: function(modal, trigger) {
                // Callback for Modal open. Modal and trigger parameters available.
            },
            complete: function() {  } // Callback for Modal close
        });

        /*
        $('#client-box' ).select2();

        $('#client-box2' ).select2({
            templateResult: formatState
        });
        */

        $('.materialboxed').materialbox();
    },

    created() {

    },

    methods: {

        getCategories() {
            let params = '?fields=id,name&paginate=off&sort=name&q=category_id:null';
            let uri = `/api/admin/products/categories` + params;
            axios.get(uri).then((response) => {
                    let res = response.data;
                    if (res.success) {
                        this.categories = res.data;
                    }
                })
                .catch(error => console.log(error));
        },

        getProducts(ids = null) {

            var filter = '';

            if (ids) {
                let productsIds = this.getIdsString(ids)
                filter = '&q=id:in:' + productsIds;
            }

            let params = '?fields=id,code,name,price,image,description&paginate=off' + filter;
            let uri = `/api/admin/products/products` + params;
            axios.get(uri).then((response) => {
                    let res = response.data;
                    if (res.success) {
                        this.products = res.data;
                    }
                })
                .catch(error => console.log(error));
        },

        categoryFilter(category) {

            if (category.id == null) {
                this.resetMainCategories(category);
                this.getProducts();
                return;
            } 

            this.updateMainCategories(category);
            
            let params = '?fields=id,name,children,products_ids';
            let uri = `/api/admin/products/categories/` + category.id + params;
            axios.get(uri).then((response) => {
                    if (response.status == 200) {
                        this.categories = response.data.data.children;
                        this.getProducts(response.data.data.products_ids);
                    }
                })
                .catch(error => console.log(error));
            
        },

        updateMainCategories(category) {

            var index = this.mainCategories.indexOf(category);

            if (index < 0) {
                this.mainCategories.push(category);
                return;
            }
            
            this.mainCategories.length = index + 1;
        },

        resetMainCategories(category = null) {

            this.mainCategories = [];
            this.mainCategories.push(category)
            this.getCategories();
        },

        getIdsString(ids) {

            var idsString = '';
            ids.forEach(function(item, index) {
                    idsString = idsString == '' ? item : idsString + '|' + item;
            });

            return idsString;
        },

        addLine(product) {

            var index = this.findLine(product);

            if (index < 0) {
                
                var line = {
                    product: product,
                    price: product.price,
                    qty: 1,
                    subtotal: product.price
                };

                this.invoice.lines.push(line);

                this.updateTotals()   
                
                return;
            }

            this.increaseQty(index);
        },

        findLine(product) {

            let found = -1;

            this.invoice.lines.some(function(item, index) {
                if (item.product.id == product.id) {
                    found = index;
                }
            });

            return found;
        },

        removeLine(index) {
            this.invoice.lines.splice(index, 1);
            this.updateTotals()
        },

        increaseQty(index) {
            this.invoice.lines[index].qty = this.invoice.lines[index].qty + 1;
            this.invoice.lines[index].subtotal = this.invoice.lines[index].qty * this.invoice.lines[index].product.price;
            this.updateTotals()
        },

        decreaseQty(index) {
            if (this.invoice.lines[index].qty > 0) {
                this.invoice.lines[index].qty = this.invoice.lines[index].qty - 1;
                this.invoice.lines[index].subtotal = this.invoice.lines[index].qty * this.invoice.lines[index].product.price;
                this.updateTotals()
            }
        },

        updateTotals() {

            var subtotal = 0;
            var tax = 0;
            
            this.invoice.lines.forEach(function(item, index) {
                subtotal = subtotal + item.subtotal;
            });

            this.invoice.subtotal = subtotal;
            this.invoice.tax = tax;
            this.invoice.total = subtotal + tax;
        },

        showSearch(type) {
            //this.$refs.searchCustomer.focus();
            this.activeSearch = true;

        },

        searchBlur() {
            this.activeSearch = true;
        },

        hideSearch() {
            this.activeSearch = false;  
        },

        selectCustomer(customer) {
            this.invoice.client = customer;
            //this.activeSearch = false; 
        },

        openCustomer(customer = null) {

            if (customer) {

                this.updatingCustomer = true;
                this.client.document = customer.document;
                this.client.name = customer.name;
                this.client.phone = customer.phone;
                this.client.address.address_1 = customer.address.address_1;
                $('#customer-modal').modal('open');
                return;
            }

            this.creatingCustomer = true;
            this.client.document = this.searchCustomer;
            $('#customer-modal').modal('open');
        },

        updateCustomer() {

        },

        createCustomer() {
          
        }

    },

    computed: {

        isNotValidateCustomer() {
            
            if (this.client.document == '') {
                return true;
            }

            if (this.client.name == '') {
                return true;
            }

            if (this.client.address.address_1 == '') {
                return true;
            }

            if (this.client.phone == '') {
                return true;
            }

            return false;
        }
    }
}

function formatState (state) {
    if (state.id != 'new') { return state.name; }
    var $state = $(
        '<span><img src="/images/icons/new.png" class="img-flag" /> ' + state.name + ' </span>'
    );
    return $state;
};
</script>
