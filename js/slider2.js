var countSlide = 0;

$(document).ready (function (){
  $('.slideshow').slick({
    dots: false,
    arrows: false,
    autoplay: true,
    accessibility: false,
    autoplaySpeed: 2000,
    slidesToShow: 3,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          arrows: false,
          centerMode: true,
          centerPadding: '40px',
          slidesToShow: 3
        }
      },
      {
        breakpoint: 480,
        settings: {
          arrows: false,
          centerMode: true,
          centerPadding: '40px',
          slidesToShow: 1
        }
      }
    ]
  });
});

$('.slideshow').on('afterChange', function(event, slick, currentSlide){
  if(countSlide == slick.slideCount - 1) {
    $('#modal-container').addClass('out');
    $('body').removeClass('modal-active');  
  }
  countSlide = countSlide + 1;
});