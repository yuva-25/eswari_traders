function ProductUploadCheck(file_name) {
	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({
		url: post_url, success: function (check_login_session) {
			if (check_login_session == 1) {
				var post_url = file_name+"_changes.php?check_"+file_name+"_count=1";
				jQuery.ajax({
					url: post_url, success: function (product_count) {
						if (parseInt(product_count) > 0) {
							// jQuery('.upload_modal_button').trigger("click");
                            var modal = new bootstrap.Modal(document.getElementById('ProductUploadModal'));
				            modal.show();
							jQuery('#product_modal_header').html(file_name + " Upload");							
						}
						else {
							UploadExcel();
						}
						if (jQuery('#excel_div').length > 0) {
							jQuery('#excel_div').addClass("d-none");
						}
						if (jQuery('#table_listing_records').length > 0) {
							jQuery('#table_listing_records').addClass("d-none");
						}
					}
				});
			}
		}
	});
}

function UploadExcel(upload_type,file_name) {	
	var check_login_session = 1;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({
		url: post_url, success: function (check_login_session) {
			if (check_login_session == 1) {

				if (jQuery('.add_update_excel_form_content_excel').length > 0) {
					jQuery('.add_update_excel_form_content_excel').removeClass('col-xl-7 px-0 mx-auto');
				}
 
				var post_url = "product_upload.php?show_upload_excel=1";
				jQuery.ajax({
					url: post_url, success: function (result) {
						if (jQuery('.add_update_excel_form_content_excel').length > 0) {
							jQuery('.add_update_excel_form_content_excel').html(result);
						}
					}
				});

				if (jQuery('input[name="upload_type"]').length > 0) {
					jQuery('input[name="upload_type"]').val(upload_type);
				}

				// if (jQuery('#UploadModal').length > 0) {
				// 	jQuery('#UploadModal').modal('hide');
				// }

                jQuery('#ProductUploadModal .modal-header .close').trigger("click");
        
				if (jQuery('input[name="product_excel_upload"]').length > 0) {
					jQuery('input[name="product_excel_upload"]').trigger("click");
				}
			}
			else {
				window.location.reload();
			}
		}
	});
}

function UploadExcelData(event, form_name) {

	event.preventDefault();
	if (jQuery('div.alert').length > 0) {
		jQuery('div.alert').remove();
	}
	if (jQuery('span.infos').length > 0) {
		jQuery('span.infos').remove();
	}
	if (jQuery('.submit_button').length > 0) {
		jQuery('.submit_button').attr('disabled', true);
	}
	if (jQuery('#excel_upload_details_table').find('tbody').find('tr.excel_row').length > 0) {
		jQuery('html, body').animate({
			scrollTop: (jQuery('.add_update_excel_form_content_excel').parent().parent().offset().top)
		}, 500);
		jQuery('form[name="' + form_name + '"]').find('.row:first').before('<div class="alert alert-danger mb-3"> <button type="button" class="close" data-dismiss="alert">&times;</button> Processing </div>');
		let file_name = "product";
		
		var excel_upload_type = "";
		if (jQuery('input[name="excel_upload_type"]').length > 0) {
			excel_upload_type = jQuery('input[name="excel_upload_type"]').val();
		}
		var check_login_session = 1;
		var post_url = "dashboard_changes.php?check_login_session=1";
		jQuery.ajax({
			url: post_url, success: function (check_login_session) {
				if (check_login_session == 1) {
					if (parseInt(excel_upload_type) == 1) {
						var post_url ="product_changes.php?clear_product_tables=1";
						jQuery.ajax({
							url: post_url, success: function (result) {
								setTimeout(function () {
									var upload_row_index = "";
									var row_index = 0;
									if (jQuery('.excel_upload_details_table').find('tr').find('.status').find('.fa-check').length > 0) {
										row_index = jQuery('.excel_upload_details_table').find('tr').find('.status').find('.fa-check').length;
									}
									upload_row_index = parseInt(row_index) + 1;
									UploadExcelRow(form_name, upload_row_index,file_name);
								}, 500);
							}
						});
					}
					else {
						setTimeout(function () {
							var upload_row_index = "";
							if (jQuery('input[name="upload_row_index"]').length > 0) {
								upload_row_index = jQuery('input[name="upload_row_index"]').val();
							}
							UploadExcelRow(form_name, upload_row_index,file_name);
						}, 500);
					}
				}
				else {
					window.location.reload();
				}
			}
		});
	}
	else {
		jQuery('form[name="' + form_name + '"]').find('.row:first').before('<div class="alert alert-danger mb-3"> <button type="button" class="close" data-dismiss="alert">&times;</button> Upload the file </div>');
		if (jQuery('.submit_button').length > 0) {
			jQuery('.submit_button').attr('disabled', false);
		}
	}
}

