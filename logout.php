<?php 
 	ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    $page = "Dashboard";
    include("include_user_check_and_files.php");

	$backup = "";
	$backup = $obj->daily_db_backup();

	$msg = "";
	if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_login_record_id'])) {
		$create_date_time = $GLOBALS['create_date_time_label'];		
		if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_login_record_id']) && isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_login_record_id'])) {
			$columns = array('logout_date_time');
			$values = array($create_date_time);
			$msg = $obj->UpdateSQL($GLOBALS['login_table'], $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_login_record_id'], $columns, $values, '');
		}		
		if(preg_match("/^\d+$/", $msg)) {
			session_destroy();	
			header("Location:index.php?success_msg=You have successfully logged out");
			exit;
		}
		else {			
			session_destroy();	
			header("Location:index.php?failure_msg=".$msg);
			exit;
		}	
	}
	else {
		session_destroy();	
		header("Location:index.php?success_msg=You have successfully logged out");
		exit;
	}
?>