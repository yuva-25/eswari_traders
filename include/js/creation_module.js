function SnoCalculation() {
    if (jQuery('.sno').length > 0) {
        var row_count = 0;
        row_count = jQuery('.sno').length;
        if (typeof row_count != "undefined" && row_count != null && row_count != 0 && row_count != "") {
            var j = 1;
            var sno = document.getElementsByClassName('sno');
            for (var i = row_count - 1; i >= 0; i--) {
                sno[i].innerHTML = j;
                j = parseInt(j) + 1;
            }
        }
    }
}

var size_regex = /^\d+(\.\d+)?\s*[xX]\s*\d+(\.\d+)?$/;

function addCreationDetails(name) {
    var check_login_session = 1; var all_errors_check = 1; var error = 1; var letters_check = 1;
    // var post_url = "dashboard_changes.php?check_login_session=1";
    // jQuery.ajax({
    //     url: post_url, success: function (check_login_session) {
    // if (check_login_session == 1) {
   
    if (jQuery('.infos').length > 0) {
        jQuery('.infos').each(function () { jQuery(this).remove(); });
    }
    var creation_name = "";
    if (name == 'size') {
        var format = size_regex;
    } else {
        var format = regex;
    }
    var name_variable = "";
    var form_name = name + "_form";




    name_variable = name.toLowerCase();
    name_variable = name_variable.trim();
    name_variable = name_variable.replace("_", " ");
    if (jQuery('input[name="' + name + '_name"]').is(":visible")) {
        if (jQuery('input[name="' + name + '_name"]').length > 0) {
            creation_name = jQuery('input[name="' + name + '_name"]').val();
            creation_name = creation_name.trim();
            creation_name = creation_name.replace('&', "@@@");
            if (typeof creation_name == "undefined" || creation_name == "" || creation_name == 0 || creation_name == null) {
                all_errors_check = 0;
                throwerrormsg(name + '_name', 'input', 'Enter The Name', form_name);
            }
            else if (format.test(creation_name) == false) {
                letters_check = 0;
                if (name == "size") {
                    throwerrormsg(name + '_name', 'input', 'Invalid Size Allow Only 24x20 in this format', form_name);
                } else {
                    throwerrormsg(name + '_name', 'input', 'Invalid Name', form_name);
                }
            }

        }
    }

    var category_description = "";

    if (name == 'category') {
        if ($('textarea[name="category_description"]').length > 0) {
            category_description = $('textarea[name="category_description"]').val();
        }
    }

    if (parseInt(all_errors_check) == 1) {
        if (parseInt(letters_check) == 1) {
            var add = 1;
            if (creation_name != "") {
                if (jQuery('input[name="' + name + '_names[]"]').length > 0) {
                    jQuery('.added_' + name + '_table tbody').find('tr').each(function () {
                        var prev_creation_name = jQuery(this).find('input[name="' + name + '_names[]"]').val().toLowerCase();
                        var current_creation_name = creation_name.toLowerCase();
                        if (prev_creation_name == current_creation_name) {
                            add = 0;
                        }
                    });
                }
            }



            if (add == 1) {
                var count = jQuery('input[name="' + name + '_count"]').val();
                count = parseInt(count) + 1;
                jQuery('input[name="' + name + '_count"]').val(count);

                let data = {
                    [`${name}_row_index`]: count,
                    [`selected_${name}_name`]: creation_name
                };


                if (name.trim() === 'category') {
                    data.category_description = category_description;
                }

                var post_url = name + "_changes.php";
                jQuery.ajax({
                    url: post_url,
                    type: 'POST',
                    data: data,
                    dataType: "json",
                    success: function (result) {
                        if (result != '') {
                            if (jQuery('.added_' + name + '_table tbody').find('tr').length > 0) {
                                jQuery('.added_' + name + '_table tbody').find('tr:first').before(result);
                            }
                            else {
                                jQuery('.added_' + name + '_table tbody').append(result);
                            }

                            if (jQuery('input[name="' + name + '_name"]').length > 0) {
                                jQuery('input[name="' + name + '_name"]').val('').focus();
                            }

                            if (name == "category") {
                                if ($('textarea[name="category_description"]').length > 0) {
                                    $('textarea[name="category_description"]').val("");
                                }
                            }
                        }

                        SnoCalculation();
                    }
                });
            }
            else {
                jQuery('.added_' + name + '_table').before('<div class="infos w-100 text-danger text-center mb-3" style="font-size: 15px;">This ' + name_variable + ' already Exists</div>');
            }

        }
        else {
            jQuery('.added_' + name + '_table').before('<div class="infos text-danger text-center mb-3" style="font-size: 15px;color:red;">Invalid Characters</div>');
        }
    }
    else {
        jQuery('.added_' + name + '_table').before('<div class="infos text-danger text-center mb-3" style="font-size: 15px;">Please check field values</div>');
    }
    // }
    //         else {
    //             window.location.reload();
    //         }
    //     }
    // });
}

