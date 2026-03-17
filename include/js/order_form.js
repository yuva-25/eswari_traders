function FormatType(){
    var format_type = "";
    if (jQuery('select[name="format_type"]').length > 0) {
        format_type = jQuery('select[name="format_type"]').val();
    }

    if(format_type != ""){
			format_type = format_type.trim();

        if(format_type == 'Office Copy'){
            if (jQuery('.office_type').length > 0) {
                jQuery('.office_type').removeClass('d-none');
            }
            if (jQuery('.customer_type').length > 0) {
                jQuery('.customer_type').addClass('d-none');
            }
        }else {
            if (jQuery('.office_type').length > 0) {
                jQuery('.office_type').addClass('d-none');
            }
            if (jQuery('.customer_type').length > 0) {
                jQuery('.customer_type').removeClass('d-none');
            }
        }
    }
  
}


function DeleteOrderRow(id_name, row_index) {
	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({
		url: post_url, success: function (check_login_session) {
			if (check_login_session == 1) {
				if (jQuery('#' + id_name + row_index).length > 0) {
					jQuery('#' + id_name + row_index).remove();
				}

				calTotalValue();
				SnoCalculation();
			}
			else {
				window.location.reload();
			}
		}
	});
}

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

function AddOrderFormRow() {
	var check_login_session = 1; var all_errors_check = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({
		url: post_url, success: function (check_login_session) {
			if (check_login_session == 1) {

				var form_name = jQuery('form').attr('name');

				if (jQuery('.infos').length > 0) {
					jQuery('.infos').each(function () { jQuery(this).remove(); });
				}

				if (jQuery('select[name="party_id"]').length > 0) {
					party_id = jQuery('select[name="party_id"]').val();
				}

				var selected_product_id = "";
				if (jQuery('select[name="selected_product_id"]').is(":visible")) {
					if (jQuery('select[name="selected_product_id"]').length > 0) {
						selected_product_id = jQuery('select[name="selected_product_id"]').val();
						selected_product_id = jQuery.trim(selected_product_id);
                        if (typeof selected_product_id == "undefined" || selected_product_id == "" || selected_product_id == 0) {
							all_errors_check = 0;
						}
					}
				}

				var selected_unit_id = "";
				if (jQuery('select[name="selected_unit_id"]').is(":visible")) {
					if (jQuery('select[name="selected_unit_id"]').length > 0) {
						selected_unit_id = jQuery('select[name="selected_unit_id"]').val();
						selected_unit_id = jQuery.trim(selected_unit_id);
                        if (typeof selected_unit_id == "undefined" || selected_unit_id == "" || selected_unit_id == 0) {
							all_errors_check = 0;
						}
					}
				}

				var selected_size_id = "";
				if (jQuery('select[name="selected_size_id"]').is(":visible")) {
					if (jQuery('select[name="selected_size_id"]').length > 0) {
						selected_size_id = jQuery('select[name="selected_size_id"]').val();
						selected_size_id = jQuery.trim(selected_size_id);
                        if (typeof selected_size_id == "undefined" || selected_size_id == "" || selected_size_id == 0) {
							all_errors_check = 0;
						}
					}
				}
      		    var selected_quantity = "";
				if (jQuery('input[name="selected_quantity"]').length > 0) {
					selected_quantity = jQuery('input[name="selected_quantity"]').val();
					selected_quantity = jQuery.trim(selected_quantity);
					if (typeof selected_quantity == "undefined" || selected_quantity == "" || selected_quantity == 0) {
						all_errors_check = 0;
					}
					else if (price_regex.test(selected_quantity) == false) {
						all_errors_check = 0;
					}
				}

		        var selected_rate = "";
				if (jQuery('input[name="selected_rate"]').length > 0) {
					selected_rate = jQuery('input[name="selected_rate"]').val();
					selected_rate = jQuery.trim(selected_rate);
					if (typeof selected_rate == "undefined" || selected_rate == "" || selected_rate == 0) {
						all_errors_check = 0;
					}
					else if (price_regex.test(selected_rate) == false) {
						all_errors_check = 0;
					}
				}

				var selected_amount = "";
				if (jQuery('input[name="selected_amount"]').length > 0) {
					selected_amount = jQuery('input[name="selected_amount"]').val();
					selected_amount = jQuery.trim(selected_amount);
					if (typeof selected_amount == "undefined" || selected_amount == "" || selected_amount == 0) {
						all_errors_check = 0;
					}
					else if (price_regex.test(selected_amount) == false) {
						all_errors_check = 0;
					}
				}


				if (parseFloat(all_errors_check) == 1) {
					var add = 1;
					if (selected_product_id != "") {
						if (jQuery('input[name="product_id[]"]').length > 0) {
							if (jQuery('input[name="unit_id[]"]').length > 0) {
                                if (jQuery('input[name="size_id[]"]').length > 0) {

                                    jQuery('.order_form_row_table tbody').find('tr').each(function () {
                                        var prev_product_id = ""; var prev_size_id = ""; var prev_unit_id ="";
                                        prev_product_id = jQuery(this).find('input[name="product_id[]"]').val();
                                        prev_unit_id = jQuery(this).find('input[name="unit_id[]"]').val();
                                        prev_size_id = jQuery(this).find('input[name="size_id[]"]').val();

                                        if (prev_product_id == selected_product_id && (selected_unit_id == prev_unit_id) && (selected_size_id == prev_size_id))  {
                                            add = 0;
                                        }
                                    });
                                }
							}
						}
					}
					
					if (parseInt(add) == 1) {
				
							var order_count = 0;
							order_count = jQuery('input[name="order_form_row_count"]').val();
							order_count = parseInt(order_count) + 1;
							jQuery('input[name="order_form_row_count"]').val(order_count);

							var post_url = "order_form_changes.php?order_form_row_index=" + order_count + "&selected_product_id=" + selected_product_id + "&selected_quantity=" + selected_quantity + "&selected_amount=" + selected_amount+ "&selected_unit_id=" + selected_unit_id+ "&selected_size_id=" + selected_size_id+ "&selected_rate=" + selected_rate;

							jQuery.ajax({
								url: post_url, success: function (result) {
									if (jQuery('.order_form_row_table tbody').find('tr').length > 0) {
										jQuery('.order_form_row_table tbody').find('tr:first').before(result);
									}
									else {
										jQuery('.order_form_row_table tbody').append(result);
									}
	
									if (jQuery('select[name="selected_product_id"]').length > 0) {
										jQuery('select[name="selected_product_id"]').val('').trigger('change').focus();
									}
	                                if (jQuery('select[name="selected_size_id"]').length > 0) {
										jQuery('select[name="selected_size_id"]').val('').trigger('change');
									}
									if (jQuery('select[name="selected_unit_id"]').length > 0) {
										jQuery('select[name="selected_unit_id"]').val('').trigger('change');
									}
                                    if (jQuery('input[name="selected_quantity"]').length > 0) {
										jQuery('input[name="selected_quantity"]').val('');
									}
									if (jQuery('input[name="selected_amount"]').length > 0) {
										jQuery('input[name="selected_amount"]').val('');
									}
								    if (jQuery('input[name="selected_rate"]').length > 0) {
										jQuery('input[name="selected_rate"]').val('');
									}
								
									calTotalValue();
									SnoCalculation();
								}
							});
						
					}
					else {
						jQuery('.order_form_row_table').before('<span class="infos w-50 text-center mb-3 fw-bold" style="font-size: 15px;">This Product Already Exists</span>');
					}
				}
				else {
					jQuery('.order_form_row_table').before('<span class="infos w-50 text-center mb-3 fw-bold" style="font-size: 15px;">Check All Details</span>');
				}
			}
			else {
				window.location.reload();
			}
		}
	});
}

