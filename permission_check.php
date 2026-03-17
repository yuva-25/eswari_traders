<?php
    if(!empty($login_staff_id) && !empty($permission_module)) {
        $check_role_id = "";
        $check_role_id = $obj->getTableColumnValue($GLOBALS['user_table'], 'user_id', $login_staff_id, 'role_id');
        $access_page_permission = 0;					
        $access_page_permission = $obj->CheckRoleAccessPage($GLOBALS['bill_company_id'],$check_role_id, $permission_module);
        if(empty($access_page_permission)) {
            header("Location:dashboard.php");
            exit;
        }
    }
?>