function DeleteCreationRow(id_name, row_index) {
    if (jQuery('#' + id_name + '_row' + row_index).length > 0) {
        jQuery('#' + id_name + '_row' + row_index).remove();
    }
    SnoCalculation();
}

function subunitNeed() {
    var checkbox_button = document.getElementById('subunit_need').checked;
    const $select = $('select[name="selected_unit_type"]');
    if (checkbox_button == true) {
        if ($('.subunit_need').length > 0) {
            $('.subunit_need').removeClass("d-none");
        }

        jQuery('#subunit_need').val(1)

    } else {
        if ($('.subunit_need').length > 0) {
            $('.subunit_need').addClass("d-none");
        }

        jQuery('#subunit_need').val(2)

    }
    AddUnitForStock();
}

function stockMaintain() {
    if (jQuery('#stock_maintain').is(':checked')) {
        jQuery('#stock_maintain').val(1);
        jQuery('.opening_stock_table').removeClass('d-none');
    } else {
        jQuery('#stock_maintain').val(2);
        jQuery('.opening_stock_table').addClass('d-none');
    }
}

function NegativeStock() {
    if (jQuery('#negative_stock').is(':checked')) {
        jQuery('#negative_stock').val(1);

    } else {
        jQuery('#negative_stock').val(2);
    }
}

function FindTotalQty() {
    var quantity = jQuery('input[name="selected_quantity"]').val() || 0;
    var content = jQuery('input[name="subunit_contains"]').val() || 1;
    var total_quantity = jQuery('input[name="selected_total_qty"]').val() || 0;
    var unit_type = jQuery('select[name="selected_unit_type"]').val();

    if (unit_type == '2') {
        content = quantity;
        total_quantity = quantity;
    } else {
        total_quantity = Number(content) * Number(quantity);
    }
    jQuery('input[name="selected_quantity"]').val(Number(quantity));
    jQuery('input[name="selected_total_qty"]').val(Number(total_quantity));
}

function AddUnitForStock() {
    var unit_id = jQuery('select[name="unit_id"]').val();
    var subunit_id = jQuery('select[name="subunit_id"]').val();
    var subunit_need = jQuery('#subunit_need').val();
    var listdetials = [];
    var list = {
        unit_id: unit_id,
        subunit_id: subunit_id,
        subunit_need: subunit_need,
    };

    listdetials.push(list);
    var check_login_session = 1;
    post_url = "product_changes.php?unit_select_change=" + JSON.stringify(listdetials);
    jQuery.ajax({
        url: post_url, success: function (result) {
            if (result == "invalid_user") {
                window.location.reload();
            }
            else {
                if (result != "") {
                    $("select[name='selected_unit_type']").empty().append(result);
                }
            }
        }
    });

}

