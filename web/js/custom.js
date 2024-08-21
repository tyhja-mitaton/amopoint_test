$(function () {
    $('select[name="type_val"]').on('change', function() {
        let value = $(this).val();
        switchFields(value);
    });
    switchFields($('select[name="type_val"]').val());
});
function switchFields(value) {
    $('input[type="text"]:not([name="input_' + value + '"])').hide();
    $('input[type="text"]:not([name="input_' + value + '"])').closest('p').hide();
    $('input[type="text"][name="input_' + value + '"]').show();
    $('input[type="text"][name="input_' + value + '"]').closest('p').show();
}