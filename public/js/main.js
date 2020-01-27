window.onload = function() {
    // Home Carousel
    // var currentSlide;
    // var rand;
    // $(document).ready(function() {
    // currentSlide = Math.floor((Math.random() * $('.item').length));
    // rand = currentSlide;
    // $('#carousel-example-generic').carousel(currentSlide);
    // $('#carousel-example-generic').fadeIn(1000);
    // setInterval(function(){ 
    //     while(rand == currentSlide){
    //     rand = Math.floor((Math.random() * $('.item').length));
    //     }
    //     currentSlide = rand;
    //     $('#carousel-example-generic').carousel(rand);
    // },5000);
    // });

    $('.carousel').carousel({
        interval: 6000,
        pause: "false"
    });

    var $item = $('.carousel-item');
    var $wHeight = $(window).height();

    $item.height($wHeight);
    $item.addClass('full-screen');

    $('.carousel img').each(function() {
    var $src = $(this).attr('src');
    var $color = $(this).attr('data-color');
    $(this).parent().css({
        'background-image' : 'url(' + $src + ')',
        'background-color' : $color
    });
    $(this).remove();
    });

    $(window).on('resize', function (){
    $wHeight = $(window).height();
    $item.height($wHeight);
    });

    $item.eq(0).addClass('active');

    var $numberofSlides = $('.carousel-item').length;
    var $currentSlide = Math.floor((Math.random() * $numberofSlides));

    $('.carousel-indicators li').each(function(){
    var $slideValue = $(this).attr('data-slide-to');
    if($currentSlide == $slideValue) {
        $(this).addClass('active');
        $item.eq($slideValue).addClass('active');
    } else {
        $(this).removeClass('active');
        $item.eq($slideValue).removeClass('active');
    }
    });

}
