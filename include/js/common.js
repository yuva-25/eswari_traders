// JavaScript Document
function CheckPassword(field_name) {
	var password = "";
	if (jQuery('input[name="password"]').length > 0) {
		password = jQuery('input[name="password"]').val();
		//password = jQuery.trim(password);
	}

	if (jQuery('#password_cover').length > 0) {
		if (jQuery('#password_cover').find('label').length > 0) {
			jQuery('#password_cover').find('label').addClass('text-danger');
		}
		if (jQuery('#password_cover').find('input[name="length_check"]').length > 0) {
			jQuery('#password_cover').find('input[name="length_check"]').prop('checked', false);
		}
		if (jQuery('#password_cover').find('input[name="letter_check"]').length > 0) {
			jQuery('#password_cover').find('input[name="letter_check"]').prop('checked', false);
		}
		if (jQuery('#password_cover').find('input[name="number_symbol_check"]').length > 0) {
			jQuery('#password_cover').find('input[name="number_symbol_check"]').prop('checked', false);
		}
		if (jQuery('#password_cover').find('input[name="space_check"]').length > 0) {
			jQuery('#password_cover').find('input[name="space_check"]').prop('checked', false);
		}

		var upper_regex = /[A-Z]/; var lower_regex = /[a-z]/;
		var number_regex = /\d/; var symbol_regex = /[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\]/; var no_space_regex = /^\S+$/;

		if (typeof password != "undefined" && password != null && password != "") {
			var password_length = password.length;
			if (parseInt(password_length) >= 8 && parseInt(password_length) <= 20) {
				if (jQuery('#password_cover').find('input[name="length_check"]').length > 0) {
					jQuery('#password_cover').find('input[name="length_check"]').prop('checked', true);
					if (jQuery('#password_cover').find('input[name="length_check"]').parent().find('label').length > 0) {
						jQuery('#password_cover').find('input[name="length_check"]').parent().find('label').removeClass('text-danger');
						jQuery('#password_cover').find('input[name="length_check"]').parent().find('label').addClass('text-success');
					}
				}
			}
			if ((upper_regex.test(password) == true) && (lower_regex.test(password) == true)) {
				if (jQuery('#password_cover').find('input[name="letter_check"]').length > 0) {
					jQuery('#password_cover').find('input[name="letter_check"]').prop('checked', true);
					if (jQuery('#password_cover').find('input[name="letter_check"]').parent().find('label').length > 0) {
						jQuery('#password_cover').find('input[name="letter_check"]').parent().find('label').removeClass('text-danger');
						jQuery('#password_cover').find('input[name="letter_check"]').parent().find('label').addClass('text-success');
					}
				}
			}
			if ((number_regex.test(password) == true) && (symbol_regex.test(password) == true)) {
				if (jQuery('#password_cover').find('input[name="number_symbol_check"]').length > 0) {
					jQuery('#password_cover').find('input[name="number_symbol_check"]').prop('checked', true);
					if (jQuery('#password_cover').find('input[name="number_symbol_check"]').parent().find('label').length > 0) {
						jQuery('#password_cover').find('input[name="number_symbol_check"]').parent().find('label').removeClass('text-danger');
						jQuery('#password_cover').find('input[name="number_symbol_check"]').parent().find('label').addClass('text-success');
					}
				}
			}
			if (no_space_regex.test(password) == true) {
				if (jQuery('#password_cover').find('input[name="space_check"]').length > 0) {
					jQuery('#password_cover').find('input[name="space_check"]').prop('checked', true);
					if (jQuery('#password_cover').find('input[name="space_check"]').parent().find('label').length > 0) {
						jQuery('#password_cover').find('input[name="space_check"]').parent().find('label').removeClass('text-danger');
						jQuery('#password_cover').find('input[name="space_check"]').parent().find('label').addClass('text-success');
					}
				}
			}
		}
	}
}

// function CustomCheckboxToggle(obj, toggle_id) {
// 	var check_login_session = 1;
// 	var post_url = "dashboard_changes.php?check_login_session=1";
// 	jQuery.ajax({
// 		url: post_url, success: function (check_login_session) {
// 			if (check_login_session == 1) {
// 				var toggle_value = 2;
// 				if (jQuery('#' + toggle_id).length > 0) {
// 					if (jQuery('#' + toggle_id).prop('checked') == true) {
// 						toggle_value = 1;
// 					}
// 					jQuery('#' + toggle_id).val(toggle_value);
// 				}

// 				if (jQuery('.gst_row').length > 0) {
// 					if (jQuery('.tax_type_cover').length > 0) {
// 						if (parseInt(toggle_value) == 1) {
// 							jQuery('.tax_type_cover').removeClass('d-none');
// 						}
// 						else {
// 							jQuery('.tax_type_cover').addClass('d-none');
// 						}
// 					}
// 					ShowHideGSTRows();
// 				}
// 				if (jQuery('.staff_access_table').length > 0) {
// 					toggle_id = toggle_id.replace('view', '');
// 					toggle_id = toggle_id.replace('add', '');
// 					toggle_id = toggle_id.replace('edit', '');
// 					toggle_id = toggle_id.replace('delete', '');
// 					toggle_id = jQuery.trim(toggle_id);
// 					var checkbox_cover = toggle_id + "cover";
// 					//console.log('checkbox_cover - '+checkbox_cover+', checbox count - '+jQuery('#'+checkbox_cover).find('input[type="checkbox"]').length);
// 					if (jQuery('#' + checkbox_cover).find('input[type="checkbox"]').length > 0) {

