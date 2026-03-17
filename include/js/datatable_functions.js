
function CreationDatatable(changes_file, tableId, processing, ordering, searching, orderable, targets, columns) {
    if (jQuery.fn.DataTable.isDataTable('#' + tableId)) {
        jQuery('#' + tableId).DataTable().destroy();
    }

    var pagination_option = true;
    if (tableId == "current_stock_table" || tableId == "current_stock_table1" || tableId == "purchase_report_table" || tableId == "purchase_report_table1") {
        pagination_option = false;
    }
    // Show export buttons only for these files
    var showExportButtons = [
        'receipt_changes.php'
    ].includes(changes_file);

    var table = jQuery('#' + tableId).DataTable({
        "processing": processing,
        "serverSide": true,
        "ordering": ordering,
        "searching": searching,
        "columnDefs": [
            { "orderable": orderable, "targets": targets }
        ],
        "paging": pagination_option,
        "ajax": {
            "url": changes_file,
            "type": "POST",
            "data": function (d) {
                if (jQuery('input[name="search_text"]').length > 0) {
                    d.search_text = jQuery('input[name="search_text"]').val();
                }
                if (jQuery('select[name="filter_party_id"]').length > 0) {
                    d.filter_party_id = jQuery('select[name="filter_party_id"]').val();
                }
                if (jQuery('select[name="filter_party_type"]').length > 0) {
                    d.filter_party_type = jQuery('select[name="filter_party_type"]').val();
                }
                if (jQuery('select[name="filter_group_id"]').length > 0) {
                    d.filter_group_id = jQuery('select[name="filter_group_id"]').val();
                }
                if (jQuery('select[name="filter_member_id"]').length > 0) {
                    d.filter_member_id = jQuery('select[name="filter_member_id"]').val();
                }
                if (jQuery('select[name="filter_category_id"]').length > 0) {
                    d.filter_category_id = jQuery('select[name="filter_category_id"]').val();
                }
                if (jQuery('select[name="filter_unit_id"]').length > 0) {
                    d.filter_unit_id = jQuery('select[name="filter_unit_id"]').val();
                }
                if (jQuery('select[name="filter_payment_mode_id"]').length > 0) {
                    d.filter_payment_mode_id = jQuery('select[name="filter_payment_mode_id"]').val();
                }
                if (jQuery('select[name="filter_bank_id"]').length > 0) {
                    d.filter_bank_id = jQuery('select[name="filter_bank_id"]').val();
                }
                if (jQuery('select[name="filter_product_id"]').length > 0) {
                    d.filter_product_id = jQuery('select[name="filter_product_id"]').val();
                }
                if (jQuery('select[name="filter_type_id"]').length > 0) {
                    d.filter_type_id = jQuery('select[name="filter_type_id"]').val();
                }
                if (jQuery('select[name="filter_godown_id"]').length > 0) {
                    d.filter_godown_id = jQuery('select[name="filter_godown_id"]').val();
                }
                if (jQuery('select[name="filter_brand_id"]').length > 0) {
                    d.filter_brand_id = jQuery('select[name="filter_brand_id"]').val();
                }
                if (jQuery('select[name="filter_magazine_id"]').length > 0) {
                    d.filter_magazine_id = jQuery('select[name="filter_magazine_id"]').val();
                }
                if (jQuery('select[name="filter_vendor_id"]').length > 0) {
                    d.filter_vendor_id = jQuery('select[name="filter_vendor_id"]').val();
                }
                if (jQuery('select[name="filter_party_id"]').length > 0) {
                    d.filter_party_id = jQuery('select[name="filter_party_id"]').val();
                }
                if (jQuery('input[name="filter_from_date"]').length > 0) {
                    d.filter_from_date = jQuery('input[name="filter_from_date"]').val();
                }
                if (jQuery('input[name="to_date"]').length > 0) {
                    d.to_date = jQuery('input[name="to_date"]').val();
                }
                if (jQuery('input[name="show_bill"]').length > 0) {
                    d.show_bill = jQuery('input[name="show_bill"]').val();
                }
                if (jQuery('input[name="from_date"]').length > 0) {
                    d.from_date = jQuery('input[name="from_date"]').val();
                }
                if (jQuery('input[name="filter_to_date"]').length > 0) {
                    d.filter_to_date = jQuery('input[name="filter_to_date"]').val();
                }
                if (jQuery('input[name="search_text"]').length > 0) {
                    d.search_text = jQuery('input[name="search_text"]').val();
                }
                if (jQuery('.tab-pane.active').find('input[name="cancelled"]').length > 0) {
                    d.cancelled = jQuery('.tab-pane.active').find('input[name="cancelled"]').val();
                }
                if (jQuery('select[name="from_godown_id"]').length > 0) {
                    d.from_godown_id = jQuery('select[name="from_godown_id"]').val();
                }
                if (jQuery('select[name="to_godown_id"]').length > 0) {
                    d.to_godown_id = jQuery('select[name="to_godown_id"]').val();
                }
                if (jQuery('select[name="filter_group_id"]').length > 0) {
                    d.filter_group_id = jQuery('select[name="filter_group_id"]').val();
                }
                if (jQuery('select[name="filter_category_id"]').length > 0) {
                    d.filter_category_id = jQuery('select[name="filter_category_id"]').val();
                }

            },
            "dataSrc": function (json) {
                let tableElement = jQuery('#' + tableId);

                if (json.summary && tableElement.find('thead').length > 0) {
                    let theadCells = tableElement.find('thead');

                    if (theadCells.find('.product_header').length > 0) {
                        theadCells.find('.product_header').html(json.summary.product_header ?? '');
                    }
                }

                if (json.summary && tableElement.find('tfoot').length > 0) {
                    let tfootCells = tableElement.find('tfoot');

                    if (tfootCells.find('.total_unit').length > 0) {
                        tfootCells.find('.total_unit').html(json.summary.total_unit ?? '');
                    }
                    if (tfootCells.find('.total_subunit').length > 0) {
                        tfootCells.find('.total_subunit').html(json.summary.total_subunit ?? '');
                    }
                    if (tfootCells.find('.total_inward').length > 0) {
                        tfootCells.find('.total_inward').html(json.summary.total_inward ?? '');
                    }
                    if (tfootCells.find('.total_outward').length > 0) {
                        tfootCells.find('.total_outward').html(json.summary.total_outward ?? '');
                    }
                    if (tfootCells.find('.balance').length > 0) {
                        tfootCells.find('.balance').html(json.summary.balance ?? '');
                    }
                }

                return json.data;
            }
        },
        "columns": columns
    });
    return table;
}

