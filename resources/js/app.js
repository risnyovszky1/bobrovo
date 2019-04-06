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
require('./bootstrap-datetimepicker');
require('./bootstrap-datetimepicker.sk');

$(document).ready(function(){
  // settings
  $.ajaxSetup({
    beforeSend: function(xhr, type) {
        if (!type.crossDomain) {
            xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
        }
    },
  });

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
  $('textarea#news-text-editor, textarea#faq-content-input, textarea.wyswyg-editor').froalaEditor({
    toolbarButtons: ['paragraphFormat', '|', 'fontSize', '|', 'bold', 'italic', 'underline', '|', 'codeView'],
    fontSizeSelection: true,
    paragraphFormatSelection: true,
    toolbarSticky: false,
    heightMin: 150,
    imageMove:true,
    codeMirror:true,
    imageUploadParam: 'image_param',
    imageUploadParams: {
      froala: true,
      _token: $('meta[name="csrf-token"]').attr('content'),
    },
    imageUploadURL: '/upload-img',
    imageAllowedTypes: ['jpeg', 'jpg', 'png', 'gif'],
    imageMaxSize: 2 * 1024 * 1024,
  })
  .on('froalaEditor.image.beforeUpload', function (e, editor, images) {
    // Return false if you want to stop the image upload.
    console.log('before uploaded');
  })
  .on('froalaEditor.image.uploaded', function (e, editor, response) {
    // Image was uploaded to the server.
    console.log('uploaded');
  })
  .on('froalaEditor.image.inserted', function (e, editor, $img, response) {
    // Image was inserted in the editor.
    console.log('inserted to editor');
  })
  .on('froalaEditor.image.replaced', function (e, editor, $img, response) {
    // Image was replaced in the editor.
    console.log('replaced');
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

  $('#unselect-all').click(function(event){
    event.preventDefault();
    var selector = $(this).data('select');
    $('input[name="' + selector +'"]').prop('checked', false);
  });

  $('#generate-random-code').change(function(){
    if ($(this).prop('checked')){
      $('#code-input').prop('disabled', true);
    }
    else{
      $('#code-input').prop('disabled', false); 
    }
  });

  $('#question-type').on('change', function(){
    var val = $(this).val();
    $('.question-possibilities').hide();
    if (val == 4){$('#picture-ans').fadeIn('slow');}
    else if (val == 5){$('#interactive-ans').fadeIn('slow');}
    else{ $('#text-ans').fadeIn('slow');}

  });
  // -- question rating --
  $('.rating-star')
    .mouseenter(function(){
      var index = $(this).index()
      $('.rating-star').each(function(i){
        console.log(index, i);
        if (i < index){
          $(this).removeClass('text-secondary');
          $(this).addClass('text-warning');
        }
        else{
          $(this).addClass('text-warning');
          $(this).removeClass('text-secondary');
        }
      });
    })
    .mouseleave(function(){
      $('.rating-star').each(function(i){
        console.log($(this).data('original'));
        
        if ($(this).data('original') == true){
          $(this).removeClass('text-secondary');
          $(this).addClass('text-warning');
        }
        else{
          $(this).addClass('text-warning');
          $(this).removeClass('text-secondary');
        }
      });
    });

    // -- datetime picker in test

    $('#available_from').datetimepicker({
      format: 'yyyy-mm-dd hh:ii',
      autoclose: true,
      locale: 'sk',
      pickerPosition: "top-right"
    });

    $('#available_to').datetimepicker({
      format: 'yyyy-mm-dd hh:ii',
      autoclose: true,
      locale: 'sk',
      pickerPosition: "top-right"
    });

    
});
