function autoHeight() {
    var h = $(document).height() - $('body').height();
    if (h > 0) {
        $('#footer').css({
            marginTop: h
        });
    }
}
$j(window).on('load', autoHeight);