function getProductUnitSize(){
    var product_id = "";
    if (jQuery('select[name="selected_product_id"]').length > 0) {
        product_id = jQuery('select[name="selected_product_id"]').val();
    }

	if (jQuery('input[name="selected_quantity"]').length > 0) {
        jQuery('input[name="selected_quantity"]').val('');
    }
    if (jQuery('input[name="selected_rate"]').length > 0) {
        jQuery('input[name="selected_rate"]').val('');
    }
    if (jQuery('input[name="selected_amount"]').length > 0) {
        jQuery('input[name="selected_amount"]').val('');
    }
    var post_url = "order_form_changes.php?product_id=" + product_id;

        jQuery.ajax({
            url: post_url, success: function (result) {
                        result = result.trim();
                    result = result.split("$$$");
                if (jQuery('select[name="selected_unit_id"]').length > 0) {
                        jQuery('select[name="selected_unit_id"]').html(result[0]);
                }
                if (jQuery('select[name="selected_size_id"]').length > 0) {
                        jQuery('select[name="selected_size_id"]').html(result[1]);
                }
					if (jQuery('input[name="selected_quantity"]').length > 0) {
						jQuery('input[name="selected_quantity"]').focus();
					}
            }
        });
}

var number_regex = /^\d+$/;
var price_regex = /^(\d*\.)?\d+$/;


function CalcAmount(){

    var selected_quantity = 0; var selected_rate = 0; var amount = 0;
    if(jQuery('input[name="selected_quantity"]').length > 0) {
        selected_quantity = jQuery('input[name="selected_quantity"]').val();
        if(selected_quantity != "" && number_regex.test(selected_quantity) == false) {
            if(jQuery('input[name="selected_quantity"]').parent().find('span.infos').length == 0) {
                jQuery('input[name="selected_quantity"]').after('<span class="infos text-danger"><i class="fa fa-exclamation-circle"></i>Enter Valid Qty</span>');
            }
        }
    }

    if(jQuery('input[name="selected_rate"]').length > 0) {
        selected_rate = jQuery('input[name="selected_rate"]').val();
        if(selected_rate != "" && number_regex.test(selected_rate) == false) {
            if(jQuery('input[name="selected_rate"]').parent().find('span.infos').length == 0) {
                jQuery('input[name="selected_rate"]').after('<span class="infos text-danger"><i class="fa fa-exclamation-circle"></i>Enter Valid Rate</span>');
            }
        }
    }
    if(selected_rate != "" && selected_quantity != "") {

        amount = selected_quantity * selected_rate;
    }
    if(!isNaN(amount) && amount != 'Infinity' &&  amount != "" && amount != 0) {

        if(jQuery('input[name="selected_amount"]').length > 0) {
            jQuery('input[name="selected_amount"]').val(amount.toFixed(2));
        }
    }else{
		  if(jQuery('input[name="selected_amount"]').length > 0) {
            jQuery('input[name="selected_amount"]').val('');
        }
	}
}


