jQuery(window).scroll(startCounter);

function startCounter() {
    var hT = jQuery('.counter').offset().top,
        hH = jQuery('.counter').outerHeight(),
        wH = jQuery(window).height();
    if (jQuery(window).scrollTop() > hT + hH - wH) {
        jQuery(window).off("scroll", startCounter);
        jQuery('.count').each(function() {
            var $this = jQuery(this);
            jQuery({ Counter: 0 }).animate({ Counter: $this.text() }, {
                duration: 2000,
                easing: 'swing',
                step: function() {
                    $this.text(Math.ceil(this.Counter) + '+');
                }
            });
        });
    }
}