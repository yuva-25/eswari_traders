<?php
    if(!empty($login_staff_id) && !empty($permission_module) && !empty($permission_action)){

        $role_id = "";
        $role_id = $obj->getTableColumnValue($GLOBALS['user_table'],'user_id',$login_staff_id,'role_id');
        $access_page_action = "";
        $access_page_action = $obj->accessPageAction($GLOBALS['bill_company_id'],$role_id,$permission_module);
        $module_action = array();
        $module_action = str_split($access_page_action);
        if(!empty($module_action)){
            if(!in_array($permission_action, $module_action)){
                if($permission_action == $view_action) {
                    $view_access_error = "You don't have permission to view ".strtolower($permission_module);
                }
                else if($permission_action == $add_action) {
                    
                    $add_access_error = "You don't have permission to add ".strtolower($permission_module);
                }
                else if($permission_action == $edit_action) {
                    $edit_access_error = "You don't have permission to edit ".strtolower($permission_module);
                }
                else if($permission_action == $delete_action) {
                    $delete_access_error = "You don't have permission to delete ".strtolower($permission_module);
                }
            }
        }
    }
?>