function AddProductStock() {
    // if(result == "invalid_user") {
    //     window.location.reload();
    // }
    // else {
    if (jQuery('.infos').length > 0) {
        jQuery('.infos').each(function () { jQuery(this).remove(); });
    }
    var all_errors_check = 1; var unit_error = 1; var unit_id = ""; var subunit_id = ""; var subunit_need = 0;
    var selected_unit_type = "";
    if (jQuery('select[name="selected_unit_type"]').is(":visible")) {
        if (jQuery('select[name="selected_unit_type"]').length > 0) {
            selected_unit_type = jQuery('select[name="selected_unit_type"]').val();
            selected_unit_type = jQuery.trim(selected_unit_type);
            if (typeof selected_unit_type == "undefined" || selected_unit_type == "" || selected_unit_type == 0) {
                all_errors_check = 0;
            }
        }
    }

    var selected_unit_id = "";
    if (selected_unit_type == '1') {
        if (jQuery('select[name="unit_id"]').is(":visible")) {
            if (jQuery('select[name="unit_id"]').length > 0) {
                selected_unit_id = jQuery('select[name="unit_id"]').val();

                selected_unit_id = jQuery.trim(selected_unit_id);
                if (typeof selected_unit_id == "undefined" || selected_unit_id == "" || selected_unit_id == 0) {
                    all_errors_check = 0;
                }
            }
        }
    }
    else if (selected_unit_type == '2') {
        if (jQuery('select[name="subunit_id"]').is(":visible")) {
            if (jQuery('select[name="subunit_id"]').length > 0) {
                selected_unit_id = jQuery('select[name="subunit_id"]').val();

                selected_unit_id = jQuery.trim(selected_unit_id);
                if (typeof selected_unit_id == "undefined" || selected_unit_id == "" || selected_unit_id == 0) {
                    all_errors_check = 0;
                }
            }
        }
    }
    if (jQuery('select[name="unit_id"]').length > 0) {
        unit_id = jQuery('select[name="unit_id"]').val();
    }
    if (jQuery('select[name="subunit_id"]').length > 0) {
        subunit_id = jQuery('select[name="subunit_id"]').val();
    }
    if (jQuery('#subunit_need').length > 0) {
        subunit_need = jQuery('#subunit_need').val();
    }

    if (unit_id != "" && subunit_id != "" && subunit_need == 1) {
        if (unit_id == subunit_id) {
            unit_error = 0;
        }
    }

    var selected_stock_date = "";
    if (jQuery('input[name="selected_stock_date"]').is(":visible")) {
        if (jQuery('input[name="selected_stock_date"]').length > 0) {
            selected_stock_date = jQuery('input[name="selected_stock_date"]').val();
            selected_stock_date = jQuery.trim(selected_stock_date);
            if (typeof selected_stock_date == "undefined" || selected_stock_date == "" || selected_stock_date == 0) {
                all_errors_check = 0;
            }
        }
    }

    var selected_quantity = "";
    if (jQuery('input[name="selected_quantity"]').length > 0) {
        selected_quantity = jQuery('input[name="selected_quantity"]').val();
        selected_quantity = jQuery.trim(selected_quantity);
        if (typeof selected_quantity == "undefined" || selected_quantity == "") {
            all_errors_check = 0;
        }
        else if (price_regex.test(selected_quantity) == false) {
            all_errors_check = 0;
        }
        else if (parseFloat(selected_quantity) > 99999) {
            all_errors_check = 0;
        }
    }

    var selected_content = "";
    if (jQuery('input[name="selected_content"]').is(":visible")) {
        if (jQuery('input[name="selected_content"]').length > 0) {
            selected_content = jQuery('input[name="selected_content"]').val();
            selected_content = jQuery.trim(selected_content);
            if (typeof selected_content == "undefined" || selected_content == "" || selected_content == 0) {
                all_errors_check = 0;
            }
            else if (price_regex.test(selected_content) == false) {
                all_errors_check = 0;
            }
            else if (parseFloat(selected_content) > 99999) {
                all_errors_check = 0;
            }
        }
    }


    if (parseFloat(all_errors_check) == 1) {
        if (parseFloat(unit_error) == 1) {


            var add = 1;
            jQuery('.product_stock_table tbody').find('tr').each(function () {
                prev_unit_type = jQuery(this).find('input[name="unit_type[]"]').val();
                prev_content = jQuery(this).find('input[name="content[]"]').val();
                prev_content = jQuery.trim(prev_content);
                if (subunit_need == 1) {
                    if (prev_unit_type == selected_unit_type && prev_content == selected_content) {
                        add = 0;
                    }
                } else {
                    if (prev_unit_type == selected_unit_type) {
                        add = 0;
                    }
                }

            });


            if (parseFloat(add) == 1) {

                unit_type_count = jQuery('input[name="unit_type_count"]').val();
                unit_type_count = parseInt(unit_type_count) + 1;
                jQuery('input[name="unit_type_count"]').val(unit_type_count);
                var post_url = "product_changes.php?product_row_index=" + unit_type_count + "&selected_unit_type=" + selected_unit_type + "&selected_stock_date=" + selected_stock_date + "&selected_quantity=" + selected_quantity + "&selected_content=" + selected_content + "&unit_id=" + selected_unit_id;
                jQuery.ajax({
                    url: post_url, success: function (result) {
                        if (jQuery('.product_stock_table tbody').find('tr').length > 0) {
                            jQuery('.product_stock_table tbody').find('tr:first').before(result);
                        }
                        else {
                            jQuery('.product_stock_table tbody').append(result);
                        }

                        if (jQuery('select[name="selected_unit_type"]').length > 0) {
                            jQuery('select[name="selected_unit_type"]').val('1').trigger('change');
                        }
                        if (jQuery('input[name="selected_quantity"]').length > 0) {
                            jQuery('input[name="selected_quantity"]').val('');
                        }
                        if (jQuery('input[name="selected_content"]').length > 0) {
                            jQuery('input[name="selected_content"]').val('');
                        }
                        if (jQuery('#subunit_need').length > 0) {
                            jQuery('#subunit_need').attr('disabled', true);
                        }
                        if (jQuery('input[name="subunit_need"]').length > 0) {
                            jQuery('input[name="subunit_need"]').attr('disabled', false);
                            jQuery('input[name="subunit_need"]').val(subunit_need)
                        }
                        SnoCalculation();
                    }
                });
            }
            else {
                if (subunit_need == 1) {
                    jQuery('.product_stock_table').before('<span class="infos w-50 text-center mb-3" style="font-size: 15px;">This Unit Type Already Exists with same contains</span>');
                } else {
                    jQuery('.product_stock_table').before('<span class="infos w-50 text-center mb-3" style="font-size: 15px;">This Unit Type Already Exists</span>');
                }

            }
        }
        else {
            jQuery('.product_stock_table').before('<span class="infos w-50 text-center mb-3" style="font-size: 15px;">Unit and Subunit must be different </span>');
        }
    }
    else {
        jQuery('.product_stock_table').before('<span class="infos w-50 text-center mb-3" style="font-size: 15px;">Check Qty Details</span>');
    }
    // }	
}

