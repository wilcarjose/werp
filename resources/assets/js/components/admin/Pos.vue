<template>
    <div class="row">
        <div class="s12 col">
            <div v-if="showAlert">
              <alert :type="alertType">{{ alertText }}</alert>
            </div>
        </div>
        <div class="col s12 m6 l5 xl4 mr-top-10">
            <div class="card-panel">

                <div class="row box-title">
                    <div class="col s12">
                        <h5 class="content-headline">Factura</h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12">
                        <h5>Número # 000021478</h5>
                    </div>

                    <div class="select2-input col s12" id="client-main-box">
                        <label for="client-box" style="top: -22px; font-size: 0.8rem;">Cliente</label>
                        <select class="select2_select" id="client-box" name="client-box" v-model="invoice.client" required="required">
                            <option value="" disabled=>Seleccione...</option>
                            <option :value="c.id" v-for="c in clients">{{ c.name }}</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12">
                        <p v-show="invoice.lines.length == 0">No hay productos en la factura</p>
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
                                        <button class="btn waves-effect waves-light green btn-invoice-line" type="button" name="action">
                                            <i class="material-icons">add</i>
                                        </button>
                                        <button class="btn waves-effect waves-light orange btn-invoice-line" type="button" name="action">
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
                                    <th class="right">54585.52</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Impuesto</th>
                                    <th class="right">585.52</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>Total</th>
                                    <th class="right">4554585.52</th>
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
        <!--
      <div id="componentDataModal" class="modal modal-fixed-footer medium">
        <div class="modal-content">
          <div class="col s12">
            <h5>Rol</h5>
          </div>
          <form @submit.prevent="isNotValidateForm" name="callback" class="col s12">
            <div class="input-field">
              <input type="text" id="role-name" name="role-name" v-model="singleObj.name">
              <label for="role-name">Nombre</label>
            </div>
            <div class="input-field">
              <input type="text" id="label-text" name="role-label" v-model="singleObj.label">
              <label for="role-label">Descripción</label>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Cerrar</a>
          <a href="#!" class="btn-flat" :disabled="isNotValidateForm" @click="update()" v-if="pupupMod=='edit'">Editar</a>
          <a href="#!" class="btn-flat" :disabled="isNotValidateForm" @click="store()" v-else>Añadir</a>
        </div>
      </div>
        -->
    </div>
</template>
<script>

import { tableData } from '../../mixins/tableMixin';

export default {

    mixins: [tableData],

    data() {

        return {
            
            invoice: {
            
                client: {
                    id: '',
                    name: ''
                },
            
                lines: []
            
            },

            clients: [
                {
                    id: '1',
                    name: '16323242 - Jose Perez'
                },
                {
                    id: '2',
                    name: '7569842 - Robert Perez'
                },
                {
                    id: '3',
                    name: '12589321 - José Altuve'
                },
                {
                    id: '4',
                    name: '9632145 - Luisa Rodríguez'
                }
            ],

            categories: [],

            mainCategories: [
                {
                    id: null,
                    name: 'Todos'
                }
            ],

            products: [],

            searchProduct: ''
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
        }
    
    },

    mounted() {

        let vm = this;
        vm.getCategories();
        vm.getProducts();
        $('#componentDataModal').modal({
            dismissible: false,
            ready: function(modal, trigger) {
                // Callback for Modal open. Modal and trigger parameters available.
            },
            complete: function() {  } // Callback for Modal close
        });

        $('#client-box' ).select2();

        $('#client-box2' ).select2({
            templateResult: formatState
        });

        $('.materialboxed').materialbox();
    },

    created() {

    },

    methods: {

        show(obj) {
            $('#componentDataModal').modal('open');
        },

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
                
                return;
            }

            this.invoice.lines[index].qty = this.invoice.lines[index].qty + 1;
            this.invoice.lines[index].subtotal = this.invoice.lines[index].qty * product.price;
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
        }

    },

    computed: {

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
