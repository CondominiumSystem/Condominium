
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');




window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/*
Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app'
});
*/
/**
 * Properties index
 * Modal dialog for delete one property
 */
 $('#confirm-delete').on('show.bs.modal', function(e) {
   $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));

   $('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
 });

/*
$('#payments-table').DataTable({
     processing: true,
     serverSide: true,
     ajax: '{!! route("Reports.paymentsData") !!}',
     columns: [
         { data: 'person_name', name: 'persons.name'},
         { data: 'person_type_name', name: 'person_types.name' },
         { data: 'lot_number', name: 'properties.lot_number' },
         { data: 'value', name: 'payments.value'},
         { data: 'year', name: 'periods.year'},
         { data: 'month_name', name:'periods.month_name'},
     ]
 });
*/
