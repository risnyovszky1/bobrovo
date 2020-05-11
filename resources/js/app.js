/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./jquery.min');
require('./bootstrap-datetimepicker');
require('./bootstrap-datetimepicker.sk');
require('./jquery.countdown');
window.Vue = require('vue');

import Tinymce from "./components/Tinymce";

Vue.component('tinymce', Tinymce);


$(document).ready(function(){
    const app = new Vue({
        el: '#app',
        components:{
            Tinymce
        }
    });

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
        if (i <= index){
          $(this).removeClass('text-secondary');
          $(this).addClass('text-warning');
        }
        else{
          $(this).removeClass('text-warning');
          $(this).addClass('text-secondary');
        }
      });
    })
    .mouseleave(function(){
      $('.rating-star').each(function(i){
        if ($(this).data('original') == true){
          $(this).removeClass('text-secondary');
          $(this).addClass('text-warning');
        }
        else{
          $(this).removeClass('text-warning');
          $(this).addClass('text-secondary');
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

    // -- admin menu
    $('#toggle-admin-menu').click(function () {
      $('#admin-menu').slideToggle();
      $('#toggle-admin-menu i').toggleClass('fa-caret-down fa-caret-up')
    });

});