function UploadExcelRow(form_name, row_index,file_name) {
	var check_login_session = 1; var upload_count = 0;
	var post_url = "dashboard_changes.php?check_login_session=1";
	jQuery.ajax({
		url: post_url, success: function (check_login_session) {
			if (check_login_session == 1) {
				if (jQuery('#excel_upload_details_table').find('tbody').find('tr:nth-child(' + row_index + ')').length > 0) {
					if (row_index != 1) {
						var pos = "";
						pos = parseInt(row_index) - 1;
						jQuery('html, body').animate({
							scrollTop: (jQuery('#excel_upload_details_table').find('tbody').find('tr:nth-child(' + pos + ')').offset().top)
						}, 500);
					}

					var excel_row = "";
					excel_row = jQuery('#excel_upload_details_table').find('tbody').find('tr:nth-child(' + row_index + ')');

                    var product_name = "";
					if (jQuery(excel_row).find('input[name="product_names"]').length > 0) {
						product_name = jQuery(excel_row).find('input[name="product_names"]').val();
						product_name = clean_value(product_name);
						product_name = jQuery.trim(product_name);
					}

					
					var unit_names = "";
					if (jQuery(excel_row).find('input[name="unit_names"]').length > 0) {
						unit_names = jQuery(excel_row).find('input[name="unit_names"]').val();
						unit_names = clean_value(unit_names);
						unit_names = jQuery.trim(unit_names);
					}

					var size_names = "";
					if (jQuery(excel_row).find('input[name="size_names"]').length > 0) {
						size_names = jQuery(excel_row).find('input[name="size_names"]').val();
						size_names = clean_value(size_names);
						size_names = jQuery.trim(size_names);
					}

					
					var hsn_code = "";
					if (jQuery(excel_row).find('input[name="hsn_code"]').length > 0) {
						hsn_code = jQuery(excel_row).find('input[name="hsn_code"]').val();
						hsn_code = clean_value(hsn_code);
						hsn_code = jQuery.trim(hsn_code);
					}

					var product_tax = "";
					if (jQuery(excel_row).find('input[name="product_tax"]').length > 0) {
						product_tax = jQuery(excel_row).find('input[name="product_tax"]').val();
						product_tax = clean_value(product_tax);
						product_tax = jQuery.trim(product_tax);
					} 		
					
					var description = "";
					if (jQuery(excel_row).find('input[name="description"]').length > 0) {
						description = jQuery(excel_row).find('input[name="description"]').val();
						description = clean_value(description);
						description = jQuery.trim(description);
					} 		

					var excel_upload_type = "";
					if (jQuery('input[name="excel_upload_type"]').length > 0) {
						excel_upload_type = jQuery('input[name="excel_upload_type"]').val();
					}

					jQuery(excel_row).find('.excel_upload_status').html('<i class="fa fa-spinner fa-spin" style="color: blue; font-size: 15px; line-height: 15px;"></i>');

					var post_url = "product_upload.php?product_names=" + product_name +  "&unit_names=" + unit_names  +  "&size_names=" + size_names+  "&excel_upload_type=" + excel_upload_type + "&file_name=" + file_name+ "&hsn_code=" + hsn_code + "&product_tax=" + product_tax + "&description=" + description ;
					jQuery.ajax({
						url: post_url, success: function (result) {
							if (result == 1) {
								jQuery(excel_row).find('.excel_upload_status').html('<i class="fa fa-check" style="color: green; font-size: 15px; line-height: 15px;"></i>');
								setTimeout(function () {
									if (jQuery('.excel_upload_details').length > 0) {
										jQuery('.excel_upload_details').css({ "display": "block" });

										upload_count = jQuery('#excel_upload_details_table').find('tbody').find('.fa-check').length;

										if (jQuery('.excel_upload_count').length > 0) {
											jQuery('.excel_upload_count').html(upload_count);
										}
									}
									row_index = parseInt(row_index) + 1;
									if (jQuery('input[name="upload_row_index"]').length > 0) {
										jQuery('input[name="upload_row_index"]').val(row_index);
									}
									UploadExcelRow(form_name, row_index,file_name);
								}, 500);
							}
							else {
								if (jQuery('div.alert').length > 0) {
									jQuery('div.alert').remove();
								}
								// if (jQuery('span.infos').length > 0) {
								// 	jQuery('span.infos').remove();
								// }
								if (jQuery('.submit_button').length > 0) {
									jQuery('.submit_button').attr('disabled', false);
								}
								setTimeout(function () {
									jQuery(excel_row).find('.excel_upload_status').html('<span class="infos"> <i class="fa fa-close"></i> ' + result + '</span>');
									row_index = parseInt(row_index) + 1;
									if (jQuery('input[name="upload_row_index"]').length > 0) {
										jQuery('input[name="upload_row_index"]').val(row_index);
									}
									UploadExcelRow(form_name, row_index,file_name);
								}, 500);
								jQuery('.back_button').removeClass("d-none");

							}
						}
					});
				}
				else {
					jQuery('html, body').animate({
						scrollTop: (jQuery('.add_update_excel_form_content_excel').parent().parent().offset().top)
					}, 500);
					if (jQuery('div.alert').length > 0) {
						jQuery('div.alert').remove();
					}
					jQuery('form[name="' + form_name + '"]').find('.row:first').before('<div class="alert alert-success"> <button type="button" class="close" data-dismiss="alert">&times;</button> Updated Successfully </div>');
				}
			}
			else {
				// window.location.reload();
			}
			var uploaded_count = ""; var total_row_count = "";

			if (jQuery('.excel_upload_count').length > 0) {
				uploaded_count = jQuery('.excel_upload_count').html();
			}

			if (jQuery('.excel_upload_total_count').length > 0) {
				total_row_count = jQuery('.excel_upload_total_count').html();
			}

			if ((uploaded_count != "" && (total_row_count != "")) && (uploaded_count == total_row_count)) {

				if (jQuery('.excel_upload_details').length > 0) {
					jQuery('.excel_upload_details').css({ "display": "none" });
				}
				if (jQuery('.back_button').length > 0) {
					jQuery('.back_button').css({ "display": "none" });
				}
				jQuery('form[name="' + form_name + '"]').before('<div class="alert alert-success" style="width:75%; margin-left:32px;"> <button type="button" class="close" data-dismiss="alert">&times;</button> All Product are successfully uploaded </div>');
				window.location = "product.php";
			}
		}
	});
}

