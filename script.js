jQuery('input.notos-toggle').on('click', function (){
    jQuery('input.notos-toggle').not(this).prop('checked', false);
});