// function calcEndingDate() {

//     var starting_date = ""; var duration = "";
//     if($('input[name="starting_date"]').length > 0){
//         starting_date = $('input[name="starting_date"]').val();
//     }
//     if($('input[name="duration"]').length > 0){
//          duration = $('input[name="duration"]').val();
//     }

//     if (starting_date !== "" && duration !== "") {

//         // Parse YYYY-MM-DD manually
//         var parts = starting_date.split('-');
//         var year  = parseInt(parts[0]);
//         var month = parseInt(parts[1]) - 1; // JS month starts from 0
//         var day   = parseInt(parts[2]);

//         // Add months
//         month += (parseInt(duration) - 1);

//         // Handle year overflow
//         year += Math.floor(month / 12);
//         month = month % 12;

//         // Create end date
//         var endDate = new Date(year, month, day);

//         // Format back to YYYY-MM-DD
//         var yyyy = endDate.getFullYear();
//         var mm = String(endDate.getMonth() + 1).padStart(2, '0');
//         var dd = String(endDate.getDate()).padStart(2, '0');

//         $('input[name="ending_date"]').val(`${yyyy}-${mm}-${dd}`);
//     }

// }
function calcEndingDate() {
    var starting_date = ""; var duration = "";
    if ($('input[name="starting_date"]').length > 0) {
        starting_date = $('input[name="starting_date"]').val();
    }
    if ($('input[name="duration"]').length > 0) {
        duration = $('input[name="duration"]').val();
    }


    if (starting_date !== "" && duration > 0) {
        var startDate = new Date(starting_date + 'T00:00:00'); // Ensure full date
        var originalDay = startDate.getDate();

        // Add (duration - 1) months using setMonth (handles overflow automatically)
        startDate.setMonth(startDate.getMonth() + (duration - 1));

        // CRITICAL: If day overflowed (31st → next month), set to LAST DAY of target month
        if (startDate.getDate() !== originalDay) {
            startDate.setDate(0); // 0 = last day of previous month (target month)
        }

        // Format YYYY-MM-DD
        var yyyy = startDate.getFullYear();
        var mm = String(startDate.getMonth() + 1).padStart(2, '0');
        var dd = String(startDate.getDate()).padStart(2, '0');

        $('input[name="ending_date"]').val(`${yyyy}-${mm}-${dd}`);
    }
}