function getExcelData(obj, file_name) {
	var count = jQuery(obj).get(0).files.length;
    
	if (parseInt(count) > 0) {
    
		if (jQuery('#excel_div').length > 0) {
			jQuery('#excel_div').addClass('d-none');
		}
		if (jQuery('#table_listing_records').length > 0) {
			jQuery('#table_listing_records').addClass("d-none");
		}

		var fileName = jQuery(obj).get(0).files[0];
		var idxDot = fileName.name.lastIndexOf(".") + 1;
		var extFile = fileName.name.substr(idxDot, fileName.name.length).toLowerCase();
		if (extFile == "xls" || extFile == "xlsx") {
			var reader = new FileReader();
			reader.readAsArrayBuffer(fileName);
			reader.onload = function (event) {
				var data = new Uint8Array(event.target.result);
				var workbook = "";
				if (extFile == "xlsx") {
					workbook = XLSX.read(data, { type: 'array' });
				}
				else if (extFile == "xls") {
					workbook = XLS.read(data, { type: 'array' });
				}

				var sheet_name_list = workbook.SheetNames;
				var s = 0;
				sheet_name_list.forEach(function (y) {
					var Sheet = workbook.Sheets[workbook.SheetNames[s]];
					var result = XLSX.utils.sheet_to_json(Sheet, { header: 1 });

					const nonEmptyRows = result.filter(row => row.some(cell => cell !== undefined && cell !== null && cell !== ''));
					const usedRowsCount = nonEmptyRows.length;

					if (usedRowsCount != "" && usedRowsCount != undefined) {
						if ($('.excel_upload_total_count').length > 0) {
							$('.excel_upload_total_count').html(usedRowsCount - 1);
						}
					}


					var pages = JSON.stringify(result);
					var data_array = $.parseJSON(pages);


					var category_index = 0; var product_index = 0;
					var each_product = new Array(); var product_list = new Array(); var category_product_list = new Array();
					if (data_array.length > 0 && data_array != '' && typeof data_array != 'undefined') {
						getExcelRow('0', '1', data_array,file_name);
					}
				});
				s = parseInt(s) + 1;
				jQuery('html, body').animate({
					scrollTop: (jQuery('.submit_button').parent().offset().top)
				}, 500);
				if (jQuery('.submit_button').length > 0) {
					jQuery('.submit_button').attr('disabled', false);
				}
			};
		}
		else {
			if (jQuery('.custom-file').parent().find('infos').length == 0) {
				jQuery('.custom-file').parent().append('<span class="infos">Upload Excel File Only</span>');
			}
		}
	}
}

