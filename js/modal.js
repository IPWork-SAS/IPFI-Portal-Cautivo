jQuery(document).ready(function($){  
    window.onload = function (){  
      $('#modal-container').removeAttr('class').addClass("one");
      $('body').addClass('modal-active');
    }
});
  
$('.button').click(function(){
    var buttonId = $(this).attr('id');
    $('#modal-container').removeAttr('class').addClass(buttonId);
    $('body').addClass('modal-active');
})
    
  