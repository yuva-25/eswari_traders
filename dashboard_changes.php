<?php
    include("include_files.php");
    
    if(isset($_REQUEST['check_login_session'])) {
		$check_login_session = $_REQUEST['check_login_session'];

		if($check_login_session == 1) {
			$check_login_session = 1; $login_user_id = "";
			if(!empty($_SESSION)) {
				$login_user_id = $obj->checkUser();
				if(!empty($login_user_id)) {
					if($login_user_id != $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id']) {
						$check_login_session = 0;
					}
				}
				else {
					$check_login_session = 0;
				}
			}
			else {
				$check_login_session = 0;
			}
			echo $check_login_session;
			exit;
		}
	}

	if(isset($_REQUEST['get_backup'])) {
		$get_backup = $_REQUEST['get_backup'];
		if(!empty($get_backup) && $get_backup == 1) {
			$backup = $obj->daily_db_backup();
			echo $backup;
			exit;
		}
	}
?>