// 						var view_checkbox = toggle_id + "view"; var add_checkbox = toggle_id + "add"; var edit_checkbox = toggle_id + "edit";
// 						var delete_checkbox = toggle_id + "delete"; var select_count = 0; var select_all_checkbox = toggle_id + "select_all";
// 						//console.log('add_checkbox - '+add_checkbox+', edit_checkbox - '+edit_checkbox+', delete_checkbox - '+delete_checkbox+', select_all_checkbox - '+select_all_checkbox);
// 						if (jQuery('#' + view_checkbox).prop('checked') == true) {
// 							select_count = parseInt(select_count) + 1;
// 						}
// 						if (jQuery('#' + add_checkbox).prop('checked') == true) {
// 							select_count = parseInt(select_count) + 1;
// 						}
// 						if (jQuery('#' + edit_checkbox).prop('checked') == true) {
// 							select_count = parseInt(select_count) + 1;
// 						}
// 						if (jQuery('#' + delete_checkbox).prop('checked') == true) {
// 							select_count = parseInt(select_count) + 1;
// 						}

// 						if (parseInt(select_count) == 4) {
// 							jQuery('#' + select_all_checkbox).prop('checked', true);
// 						}
// 						else {
// 							jQuery('#' + select_all_checkbox).prop('checked', false);
// 						}
// 					}
// 				}
// 			}
// 			else {
// 				window.location.reload();
// 			}
// 		}
// 	});
// }

// function SelectAllModuleActionToggle(obj, toggle_id) {

// 	var check_login_session = 1;
// 	var post_url = "dashboard_changes.php?check_login_session=1";
// 	jQuery.ajax({
// 		url: post_url, success: function (check_login_session) {
// 			if (check_login_session == 1) {
// 				var toggle_value = 2;
// 				if (jQuery('#' + toggle_id).length > 0) {
// 					if (jQuery('#' + toggle_id).prop('checked') == true) {
// 						toggle_value = 1;
// 					}
// 					jQuery('#' + toggle_id).val(toggle_value);
// 				}
// 				if (parseInt(toggle_value) == 1) {
// 					if (jQuery('#' + toggle_id).parent().parent().parent().parent().find('input[type="checkbox"]').length > 0) {
// 						jQuery('#' + toggle_id).parent().parent().parent().parent().find('input[type="checkbox"]').each(function () {
// 							jQuery(this).prop('checked', true);
// 							jQuery(this).val('1');
// 						});
// 					}
// 				}
// 				else {
// 					if (jQuery('#' + toggle_id).parent().parent().parent().parent().find('input[type="checkbox"]').length > 0) {
// 						jQuery('#' + toggle_id).parent().parent().parent().parent().find('input[type="checkbox"]').each(function () {
// 							jQuery(this).prop('checked', false);
// 							jQuery(this).val('2');
// 						});
// 					}
// 				}
// 			}
// 			else {
// 				window.location.reload();
// 			}
// 		}
// 	});
// }

