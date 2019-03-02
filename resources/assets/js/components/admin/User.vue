<template>
    <div class="row">
      <div class="s12 col">
        <div v-if="showAlert">
          <alert :type="alertType">{{ alertText }}</alert>
        </div>
      </div>
      <div class="col s12 mr-top-10">
        <div class="card-panel">
          <div class="row box-title">
            <div class="col s12">
              <h5 class="content-headline">{{ title }}</h5>
            </div>
            <div class="col s12 m8">
              <transition name="custom-classes-transition" enter-active-class="animated tada" leave-active-class="animated bounceOutRight">
                <a class="btn btn-default pull-right btn-floating" :href="route + '/create'" v-show="showAdd">
                  <i class="material-icons">add</i>
                </a>
              </transition>
              <button type="button" class="btn error-bg btn-floating tooltipped"
                @click="removeBulkConfirm()" data-position="righht" data-delay="50" data-tooltip="Delete Selected"
                :disabled="multiSelection.length == 0">
                <i class="material-icons">delete</i>
              </button>
              <button v-if="show_status" type="button" class="btn info-bg btn-floating tooltipped"
                @click="switchStatusBulkConfirm()" data-position="righht" data-delay="50" data-tooltip="Change Status"
                :disabled="multiSelection.length == 0">
                <i class="material-icons">compare_arrows</i>
              </button>
            </div>
            <div class="col s12 m4">
              <form class="form-inline" @submit.prevent="searchInput">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-addon"><span class="glyphicon glyphicon-search"></span></div>
                    <input type="text" v-model="searchQuery" class="form-control" id="searchInputUser" placeholder="Search" @keyup.delete="searchChanges">
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
                    <th  class="multiple-cb">
                      <p>
                        <input type="checkbox" value="1" id="toggleAll" @click="toggleAll()" v-model="isAll">
                        <label for="toggleAll"></label>
                      </p>
                    </th>
                    <th v-for="(col,index) in columns" @click="sortBy(col.name)">
                      {{ col.name | capitalize }}
                      <span class="arrow"
                        :class="sortOrder.field == col.name ? sortOrder.order : 'asc'"
                        v-if="escapeSort.indexOf(col.name) < 0"></span>
                    </th>
                    <th v-if="show_status" @click="sortBy('status')">
                      Estatus
                      <span class="arrow"
                            :class="sortOrder.field == 'status' ? sortOrder.order : 'asc'"
                            v-if="escapeSort.indexOf('status') < 0"></span>
                    </th>
                    <th>
                      Acciones
                    </th>
                  </tr>
                </thead>
                <tbody  v-if="componentData.length">
                  <tr v-for="runningData in componentData">
                    <th class="multiple-cb">
                      <p>
                        <input type="checkbox" :value="runningData.id" :id="runningData.id" v-model="multiSelection">
                        <label :for="runningData.id"></label>
                      </p>
                    </th>
                    <td v-for="(cols,index) in columns" v-text="runningData[cols.field]"></td>
                    <td v-if="show_status">
                      <button :class="runningData.status == 'active'? 'btn success-bg': 'btn error-bg'"
                        @click="switchStatus(runningData)">
                        {{runningData.status | capitalize}}
                      </button>
                    </td>
                    <td>
                      <div class="btn-group" role="group" aria-label="...">
                        <a type="button" class="btn btn-floating btn-flat" :href="route + '/' + runningData.id + '/edit'">
                          <i class="material-icons warning-text">mode_edit</i>
                        </a>
                        <button type="button" class="bt btn-floating btn-flat" @click="removeConfirm(runningData)">
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
          <div class="row">
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
            show_status: this.config.show_status
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
        }
    },
    mounted() {
        this.test();
        this.all();
        this.showAdd = true;
    },
    methods: {
        all(page = 1) {
            this.resetAlert();
            let uri = `${this.route}?page=${page}&sort=${this.sortOrder.field}&order=${this.sortOrder.order}&fields=${this.fieldList}`;
            axios.get(uri).then((response) => {
                    let res = response.data;
                    if (res.status_code == 200) {
                        this.componentData = res.data;
                        this.pagination = res.paginator;
                    }
                })
                .catch(error => this.alertHandler('info', `No ${this.headline} to list!`, true));
        },
        remove(obj) {
            this.resetAlert();
            var index = this.componentData.indexOf(obj);
            this.componentData.splice(index, 1);
            let uri = `${this.route}/${obj.id}`;
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
        test() {
          console.log('**********************************************************************')
          console.log(this.fieldList)
        }
    }
}
</script>
