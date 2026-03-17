<?php
	include("include_files.php");
	if(isset($_REQUEST['show_user_id'])) { 
        
        $show_user_id = filter_input(INPUT_GET, 'show_user_id', FILTER_SANITIZE_SPECIAL_CHARS);

        $show_user_id = trim($show_user_id);
        $name = ""; $mobile_number = ""; $username = ""; $password = ""; $type = ""; $access_pages = ""; $access_page_actions = ""; $admin = 0; $role_id = "";  
        if(!empty($show_user_id)) {
            $user_list = array();
            $user_list = $obj->getTableRecords($GLOBALS['user_table'], 'user_id', $show_user_id,'');
            if(!empty($user_list)) {
                foreach($user_list as $data) {
                    if(!empty($data['name']) && $data['name'] != $GLOBALS['null_value']) {
                        $name = $obj->encode_decode('decrypt', $data['name']);
                    }
                    if(!empty($data['user_id']) && $data['user_id'] != $GLOBALS['null_value']) {
                        $user_id = $obj->encode_decode('decrypt', $data['user_id']);
                    }
                    if(!empty($data['mobile_number']) && $data['mobile_number'] != $GLOBALS['null_value']) {
                        $mobile_number = $obj->encode_decode('decrypt', $data['mobile_number']);
                    }
                    if(!empty($data['login_id']) && $data['login_id'] != $GLOBALS['null_value']) {
                        $username = $obj->encode_decode('decrypt', $data['login_id']);
                    }
                    if(!empty($data['password']) && $data['password'] != $GLOBALS['null_value']) {
                        $password = $obj->encode_decode('decrypt', $data['password']);
                    }
                    if(!empty($data['type']) && $data['type'] != $GLOBALS['null_value']) {
                        $type = $data['type'];
                    }
                    if(!empty($data['role_id']) && $data['role_id'] != $GLOBALS['null_value']) {
                        $role_id = $data['role_id'];
                    }
                    if(!empty($data['access_pages']) && $data['access_pages'] != $GLOBALS['null_value']) {
						$access_pages = explode(",", $data['access_pages']);
					}
					if(!empty($data['access_page_actions']) && $data['access_page_actions'] != $GLOBALS['null_value']) {
						$access_page_actions = explode(",", $data['access_page_actions']);
					}
                    if(!empty($data['admin'])) {
                        $admin = $data['admin'];
                    }
                    if(!empty($data['role_id']) && $data['role_id'] != $GLOBALS['null_value']) {
                        $role_id = $data['role_id'];
                    }
                }
            }
        }
        $role_list = array();
        $role_list = $obj->getTableRecords($GLOBALS['role_table'], '', '', '');
        ?>
        <form class="poppins pd-20 redirection_form" name="user_form" method="POST">
			<div class="card-header">
				<div class="row p-2">
					<div class="col-lg-8 col-md-8 col-8 align-self-center">
                        <?php if(empty($show_user_id)) { ?>
						    <div class="h5">Add User</div>
                        <?php }else { ?>
						    <div class="h5">edit User</div>
                        <?php } ?>
					</div>
					<div class="col-lg-4 col-md-4 col-4">
						<button class="btn btn-dark float-end" style="font-size:11px;" type="button" onclick="window.open('user.php','_self')"> <i class="fa fa-arrow-circle-o-left"></i> &ensp; Back </button>
					</div>
				</div>
			</div>
            <div class="row p-3">
                <input type="hidden" name="edit_id" value="<?php if(!empty($show_user_id)) { echo $show_user_id; } ?>">
                <div class="col-lg-3 col-md-4 col-12 py-2 px-lg-1">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                            <input type="text" id="name" name="name" class="form-control shadow-none" value="<?php if(!empty($name)) { echo $name; } ?>" onkeydown="Javascript:KeyboardControls(this,'text',15,1);" placeholder="" required>
                            <label>Name</label>
                        </div>
                        <div class="new_smallfnt">Contains Text, Symbols &amp;, -,',.</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-12 py-2 px-lg-1">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                            <input type="text" name="mobile_number" class="form-control shadow-none" value="<?php if(!empty($mobile_number)) { echo $mobile_number; } ?>" onfocus="Javascript:KeyboardControls(this,'mobile_number',10,'1');"  placeholder="" required>
                            <label>Contact Number</label>
                        </div>
                        <div class="new_smallfnt">Numbers Only (only 10 digits)</div>
                    </div>
                </div>
                <?php if(empty($admin)) { ?>
                    <div class="col-lg-3 col-md-4 col-12 py-2 px-lg-1">
                        <div class="form-group">
                            <div class="form-label-group in-border">
                                <select name="role_id" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                    <option value="">Select Role</option>    
                                    <?php if(!empty($role_list)) {
                                        foreach($role_list as $data) {
                                            if(!empty($data['role_id']) && $data['admin'] != '1') { ?>
                                                <option value="<?php echo $data['role_id']; ?>" <?php if(!empty($role_id) && $data['role_id'] == $role_id) { ?>selected="selected"<?php } ?>>
                                                    <?php
                                                        if(!empty($data['role_name'])) {
                                                            $data['role_name'] = $obj->encode_decode('decrypt', $data['role_name']);
                                                            echo($data['role_name']);
                                                        }
                                                    ?>
                                                </option>
                                            <?php }
                                        }
                                    } ?>
                                </select>
                                <label>Select Role</label>
                            </div>
                        </div>        
                    </div>
                <?php } ?>
                <div class="col-lg-3 col-md-4 col-12 py-2 px-lg-1">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                            <input type="text" name="username" value="<?php if(!empty($username)) { echo $username; } ?>"  class="form-control shadow-none" onkeydown="Javascript:KeyboardControls(this,'text',25,1);"  placeholder="" required="">
                            <label>User Name(*)</label>
                        </div>
                        <div class="new_smallfnt">Contains Text, Symbols &amp;, -,',.</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-12 py-2 px-lg-1">
                    <div id="password_cover" class="form-group">
                        <div class="form-label-group in-border">
                            <div class="input-group">
                                <input type="password" class="form-control shadow-none" id="password" name="password" value="<?php if(!empty($password)) { echo $password; } ?>" onkeyup="Javascript:CheckPassword('password');" onfocus="Javascript:KeyboardControls(this,'password',20,'1');" placeholder="Password">
                                <label for="password">Password(*)</label>
                                <div style="position: inherit; top: 0px;" class="input-group-append" data-toggle="tooltip" data-placement="right" title="Show Password">
                                    <button class="btn btn-dark" type="button" id="passwordBtn" data-toggle="button" aria-pressed="false"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="smallfnt p-gray">Password must include:</div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="length_check" value="" id="defaultCheck1">
                            <label class="form-check-label smallfnt fw-400 checkbox" for="defaultCheck1">
                                8 - 20 characters
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="letter_check" value="" id="defaultCheck1">
                            <label class="form-check-label smallfnt fw-400 checkbox" for="defaultCheck1">
                                Atleast one upper case and lower case letter
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="number_symbol_check" value="" id="defaultCheck1">
                            <label class="form-check-label smallfnt fw-400 checkbox" for="defaultCheck1">
                                Atleast one number and one symbol
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="space_check" value="" id="defaultCheck1">
                            <label class="form-check-label smallfnt fw-400 checkbox" for="defaultCheck1">
                                No space
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 pt-3 text-center">
                    <button class="btn btn-danger submit_button" onClick="Javascript:SaveModalContent(event, 'user_form', 'user_changes.php', 'user.php');" type="button">
                        Submit
                    </button>
                </div>
            </div>
            <script src="include/select2/js/select2.min.js"></script>
            <script src="include/select2/js/select.js"></script>
            <script>
                jQuery(document).ready(function() {
                    const passBtn = $("#passwordBtn");
                    passBtn.click(togglePassword);
                    function togglePassword() {
                        const passInput = $("#password");
                        if (passInput.attr("type") === "password") {
                            passInput.attr("type", "text");
                        } 
                        else {
                            passInput.attr("type", "password");
                        }
                    }
                    <?php
                        if(!empty($show_user_id)){ ?>CheckPassword('password');<?php }
                    ?>
                });
            </script>
        </form>
		<?php
    } 
     if(isset($_POST['name'])) {	
        $name = ""; $name_error = "";  $mobile_number = ""; $mobile_number_error = ""; 	$username = ""; $username_error = "";
        $password = ""; $password_error = ""; $access_page_actions = array(); $access_pages = array();
        $valid_user = ""; $form_name = "user_form";
        
        $edit_id = ""; $admin = 0; $type = $GLOBALS['staff_user_type'];
        if(isset($_POST['edit_id'])) {
            $edit_id = $_POST['edit_id'];
            $edit_id = trim($edit_id);
            if(!empty($edit_id)) {
                $admin = $obj->getTableColumnValue($GLOBALS['user_table'], 'user_id', $edit_id, 'admin');
                if(empty($admin)) {
                    $type = $obj->getTableColumnValue($GLOBALS['user_table'], 'user_id', $edit_id, 'type');
                }
                else {
                    $type = $GLOBALS['admin_user_type'];
                }
            }
        }
   
        $name = $_POST['name'];
        $name = trim($name);
        if(!empty($name) && strlen($name) > 25) {
            $name_error = "Only 25 characters allowed";
        }
        else {
            $name_error = $valid->valid_regular_expression($name,'name','1','25');
        }
        if(empty($name_error) && empty($edit_id)) {
            $user_list = array(); $user_count = 0;
            $user_list = $obj->getTableRecords($GLOBALS['user_table'], '', '','');
            if(!empty($user_list)) {
                $user_count = count($user_list);
            }
            if($user_count >= $GLOBALS['max_user_count']) {
                $name_error = "Max.".$GLOBALS['max_user_count']." users are allowed";
            }
        }
        if(!empty($name_error)) {
            $valid_user = $valid->error_display($form_name, "name", $name_error, 'text');			
        }
        $mobile_number = $_POST['mobile_number'];
        $mobile_number = trim($mobile_number);
        $mobile_number_error = $valid->valid_mobile_number($mobile_number, "Mobile number", "1");
        // echo $mobile_number_error." hi";
        if(!empty($mobile_number_error)) {
            if(!empty($valid_user)) {
                $valid_user = $valid_user." ".$valid->error_display($form_name, "mobile_number", $mobile_number_error, 'text');
            }
            else {
                $valid_user = $valid->error_display($form_name, "mobile_number", $mobile_number_error, 'text');
            }
        }
        // echo $valid_user."hi";
        $username = $_POST['username'];
        $username = trim($username);
        if(!empty($username) && strlen($username) > 25) {
            $username_error = "Only 25 digits allowed";
        }
        else {
            $username_error = $valid->valid_username($username,'user ID','1','25');
        }        
        if(!empty($username_error)) {
            if(!empty($valid_user)) {
                $valid_user = $valid_user." ".$valid->error_display($form_name, "username", $username_error, 'text');
            }
            else {
                $valid_user = $valid->error_display($form_name, "username", $username_error, 'text');
            }
        }
        if(empty($admin)) {
            if(isset($_POST['role_id'])) {
                $role_id = $_POST['role_id'];
                $role_id = trim($role_id);
            }
            if(!empty($role_id)) {
                $role_unique_id = "";
                $role_unique_id = $obj->getTableColumnValue($GLOBALS['role_table'], 'role_id', $role_id, 'id');
                if(!preg_match("/^\d+$/", $role_unique_id)) {
                    $role_id_error = "Invalid role";
                }
            }
            else {
                $role_id_error = "Select the role";
            }
            if(!empty($role_id_error)) {
                if(!empty($valid_user)) {
                    $valid_user = $valid_user." ".$valid->error_display($form_name, "role_id", $role_id_error, 'select');
                }
                else {
                    $valid_user = $valid->error_display($form_name, "role_id", $role_id_error, 'select');
                }
            }
        }
        $password = $_POST['password'];
        $password = trim($password);
        if(strpos($password," ") == true) {
            $password_error = "Password should not contain spaces";
        }
        else if(strlen($password) > 20) {
            $password_error = "Only 20 digits allowed(recommended)";
        }
        else {
            $password_error = $valid->valid_password($password, "Password", "1",'20');
        }        
        if(!empty($password_error)) {
            if(!empty($valid_user)) {
                $valid_user = $valid_user." ".$valid->error_display($form_name, "password", $password_error, 'input_group');
            }
            else {
                $valid_user = $valid->error_display($form_name, "password", $password_error, 'input_group');
            }
        }  
        $user_access_pages_list = $GLOBALS['access_pages_list']; 
        
        
        $module_selected = 0;
		if(!empty($user_access_pages_list)) {
			foreach($user_access_pages_list as $module) {
				if(!empty($module)) {
					$module_encrypted = "";
					$module_encrypted = $obj->encode_decode('encrypt', $module);
					$module_action = array(); 
					$view_checkbox_value = 2; $add_checkbox_value = 2; $edit_checkbox_value = 2; $delete_checkbox_value = 2;
					$view_field = $module_encrypted."_view"; $add_field = $module_encrypted."_add"; $edit_field = $module_encrypted."_edit"; 
					$delete_field = $module_encrypted."_delete";
					if(isset($_POST[$view_field])) {
						$view_checkbox_value = $_POST[$view_field];
						$view_checkbox_value = trim($view_checkbox_value);
					}
					if($view_checkbox_value != 1 && $view_checkbox_value != 2) { $view_checkbox_value = 2; }
					if($view_checkbox_value == 1) { 
						$module_action[] = $view_action;
					}
					if(isset($_POST[$add_field])) {
						$add_checkbox_value = $_POST[$add_field];
						$add_checkbox_value = trim($add_checkbox_value);
					}
					if($add_checkbox_value != 1 && $add_checkbox_value != 2) { $add_checkbox_value = 2; }
					if($add_checkbox_value == 1) { 
						$module_action[] = $add_action;
					}
					if(isset($_POST[$edit_field])) {
						$edit_checkbox_value = $_POST[$edit_field];
						$edit_checkbox_value = trim($edit_checkbox_value);
					}
					if($edit_checkbox_value != 1 && $edit_checkbox_value != 2) { $edit_checkbox_value = 2; }
					if($edit_checkbox_value == 1) { 
						$module_action[] = $edit_action;
					}
					if(isset($_POST[$delete_field])) {
						$delete_checkbox_value = $_POST[$delete_field];
						$delete_checkbox_value = trim($delete_checkbox_value);
					}
					if($delete_checkbox_value != 1 && $delete_checkbox_value != 2) { $delete_checkbox_value = 2; }
					if($delete_checkbox_value == 1) { 
						$module_action[] = $delete_action;
					}
					if(!empty($module_action) && count($module_action) > 0) {
						$access_pages[] = $module_encrypted;
						$access_page_actions[] = implode("$$$", $module_action);
						$module_selected = 1;
					}
				}
			}
		}
        $access_permission_error = "";
    
        $result = "";
        
        if(empty($valid_user) && empty($access_permission_error)) {
            $check_user_id_ip_address = 0;
            $check_user_id_ip_address = $obj->check_user_id_ip_address();	
            if(preg_match("/^\d+$/", $check_user_id_ip_address)) {
                $name_mobile = "";
                if(!empty($name)) {
                    $name_mobile = $name;
                    $name = $obj->encode_decode('encrypt', $name);
                }
                if(!empty($mobile_number)) {
                    $mobile_number = str_replace(" ", "", $mobile_number);
                    $mobile_number = trim($mobile_number);
                    if(!empty($name_mobile)) {
                        $name_mobile = $name_mobile." (".$mobile_number.")";
                    }
                    $mobile_number = $obj->encode_decode('encrypt', $mobile_number);
                }
                $factory_id = ""; $godown_id = ""; $magazine_id = ""; $factory_unique_id = ""; $godown_unique_id = ""; $magazine_unique_id = "";
                $factory_details = ""; $godown_details = ""; $magazine_details = ""; 
               
                $login_id = ""; $lower_case_login_id = "";
                if(!empty($username)) {
                    $login_id = $username;
                    $lower_case_login_id = strtolower($login_id);
                    $lower_case_login_id = $obj->encode_decode('encrypt', $lower_case_login_id);
                    $login_id = $obj->encode_decode('encrypt', $login_id);
                }
                if(!empty($password)) {
                    $password = $obj->encode_decode('encrypt', $password);
                }
                if(!empty($access_pages)) {
                    $access_pages = implode(",", $access_pages);
                }
                else {
                    $access_pages = $GLOBALS['null_value'];
                }
                if(!empty($access_page_actions)) {
                    $access_page_actions = implode(",", $access_page_actions);
                }
                else {
                    $access_page_actions = $GLOBALS['null_value'];
                }
                if(!empty($name_mobile)) {
                    $name_mobile = $obj->encode_decode('encrypt', $name_mobile);
                }
                $prev_user_id = ""; $user_error = ""; $prev_user_name = "";	
                if(!empty($lower_case_login_id)) {
                    $prev_user_id = $obj->getTableColumnValue($GLOBALS['user_table'], 'lower_case_login_id', $lower_case_login_id, 'user_id');
                    if(!empty($prev_user_id) && $prev_user_id != $edit_id) {
                        $prev_user_name = $obj->getTableColumnValue($GLOBALS['user_table'],'user_id',$prev_user_id,'name');
						$prev_user_name = $obj->encode_decode("decrypt",$prev_user_name);
                        $user_error = "This User ID is already exist in ".$prev_user_name;
                    }
                }
                
                if(!empty($mobile_number) && empty($user_error)) {
                    $prev_user_id = $obj->getTableColumnValue($GLOBALS['user_table'], 'mobile_number', $mobile_number, 'user_id');
                    if(!empty($prev_user_id) && $prev_user_id != $edit_id) {
                        $prev_user_name = $obj->getTableColumnValue($GLOBALS['user_table'],'user_id',$prev_user_id,'name');
						$prev_user_name = $obj->encode_decode("decrypt",$prev_user_name);
                        $user_error = "This Mobile Number already exist in ".$prev_user_name;
                    }
                }
                if($admin == '1') {
                    $role_id = $GLOBALS['null_value'];
                }
                $created_date_time = $GLOBALS['create_date_time_label'];
                $updated_date_time = $GLOBALS['create_date_time_label'];
                $creator = $GLOBALS['creator'];
                $creator_name = $obj->encode_decode('encrypt', $GLOBALS['creator_name']);
                if(empty($edit_id)) {
                    if(empty($prev_user_id)) {
                        $action = "";
                        if(!empty($name_mobile)) {
                            $action = "New User Created. Details - ".$obj->encode_decode('decrypt', $name_mobile);
                        }
                        $null_value = $GLOBALS['null_value'];
                        $columns = array(); $values = array();
                        $columns = array('created_date_time','updated_date_time', 'creator', 'creator_name', 'user_id', 'name', 'mobile_number', 'name_mobile', 'password', 'admin', 'type', 'role_id', 'login_id', 'lower_case_login_id','deleted');
                        $values = array($created_date_time,$updated_date_time, $creator, $creator_name, $null_value, $name, $mobile_number, $name_mobile,  $password, $admin, $type, $role_id,$login_id, $lower_case_login_id, '0');
                        $user_insert_id = $obj->InsertSQL($GLOBALS['user_table'], $columns, $values, 'user_id', '', $action);
                        if(preg_match("/^\d+$/", $user_insert_id)) {								
                            $result = array('number' => '1', 'msg' => 'User Successfully Created');
                        }
                        else {
                            $result = array('number' => '2', 'msg' => $user_insert_id);
                        }
                    }
                    else {
                        $result = array('number' => '2', 'msg' => $user_error);
                    }
                }
                else {
                    if(empty($prev_user_id) || $prev_user_id == $edit_id) {
                        $getUniqueID = "";
                        $getUniqueID = $obj->getTableColumnValue($GLOBALS['user_table'], 'user_id', $edit_id, 'id');
                        if(preg_match("/^\d+$/", $getUniqueID)) {
                            $action = "";
                            if(!empty($name_mobile)) {
                                $action = "User Updated. Details - ".$obj->encode_decode('decrypt', $name_mobile);
                            }
                        
                            $columns = array(); $values = array();						
                            $columns = array('updated_date_time','creator_name', 'name', 'mobile_number', 'name_mobile', 'lower_case_login_id', 'password', 'role_id','login_id');
                            $values = array($updated_date_time ,$creator_name, $name, $mobile_number, $name_mobile, $lower_case_login_id, $password ,$role_id,$login_id);
                            $user_update_id = $obj->UpdateSQL($GLOBALS['user_table'], $getUniqueID, $columns, $values, $action);
                            if(preg_match("/^\d+$/", $user_update_id)) {
                                $result = array('number' => '1', 'msg' => 'Updated Successfully');
                            }
                            else {
                                $result = array('number' => '2', 'msg' => $user_update_id);
                            }							
                        }
                    }
                    else {
                        $result = array('number' => '2', 'msg' => $user_error);
                    }
                }
                if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id']) && isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'])) {
					$name = "";
					$name = $obj->getTableColumnValue($GLOBALS['user_table'], 'user_id', $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'], 'name');
					if(!empty($name)) {
						$name = $obj->encode_decode('decrypt', $name);
						if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name'])) {
							unset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name']);
							$_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name'] = $name;
						}
					}
					$mobile_number = "";
					$mobile_number = $obj->getTableColumnValue($GLOBALS['user_table'], 'user_id', $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'], 'mobile_number');
					if(!empty($mobile_number)) {
						$mobile_number = $obj->encode_decode('decrypt', $mobile_number);
						if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_mobile_number'])) {
							unset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_mobile_number']);
							$_SESSION[$GLOBALS['site_name_user_prefix'].'_user_mobile_number'] = $mobile_number;
						}
					}
					$name_mobile = "";
					$name_mobile = $obj->getTableColumnValue($GLOBALS['user_table'], 'user_id', $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'], 'name_mobile');
					if(!empty($name_mobile)) {
						$name_mobile = $obj->encode_decode('decrypt', $name_mobile);
						if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name_mobile'])) {
							unset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name_mobile']);
							$_SESSION[$GLOBALS['site_name_user_prefix'].'_user_name_mobile'] = $name_mobile;
						}
					}
				}
            }
            else {
                $result = array('number' => '2', 'msg' => 'Invalid IP');
            }
        }
        else {
            if(!empty($valid_user)) {
                $result = array('number' => '3', 'msg' => $valid_user);
            }
            else if(!empty($access_permission_error)) {
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
        
        $login_staff_id = "";
		if($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type'] == $GLOBALS['staff_user_type']) {
			$login_staff_id =  $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'];
		}

        $search_text = "";
        if(isset($_POST['search_text'])){
            $search_text = $_POST['search_text'];
        }
		
		$total_records_list = array();
		$total_records_list = $obj->getTableRecords($GLOBALS['user_table'],'','', ''); 

        if(!empty($search_text)) {
			$search_text = strtolower($search_text);
			$list = array();
			if(!empty($total_records_list)) {
				foreach($total_records_list as $val) {
					if( (strpos(strtolower($obj->encode_decode('decrypt', $val['name'])), $search_text) !== false) || (strpos(strtolower($obj->encode_decode('decrypt', $val['mobile_number'])), $search_text) !== false) ) {
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
		<?php } 
		
		$access_error = "";
        if(!empty($login_staff_id)) {
            $permission_module = $GLOBALS['user_module'];
            $permission_action = $view_action;
            include('permission_action.php');
        }
		if(empty($access_error)) { ?>
        
		<table class="table cursor text-center smallfnt">
            <thead class="bg-light">
                <tr>
                    <th>S.No</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Mobile</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                        <?php
                            if(!empty($show_records_list)) {
                                foreach($show_records_list as $key => $list) {

                                    $index = $key + 1;
                                    if(!empty($prefix)) { $index = $index + $prefix; } ?>
                                    <tr>
                                        <td><?php echo $index; ?></td>
                                        <td onclick="ShowModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '<?php if(!empty($list['user_id'])) { echo $list['user_id']; } ?>');">
                                            <?php
                                                    if(!empty($list['name'])) {
                                                        $list['name'] = $obj->encode_decode('decrypt', $list['name']);
                                                        echo($list['name']);
                                                    }
                                                ?>
                                        </td>
                                        <td onclick="ShowModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '<?php if(!empty($list['user_id'])) { echo $list['user_id']; } ?>');">
                                                        <?php 
                                                              
                                                if(!empty($list['role_id'])) {
                                                    $role_name = $obj->getTableColumnValue($GLOBALS['role_table'], 'role_id',$list['role_id'], 'role_name');
                                                }

                                                if(empty($role_name) || $role_name == $GLOBALS['null_value']){
                                                    echo  $role_name = "Super Admin";
                                                }else{
                                                    echo $role_name = $obj->encode_decode("decrypt", $role_name);

                                                }
                                                        ?>
                                        </td>

                                        <td onclick="ShowModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '<?php if(!empty($list['user_id'])) { echo $list['user_id']; } ?>');">
                                            <?php

                                                if(!empty($list['mobile_number'])) {
                                                    echo $obj->encode_decode('decrypt', $list['mobile_number']);
                                                }

                                            ?>
                                        </td>
                                        <td>
                                        <?php 
                                            $access_error = "";
                                            if(!empty($login_staff_id)) {
                                                $permission_module = $GLOBALS['user_module'];
                                                $permission_action = $edit_action;
                                                include('permission_action.php');

                                            }
                                            if(empty($access_error)) {
                                                 ?>
                                                <a class="pr-2" href="Javascript:ShowModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '<?php if(!empty($list['user_id'])) { echo $list['user_id']; } ?>');"><i class="fa fa-pencil" title="edit"></i></a>&ensp;
                                            <?php } ?>
                                            <?php
                                            $access_error = "";
                                            // if(!empty($login_staff_id)) { 
                                            //     $permission_module = $GLOBALS['user_module'];
                                            //     $permission_action = $delete_action;
                                            //     include('permission_action.php'); 
                                                if($role_name != 'Super Admin'){

                                                ?>

                                                <a class="pr-2" href="Javascript:DeleteModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '<?php if(!empty($list['user_id'])) { echo $list['user_id']; } ?>');"><i class="fa fa-trash" title="delete"></i></a>
                                            <?php 
                                                }
                                        // }
                                         ?>	
                                        </td>
                                    </tr>
                                <?php 
                                    
                            }
                        
                        } else { ?>
                        <td colspan="5" class="text-center">Sorry! No records found</td>
                       <?php } ?>
                    </tr>
                </tbody>
            </table>             
		<?php
        }	
	}
    
    if(isset($_REQUEST['delete_user_id'])) {
         $delete_user_id = $_REQUEST['delete_user_id'];
        $delete_user_id = trim($delete_user_id);
        $msg = "";
        if(!empty($delete_user_id)) {	
            $user_unique_id = "";
            $user_unique_id = $obj->getTableColumnValue($GLOBALS['user_table'], 'user_id', $delete_user_id, 'id');
            if(preg_match("/^\d+$/", $user_unique_id)) {
                $admin = 0;
                $admin = $obj->getTableColumnValue($GLOBALS['user_table'], 'user_id', $delete_user_id, 'admin');
                if(empty($admin)) {
                    $name_mobile = "";
                    $name_mobile = $obj->getTableColumnValue($GLOBALS['user_table'], 'user_id', $delete_user_id, 'name_mobile');
                    $action = "";
                    if(!empty($name_mobile)) {
                        $action = "User Deleted. Details - ".$obj->encode_decode('decrypt', $name_mobile);
                    }
                
                    $columns = array(); $values = array();						
                    $columns = array('deleted');
                    $values = array(1);
                    $msg = $obj->UpdateSQL($GLOBALS['user_table'], $user_unique_id, $columns, $values, $action);
                }
                else {
                    $msg = "Unable to delete";
                }    
            }
            else {
                $msg = "Invalid user";
            }
        }
        else {
            $msg = "Empty user";
        }
        echo $msg;
        exit;	
    }
    ?>
    <script>
        $(document).ready(function() {
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });

    // const passBtn = $("#passwordBtn");

    // passBtn.click(togglePassword);

    function togglePassword() {
        const passInput = $("#password");
    if (passInput.attr("type") === "password") {
        passInput.attr("type", "text");
    } 
    else {
        passInput.attr("type", "password");
    }
  }
});
    </script>