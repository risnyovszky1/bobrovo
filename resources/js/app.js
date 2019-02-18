/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//const app = new Vue({
  //  el: '#app'
//});


require('./jquery.min');

$(document).ready(function(){
  // ---- COUNT-UP EFFECT ----
  $('.count-up .counter span').each(function() {
    var $this = $(this),
        countTo = $this.data('count');
    
    $({ countNum: $this.text()}).animate({
      countNum: countTo
    },
    {
      duration: 8000,
      easing:'linear',
      step: function() {
        $this.text(Math.floor(this.countNum));
      },
      complete: function() {
        $this.text(this.countNum);
        //alert('finished');
      }
    });  
  });

  // ---- WYSWIG EDITOR ----
  $('textarea#news-text-editor').froalaEditor({
    toolbarButtons: ['paragraphFormat', '|', 'fontSize', '|', 'bold', 'italic', 'underline'],
    fontSizeSelection: true,
    paragraphFormatSelection: true
  });
  $('textarea#faq-content-input').froalaEditor({
    toolbarButtons: ['paragraphFormat', '|', 'fontSize', '|', 'bold', 'italic', 'underline'],
    fontSizeSelection: true,
    paragraphFormatSelection: true
  });

  // ---- SELECT2 ----

  $('select#addresses').select2({
    placeholder: "Vyber všetky adresáty",
    allowClear: true,
    maximumInputLength: 10,
    theme: 'bootstrap4',
  });

  $('select#group-select').select2({
    allowClear: true,
    theme: 'bootstrap4',
  });
  $('select#add-to-group').select2({
    theme: 'bootstrap4',
  });

  // --- events and ux

  $('#select-all').click(function(event){
    event.preventDefault();
    var selector = $(this).data('select');
    $('input[name="' + selector +'"]').prop('checked', true);
  });

  $('#generate-random-code').change(function(){
    if ($(this).prop('checked')){
      $('#code-input').prop('disabled', true);
    }
    else{
      $('#code-input').prop('disabled', false); 
    }
  });
});
