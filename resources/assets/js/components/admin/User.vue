<template>
    <div class="row">
      <div class="s12 col">
        <div v-if="showAlert && show_messages">
          <alert :type="alertType">{{ alertText }} </alert>
        </div>
      </div>
      <div class="col s12 mr-top-10" v-if="componentData.length === 0">
        <div class="card-panel">
          <div style="text-align: center;">
            <p style="color: #ea4869; font-size: 20px; font-weight: 300; margin-bottom: 0; text-align: center;"> No hay registros aún </p>
            <h5 class="content-headline" style="font-size: 2rem;" v-show="showAdd"> Agregar {{ title }}</h5> 
            <a class="btn btn-default pull-right btn-floating" :href="route + '/create'" v-show="showAdd" v-if="!use_modal" style="width: 60px; height: 60px;">
                <i class="material-icons" style="line-height: 60px; font-size: 2.2rem;">add</i>
            </a>
            <button type="button" class="btn btn-default pull-right btn-floating" @click="create()" v-show="showAdd" v-if="use_modal" style="width: 60px; height: 60px;">
                <i class="material-icons" style="line-height: 60px; font-size: 2.2rem;">add</i>
            </button>
          </div>
        </div>
      </div>
      <div class="col s12 mr-top-10" v-else>
        <div class="card-panel">
          <div class="row box-title">
            <div class="col s12">
              <h5 class="content-headline">{{ title }}</h5>
            </div>
            <div class="col s12 m8" v-if="show_multi_actions && !disable">
              <transition name="custom-classes-transition" enter-active-class="animated tada" leave-active-class="animated bounceOutRight">
                <a class="btn btn-default pull-right btn-floating" :href="route + '/create'" v-show="showAdd" v-if="!use_modal">
                  <i class="material-icons">add</i>
                </a>
                <button type="button" class="btn btn-default pull-right btn-floating" @click="create()" v-show="showAdd" v-if="use_modal">
                    <i class="material-icons">add</i>
                </button>
              </transition>
              <button type="button" class="btn error-bg btn-floating tooltipped"
                @click="removeBulkConfirm()" data-position="righht" data-delay="50" data-tooltip="Borrar seleccionados"
                :disabled="multiSelection.length == 0" v-if="show_delete && delete_multiple">
                <i class="material-icons">delete</i>
              </button>
              <button v-if="show_status" type="button" class="btn info-bg btn-floating tooltipped"
                @click="switchStatusBulkConfirm()" data-position="righht" data-delay="50" data-tooltip="Cambiar estatus"
                :disabled="multiSelection.length == 0">
                <i class="material-icons">compare_arrows</i>
              </button>
            </div>
            <div class="col s12 m4" v-if="show_search">
              <form class="form-inline" @submit.prevent="searchInput">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon"><span class="glyphicon glyphicon-search"></span></div>
                    <input type="text" v-model="searchQuery" class="form-control" id="searchInputUser" placeholder="Buscar" @keyup.delete="searchChanges">
                  </div>
                </div>
              </form>
            </div>
            <div class="col s12" v-if="show_filters">
                  <a href="#">Más filtros..</a>
            </div>
            <div class="input-field col s12" v-if="show_filters">
                <div class="col s4">
                  <label style="top: -22px; font-size: 0.8rem;">Almacén</label>
                  <select class="select2_select" style="display: block;">
                      <option value="" disabled>Seleccione...</option>
                      <option value="1" >Almacén 1</option>
                      <option value="2" >Almacen 2</option>
                      <option value="3" >Almacen 3</option>
                      <!-- <option :value="item[field.id_key]" v-for="item in dependencies[field.items]">{{ item[field.value_key] }}</option> -->
                  </select>
                </div>
            </div>
          </div>
          <div class="row">
            <div class="col s12">
              <table class="responsive-table bordered">
                <thead>
                  <tr>
                    <th  class="multiple-cb" v-if="show_multi_actions && delete_multiple">
                      <p>
                        <input type="checkbox" value="1" id="toggleAll" @click="toggleAll()" v-model="isAll">
                        <label for="toggleAll" v-if="use_modal" style="left: -0.25rem;top: -0.5rem;"></label>
                        <label for="toggleAll" v-else></label>
                      </p>
                    </th>
                    <!-- <th v-for="(col,index) in columns" @click="sortBy(col.name)"> -->
                    <th v-for="(col,index) in columns">
                      <span v-if="col.type == 'amount'" style="float: right; margin-right: 50px;">
                        {{ col.name | capitalize }}
                      </span>
                      <span v-if="col.type == 'text' || col.type == 'date' || col.type == 'link'">
                        {{ col.name | capitalize }}
                      </span>
                      <span class="arrow"
                        :class="sortOrder.field == col.name ? sortOrder.order : 'asc'"
                        v-if="escapeSort.indexOf(col.name) < 0"></span>
                    </th>
                    <th v-if="show_state" @click="sortBy('state')">
                      Estado
                      <span class="arrow"
                            :class="sortOrder.field == 'state' ? sortOrder.order : 'asc'"
                            v-if="escapeSort.indexOf('state') < 0"></span>
                    </th>
                    <th v-if="show_status" @click="sortBy('active')">
                      Activo
                      <span class="arrow"
                            :class="sortOrder.field == 'active' ? sortOrder.order : 'asc'"
                            v-if="escapeSort.indexOf('active') < 0"></span>
                    </th>
                    <th v-if="show_actions && !disable">
                      Acciones
                    </th>
                  </tr>
                </thead>
                <tbody  v-if="componentData.length">
                  <tr v-for="runningData in componentData">
                    <th class="multiple-cb" v-if="show_multi_actions && delete_multiple">

                      <p v-if="!show_state || runningData.state.key == 'pending'">
                        <input type="checkbox" :value="runningData.id" :id="runningData.id" v-model="multiSelection">
                        <label :for="runningData.id" v-if="use_modal" style="left: -0.25rem;top: -0.5rem;"></label>
                        <label :for="runningData.id" v-else></label>
                      </p>
                    </th>
                    <td v-for="(cols,index) in columns"> 
                        
                        <span v-if="cols.type == 'amount'" style="float: right; margin-right: 50px;">
                            <a v-if="cols.link && !use_modal" :href="route + '/' + runningData.id + '/edit'" style="font-weight: 600;">
                                {{ numberFormat(runningData[cols.field]) }}
                            </a>
                            <a href="javascript:void(0);" @click="show(runningData)" v-if="cols.link && use_modal" style="font-weight: 600;">
                                {{ numberFormat(runningData[cols.field]) }}
                            </a>
                            <span v-if="!cols.link">
                                {{ numberFormat(runningData[cols.field]) }}
                            </span>
                        </span>
                        
                        <span v-if="cols.type == 'text'">
                            <a v-if="cols.link && !use_modal" :href="route + '/' + runningData.id + '/edit'" style="font-weight: 600;">
                                {{ runningData[cols.field] }}
                            </a>
                            <a href="javascript:void(0);" @click="show(runningData)" v-if="cols.link && use_modal" style="font-weight: 600;">
                                {{ runningData[cols.field] }}
                            </a>
                            <span v-if="!cols.link">
                                {{ runningData[cols.field] }}
                            </span>
                        </span>
                        
                        <span v-if="cols.type == 'date'">
                            <a v-if="cols.link && !use_modal" :href="route + '/' + runningData.id + '/edit'" style="font-weight: 600;">
                                {{ dateFormat(runningData[cols.field]) }}
                            </a>
                            <a href="javascript:void(0);" @click="show(runningData)" v-if="cols.link && use_modal" style="font-weight: 600;">
                                {{ dateFormat(runningData[cols.field]) }}
                            </a>
                            <span v-if="!cols.link">
                                {{ dateFormat(runningData[cols.field]) }}
                            </span>
                        </span>

                        <span v-if="cols.type == 'link'">
                            <a :href="runningData[cols.field]['url']"  target="_blank">{{ runningData[cols.field]['text'] }}</a>
                        </span>

                    </td>
                    <td v-if="show_state">
                      <h5 :style="'background: ' + runningData.state.color + '; text-align: center; border-radius: 9px; padding: 3px 0px; width: 120px; font-size: medium;'"> {{ runningData.state.name }}</h5>
                    </td>
                    <td v-if="show_status">
                      <button :class="runningData.active == 'on'? 'btn success-bg': 'btn error-bg'"
                        @click="switchStatus(runningData)">
                        {{runningData.active == 'on' ? 'Activo' : 'Inactivo'}}
                      </button>
                    </td>
                    <td v-if="show_actions && !disable">
                      <div class="btn-group" role="group" aria-label="...">
                        <a v-for="action in actions" type="button" class="btn btn-floating btn-flat" :href="route + '/' + runningData.id + '/' + action.action">
                          <i class="material-icons" :style="'color: ' + action.color + ' !important;'">{{ action.icon }}</i>
                        </a>
                        <a type="button" class="btn btn-floating btn-flat" :href="route + '/' + runningData.id + '/edit'" v-if="show_edit && !use_modal">
                          <i class="material-icons warning-text">mode_edit</i>
                        </a>
                        <button type="button" class="btn btn-floating btn-flat" @click="show(runningData)" v-if="show_edit && use_modal">
                            <i class="material-icons warning-text">mode_edit</i>
                        </button>
                        <button type="button" class="bt btn-floating btn-flat" @click="removeConfirm(runningData)" v-if="show_delete && (!show_state || runningData.state.key == 'pending')">
                          <i class="material-icons error-text">delete</i>
                        </button>
                      </div>
                    </td>
                  </tr>

                  <tr>

                    <th v-if="show_multi_actions && delete_multiple">
                    </th>
                    <td v-for="(cols,index) in columns"> 
                        <span v-if="cols.total" style="float: right; margin-right: 50px;">
                          <strong style="font-size: 18px;"> {{ numberFormat(totals[cols.field]) }} </strong>
                        </span>
                    </td>
                    <td v-if="show_state">
                      
                    </td>
                    <td v-if="show_status">
                    </td>
                    <td v-if="show_actions && !disable">
                    </td>
                  
                  </tr>

                </tbody>
              </table>
            </div>
          </div>
          <!-- PAGINATION -->
          <div class="row" v-if="componentData.length && paginate">
            <div class="s12 col">
              <ul class="pagination pagination-sm no-margin pull-right">
                <li v-show="pagination.total_pages > 0 && pagination.current_page != 1">
                  <a href="javascript:void(0);" aria-label="Previous" @click="all(1)">
                    <i class="material-icons">first_page</i>
                  </a>
                </li>
                <!-- PREVIOUS PAGE -->
                <li>
                  <a href="javascript:void(0);" aria-label="Previous" @click="prevPage()"><i class="material-icons">chevron_left</i></a>
                </li>

                <li v-for="n in pagination.total_pages"
                  :class="{'active':pagination.current_page==n}"
                  v-show="n >= pagination.current_page && n <= paginationList">
                  <a href="javascript:void(0);" @click="all(n)">{{ n }}</a>
                </li>
                <li>
                  <a href="javascript:void(0);" @click="nextPage()">
                    <i class="material-icons">chevron_right</i>
                  </a>
                </li>
                <li v-show="pagination.total_pages > 0 && pagination.total_pages != pagination.current_page">
                  <a href="javascript:void(0);" aria-label="Previous" @click="all(pagination.total_pages)">
                    <i class="material-icons">last_page</i>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Structure -->
      <div id="componentDataModal" class="modal modal-fixed-footer large" v-if="use_modal">
        <div class="modal-content">
          <div class="col s12">
            <h5>{{modalAction | capitalize}} Producto</h5>
          </div>
          <form @submit.prevent="isNotValidateForm" name="callback" class="col s12" style="margin-top: 10px;">
              <div class="input-field col s12" v-for="field in modal.fields" :style="field.type == 'select' || 'amount' ? 'margin-bottom: 10px;' : 'margin-bottom: 0px;'">

                <!-- selects -->
                  <label v-if="field.type == 'select'" :for="'modal-'+field.id" style="top: -22px; font-size: 0.8rem;">{{ field.label }}</label>
                  <select v-if="field.type == 'select'" class="select2_select" :id="'modal-'+field.id" :name="field.name" v-model="modal.object[field.name]" :required="field.required">
                      <option value="" disabled=>Seleccione...</option>
                      <option value="0" v-if="field.none">Ninguno</option>
                      <option :value="item[field.id_key]" v-for="item in dependencies[field.items]">{{ item[field.value_key] }}</option>
                  </select>
                  <!-- selects -->
                  
                  <!-- texts inputs -->
                  <input v-if="field.type == 'text'" type="text" :name="field.name" :id="'modal-'+field.id" v-model="modal.object[field.name]" :required="field.required">
                  <label v-if="field.type == 'text'" :for="'modal-'+field.id">{{ field.label }}</label>
                  <!-- texts inputs -->

                   <!-- amounts inputs -->
                  <input v-if="field.type == 'amount'" class="custom-numberbox" :id="'modal-'+field.id" :name="field.name" :value="modal.object[field.name]" style="width:509px;" :required="field.required">
                  <!-- <NumberBox v-if="field.type == 'amount'" :inputId="'modal-'+field.id" :name="field.name" v-model="modal.object[field.name]" :precision="2" :spinners="false" :groupSeparator="amount.groupSeparator" :decimalSeparator="amount.decimalSeparator" style="width:100%;"></NumberBox> -->
                  <label v-if="field.type == 'amount'" :for="'modal-'+field.id" style="margin-left: 0; margin-top: -13px;">{{ field.label }}</label>
                  <!-- texts inputs -->

                  <!-- checks -->
                  <input v-if="field.type == 'check'" type="checkbox" checked="checked" :id="'modal-'+field.id" :name="field.name" v-model="modal.object[field.name]" :required="field.required"/>
                  <label v-if="field.type == 'check'" :for="'modal-'+field.id">{{ field.label }}</label>
                  <!-- checks -->

              </div>

              <div class="input-field col s12" v-show="show_advanced">
                <a href="javascript:void(0);" @click="switchAdvancedOptions()">
                    {{ more_options }}
                </a>
              </div>

              <div v-show="show_advanced_options" class="input-field col s12 advanced-modal-options" v-for="field in modal.advanced_fields" :style="field.type == 'select' || 'amount' || 'ckeck' ? 'margin-bottom: 30px;' : 'margin-bottom: 0px;'">

                  <!-- selects -->
                  <label v-if="field.type == 'select'" :for="'modal-'+field.id" style="top: -22px; font-size: 0.8rem;">{{ field.label }}</label>
                  <select v-if="field.type == 'select'" class="select2_select" :id="'modal-'+field.id" :name="field.name" v-model="modal.object[field.name]" :required="field.required">
                      <option value="" disabled=>Seleccione...</option>
                      <option value="0" v-if="field.none">Ninguno</option>
                      <option :value="item[field.id_key]" v-for="item in dependencies[field.items]">{{ item[field.value_key] }}</option>
                  </select>
                  <!-- selects -->

                  <!-- texts inputs -->
                  <input v-if="field.type == 'text'" type="text" :name="field.name" :id="'modal-'+field.id" v-model="modal.object[field.name]" :required="field.required">
                  <label v-if="field.type == 'text'" :for="'modal-'+field.id">{{ field.label }}</label>
                  <!-- texts inputs -->

                  <!-- amounts inputs -->
                  <input v-if="field.type == 'amount'" class="custom-numberbox" :id="'modal-'+field.id" :name="field.name" :value="modal.object[field.name]" style="width:509px;" :required="field.required">
                  <!-- <NumberBox v-if="field.type == 'amount'" :inputId="'modal-'+field.id" :name="field.name" v-model="modal.object[field.name]" :precision="2" :spinners="false" :groupSeparator="amount.groupSeparator" :decimalSeparator="amount.decimalSeparator" style="width:100%;"></NumberBox> -->
                  <label v-if="field.type == 'amount'" :for="'modal-'+field.id" style="margin-left: 0; margin-top: -13px;">{{ field.label }}</label>
                  <!-- amounts inputs -->

                  <!-- checks -->
                  <input v-if="field.type == 'check'" type="checkbox" checked="checked" :id="'modal-'+field.id" :name="field.name" v-model="modal.object[field.name]" :required="field.required"/>
                  <label v-if="field.type == 'check'" :for="'modal-'+field.id">{{ field.label }}</label>
                  <!-- checks -->

              </div>
              
              <!--
              <div class="input-field col s12" style="margin-bottom: 15px; margin-top: 25px;">
                <input class="custom-numberbox" id="numero" name="numero" value="98123.26" style="width:100%;">
                <label for="numero" style="margin-left: 0; margin-top: -13px;">Numero</label>
              </div>
              -->
          </form>
      </div>
      <div class="modal-footer">
          <a href="javascript:void(0);" class="modal-action modal-close waves-effect waves-green btn-flat">Cerrar</a>
          <a href="javascript:void(0);" class="btn-flat" :disabled="isNotValidateForm" @click="update()" v-if="pupupMod=='edit'">Editar</a>
          <a href="javascript:void(0);" class="btn-flat" :disabled="isNotValidateForm" @click="store()" v-else>Agregar</a>
        </div>
      </div>
    </div>
