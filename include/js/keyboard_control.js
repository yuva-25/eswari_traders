var number_regex = /^\d+$/;
var price_regex = /^(\d*\.)?\d+$/;
var percentage_regex = /^(?:\d{1,2}(?:\.\d{1,2})?)%?$/;
var letter_regex = /^[a-zA-Z\s ]+$/;
var regex = /^(?=.*[a-zA-Z])[^?!<>$+=`~_|?;^{}]*$/;


function KeyboardControls(obj, type, characters, color) {
    var input = jQuery(obj);
    // Use onkeydown
    if (type == "text") {
        input.on('keypress', function (event) {
            // Get the keycode of the pressed key
            var keyCode = event.keyCode || event.which;

            // Allow: backspace, delete, tab, escape, enter, and arrow keys
            if ([8, 46, 9, 27, 13, 37, 38, 39, 40].indexOf(keyCode) !== -1 ||
                // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
                (keyCode === 65 && (event.ctrlKey || event.metaKey)) ||
                (keyCode === 67 && (event.ctrlKey || event.metaKey)) ||
                (keyCode === 86 && (event.ctrlKey || event.metaKey)) ||
                (keyCode === 88 && (event.ctrlKey || event.metaKey)) ||
                // Allow: home, end, page up, page down
                (keyCode >= 35 && keyCode <= 40)) {
                // Let it happen, don't do anything
                return;
            }

            // Block numeric key codes (0-9 on main keyboard and numpad)
            if ((keyCode >= 48 && keyCode <= 57)) {
                event.preventDefault();
            }
        });
    }
    // Use onfocus
    if (type == "mobile_number") {
        input.on('keypress', function (event) {
            var keyCode = event.keyCode || event.which;

            // Allow: backspace, delete, tab, escape, enter, period, arrow keys
            if ([8, 46, 9, 27, 13, 190].indexOf(keyCode) !== -1 ||
                // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
                (keyCode === 65 && (event.ctrlKey || event.metaKey)) ||
                (keyCode === 67 && (event.ctrlKey || event.metaKey)) ||
                (keyCode === 86 && (event.ctrlKey || event.metaKey)) ||
                (keyCode === 88 && (event.ctrlKey || event.metaKey)) ||
                // Allow: arrow keys
                (keyCode >= 37 && keyCode <= 40)) {
                // Let it happen, don't do anything
                return;
            }

            // Ensure that it is a number and stop the keypress if not
            if ((keyCode < 48 || keyCode > 57)) {
                event.preventDefault();
            }
        });

        input.on("input", function (event) {
            var str_len = input.val().length;
            if (str_len > 10) {
                input.val(input.val().substring(0, 10));
            }
        });
        input.on('keypress', function (event) {
            if (event.keyCode === 32) {
                event.preventDefault();
            }
        });
    }
    // Use onfocus
    if (type == "email" || type == "password") {
        input.on('keypress', function (event) {
            if (event.keyCode === 32) {
                event.preventDefault();
            }
        });
    }
    // Use onfocus
    if (type == "number") {
        input.on('keypress', function (event) {
            var keyCode = event.keyCode || event.which;

            // Allow: backspace, delete, tab, escape, enter, period, arrow keys
            if ([8, 46, 9, 27, 13, 190].indexOf(keyCode) !== -1 ||
                // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
                (keyCode === 65 && (event.ctrlKey || event.metaKey)) ||
                (keyCode === 67 && (event.ctrlKey || event.metaKey)) ||
                (keyCode === 86 && (event.ctrlKey || event.metaKey)) ||
                (keyCode === 88 && (event.ctrlKey || event.metaKey)) ||
                // Allow: arrow keys
                (keyCode >= 37 && keyCode <= 40)) {
                // Let it happen, don't do anything
                return;
            }


            // Ensure that it is a number and stop the keypress if not
            if ((keyCode < 48 || keyCode > 57)) {
                event.preventDefault();
            }
        });

        input.on('keypress', function (event) {
            if (event.keyCode === 32) {
                event.preventDefault();
            }
        });

    }
    // Use onfocus
    if (type == "no_space") {
        input.on('keypress', function (event) {
            if (event.keyCode === 32) {
                event.preventDefault();
            }
        });
    }

    if (number_regex.test(characters) != false) {
        if (characters != "" && characters != 0) {
            input.on("input", function (event) {
                var str_len = input.val().length;
                if (str_len > parseFloat(characters)) {
                    input.val(input.val().substring(0, parseFloat(characters)));
                }
            });
        }
    }
    if (color == '1') {
        InputBoxColor(obj, type);
    }
}

function InputBoxColor(obj, type) {
    if (type == 'select') {
        if (jQuery(obj).closest().find('.select2-selection--single').length > 0) {
            jQuery(obj).closest().find('.select2-selection--single').css('border', '1px solid #aaa');
        }
        if (jQuery(obj).parent().find('.infos').length > 0) {
            jQuery(obj).parent().find('.infos').remove();
        }
        if (jQuery(obj).parent().parent().find('.infos').length > 0) {
            jQuery(obj).parent().parent().find('.infos').remove();
        }
    }
    else if (type == 'input-group') {
        jQuery(obj).css('border', '1px solid #ced4da');
        if (jQuery(obj).parent().find('.infos').length > 0) {
            jQuery(obj).parent().find('.infos').remove();
        }
        if (jQuery(obj).parent().parent().find('.infos').length > 0) {
            jQuery(obj).parent().parent().find('.infos').remove();
        }
        if (jQuery(obj).parent().parent().parent().find('.infos').length > 0) {
            jQuery(obj).parent().parent().parent().find('.infos').remove();
        }
    }
    else {
        jQuery(obj).css('border', '1px solid #ced4da');
        if (jQuery(obj).parent().find('.infos').length > 0) {
            jQuery(obj).parent().find('.infos').remove();
        }
        if (jQuery(obj).parent().parent().find('.infos').length > 0) {
            jQuery(obj).parent().parent().find('.infos').remove();
        }
    }
}























