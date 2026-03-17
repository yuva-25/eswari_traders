<?php
	include("include_files.php");
	if(isset($_REQUEST['show_role_id'])) {  
        $show_role_id = $_REQUEST['show_role_id'];
        $show_role_id = trim($show_role_id);        
        $role_name = ""; $access_pages = ""; $access_page_actions = ""; $incharger = 0;
        if(!empty($show_role_id)) {
            $role_list = array();
            $role_list = $obj->getTableRecords($GLOBALS['role_table'], 'role_id', $show_role_id, '');
            if(!empty($role_list)) {
                foreach($role_list as $data) {
                    if(!empty($data['role_name']) && $data['role_name'] != $GLOBALS['null_value']) {
                         $role_name = $obj->encode_decode('decrypt',$data['role_name']);
                    }
                    if(!empty($data['access_pages']) && $data['access_pages'] != $GLOBALS['null_value']) {
						$access_pages = explode(",", $data['access_pages']);
					}
					if(!empty($data['access_page_actions']) && $data['access_page_actions'] != $GLOBALS['null_value']) {
						$access_page_actions = explode(",", $data['access_page_actions']);
					}
                    if(!empty($data['incharger']) && $data['incharger'] != $GLOBALS['null_value']) {
                        $incharger = $data['incharger'];
                    }
                }
            }
        }
            $total_role_list = array();
            $total_role_list = $obj->getTableRecords($GLOBALS['role_table'], '', '', '');   
            $role_count = count($total_role_list);
            if(empty($role_count)){
                $role_name = "Super Admin";
            }
        
        $access_pages_list = $GLOBALS['access_pages_list'];     
        
?>
        <form class="poppins pd-20 redirection_form" name="role_form" method="POST">
			<div class="card-header">
				<div class="row p-2">
					<div class="col-lg-8 col-md-8 col-8 align-self-center">
                        <?php if(empty($show_role_id)) { ?>
                            <div class="h5">Add Role</div>
                        <?php } else { ?>
                            <div class="h5">Edit Role</div>
                        <?php } ?>
					</div>
					<div class="col-lg-4 col-md-4 col-4">
						<button class="btn btn-dark float-end" style="font-size:11px;" type="button" onclick="window.open('role.php','_self')"> <i class="fa fa-arrow-circle-o-left"></i> &ensp; Back </button>
					</div>
				</div>
			</div>
            <div class="row p-3">
            <input type="hidden" name="edit_id" value="<?php if(!empty($show_role_id)) { echo $show_role_id; } ?>">
                <div class="col-lg-4 col-md-6 col-12 py-2">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                        <input type="text" name="role_name" class="form-control shadow-none" value="<?php if(!empty($role_name)) { echo $role_name; } ?>" onkeydown="Javascript:KeyboardControls(this,'text',25,1);" <?php  if(empty($role_count)){ ?> readonly <?php } ?>>
                            <label>Enter Role <span class="text-danger">*</span></label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12 col-12">
                    <?php
                        $company_list=array();
                        $company_list = $obj->getTableRecords($GLOBALS['company_table'], '', '', ''); 
                        $company_list =array_reverse($company_list); 
                        if (!empty($company_list)) {
                            $index = 0;  $applyButtonDisplay = 0; $count = 1;
                            foreach ($company_list as $data) {
                                $access_pages_list = $GLOBALS['access_pages_list'];
                                if (!empty($data['name'])) {
                                    $company_name = $obj->encode_decode('decrypt', $data['name']); 
                                    $company_id ="";
                                    if (!empty($data['company_id'])) {
                                        $company_id =  $data['company_id'];
                                    }
                                    if(!empty($role_count)){
                                    ?>
                                    
                                    <div class="table-responsive poppins p-2">
                                        <table class="table nowrap table-bordered smallfnt staff_access_table_<?php echo $count; ?>" id="staff_access_table<?php echo $count; ?>">
                                            <thead  class="bg-light">
                                                <tr class="bg-primary text-white text-center">
                                                    <th>Module</th>
                                                    <th>Permission</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                            
                                                    if (!empty($access_pages_list)) {
                                                        foreach ($access_pages_list as $module) {
                                                            if (!empty($module)) {
                                                                $str_module = "";
                                                                $str_module = $module;
                                                                $module = strtolower($module);
                                                                $module_key = $module . '_' . $count; // Concatenate module with count
                                                                $module_key_action =$module_key."_action";
                                                                    // $module_action = $module."_action";
                                                                $view_checkbox_value = 2;
                                                                $add_checkbox_value = 2;
                                                                $edit_checkbox_value = 2;
                                                                $delete_checkbox_value = 2;
                                                                $select_all_checkbox_value = 2;
                                                        
                                                                if(!empty($show_role_id)){
                                                                    
                                                                    $view_action = 'V';
                                                                    $add_action = 'A';
                                                                    $edit_action = 'E';
                                                                    $delete_action = 'D';
                                                                    $module_selected = 0;
                                                                    $module_action_value ="";

                                                                    $role_permission_array =array();
                                                                    $role_permission_array = $creation_obj->getPermissionId($company_id,$show_role_id, $str_module);
                                                                    if(!empty($role_permission_array)){
                                                                        foreach($role_permission_array as $value){
                                                                            if(!empty($value['role_permission_id'])){
                                                                                $role_permission_id =$value['role_permission_id'];
                                                                            }
                                                                            if(!empty($value['module_actions'])){
                                                                                $module_action_value =$value['module_actions'];
                                                                            }
                                                                        }
                                                                    }

                                                                    if(!empty($module_action_value)){
                                                                        
                                                                        if (strpos($module_action_value, $view_action) !== false) {
                                                                            $view_checkbox_value = 1; 
                                                                            $module_selected++;
                                                                        }
                                                            
                                                                        if (strpos($module_action_value, $add_action) !== false) {
                                                                            $add_checkbox_value = 1;  
                                                                            $module_selected++;
                                                                        }
                                                            
                                                                        if (strpos($module_action_value, $edit_action) !== false) {
                                                                            $edit_checkbox_value = 1;
                                                                            $module_selected++;
                                                                        }
                                                            
                                                                        if (strpos($module_action_value, $delete_action) !== false) {
                                                                            $delete_checkbox_value = 1;
                                                                            $module_selected++;
                                                                        }
                                                            
                                                                        if ($module_selected == 4) {
                                                                            $select_all_checkbox_value = 1;
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                                
                                                                <tr class="user_access">
                                                            
                                                                    <td><?php echo $module; ?></td>
                                                                    <td>
                                                                        <div class="d-flex mx-2" id="<?php echo $module_key . "_cover"; ?>">
                                                                            <?php if ($module != strtolower($GLOBALS['reports_module'])) { ?> 
                                                                                <div class="form-check pr-3">
                                                                                    <input class="form-check-input" type="checkbox" name="<?php echo $module_key . "_select_all"; ?>" id="<?php echo $module_key . "_select_all"; ?>" value="<?php echo $select_all_checkbox_value; ?>" <?php if ($select_all_checkbox_value == 1) { ?>checked="checked"<?php } ?> onClick="Javascript:SelectAllModuleActionToggle(this, '<?php echo $module_key; ?>');">
                                                                                    <label class="form-check-label" for="<?php echo $module_key . "_select_all"; ?>">Select All</label>
                                                                                </div>
                                                                            <?php } ?>
                                                                       
                                                                            <div class="form-check pr-3 mx-2">
                                                                                <input class="form-check-input" type="checkbox" name="<?php echo $module_key . "_view"; ?>" id="<?php echo $module_key . "_view"; ?>" value="<?php echo $view_checkbox_value; ?>" <?php if ($view_checkbox_value == 1) { ?>checked="checked"<?php } ?> onClick="Javascript:CustomCheckboxToggle(this, '<?php echo $module_key; ?>', 'V','<?php echo $count; ?>');">
                                                                                <label class="form-check-label" for="<?php echo $module_key . "_view"; ?>">View</label>
                                                                            </div>
                                                                            
                
                                                                            <?php if ($module != strtolower($GLOBALS['reports_module'])) { ?>
                                                                                <div class="form-check pr-3 mx-2">
                                                                                    <input class="form-check-input" type="checkbox" name="<?php echo $module_key . "_add"; ?>" id="<?php echo $module_key . "_add"; ?>" value="<?php echo $add_checkbox_value; ?>" <?php if ($add_checkbox_value == 1) { ?>checked="checked"<?php } ?> onClick="Javascript:CustomCheckboxToggle(this, '<?php echo $module_key; ?>', 'A','<?php echo $count; ?>');">
                                                                                    <label class="form-check-label" for="<?php echo $module_key . "_add"; ?>">Add</label>
                                                                                </div>
                                                                            <?php } ?>
                
                                                                            <?php if ($module != strtolower($GLOBALS['reports_module'])) { ?>
                                                                                <div class="form-check pr-3 mx-2">
                                                                                    <input class="form-check-input" type="checkbox" name="<?php echo $module_key . "_edit"; ?>" id="<?php echo $module_key . "_edit"; ?>" value="<?php echo $edit_checkbox_value; ?>" <?php if ($edit_checkbox_value == 1) { ?>checked="checked"<?php } ?> onClick="Javascript:CustomCheckboxToggle(this, '<?php echo $module_key; ?>', 'E','<?php echo $count; ?>');">
                                                                                    <label class="form-check-label" for="<?php echo $module_key . "_edit"; ?>">Edit</label>
                                                                                </div>
                                                                            <?php } ?>
                
                                                                            <?php if ($module != strtolower($GLOBALS['reports_module'])) { ?>
                                                                                <div class="form-check pr-3 mx-2">
                                                                                    <input class="form-check-input" type="checkbox" name="<?php echo $module_key . "_delete"; ?>" id="<?php echo $module_key . "_delete"; ?>" value="<?php echo $delete_checkbox_value; ?>" <?php if ($delete_checkbox_value == 1) { ?>checked="checked"<?php } ?> onClick="Javascript:CustomCheckboxToggle(this, '<?php echo $module_key; ?>', 'D','<?php echo $count; ?>');">
                                                                                    <label class="form-check-label" for="<?php echo $module_key . "_delete"; ?>">Delete</label>
                                                                                </div>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <input type="hidden" name="<?php echo $module_key."_action"; ?>" id="<?php echo $module_key."_action"; ?>" value="<?php if(!empty($module_action_value)){echo $module_action_value; }?>" >
                                                            <?php }
                                                        }
                                                    } 
                                                ?>
                                            </tbody>
                                        </table>
            
                                        <?php if (empty($applyButtonDisplay)) { ?>
                                            <!-- <button type="button" class="btn btn-success float-right" onclick="Javascript:applyUserAccessSettingstoAll();"> Apply to All</button> -->
                                            <?php $applyButtonDisplay = 1; ?>
                                        <?php } ?>
                                    </div>
                                    <?php $index++; $count++; 
                                    }
                                }
                            } ?>
                            <?php
                        } 
                    ?>
                </div>
                <div class="col-md-12 pt-3 text-center">
                    <button class="btn btn-danger template_button submit_button" type="button" onClick="Javascript:SaveModalContent(event,'role_form', 'role_changes.php', 'role.php');">
                        Submit
                    </button>
                </div>
            </div>
            <script src="include/select2/js/select2.min.js"></script>
            <script src="include/select2/js/select.js"></script>
        </form>
		<?php
    } 


    if(isset($_POST['role_name'])){
        $role_name = "";$role_name_error = "";
        $access_page_actions = array(); $access_pages = array(); $access_error = "";
        
        $valid_role = "";$form_name = "role_form";$type = "";$admin = "";

        $company_list = array(); $company_name="";
        $company_list = $obj->getTableRecords($GLOBALS['company_table'], '', '', ''); 
        $company_list = array_reverse($company_list); 

        $role_name = $_POST['role_name'];
        $role_name_error = $valid->valid_text($role_name,'Role Name','1', '25');
        if(!empty($role_name_error)){
            if(!empty($valid_role)){
                $valid_role = $valid_role." ".$valid->error_display($form_name,'role_name',$role_name_error,'text');
            }
            else{
                $valid_role = $valid->error_display($form_name,'role_name',$role_name_error,'text');
            }
        }
        
        if(isset($_POST['edit_id'])) {
			$edit_id = $_POST['edit_id'];
		}

        $role_list = array();
        $role_list = $obj->getTableRecords($GLOBALS['role_table'],'','', '');
        $role_list_count = "";
        $role_list_count = count($role_list);
        if(empty($role_list) && $role_list_count == 0){
            $type = $GLOBALS['admin_user_type'];
            $admin = 1;
        }
        else{
            $type = $GLOBALS['staff_user_type'];
            $admin = 0;
        }

        $access_permission_error = "";
		$access_page_error = "";
        if (!empty($company_list)) {
            $no_count = 1;$access_count = 0;
            foreach ($company_list as $row) {
                $user_access_list = $GLOBALS['access_pages_list'];
                if (!empty($user_access_list)) {
                    for($m =0; $m < count($user_access_list); $m++){
                        $module_name = "";$module_variable = "";
                        $module_name = strtolower($user_access_list[$m]);
                        if (!empty($module_name)) {
                            $module_variable = $module_name.'_'.$no_count;
                            $access_page_name = ""; 
                            $access_page_name = $module_variable."_action";
                            if(!empty($_POST[$access_page_name]) && ($type != $GLOBALS['admin_user_type'])) {
                                $access_count += 1;
                            }
                        }
                    }
                }
                $no_count++;
            }
            if($type != $GLOBALS['admin_user_type']){
                if($access_count == '0'){
                    $access_permission_error = "Select Access Permission";
                }
            }
        }

        $result = "";
        
		if(empty($valid_role) && empty($access_permission_error)) {
            if(empty($access_error)){
                $check_user_id_ip_address = "";
                $check_user_id_ip_address = $obj->check_user_id_ip_address();	
                if(preg_match("/^\d+$/", $check_user_id_ip_address)) {
                    $bill_company_id = $GLOBALS['bill_company_id'];

                    if($type == $GLOBALS['admin_user_type']){
                        $role_name = "Super Admin";
                    }

                    $lower_case_name = "";
                    if(!empty($role_name)) {
                        $lower_case_name = strtolower($role_name);
                        $role_name = $obj->encode_decode('encrypt', $role_name);
                        $lower_case_name = $obj->encode_decode('encrypt', $lower_case_name);
                    }   
                    
                    if($type == $GLOBALS['admin_user_type']){
                        $access_pages = "";
                        $access_page_actions = "";
                    }

                    if(!empty($access_pages)) {
                        $access_pages = implode(",", $access_pages);
                    }
                    if(!empty($access_page_actions)) {
                        $access_page_actions = implode(",", $access_page_actions);
                    }
                    
                    $prev_role_id = ""; $role_error = "";
                    if(!empty($lower_case_name) && !empty($bill_company_id)) {
                       $prev_role_id = $creation_obj->CheckRoleAlreadyExists($bill_company_id,$lower_case_name);
                        if(!empty($prev_role_id)){
                            $role_error = "This role name already exists";
                        }
                    }
                    if(empty($type)){
                        $type = $GLOBALS['null_value'];
                    }
                    $update_role = 0;
                    // $created_date_time = $GLOBALS['null_value'];
                    $created_date_time = $GLOBALS['create_date_time_label']; $creator = $GLOBALS['creator'];
                    $creator_name = $obj->encode_decode('encrypt', $GLOBALS['creator_name']);
                    if(empty($edit_id)) {
                        if(empty($prev_role_id)) {						
                            $action = "";
                            if(!empty($role_name)) {
                                $action = "New Role Created - ".$obj->encode_decode("decrypt",$role_name);
                            }
                            $null_value = $GLOBALS['null_value'];
                            $columns = array('created_date_time', 'updated_date_time','creator', 'creator_name', 'bill_company_id','role_id', 'role_name', 'lower_case_name','type','admin', 'deleted');
                            $values = array($created_date_time, $created_date_time, $creator, $creator_name, $bill_company_id, $null_value, $role_name, $lower_case_name,$type,$admin, 0);
                            $role_insert_id = $obj->InsertSQL($GLOBALS['role_table'], $columns, $values,'role_id', '', $action);
                            if(preg_match("/^\d+$/", $role_insert_id)) {
                                $update_role = 1;
                                $role_id =$obj->getTableColumnValue ($GLOBALS['role_table'],'id',$role_insert_id,'role_id');						
                                $result = array('number' => '1', 'msg' => 'Role Successfully Created');						
                            }
                            else {
                                $result = array('number' => '2', 'msg' => $role_insert_id);
                            }
                        }
                        else {
                            if(!empty($role_error)) {
                                $result = array('number' => '2', 'msg' => $role_error);
                            }
                        }
                    }
                    else {
                        if(empty($prev_role_id) || $prev_role_id == $edit_id) {
                            $getUniqueID = "";
                            $getUniqueID = $obj->getTableColumnValue($GLOBALS['role_table'], 'role_id', $edit_id, 'id');
                            if(preg_match("/^\d+$/", $getUniqueID)) {
                                $action = "";
                                if(!empty($role_name)) {
                                    $action = "Role Updated.";
                                }
                            
                                $columns = array(); $values = array();						
                                $columns = array('creator_name','updated_date_time','role_name', 'lower_case_name');
                                $values = array($creator_name,$created_date_time,$role_name,$lower_case_name);
                                $entry_update_id = $obj->UpdateSQL($GLOBALS['role_table'], $getUniqueID, $columns, $values, $action);
                                if(preg_match("/^\d+$/", $entry_update_id)) {	
                                    $update_role = 1;							
                                    $role_id =$obj->getTableColumnValue ($GLOBALS['role_table'],'id',$entry_update_id,'role_id');		
                                    $result = array('number' => '1', 'msg' => 'Updated Successfully');						
                                }
                                else {
                                    $result = array('number' => '2', 'msg' => $entry_update_id);
                                }							
                            }
                        }
                        else {
                            if(!empty($role_error)) {
                                $result = array('number' => '2', 'msg' => $role_error);
                            }
                        }
                    }
                    if(!empty($company_list) && $update_role == '1' && $type != $GLOBALS['admin_user_type']) {
                        $applyButtonDisplay = 0; $count = 1; $role_permission_updated = 0;
                        foreach ($company_list as $data) {
                            if (!empty($data['company_id'])) {
                                $bill_company_id = $data['company_id']; 
                            }
                            if (!empty($data['name'])) {
                                $company_name = $data['name']; 
                            }

                            if (!empty($access_pages_list)) {
                                for($m =0; $m < count($access_pages_list); $m++){
                                    $module1 = strtolower($access_pages_list[$m]);
                                    if(!empty($module1)) {

                                        $module_key = $module1.'_'.$count;
                                        $access_pages =""; 
                                        $access_pages = $module_key."_action";

                                        $access_page_actions=""; $entry_update_id = "";
                                        if(isset($_POST[$access_pages])) {
                                            $access_page_actions = $_POST[$access_pages];
                                        }
                                        $result="";
                                        if(empty($edit_id) && !empty($access_page_actions)){
                                            
                                            $action = "";
                                            if(!empty($company_name)) {
                                                $action = "New Permission Role Created - ".$obj->encode_decode("decrypt",$company_name);
                                            }
                                            $columns = array(); $values = array();
                                            $columns = array('created_date_time', 'creator', 'creator_name','role_id','role_permission_id', 'bill_company_id','module', 'module_actions','deleted');
                                            $values = array($created_date_time, $creator, $creator_name,$role_id, $null_value, $bill_company_id, $access_pages_list[$m], $access_page_actions,0);
                                            $permission_insert_id = $obj->InsertSQL($GLOBALS['role_permission_table'], $columns, $values,'role_permission_id','', $action);

                                                if(preg_match("/^\d+$/", $permission_insert_id)) {
                                                    $role_permission_updated = 1;					
                                                }
                                                else {
                                                    $role_permission_updated = $permission_insert_id;
                                                }


                                        }
                                        else {
                                            if(empty($prev_role_id) || $prev_role_id == $edit_id) {
                                                $getUniqueID = ""; $getRolePermissionRecords =array();
                                                $getUniqueID = $creation_obj->getRolePermissionId($bill_company_id,$edit_id,$access_pages_list[$m]);
                                                if(!empty($getUniqueID)){
                                                    if(preg_match("/^\d+$/", $getUniqueID)) {
                                                        $action = "";
                                                        if(!empty($role_name)) {
                                                            $action = "Role Updated.";
                                                        }
                                                        $columns = array(); $values = array();						
                                                        $columns = array('creator_name', 'module', 'module_actions');
                                                        $values = array($creator_name, $access_pages_list[$m], $access_page_actions);
                                                        $permission_update_id = $obj->UpdateSQL($GLOBALS['role_permission_table'], $getUniqueID, $columns, $values, $action);
                                                        if(preg_match("/^\d+$/", $permission_update_id)) {	
                                                            $role_permission_updated = 1;												
                                                        }
                                                        else {
                                                            $role_permission_updated = $permission_update_id;
                                                        }	
                                                    }

                                                }
                                                else if(!empty($access_page_actions)){

                                                    $action = "";
                                                    if(!empty($company_name)) {
                                                        $action = "New Permission Role Created - ".$obj->encode_decode("decrypt",$company_name);
                                                    }
                                                    $columns = array(); $values = array();
                                                    $columns = array('created_date_time', 'creator', 'creator_name','role_id','role_permission_id', 'bill_company_id','module', 'module_actions','deleted');
                                                    $values = array($created_date_time, $creator, $creator_name,$edit_id, $null_value, $bill_company_id, $access_pages_list[$m], $access_page_actions,0);
                                                    $permission_insert_id = $obj->InsertSQL($GLOBALS['role_permission_table'], $columns, $values,'role_permission_id','', $action);
                                                    if(preg_match("/^\d+$/", $permission_insert_id)) {
                                                        $role_permission_id =$obj->getTableColumnValue ($GLOBALS['role_permission_table'],'id',$entry_update_id,'role_permission_id');

                                                        $columns = array(); $values = array();						
                                                        $columns = array('role_permission_id');
                                                        $values = array($role_permission_id);
                                                        $permission_update_id = $obj->UpdateSQL($GLOBALS['role_permission_table'], $permission_insert_id, $columns, $values, '');
                                                        if(preg_match("/^\d+$/", $permission_update_id)) {
                                                            $update_role_permission_id = $role_permission_id;	
                                                            $role_permission_updated = 1;					
                                                        }
                                                        else {
                                                            $role_permission_updated = $permission_update_id;
                                                        }

                                                    }
                                                    else {
                                                        $role_permission_updated = $permission_insert_id;
                                                    }
                                                }
                                            }
                                            else {
                                                if(!empty($role_error)) {
                                                    $role_permission_updated = $role_error;
                                                }

                                            }
                                        }
                                    }
                                }
                                if($role_permission_updated == 1){
                                    $result = array('number' => '1', 'msg' => 'Role Successfully Created');
                                }
                                else {

                                    $result = array('number' => '2', 'msg' => $role_permission_updated);
                                }
                            }
                            $count++; 
                
                        }
                    }  

                }
                else {
                    $result = array('number' => '2', 'msg' => 'Invalid IP');
                }
            }
            else{
                if(!empty($access_error)) {
                    $result = array('number' => '2', 'msg' => $access_error);
                }
            }
		}
		else {
			if(!empty($valid_role)) {
				$result = array('number' => '3', 'msg' => $valid_role);
			}
            if(!empty($access_permission_error)) {
				$result = array('number' => '2', 'msg' => $access_permission_error);
			}
		}
		
		if(!empty($result)) {
			$result = json_encode($result);
		}
		echo $result; exit;
    }


   if(isset($_POST['page_number'])) {
		$page_number = $_POST['page_number'];
		$page_limit = $_POST['page_limit'];
		$page_title = $_POST['page_title']; 
        
        if(isset($_POST['search_text'])) {
			$search_text = $_POST['search_text'];
		}
	
        
        $login_staff_id = "";
		if($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type'] == $GLOBALS['staff_user_type']) {
			$login_staff_id =  $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'];
		}
        $bill_company_id = $GLOBALS['bill_company_id'];

        $total_records_list = array();

        if(!empty($GLOBALS['bill_company_id'])) {
		   $total_records_list=$obj->getTableRecords($GLOBALS['role_table'],'','', ''); 
		}


		if(!empty($search_text)) {
			$search_text = strtolower($search_text);
			$list = array();
			if(!empty($total_records_list)) {
				foreach($total_records_list as $val) {
					if( (strpos(strtolower($obj->encode_decode('decrypt', $val['role_name'])), $search_text) !== false)) {
						$list[] = $val;
					}
				}
			}
			$total_records_list = $list;
		}

        $total_pages = 0;	
		$total_pages = count($total_records_list);
		
		$page_start = 0; $page_end = 0;
		if(!empty($page_number) && !empty($page_limit) && !empty($total_pages)) {
			if($total_pages > $page_limit) {
				if($page_number) {
					$page_start = ($page_number - 1) * $page_limit;
					$page_end = $page_start + $page_limit;
				}
			}
			else {
				$page_start = 0;
				$page_end = $page_limit;
			}
		}

		$show_records_list = array();
        if(!empty($total_records_list)) {
            foreach($total_records_list as $key => $val) {
                if($key >= $page_start && $key < $page_end) {
                    $show_records_list[] = $val;
                }
            }
        }
		
		$prefix = 0;
		if(!empty($page_number) && !empty($page_limit)) {
			$prefix = ($page_number * $page_limit) - $page_limit;
		} ?>
        
		<?php if($total_pages > $page_limit) { ?>
			<div class="pagination_cover mt-3"> 
				<?php
					include("pagination.php");
				?> 
			</div> 
		<?php } ?>
		<table class="table nowrap cursor text-center smallfnt">
            <thead class="bg-light">
                <tr>
                    <th>S.No</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    if(!empty($show_records_list)) {
                        foreach($show_records_list as $key => $list) {
                            $index = $key + 1;
                            if(!empty($prefix)) { $index = $index + $prefix; } 
                            $type = "";
                            if(!empty($list['type'])){
                                $type = $list['type'];
                            }
                            ?>
                            <tr>
                                <td class="text-center" style="cursor:default;"><?php echo $index; ?></td>
                                <td class="text-center">
                                    <?php
                                        if(!empty($list['role_name']) && $list['role_name'] != $GLOBALS['null_value']) {
                                            $list['role_name'] = $obj->encode_decode('decrypt', $list['role_name']);
                                            echo($list['role_name']);
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                     if(!empty($type) && $type != $GLOBALS['admin_user_type']){  
                                        $linked_count = 0;
                                        $linked_count = $creation_obj->GetRoleLinkedCount($list['role_id']);
                                        ?>
                                        <div class="dropdown">
                                            <a href="#" role="button" id="dropdownMenuLink1" class="btn btn-dark show-button py-1 px-2" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                
                                                <li><a class="dropdown-item" style="cursor:pointer;" href="Javascript:ShowModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '<?php if(!empty($list['role_id'])) { echo $list['role_id']; } ?>');"><i class="fa fa-pencil"></i> &ensp; Edit</a></li>
                                                <?php if(empty($list['incharger']) && empty($linked_count)){  ?>
                                                    <li><a class="dropdown-item" style="cursor:pointer;" onclick="Javascript:DeleteModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '<?php if(!empty($list['role_id'])) { echo $list['role_id']; } ?>');"> <i class="fa fa-trash"></i> &ensp; Delete</a></li>
                                                <?php } ?>
                                            </ul>
                                        </div> 
                                    <?php 
                                }
                                 ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    else {
                        ?>
                        <tr>
                            <td colspan="3" class="text-center">Sorry! No records found</td>
                        </tr>
                <?php }  ?>
            </tr>
            </tbody>
        </table>             
		<?php	
	}

    if(isset($_REQUEST['delete_role_id'])){
        $delete_role_id = $_REQUEST['delete_role_id'];
        $msg = "";$delete = 0;
        if(!empty($delete_role_id)) {
            $role_unique_id = "";
            $role_unique_id = $obj->getTableColumnValue($GLOBALS['role_table'], 'role_id', $delete_role_id, 'id');
            if(preg_match("/^\d+$/", $role_unique_id)) {
               
                $action = "";$role_name = "";
                $role_name = $obj->getTableColumnValue($GLOBALS['role_table'], 'role_id', $delete_role_id, 'role_name');
                if(!empty($role_name)) {
                    $action = "Role Deleted - ".$obj->encode_decode("decrypt",$role_name);
                }

                $role_id = "";
                $role_id = $obj->getTableColumnValue($GLOBALS['user_table'],'role_id',$delete_role_id,'id');

                if(!empty($role_id)){
                    $delete = 1;
                }
                $created_date_time = $GLOBALS['create_date_time_label']; 
                if($delete == 0){
                    $columns = array(); $values = array();					
                    $columns = array('deleted');
                    $values = array(1);
                    $msg = $obj->UpdateSQL($GLOBALS['role_table'], $role_unique_id, $columns, $values, $action);
                }
                else{
                    $msg = "This Role is linked in User. So it can't be deleted!";
                }
            }
            else{
                $msg = "Unable to Delete";
            }
        }
        echo $msg;
        exit;	
    }
    ?>