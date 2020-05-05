var countSlide = 0;

$(document).ready (function (){
    $('.slideshow').slick({
        dots: true,
        arrows: false,
        autoplay: true,
        accessibility: false,
        autoplaySpeed: 1000
    });
});
  
$('.slideshow').on('afterChange', function(event, slick, currentSlide){
    if(countSlide == slick.slideCount - 1) {
        $('#modal-container').addClass('out');
        $('body').removeClass('modal-active');  
    }
    countSlide = countSlide + 1;
});

