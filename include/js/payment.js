var number_regex = /^\d+$/;
var price_regex = /^(\d*\.)?\d+$/;

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

function AddPaymentRow() {
	var check_login_session = 1; var all_errors_check = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({
		url: post_url, success: function (check_login_session) {
			if (check_login_session == 1) {
				var form_name = jQuery('form').attr('name');

				if (jQuery('.infos').length > 0) {
					jQuery('.infos').each(function () { jQuery(this).remove(); });
				}

				var available_balance = 0;
				if (jQuery('input[name="available_balance"]').length > 0) {
					available_balance = jQuery('input[name="available_balance"]').val();
					available_balance = jQuery.trim(available_balance);
				} else if (jQuery('input[name="withdraw_amount"]').length > 0) {
					available_balance = jQuery('input[name="withdraw_amount"]').val();
					available_balance = jQuery.trim(available_balance);
				}

				if (jQuery('select[name="party_id"]').length > 0) {
					party_id = jQuery('select[name="party_id"]').val();
				}

				var voucher_date = "";
				if (jQuery('input[name="voucher_date"]').is(":visible")) {
					if (jQuery('input[name="voucher_date"]').length > 0) {
						voucher_date = jQuery('input[name="voucher_date"]').val();
						voucher_date = jQuery.trim(voucher_date);
						if (typeof voucher_date == "undefined" || voucher_date == "" || voucher_date == 0) {
							all_errors_check = 0;
						}
					}
				} else if (jQuery('input[name="receipt_date"]').is(":visible")) {
					if (jQuery('input[name="receipt_date"]').length > 0) {
						voucher_date = jQuery('input[name="receipt_date"]').val();
						voucher_date = jQuery.trim(voucher_date);
						if (typeof voucher_date == "undefined" || voucher_date == "" || voucher_date == 0) {
							all_errors_check = 0;
						}
					}
				}

				var selected_payment_mode_id = "";
				if (jQuery('select[name="selected_payment_mode_id"]').is(":visible")) {
					if (jQuery('select[name="selected_payment_mode_id"]').length > 0) {
						selected_payment_mode_id = jQuery('select[name="selected_payment_mode_id"]').val();
						selected_payment_mode_id = jQuery.trim(selected_payment_mode_id);
						if (typeof selected_payment_mode_id == "undefined" || selected_payment_mode_id == "" || selected_payment_mode_id == 0) {
							all_errors_check = 0;
						}
					}
				}

				var selected_bank_id = "";
				if (jQuery('select[name="selected_bank_id"]').is(":visible")) {
					if (jQuery('select[name="selected_bank_id"]').length > 0) {
						selected_bank_id = jQuery('select[name="selected_bank_id"]').val();
						selected_bank_id = jQuery.trim(selected_bank_id);
						if (typeof selected_bank_id == "undefined" || selected_bank_id == "" || selected_bank_id == 0) {
							all_errors_check = 0;
						}
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

				var balance = 1;
				if (parseFloat(all_errors_check) == 1) {
					var add = 1;
					if (selected_payment_mode_id != "") {
						if (jQuery('input[name="payment_mode_id[]"]').length > 0) {
							if (jQuery('input[name="bank_id[]"]').length > 0) {
								jQuery('.payment_row_table tbody').find('tr').each(function () {
									var prev_payment_mode_id = "";
									prev_payment_mode_id = jQuery(this).find('input[name="payment_mode_id[]"]').val();
									prev_bank_id = jQuery(this).find('input[name="bank_id[]"]').val();
									if (prev_payment_mode_id == selected_payment_mode_id && (selected_bank_id == prev_bank_id)) {
										add = 0;
									}
								});
							}
						}
					}

					if (form_name != 'receipt_form') {
						if (parseFloat(available_balance) > 0 && parseFloat(selected_amount) > parseFloat(available_balance)) {
							balance = 0;
						}
					}

					if (parseInt(add) == 1) {
						if (parseInt(balance) == 1) {
							var payment_count = 0;
							payment_count = jQuery('input[name="payment_row_count"]').val();
							payment_count = parseInt(payment_count) + 1;
							jQuery('input[name="payment_row_count"]').val(payment_count);

							var post_url = "payment_bill_changes.php?payment_row_index=" + payment_count + "&selected_payment_mode_id=" + selected_payment_mode_id + "&selected_bank_id=" + selected_bank_id + "&selected_amount=" + selected_amount;

							jQuery.ajax({
								url: post_url, success: function (result) {
									if (jQuery('.payment_row_table tbody').find('tr').length > 0) {
										jQuery('.payment_row_table tbody').find('tr:first').before(result);
									}
									else {
										jQuery('.payment_row_table tbody').append(result);
									}

									if (jQuery('select[name="selected_payment_mode_id"]').length > 0) {
										jQuery('select[name="selected_payment_mode_id"]').val('').trigger('change');
									}

									if (jQuery('input[name="voucher_date"]').length > 0) {
										jQuery('input[name="voucher_date"]').prop('readonly', true);
									}
									if (jQuery('input[name="receipt_date"]').length > 0) {
										jQuery('input[name="receipt_date"]').prop('readonly', true);
									}
									if (jQuery('select[name="selected_bank_id"]').length > 0) {
										jQuery('select[name="selected_bank_id"]').val('').trigger('change');
									}
									if (jQuery('input[name="selected_amount"]').length > 0) {
										jQuery('input[name="selected_amount"]').val('');
									}
									if (jQuery('#AccBal').length > 0) {
										jQuery('#AccBal').html('');
									}
									PaymentTotal();
									SnoCalculation();
								}
							});
						}
						else {
							jQuery('.payment_row_table').before('<span class="infos w-50 text-center mb-3 fw-bold" style="font-size: 15px;">Amount is Greater than Withdraw Amount</span>');
						}
					}
					else {
						jQuery('.payment_row_table').before('<span class="infos w-50 text-center mb-3 fw-bold" style="font-size: 15px;">This Payment Mode Already Exists</span>');
					}
				}
				else {
					jQuery('.payment_row_table').before('<span class="infos w-50 text-center mb-3 fw-bold" style="font-size: 15px;">Check All Details</span>');
				}
			}
			else {
				window.location.reload();
			}
		}
	});
}

function getBankDetails(bank_details) {
	var post_url = "payment_bill_changes.php?selected_bank_payment_mode=" + bank_details;
	jQuery.ajax({
		url: post_url, success: function (result) {
			result = result.trim();
			if (result != "") {
				if (jQuery('#bank_list_cover').length > 0) {
					jQuery('#bank_list_cover').removeClass('d-none');
				}
				if (jQuery('select[name="selected_bank_id"]')) {
					jQuery('select[name="selected_bank_id"]').html(result);
				}
			}
			else {
				if (jQuery('#bank_list_cover').length > 0) {
					jQuery('#bank_list_cover').addClass('d-none');
				}
			}
			if (jQuery('input[name="mode_of_payment_amount"]')) {
				jQuery('input[name="mode_of_payment_amount"]').focus();
			}
		}
	});
}

function DeleteRow(id_name, row_index) {
	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({
		url: post_url, success: function (check_login_session) {
			if (check_login_session == 1) {
				if (jQuery('#' + id_name + row_index).length > 0) {
					jQuery('#' + id_name + row_index).remove();
				}

				if (jQuery('.payment_row_table tbody tr').length == 0) {
					if (jQuery('input[name="voucher_date"]').length > 0) {
						jQuery('input[name="voucher_date"]').prop('readonly', false);
					}
					if (jQuery('input[name="receipt_date"]').length > 0) {
						jQuery('input[name="receipt_date"]').prop('readonly', false);
					}
				}
				PaymentTotal();
				SnoCalculation();
			}
			else {
				window.location.reload();
			}
		}
	});
}

function HideDetails(type) {
	var type_id = ""; var lower_type = "";
	if (type != "") {
		lower_type = type.toLowerCase();
		lower_type = lower_type.trim();
	}
	if (jQuery('select[name="' + lower_type + '"]').length > 0) {
		type_id = jQuery('select[name="' + lower_type + '"]').val();
	}
	if (jQuery('select[name="' + lower_type + '_id"]').length > 0) {
		type_id = jQuery('select[name="' + lower_type + '_id"]').val();
	}

	if (type_id != "" && type_id != null && typeof type_id != "undefined") {
		if (jQuery('.details_element').length > 0) {
			jQuery('.details_element').removeClass('d-none');
		}
	}
	else {
		if (jQuery('.details_element').length > 0) {
			jQuery('.details_element').addClass('d-none');
		}
	}
}

function ViewPendingDetails(type) {
	var type_id = ""; var lower_type = "";
	if (type != "") {
		lower_type = type.toLowerCase();
		lower_type = lower_type.trim();
		type = type.replace("_", " ");
	}
	if (jQuery('select[name="' + lower_type + '_id"]').length > 0) {
		type_id = jQuery('select[name="' + lower_type + '_id"]').val();
	}

	var post_url = "payment_bill_changes.php?party_id=" + type_id + "&type=" + lower_type;
	jQuery.ajax({
		url: post_url, success: function (result) {
			result = result.trim();
			result = result.split("$$$");
			var modal = new bootstrap.Modal(document.getElementById('PendingDetailsModal'));
			modal.show();
			if (jQuery('#PendingDetailsModal').length > 0) {
				if (jQuery('#PendingDetailsModal').find('.modal-title').length > 0) {
					jQuery('#PendingDetailsModal').find('.modal-title').html(result[1]);
				}
				if (jQuery('#PendingDetailsModal').find('.modal-body').length > 0) {
					jQuery('#PendingDetailsModal').find('.modal-body').html(result[0]);
				}
			}
		}
	});
}

function PaymentTotal() {
	var total_amount = 0;
	if (jQuery('.payment_row').length > 0) {
		jQuery('.payment_row').each(function () {
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

function ViewPartyDetails(type) {
	var type_id = ""; var lower_type = "";
	if (type != "") {
		lower_type = type.toLowerCase();
		lower_type = lower_type.trim();
		type = type.replace("_", " ");
	}
	if (jQuery('select[name="' + lower_type + '"]').length > 0) {
		type_id = jQuery('select[name="' + lower_type + '"]').val();
	}
	if (jQuery('select[name="' + lower_type + '_id"]').length > 0) {
		type_id = jQuery('select[name="' + lower_type + '_id"]').val();
	}

	var post_url = "payment_bill_changes.php?view_party_details=" + type_id + "&details_type=" + lower_type;
	jQuery.ajax({
		url: post_url, success: function (result) {
			result = result.trim();
			var modal = new bootstrap.Modal(document.getElementById('ViewDetailsModal'));
			modal.show();
			if (jQuery('#ViewDetailsModal').length > 0) {
				if (jQuery('#ViewDetailsModal').find('.modal-title').length > 0) {
					jQuery('#ViewDetailsModal').find('.modal-title').html(type + ' Details');
				}
				if (jQuery('#ViewDetailsModal').find('.modal-body').length > 0) {
					jQuery('#ViewDetailsModal').find('.modal-body').html(result);
				}
			}
		}
	});
}