function getExcelRow(start_row_index, row_index, data_array,file_name) {
	
	if (parseInt(row_index) < parseInt(data_array.length)) {
		var row_values = data_array[row_index];
		if (row_values.length > 0 && row_values != '' && typeof row_values != 'undefined') {
			if (row_values['0'] != "undefined") {
				row_values['0'] = clean_value(row_values['0']);
			}
			if (row_values['1'] != "undefined") {
				row_values['1'] = clean_value(row_values['1']);
			}
			if (row_values['2'] != "undefined") {
				row_values['2'] = clean_value(row_values['2']);
			}
			if (row_values['3'] != "undefined") {
				row_values['3'] = clean_value(row_values['3']);
			}
			if (row_values['4'] != "undefined") {
				row_values['4'] = clean_value(row_values['4']);
			}
			if (row_values['5'] != "undefined") {
				row_values['5'] = clean_value(row_values['5']);
			}
			if (row_values['6'] != "undefined") {
				row_values['6'] = clean_value(row_values['6']);
			}
			
			
			var row_values = JSON.stringify(row_values);

			var check_login_session = 1;
			var post_url = "dashboard_changes.php?check_login_session=1";
			jQuery.ajax({
				url: post_url, success: function (check_login_session) {
					if (check_login_session == 1) {
						var excel_row_index = parseInt(start_row_index) + 1;

						var upload_type = "";
						if (jQuery('input[name="upload_type"]').length > 0) {
							upload_type = jQuery('input[name="upload_type"]').val();
						}
						var post_url = "product_upload.php?excel_row_index=" + excel_row_index + "&excel_row_values=" + row_values + "&upload_type=" + upload_type + "&file_name=" + file_name;
						jQuery.ajax({
							url: post_url, success: function (result) {
								if (jQuery('#excel_upload_details_table').find('tbody').length > 0) {
									jQuery('#excel_upload_details_table').find('tbody').append(result);

									setTimeout(function () {
										row_index = parseInt(row_index) + 1;
										getExcelRow(excel_row_index, row_index, data_array,file_name);
									}, 500);
								}
							}
						});
					}
					else {
						window.location.reload();
					}
				}
			});
		}
		else {
			getExcelRow('0', parseInt(row_index) + 1, data_array);
		}
	}
}

function clean_value(string) {
	if (string != "" && string != "undefined" && string != null) {
		string = jQuery.trim(string);
		if (string.indexOf('"') != -1) {
			string = string.replaceAll('"', '__');
		}
		if (string.indexOf("'") != -1) {
			string = string.replaceAll("'", '_');
		}
		if (string.indexOf("&") != -1) {
			string = string.replaceAll("&", '___');
		}
		if (string.indexOf("+") != -1) {
			string = string.replaceAll("+", '____');
		}
		if (string.indexOf("#") != -1) {
			string = string.replaceAll("#", '_____');
		}
		string = jQuery.trim(string);
	}
	return string
}