function getFilterGroupByMaterialType() {
    var filter_material_type = "";
    if (jQuery('select[name="filter_material_type"]').length > 0) {
        filter_material_type = jQuery('select[name="filter_material_type"]').val();
        filter_material_type = jQuery.trim(filter_material_type);
    }
    var post_url = "common_changes.php?GetGroupForMaterial=" + filter_material_type;
    jQuery.ajax({
        url: post_url, success: function (result) {
            if (result == 'invalid_user') {
                window.location.reload();
            } else {
                result = jQuery.parseJSON(result);
                if (result != '' && result != null) {
                    if ($('select[name="filter_group_id"]').length > 0) {
                        $('select[name="filter_group_id"]').empty().html(result);
                        selectNonEmptyOption('filter_group_id');

                        if (jQuery('.tab-pane.active .datatable').length > 0) {
                            jQuery('.tab-pane.active .datatable').DataTable().ajax.reload();
                        }
                        else if (jQuery('.report_table').length > 0) {
                            var visible_table = "";
                            visible_table = jQuery('.table-responsive:not(.d-none) table.datatable').attr('id');
                            jQuery('#' + visible_table).DataTable().ajax.reload();
                        }
                        else if (jQuery('.datatable').length > 0) {
                            jQuery('.datatable').DataTable().ajax.reload();
                        }
                    }
                }
            }

        }
    });
}

