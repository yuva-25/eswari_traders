var number_regex = /^\d+$/;
var price_regex = /^(\d*\.)?\d+$/;

function getPartyState(party_id) {
    
    var post_url = "bill_changes.php?get_party_state="+party_id;
    jQuery.ajax({
		url: post_url, success: function (result) {
            result = result.trim();
            if(jQuery('input[name="party_state"]').length > 0) {
                jQuery('input[name="party_state"]').val(result);
            }
            calTotal();
        }
    });
}


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


function AddProductRow() {
	var check_login_session = 1; var all_errors_check = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({
		url: post_url, success: function (check_login_session) {
			if (check_login_session == 1) {

				var form_name = jQuery('form').attr('name');

				if (jQuery('.infos').length > 0) {
					jQuery('.infos').each(function () { jQuery(this).remove(); });
				}
    			if(jQuery('.add_product_button').length > 0) {
                    jQuery('.add_product_button').attr('disabled', true);
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

                                    jQuery('.product_row_table tbody').find('tr').each(function () {
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
							order_count = jQuery('input[name="product_row_count"]').val();
							order_count = parseInt(order_count) + 1;
							jQuery('input[name="product_row_count"]').val(order_count);

							var post_url = "estimate_changes.php?product_row_index=" + order_count + "&selected_product_id=" + selected_product_id + "&selected_quantity=" + selected_quantity + "&selected_amount=" + selected_amount+ "&selected_unit_id=" + selected_unit_id+ "&selected_size_id=" + selected_size_id+ "&selected_rate=" + selected_rate;

							jQuery.ajax({
								url: post_url, success: function (result) {
									if (jQuery('.product_row_table tbody').find('tr').length > 0) {
										jQuery('.product_row_table tbody').find('tr:first').before(result);
									}
									else {
										jQuery('.product_row_table tbody').append(result);
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
									    
									if(jQuery('.add_product_button').length > 0) {
										jQuery('.add_product_button').attr('disabled', false);
									}
                                    ProductRowCheck();

									SnoCalcPlus();

								}
							});
						
					}
					else {
						jQuery('.product_row_table').before('<span class="infos w-50 text-center mb-3 fw-bold" style="font-size: 15px;">This Product Already Exists</span>');
					}
				}
				else {
					jQuery('.product_row_table').before('<span class="infos w-50 text-center mb-3 fw-bold" style="font-size: 15px;">Check All Details</span>');
				}
			}
			else {
				window.location.reload();
			}
		}
	});
}

function DeleteRow(id_name, row_index) {
    if (jQuery('#'+id_name+row_index).length > 0) {
        jQuery('#'+id_name+row_index).remove();
    }
    if(jQuery('.'+id_name).length == 0) {
        if (jQuery('.product_table tbody').find('tr.subtotal_row').length > 0) {
            jQuery('.product_table tbody').find('tr.subtotal_row:first').before('<tr class="no_data_row"><th colspan="10" class="text-center px-2 py-2">No Data Found!</th></tr>');
        }
    }
    SnoCalcPlus();
    calTotal();
}
