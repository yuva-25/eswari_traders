<?php
	/*require 'mailin_sms/sms_api.php';
	$GLOBALS['mailin_sms_api_key'] = "zaG0R7cJBhkUbf54";*/

	date_default_timezone_set('Asia/Calcutta');
	$GLOBALS['create_date_time_label'] = date('Y-m-d H:i:s');
	$GLOBALS['site_name_user_prefix'] = $_SERVER['SERVER_NAME']."_eswari_traders".date("d-m-Y"); $GLOBALS['user_id'] = ""; $GLOBALS['creator'] = "";
	$GLOBALS['creator_name'] = ""; $GLOBALS['bill_company_id'] = ""; $GLOBALS['null_value'] = "NULL";

	$GLOBALS['page_number'] = 1; $GLOBALS['page_limit'] = 10; $GLOBALS['page_limit_list'] = array("10", "25", "50", "100");
	$GLOBALS['max_log_file_count'] = 5; $GLOBALS['max_log_file_size_mb'] = 10; $GLOBALS['expire_log_file_days'] = 90;

	$GLOBALS['secret_key'] = "eswari_traders_2026"; 
	$GLOBALS['salt_length'] = 8;
	$GLOBALS['max_company_count'] = 1;
	$GLOBALS['max_user_count'] = 10;
	$GLOBALS['max_role_count'] = 5;
	$GLOBALS['stock_action_plus'] = "Plus"; $GLOBALS['stock_action_minus'] = "Minus";

	$GLOBALS['backup_folder_name'] = 'backup'; $GLOBALS['log_backup_folder_name'] = 'backup/logs';
	$GLOBALS['log_backup_file'] = $GLOBALS['backup_folder_name']."/logs/".date("Y").".csv"; 
	
	// Tables
	$table_prefix = "eswari_traders_";
	$GLOBALS['table_prefix'] = $table_prefix;
	$GLOBALS['company_table'] = $table_prefix."company"; 
	$GLOBALS['login_table'] = $table_prefix."login"; 
	$GLOBALS['user_table'] = $table_prefix."user"; 
	$GLOBALS['role_table'] = $table_prefix."role";
	$GLOBALS['role_permission_table'] = $table_prefix."role_permission";
	$GLOBALS['unit_table'] = $table_prefix."unit";
	$GLOBALS['size_table'] = $table_prefix."size";
	$GLOBALS['payment_mode_table'] = $table_prefix."payment_mode";
	$GLOBALS['bank_table'] = $table_prefix."bank";
	$GLOBALS['party_table'] = $table_prefix."party";
	$GLOBALS['product_table'] = $table_prefix."product";
	$GLOBALS['order_form_table'] = $table_prefix."order_form";
	$GLOBALS['estimate_table'] = $table_prefix."estimate";
	$GLOBALS['stock_table'] = $table_prefix."stock";
	$GLOBALS['invoice_table'] = $table_prefix."invoice";
	$GLOBALS['payment_table'] = $table_prefix."payment";
	$GLOBALS['voucher_table'] = $table_prefix."voucher";
	$GLOBALS['receipt_table'] = $table_prefix."receipt";
	$GLOBALS['quotation_table'] = $table_prefix."quotation";
	$GLOBALS['purchase_table'] = $table_prefix."purchase";




	


	$GLOBALS['Reset_to_one'] = "Reset To 1"; $GLOBALS['continue_last_number'] = "Continue from last number"; $GLOBALS['custom_number'] = "Custom Number";
	
	$GLOBALS['admin_user_type'] = "Super Admin"; $GLOBALS['staff_user_type'] = "Staff";

	if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id']) && isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'])) {
		$GLOBALS['creator'] = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'];
	}

	if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name']) && isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name'])) {
		$GLOBALS['creator_name'] = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name'];
	}

	if(!empty($_SESSION['bill_company_id']) && isset($_SESSION['bill_company_id'])) {
		$GLOBALS['bill_company_id'] = $_SESSION['bill_company_id'];
	}

	if(isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type']) && !empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type'])) {
		$GLOBALS['user_type'] = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type'];
	}

	// Modules
	$GLOBALS['payment_mode_module'] = 'PaymentMode';
	$GLOBALS['bank_module'] = 'Bank';
	$GLOBALS['unit_module'] = 'Unit'; 
	$GLOBALS['size_module'] = 'Size'; 
	$GLOBALS['party_module'] = 'Party'; 
	$GLOBALS['product_module'] = 'Product'; 
	$GLOBALS['order_form_module'] = 'OrderForm'; 
	$GLOBALS['estimate_module'] = 'Estimate'; 
	$GLOBALS['invoice_module'] = 'Invoice'; 
	$GLOBALS['voucher_module'] = 'Voucher';
	$GLOBALS['receipt_module'] = 'Receipt';
	$GLOBALS['quotation_module'] = 'Quotation';
	$GLOBALS['purchase_module'] = 'Purchase';

	$GLOBALS['reports_module'] = 'Reports'; 
	

	// User Access Modules
	$user_access_list = array();
	
	$user_access_list[] = $GLOBALS['payment_mode_module'];
	$user_access_list[] = $GLOBALS['bank_module'];
	$user_access_list[] = $GLOBALS['unit_module'];
	$user_access_list[] = $GLOBALS['size_module'];
	$user_access_list[] = $GLOBALS['party_module'];
	$user_access_list[] = $GLOBALS['product_module'];
	$user_access_list[] = $GLOBALS['order_form_module'];
	$user_access_list[] = $GLOBALS['estimate_module'];
	$user_access_list[] = $GLOBALS['invoice_module'];
	$user_access_list[] = $GLOBALS['voucher_module'];
	$user_access_list[] = $GLOBALS['receipt_module'];
	$user_access_list[] = $GLOBALS['quotation_module'];
	$user_access_list[] = $GLOBALS['purchase_module'];

	$user_access_list[] = $GLOBALS['reports_module'];


	$GLOBALS['access_pages_list'] = $user_access_list;
?>