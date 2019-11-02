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
                        <table class="bordered highlight invoice-lines" style="font-size: 12px; font-weight: 500;">
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
                                <tr v-for="line in invoice.lines">
                                    <td>{{ line.product.name }}</td>
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
                                        <button class="btn waves-effect waves-light red btn-invoice-line" type="button" name="action">
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
                                    <th style="font-weight: 300; font-size: 16px;">Subtotal</th>
                                    <th class="right">54585.52</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th style="font-weight: 300; font-size: 16px;">Impuesto</th>
                                    <th class="right">585.52</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th style="font-weight: 300; font-size: 16px;">Total</th>
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
                        <a v-for="category in categories" class="waves-effect waves-light btn" style="margin-right: 10px; margin-bottom: 10px;"> {{category.name}} </a>
                    </div>

                </div>

                <div class="row">
                    <div class="col s12">
                        <div class="row">
                            <div class="input-field col s6">
                                <input id="icon_prefix" type="text" class="validate">
                                <label for="icon_prefix">Código / Nombre</label>
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
                                            <button class="btn waves-effect waves-light green responsive center" type="button" name="action" style="height: 23px; line-height: 14px; padding: 5px; font-size: 13px; font-weight: 600;">
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
                lines: [
                    {
                        product: {
                            id: 'dsdsdsd',
                            name: 'Lubricante 1'
                        },
                        price: 45216.55,
                        qty: 2,
                        subtotal: 845236.10
                    },
                    {
                        product: {
                            id: '74596',
                            name: 'Liga de Frenos'
                        },
                        price: 452.55,
                        qty: 2,
                        subtotal: 5236.10
                    },
                    {
                        product: {
                            id: 'dsdsd',
                            name: 'Grasa 1'
                        },
                        price: 4525.55,
                        qty: 1,
                        subtotal: 4525.55
                    }
                ]
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
            categories: [
                {
                    id: '',
                    name: 'Todos'
                },
                {
                    id: '',
                    name: 'Lubricantes'
                },
                {
                    id: '',
                    name: 'Liga de frenos'
                },
                {
                    id: '',
                    name: 'Hidraulico'
                }
            ],
            products: [
                {
                    id: '',
                    name: 'Aceite 15-40 semisintetico',
                    price: '420054540',
                    image: '/images/products/img1.jpg',
                    description: '',
                    category: {
                        id : '',
                        name: ''
                    }
                },
                {
                    id: '',
                    name: 'Aceite de pipa',
                    price: '420',
                    image: '/images/products/img1.jpg',
                    description: '',
                    category: {
                        id : '',
                        name: ''
                    }
                },
                {
                    id: '',
                    name: 'Aceite Shell 20-50',
                    price: '4204747825,00',
                    image: '/images/products/img1.jpg',
                    description: '',
                    category: {
                        id : '',
                        name: ''
                    }
                },
                {
                    id: '',
                    name: 'Liga de frenos',
                    price: '4207452',
                    image: '/images/products/img2.jpeg',
                    description: '',
                    category: {
                        id : '',
                        name: ''
                    }
                },
                {
                    id: '',
                    name: 'Maxi diesel',
                    price: '428520',
                    image: '/images/products/img3.jpg',
                    description: '',
                    category: {
                        id : '',
                        name: ''
                    }
                },
                {
                    id: '',
                    name: '15-40 mineral',
                    price: '496320',
                    image: '/images/products/img4.jpeg',
                    description: '',
                    category: {
                        id : '',
                        name: ''
                    }
                },
                {
                    id: '',
                    name: 'Paila 20-50',
                    price: '424520',
                    image: '/images/products/img5.jpg',
                    description: '',
                    category: {
                        id : '',
                        name: ''
                    }
                },
                {
                    id: '',
                    name: '25-10',
                    price: '85420',
                    image: '/images/products/img6.jpg',
                    description: '',
                    category: {
                        id : '',
                        name: ''
                    }
                },
                {
                    id: '',
                    name: 'Lubricante PDV 25-50 litro tren en uno para camionetas y camiones pesados',
                    price: '420',
                    image: '/images/products/img7.png',
                    description: '',
                    category: {
                        id : '',
                        name: ''
                    }
                },
                {
                    id: '',
                    name: 'Liga de frenos PDV',
                    price: '420',
                    image: '/images/products/img8.png',
                    description: '',
                    category: {
                        id : '',
                        name: ''
                    }
                },
                {
                    id: '',
                    name: 'Aceite 25-10 Mineral',
                    price: '40',
                    image: '/images/products/img9.jpeg',
                    description: '',
                    category: {
                        id : '',
                        name: ''
                    }
                },
                {
                    id: '',
                    name: 'Aceite 10',
                    price: '42045',
                    image: '/images/products/img10.jpg',
                    description: '',
                    category: {
                        id : '',
                        name: ''
                    }
                },
                {
                    id: '',
                    name: 'Aceite 11',
                    price: '452020',
                    image: '/images/products/img11.jpg',
                    description: '',
                    category: {
                        id : '',
                        name: ''
                    }
                },
                {
                    id: '',
                    name: 'Aceite 15-40 semisintetico',
                    price: '452320',
                    image: '/images/products/img1.jpg',
                    description: '',
                    category: {
                        id : '',
                        name: ''
                    }
                },
                {
                    id: '',
                    name: 'Aceite de pipa',
                    price: '425220',
                    image: '/images/products/img1.jpg',
                    description: '',
                    category: {
                        id : '',
                        name: ''
                    }
                },
                {
                    id: '',
                    name: 'Aceite Shell 20-50',
                    price: '420',
                    image: '/images/products/img1.jpg',
                    description: '',
                    category: {
                        id : '',
                        name: ''
                    }
                },
                {
                    id: '',
                    name: 'Liga de frenos',
                    price: '4240',
                    image: '/images/products/img2.jpeg',
                    description: '',
                    category: {
                        id : '',
                        name: ''
                    }
                },
                {
                    id: '',
                    name: 'Maxi diesel',
                    price: '0',
                    image: '/images/products/img3.jpg',
                    description: '',
                    category: {
                        id : '',
                        name: ''
                    }
                },
                {
                    id: '',
                    name: '15-40 mineral',
                    price: '42960',
                    image: '/images/products/img4.jpeg',
                    description: '',
                    category: {
                        id : '',
                        name: ''
                    }
                },
                {
                    id: '',
                    name: 'Paila 20-50',
                    price: '44120',
                    image: '/images/products/img5.jpg',
                    description: '',
                    category: {
                        id : '',
                        name: ''
                    }
                },
                {
                    id: '',
                    name: '25-10',
                    price: '42580',
                    image: '/images/products/img6.jpg',
                    description: '',
                    category: {
                        id : '',
                        name: ''
                    }
                },
                {
                    id: '',
                    name: 'Lubricante PDV 25-50 litro tren en uno para camionetas y camiones pesados',
                    price: '4240',
                    image: '/images/products/img7.png',
                    description: '',
                    category: {
                        id : '',
                        name: ''
                    }
                },
                {
                    id: '',
                    name: 'Liga de frenos PDV',
                    price: '42085278624',
                    image: '/images/products/img8.png',
                    description: '',
                    category: {
                        id : '',
                        name: ''
                    }
                },
                {
                    id: '',
                    name: 'Aceite 25-10 Mineral',
                    price: '432420',
                    image: '/images/products/img9.jpeg',
                    description: '',
                    category: {
                        id : '',
                        name: ''
                    }
                },
                {
                    id: '',
                    name: 'Aceite 10',
                    price: '45520',
                    image: '/images/products/img10.jpg',
                    description: '',
                    category: {
                        id : '',
                        name: ''
                    }
                },
                {
                    id: '',
                    name: 'Aceite 11',
                    price: '20',
                    image: '/images/products/img11.jpg',
                    description: '',
                    category: {
                        id : '',
                        name: ''
                    }
                },
            ]
        };
    },
    mounted() {
        let vm = this;
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
    },
    methods: {
         show(obj) {
            $('#componentDataModal').modal('open');
        },
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
