

$(document).ready( function() {
    var scrollable;

    $('.scrollable').each(function(i) {
        scrollable = new Scrollable(this, {trackWidth: 1, trackColor: 'blue'});
    });

    let map = new Map('map');


    // check for viewport width...
    /*$('.slick').slick({
        arrows: false,
    });*/

    /*
    var height = $(window).height();
    var width = $(window).width();
    $.ajax({
        url: '/',
        type: 'post',
        data: { 'width' : width, 'height' : height, 'recordSize' : 'true' },
        success: function(response) {
            $('#container').html(response);
        }
    });
    */
});


