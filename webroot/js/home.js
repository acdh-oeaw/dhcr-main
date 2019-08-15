

$(document).ready( function() {
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
});
