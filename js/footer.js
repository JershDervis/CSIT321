function autoHeight() {
    var h = $j(document).height() - $j('body').height();
    if (h > 0) {
        $j('#footer').css({
            marginTop: h
        });
    }
}
$j(window).on('load', autoHeight);