function OrderProductRowCheck(obj) {
    if(jQuery(obj).closest('tr.order_form_row').find('span.infos').length > 0) {
        jQuery(obj).closest('tr.order_form_row').find('span.infos').remove();
    }
    var quantity_check = 1; var quantity_error = 1; var price_check = 1; var price_error = 1;
    

    var selected_quantity = "";
    if(jQuery(obj).closest('tr.order_form_row').find('input[name="quantity[]"]').length > 0) {
        selected_quantity = jQuery(obj).closest('tr.order_form_row').find('input[name="quantity[]"]').val();
        if(typeof selected_quantity == "undefined" || selected_quantity == "" || selected_quantity == null) {
            quantity_check = 0;
        }
        else if(number_regex.test(selected_quantity) == false) {
            quantity_error = 0;
            if(jQuery(obj).closest('tr.order_form_row').find('input[name="quantity[]"]').length > 0) {
                jQuery(obj).closest('tr.order_form_row').find('input[name="quantity[]"]').parent().after('<span class="infos">Invalid Qty</span>');
            }
        }
        else if(parseInt(selected_quantity) > 99999) {
            quantity_error = 0;
            if(jQuery(obj).closest('tr.order_form_row').find('input[name="quantity[]"]').length > 0) {
                jQuery(obj).closest('tr.order_form_row').find('input[name="quantity[]"]').parent().after('<span class="infos">Max Value : 99999</span>');
            }
        }
    }
   
    var selected_price = ""; var final_price = 0;
    if(jQuery(obj).closest('tr.order_form_row').find('input[name="rates[]"]').length > 0) {
        selected_price = jQuery(obj).closest('tr.order_form_row').find('input[name="rates[]"]').val();
        if(typeof selected_price == "undefined" || selected_price == "" || selected_price == null) {
            price_check = 0;
        }
        else if(price_regex.test(selected_price) == false) {
            price_error = 0;
            if(jQuery(obj).closest('tr.order_form_row').find('input[name="rates[]"]').length > 0) {
                jQuery(obj).closest('tr.order_form_row').find('input[name="rates[]"]').parent().after('<span class="infos">Only numbers</span>');
            }
        }
        else if(parseFloat(selected_price) > 9999999.99) {
            price_error = 0;
            if(jQuery(obj).closest('tr.order_form_row').find('input[name="rates[]"]').length > 0) {
                jQuery(obj).closest('tr.order_form_row').find('input[name="rates[]"]').parent().after('<span class="infos">Max Value : 9999999.99</span>');
            }
        }
        else {
            final_price = selected_price;
        }
    }
    
    var selected_amount = 0;
    if(parseFloat(quantity_check) == 1 && parseFloat(quantity_error) == 1 && parseFloat(price_check) == 1 && parseFloat(price_error) == 1) {
      
		selected_amount = selected_quantity * selected_price;
       
        
        if(selected_amount != "" && selected_amount != 0) {
            if(jQuery(obj).closest('tr.order_form_row').find('input[name="amount[]"]').length > 0) {
                selected_amount = selected_amount.toFixed(2);
                jQuery(obj).closest('tr.order_form_row').find('input[name="amount[]"]').val(selected_amount);
            }

        }
        else {
            if(jQuery(obj).closest('tr.order_form_row').find('input[name="amount[]"]').length > 0) {
                jQuery(obj).closest('tr.order_form_row').find('input[name="amount[]"]').val('');
            }
        }
    }
    else {
        if(jQuery(obj).closest('tr.order_form_row').find('input[name="amount[]"]').length > 0) {
            jQuery(obj).closest('tr.order_form_row').find('input[name="amount[]"]').val('');
        }
    }
    calTotalValue();
   
}

function calTotalValue() {
	var total_amount = 0;
	if (jQuery('.order_form_row').length > 0) {
		jQuery('.order_form_row').each(function () {
			var amount = 0;
			if (jQuery(this).find('input[name="amount[]"]').length > 0) {
				amount = jQuery(this).find('input[name="amount[]"]').val();
				amount = amount.trim();
			}
			if (amount != "" && amount != 0 && typeof amount != "undefined" && amount != null && price_regex.test(amount) !== false) {
				total_amount = parseFloat(amount) + parseFloat(total_amount);
				total_amount = total_amount.toFixed(2);
			}
		});
	}
	if (jQuery('.overall_total').length > 0) {
		jQuery('.overall_total').html('Rs.' + total_amount);
	}
}
