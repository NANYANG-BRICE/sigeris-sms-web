import '@/plugins/vue-composition-api'
import '@/styles/styles.scss'
import Vue from 'vue'
import App from './App.vue'
import vuetify from './plugins/vuetify'
import router from './router'
import store from './store'



/* module Axios pour interaction via API */
import axios from 'axios'
axios.defaults.baseURL = 'http://localhost:8080/';



// SweetAlert2 pour les notifications et alertes sur actions
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';



/* Datatable pour affichage des données dans un tableau dynamique*/
import DataTable from "@andresouzaabreu/vue-data-table";
import "@andresouzaabreu/vue-data-table/dist/DataTable.css";
Vue.component("data-table", DataTable);



import 'material-design-icons-iconfont/dist/material-design-icons.css'







Vue.config.productionTip = false

new Vue({
  router,
  store,
  vuetify,
  render: h => h(App),
}).$mount('#app')
