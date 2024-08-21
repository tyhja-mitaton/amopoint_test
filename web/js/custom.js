$(function () {
    $('select[name="type_val"]').on('change', function() {
        let value = $(this).val();
        switchFields(value);
    });
    switchFields($('select[name="type_val"]').val());
});
function switchFields(value) {
    $('.site-about input[type="text"]:not([name="input_' + value + '"])').hide();
    $('.site-about input[type="text"]:not([name="input_' + value + '"])').closest('p').hide();
    $('.site-about input[type="text"][name="input_' + value + '"]').show();
    $('.site-about input[type="text"][name="input_' + value + '"]').closest('p').show();
}