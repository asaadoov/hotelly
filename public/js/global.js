$(document).ready(function () {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
});

$('[type=submit]').on('click', function() {
	var formId = $(this).attr('data-submit');
	$('#' + formId).submit();
});

$("input.datetimepicker-input").on('keydown', function() {
	return false;
});

$('input.datetimepicker-input').bind("cut paste",function(e) {
	e.preventDefault();
});

$('input[data-input="number"]').keyup(function(e) {
    var float = parseFloat($(this).attr('data-float'));

    /* 2 regexp for validating integer and float inputs *****
        > integer_regexp : allow numbers, but do not allow leading zeros
        > float_regexp : allow numbers + only one dot sign (and only in the middle of the string), but do not allow leading zeros in the integer part
    *************************************************************************/
    var integer_regexp = (/[^0-9]|^0+(?!$)/g);
    var float_regexp = (/[^0-9\.]|^\.+(?!$)|^0+(?=[0-9]+)|\.(?=\.|.+\.)/g);

    var regexp = (float % 1 === 0) ? integer_regexp : float_regexp;
    if (regexp.test(this.value)) {
        this.value = this.value.replace(regexp, '');
    }
});