</template>
<script>

$(document).ready(function() {

    $('.custom-numberbox').numberbox({
        min:0,
        precision:2,
        decimalSeparator:',',
        groupSeparator:'.'
    });

})
  
import { tableData } from '../../mixins/tableMixin';
import FunctionHelper from '../../helpers/FunctionHelper.js';
//import moment from 'moment';

let funcHelp = new FunctionHelper;

export default {
    mixins: [tableData],
    props: ['config'],
    data() {
        return {
            pupupMod: 'add',
            modalAction: '',
            showAdd: this.config.show_add,
            show_edit: this.config.show_edit,
            show_delete: this.config.show_delete,
            // Component
            columns: this.config.fields,
            actions: this.config.actions,
            escapeSort: ['action'],
            sortOrder: { field: 'created_at', order: 'desc' },
            showpages: 10,
            route: this.config.route,
            title: this.config.title,
            show_status: this.config.show_status,
            use_modal: this.config.use_modal,
            show_search: this.config.show_search,
            filter: this.config.filter,
            empty_list: this.config.empty_list,
            show_messages: this.config.show_messages,
            delete_multiple: this.config.delete_multiple,
            disable: this.config.disable,
            paginate: this.config.paginate,
            show_state: this.config.show_state,
            runningData: null,
            dependencies: [],
            modal: this.config.modal,
            show_actions: this.config.show_actions,
            show_multi_actions: this.config.show_multi_actions,
            show_filters: false,
            reloadOnSave: this.config.reload_on_save,
            show_advanced_options: false,
            show_advanced: this.config.show_advanced,
            show_total: this.config.show_total,
            more_options: this.config.more_options,
            amount: {
              decimalSeparator: ",",
              groupSeparator: ".",
              prefix: "",
              suffix: ""
            }
        };
    },
    computed: {
        fieldList: function () {
            let list = '(';
            this.columns.forEach(function (value, key) {
                if (key != 0) {
                    list = list + ','
                }
                list = list + value.field;
            });
            return list + ')';
        },
        isNotValidateForm() {
            /*
            if (this.modal.object.name == "" ||
                this.modal.object.email == '' ||
                this.modal.object.designation == '' ||
                funcHelp.validateEmail(this.modal.object.email) == false) {
                return true;
            }
            */
            return false;
        }
    },
    mounted() {
        this.all();
        
        //this.showAdd = true;
        let vm = this;

        if (vm.use_modal) {
            
            $('#componentDataModal').modal({
              dismissible: false,
              ready: function(modal, trigger) {
                  // Callback for Modal open. Modal and trigger parameters available.
              },
              complete: function() { vm.resetSingleObj(); } // Callback for Modal close

            });
          
            if (vm.modal.fields.length > 0) {

                vm.modal.fields.forEach(function(item, index) {

                  if (item.type == 'select') {

                    $('#modal-'+ item.id).on('select2:select', function() {
                        let $this = $(this);
                        let myValueIs = $this.val();
                        vm.modal.object[item.name] = myValueIs;
                    });

                    axios.get(item.endpoint + '?paginate=off').then((response) => {
                          let res = response.data;
                          if (res.status_code == 200) {
                              vm.dependencies[item.items] = res.data;
                          }
                      })
                      .catch((error) => { console.log('Error cargando ' + item.items + ' - ' + error) });
                  }
                });
            };

            if (vm.modal.advanced_fields.length > 0) {

                vm.modal.advanced_fields.forEach(function(item, index) {

                  if (item.type == 'select') {

                    $('#modal-'+ item.id).on('select2:select', function() {
                        let $this = $(this);
                        let myValueIs = $this.val();
                        vm.modal.object[item.name] = myValueIs;
                    });

                    axios.get(item.endpoint + '?paginate=off').then((response) => {
                          let res = response.data;
                          if (res.status_code == 200) {
                              vm.dependencies[item.items] = res.data;
                          }
                      })
                      .catch((error) => { console.log('Error cargando ' + item.items + ' - ' + error) });
                  }
                });
            };

          //this.loadDependencies();
        }
    },
    updated() {
          
          let vm = this;

          var next = $('.custom-numberbox').next();
          var blur = $(next).children('.textbox-text');

          $(blur).blur(function() {
              let elem = $(this).next();
              var nameAttr = elem.attr('name');
              //console.log(nameAttr);
              vm.modal.object[nameAttr] = elem.val();
              //console.log(elem.val());
          });

    },
    methods: {
        resetSingleObj() {
            this.modal.object = {};
            this.showLoader = false;

        },
        all(page = 1) {
            this.resetAlert();
            if (!this.empty_list) {
              let suffix = this.filter ? `/${this.filter}/detail` : '';
              let uri = `${this.route}${suffix}?page=${page}&sort=${this.sortOrder.field}&order=${this.sortOrder.order}&fields=${this.fieldList}`;
              axios.get(uri).then((response) => {
                      let res = response.data;
                      if (res.status_code == 200) {
                          this.componentData = res.data;
                          this.pagination = res.paginator;
                          this.totals = res.totals;
                      }
                  })
                  .catch(error => { 
                    //this.alertHandler('info', `No hay registros aún`, true);
                    this.componentData = [];
                  });
            }
        },
        show(obj) {
            
            if (this.disable) {
                return false;
            }

            this.modal.object = obj;
            this.pupupMod = 'edit';
            this.modalAction = 'Editar';
            this.resetAlert(this.modal.object);
            //console.log(this.modal.object);
            this.modal.fields.forEach((item, index) => {

                if (item.type == 'select') {
                    if (obj[item.name] != '') {
                        var id = obj[item.name];
                        $('#modal-'+ item.id).val(id);
                        $('#modal-'+ item.id).select2().trigger('change');
                    }
                }

                if (item.type == 'amount') {
                    var input = $('#modal-' + item.id);
                    if ( typeof this.modal.object[item.name] !== 'undefined' &&
                      this.modal.object[item.name] !== null &&
                      this.modal.object[item.name] != '') {
                      $(input).numberbox('setValue', this.modal.object[item.name]);
                      $(input).next().next().addClass('active');
                    }                     
                }

            });

            this.modal.advanced_fields.forEach((item, index) => {

                if (item.type == 'select') {
                    if (obj[item.name] != '') {
                        var id = obj[item.name];
                        $('#modal-'+ item.id).val(id);
                        $('#modal-'+ item.id).select2().trigger('change');
                    }
                }

                if (item.type == 'amount') {
                    var input = $('#modal-' + item.id);
                    if ( typeof this.modal.object[item.name] !== 'undefined' &&
                      this.modal.object[item.name] !== null &&
                      this.modal.object[item.name] != '') {
                      $(input).numberbox('setValue', this.modal.object[item.name]);
                      $(input).next().next().addClass('active');
                    }                     
                }

            });

            //$('#componentDataModal').modal('open');
            setTimeout(() => {$('#componentDataModal').modal('open')}, 250);
        },
        update() {
            if (this.filter) {
              let suffix = `${this.filter}/detail/`;
              let uri = `${this.route}/${suffix}${this.modal.object.id}`;
              axios.put(uri, this.modal.object).then((response) => {
                    let res = response.data;
                    if (res.status_code == 200) {
                        // Handling alert
                        this.alertHandler('success', res.message, true);
                    } else {
                        this.alertHandler('error', res.message, true);
                    }
                    $('#componentDataModal').modal('close');

                    if (this.reloadOnSave) {
                      location.reload();
                    }
                })
                .catch((error) => {
                    this.alertHandler('error', error.data, true);
                    console.log(error.data) 
                });
            }

            if (!this.filter) {
              $('#componentDataModal').modal('close');
            }
        },
        create(event) {
            
            this.resetSingleObj();
            this.resetAlert();
            this.pupupMod = 'add';
            this.modalAction = 'Agregar';
            
            this.modal.fields.forEach((item, index) => {

                if (item.type == 'select') {
                    $('#modal-'+ item.id).val(0);
                    $('#modal-'+ item.id).select2().trigger('change');
                }

                if (item.type == 'amount') {
                    var input = $('#modal-' + item.id);
                    $(input).numberbox('setValue', '');
                    $(input).next().next().removeClass('active');
                }

            });

            this.modal.advanced_fields.forEach((item, index) => {

                if (item.type == 'select') {
                    $('#modal-'+ item.id).val(0);
                    $('#modal-'+ item.id).select2().trigger('change');
                }

                if (item.type == 'amount') {
                    var input = $('#modal-' + item.id);
                    $(input).numberbox('setValue', '');
                    $(input).next().next().removeClass('active');
                }

            });

            $('#componentDataModal').modal('open');
        },
        store() {
            this.showLoader = true;
            
            if (this.filter) {
              let suffix = `${this.filter}/detail`;
              let uri = `${this.route}/${suffix}`;
              //console.log(this.modal.object)
              axios.post(uri, this.modal.object).then((response) => {
                      let res = response.data;
                      if (res.status_code == 201) {
                          this.resetSingleObj(); // reset store input form
                          this.all(); // fetch updated list
                          $('#componentDataModal').modal('close'); // Hide modal
                          // Handling alert
                          this.alertHandler('success', res.message, true);

                      } else {
                          this.alertHandler('error', res.message, true);
                      }
                      this.showLoader = false;

                      this.componentData.push(this.modal.object);

                      if (this.reloadOnSave) {
                        location.reload();
                      }
                  })
                  .catch((error) => { 
                    this.alertHandler('error', error.data, true);
                    console.log(error.data) 
                  });
              
            }

            if (!this.filter) {
              $('#componentDataModal').modal('close'); // Hide modal
            }
            
        },
        remove(obj) {
            this.resetAlert();
            var index = this.componentData.indexOf(obj);
            if (!this.empty_list) {
              let suffix = this.filter ? `${this.filter}/detail/` : '';
              let uri = `${this.route}/${suffix}${obj.id}`;
              axios.delete(uri).then((response) => {
                      let res = response.data;
                      if (res.status_code == 200) {
                          // Handling alert
                          this.alertHandler('success', res.message, true);
                      } else {
                          this.alertHandler('error', res.message, true);
                      }
                      
                      this.componentData.splice(index, 1);

                      if (this.reloadOnSave) {
                        location.reload();
                      }
                  })
                  .catch((error) => { 
                      this.alertHandler('error', error.data, true);
                      console.log(error.data) 
                   });
            }
        },
        removeMultiple() {
            this.resetAlert();
            let suffix = this.filter ? `${this.filter}/detail/` : '';
            let uri = `${this.route}/${suffix}removeBulk`;
            if (this.multiSelection.length) {
                axios.post(uri, this.multiSelection).then((response) => {
                        let res = response.data;
                        if (res.status_code == 200) {
                            // Handling alert
                            this.resetMultiSelection();
                            this.all();
                            this.alertHandler('success', res.message, true);
                        } else {
                            this.alertHandler('error', res.message, true);
                        }
                    })
                    .catch((error) => { console.log(error) });
            }
        },
        switchStatus(obj) {
            this.resetAlert();
            let newStat = (obj.active == 'on') ? 'off' : 'on';
            let uri = `${this.route}/status`;
            axios.put(uri, obj).then((response) => {
                    let res = response.data;
                    if (res.status_code == 200) {
                        // Handling alert
                        obj.active = newStat;
                        this.alertHandler('success', res.message, true);
                    }
                })
                .catch((error) => {});
        },
        switchStatusSelected() {
            this.resetAlert();
            let uri = `${this.route}/statusBulk`;
            axios.put(uri, this.multiSelection).then((response) => {
                    let res = response.data;
                    if (res.status_code == 200) {
                        this.all();
                        this.resetMultiSelection();
                        // Handling alert
                        this.alertHandler('success', res.message, true);
                    }
                })
                .catch((error) => {});
        },
        searchInput() {
            let searchQuery = this.searchQuery;
            let uri = `${this.route}?searchQuery=${searchQuery}&sort=${this.sortOrder.field}&order=${this.sortOrder.order}`;
            axios.get(uri).then((response) => {
                    let res = response.data;
                    if (res.status_code == 200) {
                        this.componentData = res.data;
                        this.pagination = res.paginator;
                    }
                })
                .catch((error) => { console.log(error) });
        },
        loadDependencies() {

        },
        numberFormat(num, decimal_point = ',', thousands_sep = '.') {

            if ( typeof num === 'undefined' || num === null ) {
                return '0' + decimal_point + '00';
            }
           
            var strArray = num.toString().split(".");

            var unit = strArray[0].replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1' + thousands_sep);

            if (strArray.length === 1) {
                return unit + decimal_point + '00';
            }

            if (strArray[1].length < 2) {
                return unit + decimal_point + strArray[1] + '0';
            }

            return unit + decimal_point + strArray[1];
        },
        dateFormat(date) {
            var dateToChange = new Date(date);
            var month = dateToChange .getMonth() + 1;
            if (month.toString().length < 2) {
                month = '0' + month;
            }
            var day = dateToChange .getDate();
            if (day.toString().length < 2) {
                day = '0' + day;
            }
            var year = dateToChange .getFullYear();
            return day + "/" + month + "/" + year;
        },
        switchAdvancedOptions() {
            if (this.show_advanced_options) {
              this.show_advanced_options = false;
              $('.advanced-modal-options').hide(500);
            } else {
              this.show_advanced_options = true;
              $('.advanced-modal-options').show(500);
            }
        }

    }
}
</script>