function getGroupDetails() {
    var group_id = "";
    if (jQuery('select[name="group_id"]').length > 0) {
        group_id = jQuery('select[name="group_id"]').val();
    }

    var post_url = "category_changes.php?selected_group_id=" + group_id;
    jQuery.ajax({
        url: post_url, success: function (result) {
            if (result != "") {
                result = result.split("$$$");
                result[0] = result[0].trim();
                result[1] = result[1].trim();
                result[2] = result[2].trim();

                if (jQuery('input[name="duration"]').length > 0) {
                    jQuery('input[name="duration"]').val(result[0]);
                }
                if (jQuery('input[name="starting_date"]').length > 0) {
                    jQuery('input[name="starting_date"]').val(result[1]);
                }
                if (jQuery('input[name="ending_date"]').length > 0) {
                    jQuery('input[name="ending_date"]').val(result[2]);
                }
                cal_duration();
            } else {
                if (jQuery('input[name="duration"]').length > 0) {
                    jQuery('input[name="duration"]').val('');
                }
            }
        }
    });
}


function addPaymentModeDetails(name, characters) {
    var check_login_session = 1; var all_errors_check = 1; var error = 1; var letters_check = 1;
    var post_url = "dashboard_changes.php?check_login_session=1";
    jQuery.ajax({
        url: post_url, success: function (check_login_session) {
            if (check_login_session == 1) {
                if (jQuery('.infos').length > 0) {
                    jQuery('.infos').each(function () { jQuery(this).remove(); });
                }
                var creation_name = "";
                var format = regex;
                var name_variable = "";



                name_variable = name.toLowerCase();
                name_variable = name_variable.trim();
                name_variable = name_variable.replace("_", " ");
                if (jQuery('input[name="payment_mode_name"]').is(":visible")) {
                    if (jQuery('input[name="payment_mode_name"]').length > 0) {
                        creation_name = jQuery('input[name="payment_mode_name"]').val();
                        creation_name = creation_name.trim();
                        creation_name = creation_name.replace('&', "@@@");

                        if (typeof creation_name == "undefined" || creation_name == "" || creation_name == 0 || creation_name == null) {
                            all_errors_check = 0;
                        }
                        else if (format.test(creation_name) == false) {
                            letters_check = 0;
                        }
                        else if (creation_name.length > parseInt(characters)) {
                            error = 0;
                        }
                    }
                }
                if (parseInt(all_errors_check) == 1) {
                    if (parseInt(letters_check) == 1) {
                        if (parseInt(error) == 1) {
                            var add = 1;
                            if (creation_name != "") {
                                if (jQuery('input[name="payment_mode_names[]"]').length > 0) {
                                    jQuery('.added_payment_mode_table tbody').find('tr').each(function () {
                                        var prev_creation_name = jQuery(this).find('input[name="payment_mode_names[]"]').val().toLowerCase();
                                        var current_creation_name = creation_name.toLowerCase();
                                        if (prev_creation_name == current_creation_name) {
                                            add = 0;
                                        }
                                    });
                                }
                            }
                            if (add == 1) {
                                var count = jQuery('input[name="payment_mode_count"]').val();
                                count = parseInt(count) + 1;
                                jQuery('input[name="payment_mode_count"]').val(count);
                                var post_url = "payment_mode_changes.php?payment_mode_row_index=" + count + "&selected_payment_mode_name=" + creation_name;
                                jQuery.ajax({
                                    url: post_url, success: function (result) {
                                        if (jQuery('.added_payment_mode_table tbody').find('tr').length > 0) {
                                            jQuery('.added_payment_mode_table tbody').find('tr:first').before(result);
                                        }
                                        else {
                                            jQuery('.added_payment_mode_table tbody').append(result);
                                        }
                                        if (jQuery('input[name="payment_mode_name"]').length > 0) {
                                            jQuery('input[name="payment_mode_name"]').val('').focus();
                                        }
                                        SnoCalculation();
                                    }
                                });
                            }
                            else {
                                jQuery('.added_payment_mode_table').before('<div class="infos w-100 text-danger text-center mb-3" style="font-size: 15px;">This Payment Mode already Exists</div>');
                            }
                        }
                        else {
                            jQuery('.added_payment_mode_table').before('<div class="infos text-danger text-center mb-3" style="font-size: 15px;">Only ' + characters + ' Characters allowed</div>');
                        }
                    }
                    else {
                        jQuery('.added_payment_mode_table').before('<div class="infos text-danger text-center mb-3" style="font-size: 15px;color:red;">Invalid Characters</div>');
                        jQuery('input[name="payment_mode_name"]').val('');
                    }
                }
                else {
                    jQuery('.added_payment_mode_table').before('<div class="infos text-danger text-center mb-3" style="font-size: 15px;">Please check field values</div>');
                }
            }
            else {
                window.location.reload();
            }
        }
    });
}


