<template>
    <div class="row">
      <div class="s12 col">
        <div v-if="showAlert && show_messages">
          <alert :type="alertType">{{ alertText }} </alert>
        </div>
      </div>
      <div class="col s12 mr-top-10">
        <div class="card-panel">
          <div class="row box-title">
            <div class="col s12">
              <h5 class="content-headline">{{ title }}</h5>
            </div>
            <div class="col s12 m8" v-if="!disable">
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
                :disabled="multiSelection.length == 0" v-if="delete_multiple">
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
          </div>
          <div class="row">
            <div class="col s12">
              <table class="responsive-table bordered">
                <thead>
                  <tr>
                    <th  class="multiple-cb" v-if="delete_multiple">
                      <p>
                        <input type="checkbox" value="1" id="toggleAll" @click="toggleAll()" v-model="isAll">
                        <label for="toggleAll" v-if="use_modal" style="left: -0.25rem;top: -0.5rem;"></label>
                        <label for="toggleAll" v-else></label>
                      </p>
                    </th>
                    <th v-for="(col,index) in columns" @click="sortBy(col.name)">
                      {{ col.name | capitalize }}
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
                    <th v-if="show_status" @click="sortBy('status')">
                      Estatus
                      <span class="arrow"
                            :class="sortOrder.field == 'status' ? sortOrder.order : 'asc'"
                            v-if="escapeSort.indexOf('status') < 0"></span>
                    </th>
                    <th v-if="!disable">
                      Acciones
                    </th>
                  </tr>
                </thead>
                <tbody  v-if="componentData.length">
                  <tr v-for="runningData in componentData">
                    <th class="multiple-cb" v-if="delete_multiple">

                      <p>
                        <input type="checkbox" :value="runningData.id" :id="runningData.id" v-model="multiSelection">
                        <label :for="runningData.id" v-if="use_modal" style="left: -0.25rem;top: -0.5rem;"></label>
                        <label :for="runningData.id" v-else></label>
                      </p>
                    </th>
                    <td v-for="(cols,index) in columns" v-text="runningData[cols.field]"></td>
                    <td v-if="show_state">
                      <h5 :style="'background: ' + runningData.state.color + '; text-align: center; border-radius: 9px; padding: 3px 0px; width: 120px; font-size: medium;'"> {{ runningData.state.name }}</h5>
                    </td>
                    <td v-if="show_status">
                      <button :class="runningData.status == 'active'? 'btn success-bg': 'btn error-bg'"
                        @click="switchStatus(runningData)">
                        {{runningData.status == 'active' ? 'Activo' : 'Inactivo'}}
                      </button>
                    </td>
                    <td v-if="!disable">
                      <div class="btn-group" role="group" aria-label="...">
                        <a type="button" class="btn btn-floating btn-flat" :href="route + '/' + runningData.id + '/edit'" v-if="!use_modal">
                          <i class="material-icons warning-text">mode_edit</i>
                        </a>
                        <button type="button" class="btn btn-floating btn-flat" @click="show(runningData)" v-if="use_modal">
                            <i class="material-icons warning-text">mode_edit</i>
                        </button>
                        <button type="button" class="bt btn-floating btn-flat" @click="removeConfirm(runningData)" v-if="!show_state || runningData.state.key == 'pending'">
                          <i class="material-icons error-text">delete</i>
                        </button>
                      </div>
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
            <h5>{{pupupMod | capitalize}} Producto</h5>
          </div>
          <form @submit.prevent="isNotValidateForm" name="callback" class="col s12" style="margin-top: 10px;">
              <div class="input-field col s12" v-for="field in modal.fields" :style="field.type == 'select' ? 'margin-bottom: 10px;' : 'margin-bottom: 0px;'">
                  <label v-if="field.type == 'select'" :for="'modal-'+field.id" style="top: -22px; font-size: 0.8rem;">{{ field.label }}</label>
                  <select v-if="field.type == 'select'" class="select2_select" :id="'modal-'+field.id" :name="field.name" v-model="modal.object[field.name]">
                      <option value="" disabled=>Seleccione...</option>
                      <option :value="item[field.id_key]" v-for="item in dependencies[field.items]">{{ item[field.value_key] }}</option>
                  </select>
                  <input v-if="field.type == 'text'" type="text" :name="field.name" :id="'modal-'+field.id" v-model="modal.object[field.name]">
                  <label v-if="field.type != 'select'" :for="'modal-'+field.id">{{ field.label }}</label>
              </div>
              <div class="input-field col s12" style="margin-bottom: 15px; margin-top: 25px;">
                <input class="easyui-numberbox" id="numero" name="numero" value="123.26" data-options="label:'',labelPosition:'top',precision:2,groupSeparator:'.',decimalSeparator:',',width:'100%'">
                <label for="numero" style="margin-left: 3rem; margin-top: -13px;">Numero</label>
            </div>
          </form>
      </div>
      <div class="modal-footer">
          <a href="javascript:void(0);" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
          <a href="javascript:void(0);" class="btn-flat" :disabled="isNotValidateForm" @click="update()" v-if="pupupMod=='edit'">Edit</a>
          <a href="javascript:void(0);" class="btn-flat" :disabled="isNotValidateForm" @click="store()" v-else>Add</a>
        </div>
      </div>
    </div>
</template>
<script>
import { tableData } from '../../mixins/tableMixin';
import FunctionHelper from '../../helpers/FunctionHelper.js';

let funcHelp = new FunctionHelper;

export default {
    mixins: [tableData],
    props: ['config'],
    data() {
        return {
            pupupMod: 'add',
            showAdd: false,
            // Component
            columns: this.config.fields,
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
            modal: this.config.modal
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
        
        this.showAdd = true;
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
                        console.log('on change');
                        console.log(myValueIs);
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
                      }
                  })
                  .catch(error => { 
                    this.alertHandler('info', `No hay registros aún`, true);
                    this.componentData = [];
                  });
            }
        },
        show(obj) {
            this.modal.object = obj;
            this.pupupMod = 'edit';
            this.resetAlert();

            this.modal.fields.forEach(function(item, index) {

                if (item.type == 'select') {
                    if (obj[item.name] != '') {
                        var id = parseInt(obj[item.name]);
                        $('#modal-'+ item.id).val(id);
                        $('#modal-'+ item.id).select2().trigger('change');
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
                })
                .catch((error) => {});
            }

            if (!this.filter) {
              $('#componentDataModal').modal('close');
            }
        },
        create(event) {
            this.resetSingleObj();
            this.resetAlert();
            this.pupupMod = 'add';            
            $('#componentDataModal').modal('open');
        },
        store() {
            this.showLoader = true;
            this.componentData.push(this.modal.object);
            if (this.filter) {
              let suffix = `${this.filter}/detail`;
              let uri = `${this.route}/${suffix}`;
              console.log(this.modal.object)
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
                  })
                  .catch((error) => { console.log(error) });
              
            }

            if (!this.filter) {
              $('#componentDataModal').modal('close'); // Hide modal
            }
            
        },
        remove(obj) {
            this.resetAlert();
            var index = this.componentData.indexOf(obj);
            this.componentData.splice(index, 1);
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
                  })
                  .catch((error) => { console.log(error) });
            }
        },
        removeMultiple() {
            this.resetAlert();
            let uri = `${this.route}/removeBulk`;
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
            let newStat = (obj.status == 'active') ? 'inactive' : 'active';
            let uri = `${this.route}/status`;
            axios.put(uri, obj).then((response) => {
                    let res = response.data;
                    if (res.status_code == 200) {
                        // Handling alert
                        obj.status = newStat;
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
        }
    }
}
</script>