function FormSubmit(event, form_name, submit_page, redirection_page) {
	event.preventDefault();

	if (jQuery('div.alert').length > 0) {
		jQuery('div.alert').remove();
	}
	jQuery('form[name="' + form_name + '"]').find('.row:first').before('<div class="alert alert-danger mb-5"> <button type="button" class="close" data-dismiss="alert">&times;</button> Processing </div>');

	if (jQuery('.submit_button').length > 0) {
		jQuery('.submit_button').attr('disabled', true);
	}
	jQuery.ajax({
		url: submit_page,
		type: "post",
		async: true,
		data: jQuery('form[name="' + form_name + '"]').serialize(),
		dataType: 'html',
		contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
		success: function (data) {
			//console.log(data);
			try {
				var x = JSON.parse(data);
			} catch (e) {
				return false;
			}
			//console.log(x);

			if (jQuery('span.infos').length > 0) {
				jQuery('span.infos').remove();
			}
			if (jQuery('.valid_error').length > 0) {
				jQuery('.valid_error').remove();
			}
			if (jQuery('div.alert').length > 0) {
				jQuery('div.alert').remove();
			}

			if (typeof x.redirection_page != "undefined" && x.redirection_page != "") {
				redirection_page = x.redirection_page;
			}

			if (x.number == '1') {
				jQuery('form[name="' + form_name + '"]').find('.row:first').before('<div class="alert alert-success"> <button type="button" class="close" data-dismiss="alert">&times;</button> ' + x.msg + ' </div>');

				

				jQuery('html, body').animate({
					scrollTop: (jQuery('form[name="' + form_name + '"]').offset().top)
				}, 500);
				setTimeout(function () {
					if (typeof redirection_page != "undefined" && redirection_page != "") {
						window.location = redirection_page;
					}
					else {
						window.location.reload();
					}
				}, 1000);
			}

			if (x.number == '2') {
				jQuery('form[name="' + form_name + '"]').find('.row:first').before('<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert">&times;</button> ' + x.msg + ' </div>');
				if (jQuery('.submit_button').length > 0) {
					jQuery('.submit_button').attr('disabled', false);
				}
				jQuery('html, body').animate({
					scrollTop: (jQuery('form[name="' + form_name + '"]').offset().top)
				}, 500);
			}

			if (x.number == '3') {
				jQuery('form[name="' + form_name + '"]').append('<div class="valid_error"> <script type="text/javascript"> ' + x.msg + ' </script> </div>');
				if (jQuery('.submit_button').length > 0) {
					jQuery('.submit_button').attr('disabled', false);
				}
				jQuery('html, body').animate({
					scrollTop: (jQuery('form[name="' + form_name + '"]').offset().top)
				}, 500);
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			console.log(textStatus, errorThrown);
		}
	});
}
function table_listing_records_filter() {
	if (jQuery('#table_listing_records').length > 0) {
		jQuery('#table_listing_records').html('<div class="alert alert-success mb-3 mx-3"> Loading... </div>');
	}

	var check_login_session = 1;
	// var post_url = "dashboard_changes.php?check_login_session=1";
	// jQuery.ajax({
	// 	url: post_url, success: function (check_login_session) {
	if (check_login_session == 1) {
		var page_title = ""; var post_send_file = "";
		if (jQuery('input[name="page_title"]').length > 0) {
			page_title = jQuery('input[name="page_title"]').val();
			if (typeof page_title != "undefined" && page_title != "") {
				page_title = page_title.replaceAll(" ", "_");
				page_title = page_title.toLowerCase();
				page_title = jQuery.trim(page_title);
				post_send_file = page_title + "_changes.php";
			}
		}
		jQuery.ajax({
			url: post_send_file,
			type: "post",
			async: true,
			data: jQuery('form[name="table_listing_form"]').serialize(),
			dataType: 'html',
			contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
			success: function (result) {
				if (jQuery('.alert').length > 0) {
					jQuery('.alert').remove();
				}
				if (jQuery('#table_listing_records').length > 0) {
					jQuery('#table_listing_records').html(result);
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(textStatus, errorThrown);
			}
		});
	}
	else {
		window.location.reload();
	}
	// 	}
	// });
}

function ShowModalContent(page_title, add_edit_id_value) {
	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	// jQuery.ajax({url: post_url, success: function(check_login_session){
	// 	if(check_login_session == 1) {
	var add_edit_id = ""; var post_send_file = ""; var heading = "";
	if (typeof page_title != "undefined" && page_title != "") {
		heading = page_title;
		// page_title = page_title.replaceAll(" ", "_");
		page_title = page_title.replace(/\s+/g, "_");
		page_title = page_title.toLowerCase();
		add_edit_id = "show_" + page_title + "_id";
		post_send_file = page_title + "_changes.php";
		page_title = page_title + " Details";
		if (jQuery('.edit_title').length > 0) {
			page_title = page_title.replaceAll("_", " ");
			page_title = page_title.toLowerCase().replace(/\b[a-z]/g, function (string) {
				return string.toUpperCase();
			});
			jQuery('.edit_title').html(page_title);
		}
		if (jQuery('#table_records_cover').length > 0) {
			jQuery('#table_records_cover').addClass('d-none');
		}
		if (jQuery('#add_update_form_content').length > 0) {
			jQuery('#add_update_form_content').removeClass('d-none');
		}
	}
	var post_url = post_send_file + "?" + add_edit_id + "=" + add_edit_id_value;
	jQuery.ajax({
		url: post_url, success: function (result) {
			if (jQuery('.add_update_form_content').length > 0) {
				jQuery('.add_update_form_content').html("");
				jQuery('.add_update_form_content').html(result);
			}
			jQuery('html, body').animate({
				scrollTop: (jQuery('.add_update_form_content').parent().parent().offset().top)
			}, 500);
		}
	});
	// }
	// else {
	// 	window.location.reload();
	// }
	// }});
}

function SaveModalContent(event, form_name, post_send_file, redirection_file) { 
	event.preventDefault();
	if (jQuery('span.infos').length > 0) {
		jQuery('span.infos').remove();
	}
	if (jQuery('.valid_error').length > 0) {
		jQuery('.valid_error').remove();
	}
	if (jQuery('div.alert').length > 0) {
		jQuery('div.alert').remove();
	}
	if (jQuery('.top-alert').length > 0) {
		jQuery('.top-alert').remove();
	}
	if(jQuery('input[name="cal_save_form_value"]').length > 0) {
        jQuery('input[name="cal_save_form_value"]').val('2');
    }
	jQuery(window).off('beforeunload');

	if(form_name == 'login_form' || form_name == 'register_form') {
		showLoginAlert('error', 'Processing');
		
	}
	else {
		showAlert('error', 'Processing');
	}

	if(form_name != "bill_product_form") {
		if (jQuery('form[name="' + form_name + '"]').find('.submit_button').length > 0) {
			jQuery('form[name="' + form_name + '"]').find('.submit_button').attr('disabled', true);
		}
	}
	
	if (form_name != "register_form" && form_name != "login_form") {
		jQuery('html, body').animate({
			scrollTop: (jQuery('html, body').offset().top)
		}, 500);
		var check_login_session = 1;
		var post_url = "dashboard_changes.php?check_login_session=1";
		jQuery.ajax({
			url: post_url, success: function (check_login_session) {
				if (check_login_session == 1) {

					SendModalContent(form_name, post_send_file, redirection_file);
				}
				else {
					window.location.reload();
				}
			}
		});
	}
	else {
	
		jQuery('html, body').animate({
			scrollTop: (jQuery('form[name="' + form_name + '"]').offset().top)
		}, 500);
		SendModalContent(form_name, post_send_file, redirection_file);
	}
}
function SendModalContent(form_name, post_send_file, redirection_file) {
	jQuery.ajax({
		url: post_send_file,
		type: "post",
		async: true,
		data: jQuery('form[name="' + form_name + '"]').serialize(),
		dataType: 'html',
		contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
		success: function (data) {
			if(data == 'invalid_user') {
				window.location.reload();
			}
			else {
				try {
					var x = JSON.parse(data);
				} catch (e) {
					return false;
				}
				if (jQuery('span.infos').length > 0) {
					jQuery('span.infos').remove();
				}
				if (jQuery('.valid_error').length > 0) {
					jQuery('.valid_error').remove();
				}
				if (jQuery('div.alert').length > 0) {
					jQuery('div.alert').remove();
				}
				if (jQuery('.top-alert').length > 0) {
					jQuery('.top-alert').remove();
				}
			
				if (x.number == '1') {
					if(form_name == 'login_form' || form_name == 'register_form') {
						showLoginAlert('success', x.msg, 2);
					}
					else {
						showAlert('success', x.msg, 2);
					}

					setTimeout(function () {
						var page_title = ""; var screen_name = "";
						if(jQuery('input[name="page_title"]').length > 0) {
							page_title = jQuery('input[name="page_title"]').val();
							page_title = page_title.trim();
							screen_name = page_title.toLowerCase();
							screen_name = screen_name.replaceAll(" ", "_");
							screen_name = screen_name.trim();
						}
						
						 if((typeof x.party_id != "undefined" && x.party_id != "" && page_title != 'Party') ) {

							if (jQuery('form[name="' + form_name + '"]').find('.submit_button').length > 0) {
								jQuery('form[name="' + form_name + '"]').find('.submit_button').attr('disabled', false);
							}

							if(jQuery('#CustomPartyModal .modal-header').find('.btn-close').length > 0) {
								jQuery('#CustomPartyModal .modal-header').find('.btn-close').trigger("click");
							}

							ChangePartyIDs(page_title);
						}else if((typeof x.product_id != "undefined" && x.product_id != "" && page_title != 'Product')) {
							if (jQuery('form[name="' + form_name + '"]').find('.submit_button').length > 0) {
								jQuery('form[name="' + form_name + '"]').find('.submit_button').attr('disabled', false);
							}

							if(jQuery('#CustomProductModal .modal-header').find('.btn-close').length > 0) {
								jQuery('#CustomProductModal .modal-header').find('.btn-close').trigger("click");
							}

							ChangeProductIDs();
                        }else if((typeof x.member_id != "undefined" && x.member_id != "" && page_title != 'Member')) {
							var modalEl = document.getElementById('CustomMemberModal');
							var modal = bootstrap.Modal.getInstance(modalEl);

							if (modal) {
								modal.hide();
							}
							ChangeMemberIDs();
						} else if (jQuery('.redirection_form').length > 0) {
							if (typeof x.redirection_page != "undefined" && x.redirection_page != "") {
								window.location = x.redirection_page;
							}
							else {
								window.location = redirection_file;
							}
						}
						else {
							if (jQuery('#add_update_form_content').length > 0) {
								jQuery('#add_update_form_content').addClass('d-none');
							}
							if (jQuery('#table_records_cover').hasClass('d-none')) {
								jQuery('#table_records_cover').removeClass('d-none');
							}
							else {
								table_listing_records_filter();
							}
						}
					}, 1500);
				}
				if (x.number == '2') {
					if(form_name == 'login_form' || form_name == 'register_form') {
						showLoginAlert('error', x.msg, 10);
					}
					else {
						showAlert('error', x.msg, 10);
					}

					if (jQuery('form[name="' + form_name + '"]').find('.submit_button').length > 0) {
						jQuery('form[name="' + form_name + '"]').find('.submit_button').attr('disabled', false);
					}

				}
				if (x.number == '3') {
					jQuery('form[name="' + form_name + '"]').append('<div class="valid_error"> <script type="text/javascript"> ' + x.msg + ' </script> </div>');
					if (jQuery('form[name="' + form_name + '"]').find('.submit_button').length > 0) {
						jQuery('form[name="' + form_name + '"]').find('.submit_button').attr('disabled', false);
					}

				}
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			console.log(textStatus, errorThrown);
		}
	});
}

function DeleteModalContent(page_title, delete_content_id) {
	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({
		url: post_url, success: function (check_login_session) {
			if (check_login_session == 1) {
				if (typeof page_title != "undefined" && page_title != "") {
					jQuery('#DeleteModal .modal-header').find('h4').html("");
					jQuery('#DeleteModal .modal-header').find('h4').html("Delete " + page_title);
					page_title = page_title.toLowerCase();
				}
				jQuery('.delete_modal_button').trigger("click");
				jQuery('#DeleteModal .modal-body').html('');
				if (page_title == "quotation" || page_title == "estimate" || page_title == "invoice") {
					jQuery('#DeleteModal .modal-body').html('Are you surely want to cancel this ' + page_title + '?');
				}
				else {
					jQuery('#DeleteModal .modal-body').html('Are you surely want to delete this ' + page_title + '?');
				}

				jQuery('#DeleteModal .modal-footer .yes').attr('id', delete_content_id);
				jQuery('#DeleteModal .modal-footer .no').attr('id', delete_content_id);
			}
			else {
				window.location.reload();
			}
		}
	});
}
function DeleteNumberModalContent(page_title, delete_content_id) {

	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({
		url: post_url, success: function (check_login_session) {
			if (check_login_session == 1) {
				if (typeof page_title != "undefined" && page_title != "") {
					jQuery('#ReceiptDeleteModal .modal-header').find('h4').html("");
					jQuery('#ReceiptDeleteModal .modal-header').find('h4').html("Delete " + page_title);

					page_title = page_title.toLowerCase();
				}
				jQuery('.receipt_delete_modal_button').trigger("click");
				jQuery('#ReceiptDeleteModal .modal-body').html('');

				if (page_title == "quotation" || page_title == "estimate" || page_title == "invoice") {
					jQuery('#ReceiptDeleteModal .modal-body').html('Are you surely want to cancel this ' + page_title + '?');
				}
				else {
					jQuery('#ReceiptDeleteModal .modal-body').html('Are you surely want to delete this ' + page_title + '?');
				}

				jQuery('#ReceiptDeleteModal .modal-footer .yes').attr('id', delete_content_id);
				jQuery('#ReceiptDeleteModal .modal-footer .no').attr('id', delete_content_id);
			}
			else {
				window.location.reload();
			}
		}
	});
}

function confirm_delete_modal(obj) {
	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({
		url: post_url, success: function (check_login_session) {
			if (check_login_session == 1) {

				if (jQuery('#DeleteModal .modal-body').find('.infos').length > 0) {
					jQuery('#DeleteModal .modal-body').find('.infos').remove();
				}

				var page_title = ""; var post_send_file = "";
				if (jQuery('input[name="page_title"]').length > 0) {
					page_title = jQuery('input[name="page_title"]').val();
					if (typeof page_title != "undefined" && page_title != "") {
						// page_title = page_title.replace(" ", "_");
						page_title = page_title.replace(/\s+/g, "_");
						page_title = page_title.toLowerCase();
						page_title = jQuery.trim(page_title);
						post_send_file = page_title + "_changes.php";
					}
				}
				var delete_content_id = jQuery(obj).attr('id');
				// if (page_title != 'receipt') {
					var post_url = post_send_file + "?delete_" + page_title + "_id=" + delete_content_id;
					jQuery.ajax({
						url: post_url, success: function (result) {
							jQuery('#DeleteModal .modal-content').animate({ scrollTop: 0 }, 500);
							result = jQuery.trim(result);

							var intRegex = /^\d+$/;
							if (intRegex.test(result) == true) {
								if (page_title == "quotation" || page_title == "estimate" || page_title == "invoice") {
									jQuery('#DeleteModal .modal-body').append('<div class="alert alert-success"> <button type="button" class="close" data-dismiss="alert">&times;</button> Successfully Cancel the ' + page_title.replace("_", " ") + ' </div>');
								}
								else {
									jQuery('#DeleteModal .modal-body').append('<div class="alert alert-success"> <button type="button" class="close" data-dismiss="alert">&times;</button> Successfully Delete the ' + page_title.replace("_", " ") + ' </div>');
								}
								setTimeout(function () {
									jQuery('#DeleteModal .modal-header .close').trigger("click");
									window.location.reload();
								}, 1000);

							}
							else {
								jQuery('#DeleteModal .modal-body').append('<span class="infos w-100 text-center" style="font-size: 15px; font-weight: bold;">' + result + '</span>');
							}
						}
					});
				// }
				// else {
				// 	RemarksModalContent(delete_content_id, '')
				// }

			}
			else {
				window.location.reload();
			}
		}
	});
}
function cancel_delete_modal(obj) {
	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({
		url: post_url, success: function (check_login_session) {
			if (check_login_session == 1) {
				jQuery('#DeleteModal .modal-header .close').trigger("click");
			}
			else {
				window.location.reload();
			}
		}
	});
}

function showAlert(type, message, duration = 1) {
    // Clear existing alerts and their timers
    if(jQuery('.top-alert').length > 0) {
        jQuery('.top-alert').each(function() {
            // Clear any existing timer for this alert
            const existingTimer = jQuery(this).data('timer');
            if (existingTimer) {
                clearInterval(existingTimer);
            }
        });
        jQuery('.top-alert').remove();
    }

    // Type styles + icons
    const config = {
        error:   { bg: "#D62828", color: "#FEEFDD", icon: "⚠️" },
        success: { bg: "#0a8749ff", color: "#FEEFDD", icon: "✅" }
    };

    // Build alert html with unique ID
    const alertId = 'alert-' + Date.now();
    jQuery('body').prepend(
        '<div class="top-alert fw-bold" id="' + alertId + '" style="background:' + config[type].bg + '; color:' + config[type].color + '">' +
        config[type].icon +
        '&ensp;<span class="msg fw-bold">' + message + '</span>' +
        '<button class="close-btn" style="background:' + config[type].bg + '; color:' + config[type].color + '">&times; <span class="countdown fw-bold" style="background:' + config[type].bg + '; color:' + config[type].color + '">' + duration + '</span>s</button>' +
        '</div>'
    );

    // Get reference to the specific alert element
    const $alert = jQuery('#' + alertId);
    
    // Countdown logic - store timer reference in the element's data
    let countdown = duration;
    let timer = setInterval(function() {
        countdown--;
        $alert.find('.countdown').text(countdown);
        if (countdown <= 0) {
            clearInterval(timer);
            $alert.slideUp(300, function(){ jQuery(this).remove(); });
        }
    }, 1000);
    
    // Store timer reference in the alert element
    $alert.data('timer', timer);

    // Close button - bind directly to this specific alert
    $alert.find('.close-btn').on('click', function() {
        clearInterval(timer);
        $alert.slideUp(300, function(){ jQuery(this).remove(); });
    });
}

function showLoginAlert(type, message, duration = 10) {
    // Clear existing alerts and their timers
    if(jQuery('.top-alert').length > 0) {
        jQuery('.top-alert').each(function() {
            // Clear any existing timer for this alert
            const existingTimer = jQuery(this).data('timer');
            if (existingTimer) {
                clearInterval(existingTimer);
            }
        });
        jQuery('.top-alert').remove();
    }

    // Type styles + icons
    const config = {
        error:   { bg: "#D62828", color: "#FEEFDD", icon: "⚠️" },
        success: { bg: "#0a8749ff", color: "#FEEFDD", icon: "✅" }
    };

    // Build alert html with unique ID
    const alertId = 'alert-' + Date.now();
	console.log(alertId,"---", jQuery('body').length);
    jQuery('body').prepend(
        '<div class="top-alert login-top-alert fw-bold" id="' + alertId + '" style="background:' + config[type].bg + '; color:' + config[type].color + '">' +
        config[type].icon +
        '&ensp;<span class="msg fw-bold">' + message + '</span>' +
        '<button class="close-btn" style="background:' + config[type].bg + '; color:' + config[type].color + '">&times; <span class="countdown fw-bold" style="background:' + config[type].bg + '; color:' + config[type].color + '">' + duration + '</span>s</button>' +
        '</div>'
    );

    // Get reference to the specific alert element
    const $alert = jQuery('#' + alertId);
    
    // Countdown logic - store timer reference in the element's data
    let countdown = duration;
    let timer = setInterval(function() {
        countdown--;
        $alert.find('.countdown').text(countdown);
        if (countdown <= 0) {
            clearInterval(timer);
            $alert.slideUp(300, function(){ jQuery(this).remove(); });
        }
    }, 1000);
    
    // Store timer reference in the alert element
    $alert.data('timer', timer);

    // Close button - bind directly to this specific alert
    $alert.find('.close-btn').on('click', function() {
        clearInterval(timer);
        $alert.slideUp(300, function(){ jQuery(this).remove(); });
    });
}

function throwerrormsg(selected_name, type, value, form_name) {
	const $field = jQuery(`form[name="${form_name}"] ${type}[name="${selected_name}"]`);
	const $formGroup = $field.closest('.form-group');
	if ($formGroup.find('span.infos').length === 0) {
		$formGroup.append(`<span class="infos text-danger d-block mt-1"><i class="fa fa-exclamation-circle"></i> ${value}</span>`);
	} 
}


function SelectAllModuleActionToggle(obj, toggle_id) {
	// alert(toggle_id+"hello")
	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({
		url: post_url, success: function (check_login_session) {
			if (check_login_session == 1) {
				var toggle_value = 2;
				if (jQuery('#' + toggle_id + "_select_all").length > 0) {
					if (jQuery('#' + toggle_id + "_select_all").prop('checked') == true) {
						toggle_value = 1;
					}
					jQuery('#' + toggle_id + "_select_all").val(toggle_value);
				}
				// alert(toggle_value+"hai")
				if (parseInt(toggle_value) == 1) {
					if (jQuery('#' + toggle_id + "_select_all").closest('tr').find('input[type="checkbox"]').length > 0) {
						jQuery('#' + toggle_id + "_select_all").closest('tr').find('input[type="checkbox"]').each(function () {
							jQuery(this).prop('checked', true);
							jQuery(this).val('1');
							var currentValue = jQuery('#' + toggle_id + "_action").val('VEAD');
						});
					}
				}
				else {
					if (jQuery('#' + toggle_id + "_select_all").closest('tr').find('input[type="checkbox"]').length > 0) {
						jQuery('#' + toggle_id + "_select_all").closest('tr').find('input[type="checkbox"]').each(function () {
							jQuery(this).prop('checked', false);
							jQuery(this).val('2');
							var currentValue = jQuery('#' + toggle_id + "_action").val('');
						});
					}
				}
			}
			else {
				window.location.reload();
			}
		}
	});
}

function CustomCheckboxToggle(obj, toggle_id, action, count) {
	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({
		url: post_url, success: function (check_login_session) {
			if (check_login_session == 1) {

				var hiddenInput = jQuery('#' + toggle_id + "_action");

				if (hiddenInput.length > 0) {
					var currentValue = hiddenInput.val();
					if (jQuery(obj).prop('checked')) {
						if (currentValue.indexOf(action) === -1) {
							currentValue += action;
						}
					} else {
						currentValue = currentValue.replace(action, '');
					}

					hiddenInput.val(currentValue);
				}

				var toggle_value = 2;
				if (jQuery('#' + toggle_id).length > 0) {
					if (jQuery('#' + toggle_id).prop('checked') == true) {
						toggle_value = 1;
					}
					jQuery('#' + toggle_id).val(toggle_value);
				}
				if (jQuery('.gst_row').length > 0) {
					if (jQuery('.tax_type_cover').length > 0) {
						if (parseInt(toggle_value) == 1) {
							jQuery('.tax_type_cover').removeClass('d-none');
						}
						else {
							jQuery('.tax_type_cover').addClass('d-none');
						}
					}
					ShowHideGSTRows();
				}
				if (jQuery('.staff_access_table_' + count).length > 0) {
					toggle_id = toggle_id.replace('view', '');
					toggle_id = toggle_id.replace('add', '');
					toggle_id = toggle_id.replace('edit', '');
					toggle_id = toggle_id.replace('delete', '');
					toggle_id = toggle_id.replace('paynow', '');
					toggle_id = jQuery.trim(toggle_id);

					var checkbox_cover = toggle_id + "_cover";
					// console.log('checkbox_cover - '+checkbox_cover+', checbox count - '+jQuery('#'+checkbox_cover).find('input[type="checkbox"]').length);
					if (jQuery('#' + checkbox_cover).find('input[type="checkbox"]').length > 0) {

						var view_checkbox = toggle_id + "_view"; var add_checkbox = toggle_id + "_add"; var edit_checkbox = toggle_id + "_edit";
						var delete_checkbox = toggle_id + "_delete"; var paynow_checkbox = toggle_id + "_paynow"; var select_count = 0; var select_all_checkbox = toggle_id + "_select_all";
						//console.log('add_checkbox - '+add_checkbox+', edit_checkbox - '+edit_checkbox+', delete_checkbox - '+delete_checkbox+', select_all_checkbox - '+select_all_checkbox);
						// if (jQuery('#' + view_checkbox).prop('checked') == true) {
						// 	select_count = parseInt(select_count) + 1;
						// }
						if (jQuery('#' + view_checkbox).prop('checked') == true) {
							select_count = parseInt(select_count) + 1;
							jQuery('#' + view_checkbox).val(1);
						} else {
							select_count = parseInt(select_count) - 1;
							jQuery('#' + view_checkbox).val(2);
						}


						if (jQuery('#' + add_checkbox).prop('checked') == true) {
							jQuery('#' + view_checkbox).prop('checked', true);
							if (jQuery('#' + view_checkbox).prop('checked') == true) {
								select_count = parseInt(select_count) + 1;
								jQuery('#' + view_checkbox).val(1);

							}
							else {
								jQuery('#' + view_checkbox).prop('checked', true);
								select_count = parseInt(select_count) + 1;
								jQuery('#' + view_checkbox).val(1);

							}
						}
						if (jQuery('#' + edit_checkbox).prop('checked') == true) {
							jQuery('#' + view_checkbox).prop('checked', true);
							if (jQuery('#' + view_checkbox).prop('checked') == true) {
								select_count = parseInt(select_count) + 1;
								jQuery('#' + view_checkbox).val(1);
							}
							else {
								jQuery('#' + view_checkbox).prop('checked', true);
								select_count = parseInt(select_count) + 1;
								jQuery('#' + view_checkbox).val(1);
							}
						}
						if (jQuery('#' + delete_checkbox).prop('checked') == true) {
							jQuery('#' + view_checkbox).prop('checked', true);
							if (jQuery('#' + view_checkbox).prop('checked') == true) {
								select_count = parseInt(select_count) + 1;
								jQuery('#' + view_checkbox).val(1);
							}
							else {
								jQuery('#' + view_checkbox).prop('checked', true);
								select_count = parseInt(select_count) + 1;
							}
						}
						if (jQuery('#' + paynow_checkbox).prop('checked') == true) {
							jQuery('#' + view_checkbox).prop('checked', true);
							if (jQuery('#' + view_checkbox).prop('checked') == true) {
								select_count = parseInt(select_count) + 1;
								jQuery('#' + view_checkbox).val(1);
							}
							else {
								jQuery('#' + view_checkbox).prop('checked', true);
								select_count = parseInt(select_count) + 1;
							}
						}
						if (toggle_id == '556d566a5a576c7764413d3d_' || toggle_id == '566d39315932686c636e4d3d_') {
							if (parseInt(select_count) == 3 || parseInt(select_count) > 3) {
								jQuery('#' + select_all_checkbox).prop('checked', true);
							}
							else {
								jQuery('#' + select_all_checkbox).prop('checked', false);
							}
						}
						else {

							if (parseInt(select_count) == 4 || parseInt(select_count) > 4) {
								jQuery('#' + select_all_checkbox).prop('checked', true);
							} else {
								jQuery('#' + select_all_checkbox).prop('checked', false);
								var currentValue = jQuery('#' + toggle_id + "_action").val();

								if (!jQuery('#' + view_checkbox).prop('checked') && !jQuery('#' + edit_checkbox).prop('checked') && !jQuery('#' + delete_checkbox).prop('checked')) {
									// If view, edit, and delete are all unchecked, clear the value
									currentValue = currentValue.replace('V', '');
								} else if (!currentValue.includes('V')) {
									currentValue += 'V';
								}
								// 	if (!currentValue.includes('V')) {
								// 		currentValue += 'V'; 
								// 	}

								jQuery('#' + toggle_id + "_action").val(currentValue);
							}

						}
					}
				}
			}
			else {
				window.location.reload();
			}
		}
	});
}

function checkDateCheck() {
	var from_date = ""; var to_date = "";
	if (jQuery('.infos').length > 0) {
		jQuery('.infos').each(function () { jQuery(this).remove(); });
	}
	if (jQuery('input[name="from_date"]').length > 0) {
		from_date = jQuery('input[name="from_date"]').val();
	}
	if (jQuery('input[name="to_date"]').length > 0) {
		to_date = jQuery('input[name="to_date"]').val();
	}
	if(to_date != "") {
		if (from_date > to_date) {
			jQuery('input[name="to_date"]').after('<span class="infos">To date Must be greater than the date ' + from_date + '</span>');
			if (jQuery('input[name="to_date"]').length > 0) {
				jQuery('input[name="to_date"]').val("");
			}
		}
	}
}


function assign_bill_value() {
	if (jQuery("#show_bill").val() == "0") {
		jQuery("#show_bill").val("1");
		jQuery("#show_button").html("Show Active Bill");
		// table_listing_records_filter();
	}
	else {
		jQuery("#show_bill").val("0");
		jQuery("#show_button").html("Show Inactive Bill")
		// table_listing_records_filter();
	}
}

function ChangeMemberIDs() {

    var post_url = "action_changes.php?change_member_modal=1";

    jQuery.ajax({
        url: post_url, success: function (result) {
            result = result.trim();

            if (jQuery('select[name="index_member_id"]').length > 0) {
                jQuery('select[name="index_member_id"]').html(result);
            }
            if (jQuery('select[name="index_member_id"]').length > 0) {
                jQuery('select[name="index_member_id"]').select2('open');
            }

        }
    });
}



function CustomProductModal(obj) {
    var form_name = 0;

    var form_name = jQuery(obj).closest('form').attr('name');

    if (jQuery('.custom_product_modal_button').length > 0) {
        var post_url = "product_changes.php?show_product_id=&add_custom=1" + "&form_name=" + form_name;
        jQuery.ajax({
            url: post_url, success: function (result) {
                result = result.trim();
                if (result != "" && typeof result != "undefined" && result != null) {
                    if (jQuery('#CustomProductModal').find('.modal-body').length > 0) {
                        jQuery('#CustomProductModal').find('.modal-body').html(result);
                    }

                }
                var modal = new bootstrap.Modal(document.getElementById('CustomProductModal'));
                modal.show();
            }
        });
    }

}

function ChangeProductIDs() {

    var post_url = "common_changes.php?change_product_modal=1";

    jQuery.ajax({
        url: post_url, success: function (result) {
            result = result.trim();

            if (jQuery('select[name="selected_product_id"]').length > 0) {
                jQuery('select[name="selected_product_id"]').html(result);
            }
            if (jQuery('select[name="selected_product_id"]').length > 0) {
                jQuery('select[name="selected_product_id"]').select2('open');
            }

        }
    });
}

     

function CustomPartyModal(obj) {
    var form_name = 0;

    var form_name = jQuery(obj).closest('form').attr('name');

    if (jQuery('.custom_party_modal_button').length > 0) {
        var post_url = "party_changes.php?show_party_id=&add_custom=1" + "&form_name=" + form_name;
        jQuery.ajax({
            url: post_url, success: function (result) {
                result = result.trim();
                if (result != "" && typeof result != "undefined" && result != null) {
                    if (jQuery('#CustomPartyModal').find('.modal-body').length > 0) {
                        jQuery('#CustomPartyModal').find('.modal-body').html(result);
                    }
                }
                var modal = new bootstrap.Modal(document.getElementById('CustomPartyModal'));
                modal.show();
            }
        });
    }

}

function ChangePartyIDs(page_title) {

    var post_url = "common_changes.php?change_party_modal=1"+"&page_title=" + page_title;

    jQuery.ajax({
        url: post_url, success: function (result) {
            result = result.trim();

            if (jQuery('select[name="party_id"]').length > 0) {
                jQuery('select[name="party_id"]').html(result);
            }
            if (jQuery('select[name="party_id"]').length > 0) {
                jQuery('select[name="party_id"]').select2('open');
            }

        }
    });
}


function ShowBillConversion(page_title,conversion_id) {
    if(page_title == 'estimate')
	{
		var post_url = "invoice_changes.php?show_invoice_id="+conversion_id+"&conversion_update=1"+"&page_title="+page_title;
	}else if($page_title = 'order_form'){
		var post_url = "estimate_changes.php?show_estimate_id="+conversion_id+"&conversion_update=1"+"&page_title="+page_title;
	}

    jQuery.ajax({url: post_url, success: function (result) {
		if (jQuery('#table_records_cover').length > 0) {
			jQuery('#table_records_cover').addClass('d-none');
		}
		if (jQuery('#add_update_form_content').length > 0) {
			jQuery('#add_update_form_content').removeClass('d-none');
		}
        if (jQuery('.add_update_form_content').length > 0) {
            jQuery('.add_update_form_content').html("");
            jQuery('.add_update_form_content').html(result);
        }
    }});
}