function cal_duration() {
    var starting_date = ""; var ending_date = ""; var duration = 0;

    if (jQuery("input[name='starting_date']").length > 0) {
        starting_date = jQuery("input[name='starting_date']").val();
    }
    if (jQuery("input[name='ending_date']").length > 0) {
        ending_date = jQuery("input[name='ending_date']").val();
    }
    if (jQuery("input[name='duration']").length > 0) {
        duration = jQuery("input[name='duration']").val();
    }

    var check_login_session = 1;
    var post_url = "dashboard_changes.php?check_login_session=1";
    jQuery.ajax({
        url: post_url, success: function (check_login_session) {
            if (check_login_session == 1) {
                var post_url = "category_changes.php?chit_starting_date=" + starting_date + "&c=" + ending_date + "&duration=" + duration;
                jQuery.ajax({
                    url: post_url, success: function (result) {
                        if (jQuery("#tbl_due_list").length > 0) {
                            jQuery("#tbl_due_list").html(result)
                        }
                    }
                });
            }
        }
    });
}
function GetCreationCategoryList(group_id) {

    if (jQuery('select[name="category_id"]').length > 0) {
        category_id = jQuery('select[name="category_id"]').val();
    }

    var check_login_session = 1;
    var post_url = "dashboard_changes.php?check_login_session=1";
    jQuery.ajax({
        url: post_url, success: function (check_login_session) {
            if (check_login_session == 1) {
                post_url = "member_changes.php?get_creation_group_id=" + group_id + "&get_creation_category_id=" + category_id;
                jQuery.ajax({
                    url: post_url, success: function (result) {
                        if (result != '') {
                            if (jQuery('select[name="category_id"]').length > 0) {
                                jQuery('select[name="category_id"]').html(result);
                            }
                        } else {
                            if (jQuery('select[name="category_id"]').length > 0) {
                                jQuery('select[name="category_id"]').html("<option value = ''>Select Category</option>");
                            }
                        }
                    }
                });
            }
        }
    });
}


function AddCreationMemberDtls() {
    var check_login_session = 1; var all_errors_check = 1;
    var post_url = "dashboard_changes.php?check_login_session=1";
    jQuery.ajax({
        url: post_url, success: function (check_login_session) {
            if (check_login_session == 1) {

                if (jQuery('.infos').length > 0) {
                    jQuery('.infos').each(function () { jQuery(this).remove(); });
                }

                var group_id = "";
                if (jQuery('select[name="group_id"]').is(":visible")) {
                    if (jQuery('select[name="group_id"]').length > 0) {
                        group_id = jQuery('select[name="group_id"]').val();
                        group_id = jQuery.trim(group_id);
                        if (typeof group_id == "undefined" || group_id == "" || group_id == 0) {
                            all_errors_check = 0;
                        }
                    }
                }

                var category_id = "";
                if (jQuery('select[name="category_id"]').is(":visible")) {
                    if (jQuery('select[name="category_id"]').length > 0) {
                        category_id = jQuery('select[name="category_id"]').val();
                        category_id = jQuery.trim(category_id);
                        if (typeof category_id == "undefined" || category_id == "" || category_id == 0) {
                            all_errors_check = 0;
                        }
                    }
                }


                var balance = 1;
                if (parseFloat(all_errors_check) == 1) {
                    var add = 1;
                    if (group_id != "") {
                        if (jQuery('input[name="selected_group_id[]"]').length > 0) {
                            if (jQuery('input[name="selected_category_id[]"]').length > 0) {
                                jQuery('.member_row_table tbody').find('tr').each(function () {
                                    var prev_group_id = ""; var prev_category_id = "";
                                    prev_group_id = jQuery(this).find('input[name="selected_group_id[]"]').val();
                                    prev_category_id = jQuery(this).find('input[name="selected_category_id[]"]').val();
                                    if (prev_group_id == group_id && (category_id == prev_category_id)) {
                                        add = 0;
                                    }
                                });
                            }
                        }
                    }

                    if (parseInt(add) == 1) {
                        if (parseInt(balance) == 1) {
                            var member_count = 0;
                            member_count = jQuery('input[name="member_row_count"]').val();
                            member_count = parseInt(member_count) + 1;
                            jQuery('input[name="member_row_count"]').val(member_count);

                            var post_url = "member_changes.php?member_row_index=" + member_count + "&selected_group_id=" + group_id + "&selected_category_id=" + category_id;

                            jQuery.ajax({
                                url: post_url, success: function (result) {
                                    if (jQuery('.member_row_table tbody').find('tr').length > 0) {
                                        jQuery('.member_row_table tbody').find('tr:first').before(result);
                                    }
                                    else {
                                        jQuery('.member_row_table tbody').append(result);
                                    }
                                    if (jQuery('select[name="group_id"]').length > 0) {
                                        jQuery('select[name="group_id"]').val('').trigger('change');
                                    }
                                    if (jQuery('select[name="category_id"]').length > 0) {
                                        jQuery('select[name="category_id"]').val('').trigger('change');
                                    }
                                    SnoCalculation();
                                }
                            });
                        }
                    }
                    else {
                        jQuery('.member_row_table').before('<span class="infos w-50 text-center mb-3 fw-bold" style="font-size: 15px;">This Group & Category Already Exists</span>');
                    }
                }
                else {
                    jQuery('.member_row_table').before('<span class="infos w-50 text-center mb-3 fw-bold" style="font-size: 15px;">Check All Details</span>');
                }
            }
            else {
                window.location.reload();
            }
        }
    });
}

