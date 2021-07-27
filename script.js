jQuery('input.notos-toggle').on('click', function () {
    jQuery('input.notos-toggle').not(this).prop('checked', false);
});

/**
 * Mobile menu open handling
 */
jQuery(function () {
    const $tabs = jQuery('nav.notos ul.navtabs');
    $tabs.on('click', '.primary .opener', function (event) {
        $tabs.find('li').removeClass('active');
        jQuery(this).parent().addClass('active').next('.secondary').addClass('active');
        event.stopPropagation();
        event.preventDefault();
    });
});