function getFilterCategoryByGroup() {
    var filter_group_id = "";
    if (jQuery('select[name="filter_group_id"]').length > 0) {
        filter_group_id = jQuery('select[name="filter_group_id"]').val();
        filter_group_id = jQuery.trim(filter_group_id);
    }
    var post_url = "common_changes.php?GetCategoryForGroup=" + filter_group_id;
    jQuery.ajax({
        url: post_url,
        success: function (result) {
            if (result == 'invalid_user') {
                window.location.reload();
            } else if (result != '') {
                try {
                    result = JSON.parse(result);
                    if (result) {
                        if ($('select[name="filter_category_id"]').length > 0) {
                            $('select[name="filter_category_id"]').html(result);
                            selectNonEmptyOption('filter_category_id');

                            if (jQuery('.tab-pane.active .datatable').length > 0) {
                                jQuery('.tab-pane.active .datatable').DataTable().ajax.reload();
                            }
                            else if (jQuery('.report_table').length > 0) {
                                var visible_table = "";
                                visible_table = jQuery('.table-responsive:not(.d-none) table.datatable').attr('id');
                                jQuery('#' + visible_table).DataTable().ajax.reload();
                            }
                            else if (jQuery('.datatable').length > 0) {
                                jQuery('.datatable').DataTable().ajax.reload();
                            }
                        }
                    }
                } catch (e) {
                    console.error('JSON parse error:', e);
                    console.log('Server response:', result);
                }
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', error);
        }
    });
}

function getFilterProductByCategory() {
    var filter_category_id = "";
    if (jQuery('select[name="filter_category_id"]').length > 0) {
        filter_category_id = jQuery('select[name="filter_category_id"]').val();
        filter_category_id = jQuery.trim(filter_category_id);
    }
    var post_url = "common_changes.php?GetProductForCategory=" + filter_category_id;
    jQuery.ajax({
        url: post_url,
        success: function (result) {
            if (result == 'invalid_user') {
                window.location.reload();
            } else if (result != '') {
                try {
                    result = JSON.parse(result);
                    if (result) {
                        if ($('select[name="filter_product_id"]').length > 0) {
                            $('select[name="filter_product_id"]').html(result);
                            selectNonEmptyOption('filter_product_id');
                            if (jQuery('.tab-pane.active .datatable').length > 0) {
                                jQuery('.tab-pane.active .datatable').DataTable().ajax.reload();
                            }
                            else if (jQuery('.report_table').length > 0) {
                                var visible_table = "";
                                visible_table = jQuery('.table-responsive:not(.d-none) table.datatable').attr('id');
                                jQuery('#' + visible_table).DataTable().ajax.reload();
                            }
                            else if (jQuery('.datatable').length > 0) {
                                jQuery('.datatable').DataTable().ajax.reload();
                            }
                        }
                    }
                } catch (e) {
                    console.error('JSON parse error:', e);
                    console.log('Server response:', result);
                }
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', error);
        }
    });
}



function getFilteryByGroup() {
    var filter_type_id = "";
    if (jQuery('select[name="filter_type_id"]').length > 0) {
        filter_type_id = jQuery('select[name="filter_type_id"]').val();
        filter_type_id = jQuery.trim(filter_type_id);
    }
    var post_url = "common_changes.php?GetTypeGroup=" + filter_type_id;
    jQuery.ajax({
        url: post_url,
        success: function (result) {
            if (result == 'invalid_user') {
                window.location.reload();
            } else if (result != '') {
                try {
                    result = JSON.parse(result);
                    if (result) {
                        if ($('select[name="filter_type_id"]').length > 0) {
                            $('select[name="filter_type_id"]').html(result);
                            selectNonEmptyOption('filter_type_id');

                            if (jQuery('.tab-pane.active .datatable').length > 0) {
                                jQuery('.tab-pane.active .datatable').DataTable().ajax.reload();
                            }
                            else if (jQuery('.report_table').length > 0) {
                                var visible_table = "";
                                visible_table = jQuery('.table-responsive:not(.d-none) table.datatable').attr('id');
                                jQuery('#' + visible_table).DataTable().ajax.reload();
                            }
                            else if (jQuery('.datatable').length > 0) {
                                jQuery('.datatable').DataTable().ajax.reload();
                            }
                        }
                    }
                } catch (e) {
                    console.error('JSON parse error:', e);
                    console.log('Server response:', result);
                }
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', error);
        }
    });
}