function MemberChitDetails(member_id) {

    var post_url = "member_changes.php?modal_member_id=" + member_id;
    jQuery.ajax({
        url: post_url, success: function (result) {
            result = result.trim();
            result = result.split("$$$");
            var modal = new bootstrap.Modal(document.getElementById('ChitDetailsModal'));

            if (jQuery('#ChitDetailsModal').length > 0) {
                if (jQuery('#ChitDetailsModal').find('.modal-title').length > 0) {
                    jQuery('#ChitDetailsModal').find('.modal-title').html(result[1]);
                }
                if (jQuery('#ChitDetailsModal').find('.modal-body').length > 0) {
                    jQuery('#ChitDetailsModal').find('.modal-body').html(result[0]);
                }
            }
            modal.show();
        }
    });
}

function CategoryChitDetails(group_id, category_id) {

    var post_url = "category_changes.php?modal_group_id=" + group_id + "&modal_category_id=" + category_id;
    jQuery.ajax({
        url: post_url, success: function (result) {
            result = result.trim();
            result = result.split("###SPLIT###");
            var modal = new bootstrap.Modal(document.getElementById('MemberChitDetailsModal'));

            if (jQuery('#MemberChitDetailsModal').length > 0) {
                if (jQuery('#MemberChitDetailsModal').find('.modal-title').length > 0) {
                    jQuery('#MemberChitDetailsModal').find('.modal-title').html(result[1]);
                }
                if (jQuery('#MemberChitDetailsModal').find('.modal-body').length > 0) {
                    jQuery('#MemberChitDetailsModal').find('.modal-body').html(result[0]);
                }
            }
            modal.show();
        }
    });
}

function printChitDetails(group_id, category_id) {
    var url = "reports/print_chit_details_a5.php?view_group_id=" + group_id + "&view_category_id=" + category_id;
    window.open(url, '_blank');
}

function GetFilterCategoryList() {

    if (jQuery('select[name="filter_group_id"]').length > 0) {
        group_id = jQuery('select[name="filter_group_id"]').val();
    }

    var check_login_session = 1;
    var post_url = "dashboard_changes.php?check_login_session=1";
    jQuery.ajax({
        url: post_url, success: function (check_login_session) {
            if (check_login_session == 1) {
                post_url = "common_changes.php?get_filter_group_id=" + group_id;
                jQuery.ajax({
                    url: post_url, success: function (result) {
                        if (result != '') {
                            if (jQuery('select[name="filter_category_id"]').length > 0) {
                                jQuery('select[name="filter_category_id"]').html(result);
                            }
                        } else {
                            if (jQuery('select[name="filter_category_id"]').length > 0) {
                                jQuery('select[name="filter_category_id"]').html("<option value = ''>Select Category</option>");
                            }
                        }
                    }
                });
            }
        }
    });
}