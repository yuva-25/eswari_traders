<?php
	include("include_files.php");
    $login_staff_id = "";
    if(isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id']) && !empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'])) {
        if(!empty($GLOBALS['user_type']) && $GLOBALS['user_type'] != $GLOBALS['admin_user_type']) {
            $login_staff_id = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'];
            $permission_module = $GLOBALS['size_module'];
        }
    }


	if(isset($_REQUEST['show_size_id'])) { 
        $show_size_id = "";
        $show_size_id = filter_input(INPUT_GET, 'show_size_id', FILTER_SANITIZE_SPECIAL_CHARS);

        $size_name = "";
        if(!empty($show_size_id)) {
            $size_list = array();
            $size_list = $obj->getTableRecords($GLOBALS['size_table'], 'size_id', $show_size_id, '');
            if(!empty($size_list)) {
                foreach ($size_list as $data) {
                    if(!empty($data['size_name'])) {
                        $size_name = $obj->encode_decode('decrypt', $data['size_name']);
                    }
                }
            }
        } 
        
        ?>
        <form class="poppins pd-20 redirection_form" name="size_form" method="POST">
			<div class="card-header">
				<div class="row p-2">
					<div class="col-lg-8 col-md-8 col-8 align-self-center">
                        <?php if(!empty($show_size_id)){ ?>
                            <div class="h5">Edit Size</div>
                        <?php 
                        } else{ ?>
                            <div class="h5">Add Size</div>
                        <?php
                        } ?>
					</div>
					<div class="col-lg-4 col-md-4 col-4">
						<button class="btn btn-dark float-end" style="font-size:11px;" type="button" onclick="window.open('size.php','_self')"> <i class="fa fa-arrow-circle-o-left"></i> &ensp; Back </button>
					</div>
				</div>
			</div>
            <div class="row justify-content-center p-3">
                <input type="hidden" name="edit_id" value="<?php if(!empty($show_size_id)) { echo $show_size_id; } ?>">
                <div class="col-lg-3 col-md-6 col-12 py-2">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                            <div class="input-group">
                                <input type="text" id="size_name" name="size_name" value="<?php if(!empty($size_name)) { echo $size_name; } ?>" class="form-control shadow-none" onkeydown="Javascript:KeyboardControls(this,'',20,1);" placeholder="" required="">
                                <label>Size</label>
                                <?php if(empty($show_size_id)) { ?>
                                    <div class="input-group-append">
                                        <button class="btn btn-danger" onclick="Javascript:addCreationDetails('size');"  type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="new_smallfnt">Allow only this format 24x20 &amp;, -,',.</div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center"> 
                <?php if(empty($show_size_id)) { ?>
                    <div class="col-lg-6">
                        <div class="table-responsive text-center">
                            <table class="table nowrap cursor smallfnt w-100 table-bordered added_size_table">
                                <input type="hidden" name="size_count" value="0">   
                                <thead class="bg-dark smallfnt">
                                    <tr style="white-space:pre;">
                                        <th>#</th>
                                        <th>Size</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody> 
                            </table>
                        </div>
                    </div>
                <?php } ?>
                <div class="col-md-12 py-3 text-center">
                   <button class="btn btn-danger submit_button" type="button" onClick="Javascript:SaveModalContent(event,'size_form', 'size_changes.php', 'size.php');">
                        Submit
                    </button>
                </div>
            </div>
            <script src="include/select2/js/select2.min.js"></script>
            <script src="include/select2/js/select.js"></script>
            <script type="text/javascript" src="include/js/creation_module.js"></script>
        </form>
		<?php
    } 
   if (isset($_REQUEST['size_row_index'])) {
        $size_row_index = filter_input(INPUT_POST, 'size_row_index', FILTER_SANITIZE_SPECIAL_CHARS);
        $selected_size_name = filter_input(INPUT_POST, 'selected_size_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $selected_size_name = str_replace("@@@", "&", $selected_size_name);                
        $tr = "
            <tr class='size_row' id='size_row{$size_row_index}'>
                <td class='text-center sno'>{$size_row_index}</td>
                <td class='text-center'>
                    {$selected_size_name}
                    <input type='hidden' name='size_names[]' value='{$selected_size_name}'>
                </td>
                <td class='text-center product_pad'>
                    <button class='btn btn-danger align-self-center px-2 py-1' type='button'
                        onclick=\"DeleteCreationRow('size', '{$size_row_index}')\">
                        <i class='fa fa-trash' aria-hidden='true'></i>
                    </button>
                </td>
            </tr>
        ";

        echo json_encode($tr);
        exit;
    }
    if(isset($_POST['edit_id'])) {
        $size_name = array(); $size_name_error = ""; $single_lower_case_name = "";
        $valid_size = ""; $form_name = "size_form"; $size_error = "";
        $single_size_name = ""; $prev_size_id = ""; $lower_case_name = array();

        $edit_id = "";
        if(isset($_POST['edit_id'])) {
            $edit_id = $_POST['edit_id'];
            $edit_id = trim($edit_id);
        }
        if(!empty($edit_id)) {
            if(isset($_POST['size_name'])) {
                $single_size_name = $_POST['size_name'];
                $single_size_name = trim($single_size_name);
                $size_name_error = $valid->valid_regular_expression($single_size_name, "Size Name", "1", "50");
            }
            if(!empty($size_name_error)) {
                $valid_size = $valid->error_display($form_name, "size_name", $size_name_error, 'text');
            }
            else {
                $single_size_name = htmlentities($single_size_name, ENT_QUOTES);
                $single_lower_case_name = strtolower($single_size_name);
                $single_size_name = $obj->encode_decode('encrypt', $single_size_name);
                if(!empty($single_lower_case_name)) {
                    $prev_size_id = $obj->CheckSizeAlreadyExists($single_lower_case_name);
                    if(!empty($prev_size_id)) {
                        if($prev_size_id != $edit_id) {
                            $size_error = "This Size name - " . $single_lower_case_name . " is already exist";
                        }
                    }
                }
            }
        }

        if(empty($edit_id)) {
            if(isset($_POST['size_names'])) {
                $size_name = $_POST['size_names'];
            }
            $inputbox_size_name = "";
            $inputbox_size_name = $_POST['size_name'];

            if(!empty($inputbox_size_name) && empty($size_name)) {
                $size_add_error = "Click Add Button to Append Size";
                if(!empty($size_add_error)) {
                    $valid_size = $valid->error_display($form_name, "size_name", $size_add_error, 'text');
                }
            } else if(empty($inputbox_size_name) && empty($size_name)) {
                $size_add_error = "Enter Size Name";
                if(!empty($size_add_error)) {
                    $valid_size = $valid->error_display($form_name, "size_name", $size_add_error, 'text');
                }
            } else if(!empty($inputbox_size_name)) {
                $size_add_error = "Click Add Button to Append Size";
                if(!empty($size_add_error)) {
                    $valid_size = $valid->error_display($form_name, "size_name", $size_add_error, 'text');
                }
            }
            if(!empty($size_name)) {
                for ($p = 0; $p < count($size_name); $p++) {
                    if(!preg_match("/^(?=.*[a-zA-Z])[^`~!$^<>*+={}\[\]|?]+$/", $size_name[$p]) || strlen($size_name[$p]) > 50) {
                        $size_name_error = "Invalid Size name - " . $size_name[$p];
                    }
                    else {
                        $size_name[$p] = htmlentities($size_name[$p], ENT_QUOTES);
                        $lower_case_name[$p] = strtolower($size_name[$p]);
                        $size_name[$p] = $obj->encode_decode('encrypt', $size_name[$p]);
                    }
                }
            }
        }

        $access_error = ""; $permission_module = $GLOBALS['size_module']; $permission_action = "";
        if(!empty($login_staff_id)) {
            if(!empty($edit_id)) {
                $permission_action = $edit_action;
            }
            else {
                $permission_action = $add_action;
            }
            include('permission_action.php');
        }

        if(!empty($access_error) && empty($size_name_error)) {
            $size_name_error = $access_error;
        }

        $result = "";
        if(empty($valid_size) && empty($size_name_error)) {
            $check_user_id_ip_address = 0;
            $check_user_id_ip_address = $obj->check_user_id_ip_address();

            if(preg_match("/^\d+$/", $check_user_id_ip_address)) {
                for ($i = 0; $i < count($lower_case_name); $i++) {
                    if(!empty($lower_case_name[$i])) {
                        $prev_size_id = $obj->CheckSizeAlreadyExists($lower_case_name[$i]);
                        if(!empty($prev_size_id)) {
                            $size_error = "This Size name - " . $lower_case_name[$i] . " is already exist";
                        }
                    }
                }
                $created_date_time = $GLOBALS['create_date_time_label'];
                $updated_date_time = $GLOBALS['create_date_time_label'];
                $creator = $GLOBALS['creator'];
                $bill_company_id = $GLOBALS['bill_company_id'];
                $creator_name = $obj->encode_decode('encrypt', $GLOBALS['creator_name']);

                if(empty($size_error)) {
                    if(empty($edit_id)) {
                        $action = array();
                        for ($p = 0; $p < count($size_name); $p++) {
                            if(empty($prev_size_id)) {
                                if(!empty($size_name[$p])) {
                                    $action[$p] = "New Size Created. Name - " . $obj->encode_decode('decrypt',$size_name[$p]);
                                }

                                $null_value = $GLOBALS['null_value'];
                                $columns = array('created_date_time','updated_date_time', 'creator', 'creator_name','bill_company_id','size_id', 'size_name', 'lower_case_name', 'deleted');
                                $values = array($created_date_time, $updated_date_time, $creator, $creator_name,  $bill_company_id,$null_value, $size_name[$p], $lower_case_name[$p], 0);

                                $size_insert_id = $obj->InsertSQL($GLOBALS['size_table'], $columns, $values, 'size_id', '', $action[$p]);		
                                if(preg_match("/^\d+$/", $size_insert_id)) {								
                                    $result = array('number' => '1', 'msg' => 'Size Successfully Created');						
                                }
                                else {
                                    $result = array('number' => '2', 'msg' => $size_insert_id);
                                }
                            } 
                            else {
                                $result = array('number' => '2', 'msg' => $size_error);
                            }
                        }
                    } 
                    else if(!empty($edit_id)) {
                        $getUniqueID = "";
                        $getUniqueID = $obj->getTableColumnValue($GLOBALS['size_table'], 'size_id', $edit_id, 'id');
                        if(preg_match("/^\d+$/", $getUniqueID)) {
                            $action = "";
                            if(!empty($single_size_name)) {
                                $action = "Size Updated. Name - " . $obj->encode_decode('decrypt',$single_size_name);
                            }

                            $columns = array(); $values = array();
                            $columns = array('updated_date_time','creator_name', 'size_name', 'lower_case_name');
                            $values = array($updated_date_time, $creator_name, $single_size_name, $single_lower_case_name);
                            $size_update_id = $obj->UpdateSQL($GLOBALS['size_table'], $getUniqueID, $columns, $values, $action);
                            if(preg_match("/^\d+$/", $size_update_id)) {
                                $result = array('number' => '1', 'msg' => 'Updated Successfully');
                            } 
                            else {
                                $result = array('number' => '2', 'msg' => $size_update_id);
                            }
                        }
                    }
                } 
                else {
                    $result = array('number' => '2', 'msg' => $size_error);
                }
            } 
            else {
                $result = array('number' => '2', 'msg' => 'Invalid IP');
            }
        }
        else {
            if(!empty($valid_size)) {
                $result = array('number' => '3', 'msg' => $valid_size);
            } else if(!empty($size_name_error)) {
                $result = array('number' => '2', 'msg' => $size_name_error);		
            }
        }
        
        if(!empty($result)) {
            $result = json_encode($result);
        }
        echo $result;
        exit;
    }

   
    if(isset($_POST['draw'])){
        $draw = trim($_POST['draw']);

        if(isset($_POST['start'])) {
            $row = trim($_POST['start']);
        }
        if(isset($_POST['length'])) {
            $rowperpage = trim($_POST['length']);
        }
        $page_title = "Size";
        $order_column = "";
        $order_column_index = "";
        $order_direction = "";

        if(isset($_POST['order'][0]['column'])) {
            $order_column_index = intval($_POST['order'][0]['column']);
        }
        if(isset($_POST['order'][0]['dir'])) {
            $order_direction = $_POST['order'][0]['dir'] === 'desc' ? 'DESC' : 'ASC';
        }
        $columns = [
            0 => '',
            1 => 'created_date_time',
            2 => 'updated_date_time',
            3 => 'size_name',
            4 => '',
        ];
        if(!empty($order_column_index) && isset($columns[$order_column_index])) {
            $order_column = $columns[$order_column_index];
        }

        $search_text = "";
        if(isset($_POST['search_text'])) {
            $search_text = trim($_POST['search_text']);
        }

        $login_staff_id = "";
        if($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type'] == $GLOBALS['staff_user_type']) {
            $login_staff_id =  $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'];
        }

        $totalRecords = 0;
        $totalRecords = count($obj->getSizeList($row, $rowperpage, $order_column, $order_direction, $search_text));
        $filteredRecords = count($obj->getSizeList('', '', $order_column, $order_direction, $search_text));

        $data = [];

        $SizeList = $obj->getSizeList($row, $rowperpage, $order_column, $order_direction, $search_text);
        
        $sno = $row + 1;
        foreach ($SizeList as $val) {
            $created_date_time = ""; $updated_date_time = ""; $size_name = ""; $size_type = "";
            if(!empty($val['created_date_time']) && $val['created_date_time'] != $GLOBALS['null_value']) {
                $created_date_time = date('d-m-Y H:i:s', strtotime($val['created_date_time']));
            }
            if(!empty($val['updated_date_time']) && $val['updated_date_time'] != $GLOBALS['null_value']) {
                $updated_date_time = date('d-m-Y H:i:s', strtotime($val['updated_date_time']));
            }
            if(!empty($val['size_name']) && $val['size_name'] != $GLOBALS['null_value']){
                $size_name = html_entity_decode($val['size_name']);
                $size_name = $obj->encode_decode('decrypt', $val['size_name']);
            }
            
            $linked_count = 0;
            $linked_count = $obj->GetLinkedCount($GLOBALS['size_table'], $val['size_id']);

            $action = ""; $edit_option = ""; $delete_option = "";
            $edit_access_error = ""; $permission_module = $GLOBALS['size_module']; $permission_action = $edit_action;
            if(!empty($login_staff_id)) {
                include('permission_action.php');
            }
            $delete_access_error = ""; $permission_module = $GLOBALS['size_module']; $permission_action = $delete_action;
            if(!empty($login_staff_id)) {
                include('permission_action.php');
            }

            if(empty($edit_access_error)){
                $edit_option = '<li><a class="dropdown-item" href="Javascript:ShowModalContent('.'\''.$page_title.'\''.', '.'\''.$val['size_id'].'\''.');"><i class="fa fa-pencil"></i>&nbsp; Edit</a></li>';
            }

            if(empty($delete_access_error)){
                if(!empty($linked_count)) { 
                    $delete_option = '<li><a class="dropdown-item text-secondary" style="pointer-events: none; cursor: default;"><i class="fa fa-trash"></i>&nbsp; Delete</a></li>';
                }else{
                    $delete_option = '<li><a class="dropdown-item" href="Javascript:DeleteModalContent('.'\''.$page_title.'\''.', '.'\''.$val['size_id'].'\''.');"><i class="fa fa-trash"></i>&nbsp; Delete</a></li>';
                }
            }
            
            if(empty($edit_access_error) || empty($delete_access_error)){
                $action = '<div class="dropdown">
                            <a href="#" role="button" class="btn btn-dark py-1 px-2" id="dropdownMenuLink'.$val['size_id'].'" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink'.$val['size_id'].'">
                                '.$edit_option.$delete_option.'
                            </ul>
                        </div>';
            }

            $data[] = [
                "sno" => $sno++,
                "created_date_time" => $created_date_time,
                "updated_date_time" => $updated_date_time,
                "size_name" => $size_name,
                "action" => $action
            ];
        }

        $response = [
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $filteredRecords,
            "data" => $data
        ];

        echo json_encode($response);
    } 

    if(isset($_REQUEST['delete_size_id'])) {
        $delete_size_id = filter_input(INPUT_GET, 'delete_size_id', FILTER_SANITIZE_SPECIAL_CHARS);
        $msg = "";
        if(!empty($delete_size_id)) {
            $access_error = ""; $permission_module = $GLOBALS['size_module']; $permission_action = $delete_action;
            if(!empty($login_staff_id)) {
                include('permission_action.php');
            }
            if(empty($access_error)) {
                $unique_id = "";
                $unique_id = $obj->getTableColumnValue($GLOBALS['size_table'], 'size_id', $delete_size_id, 'id');
                if(preg_match("/^\d+$/", $unique_id)) {
                    $linked_count = 0;
                    $linked_count = $obj->GetLinkedCount($GLOBALS['size_table'], $delete_size_id);
                    if(empty($linked_count)) {
                        $size_name = "";
                        $size_name = $obj->getTableColumnValue($GLOBALS['size_table'], 'size_id', $delete_size_id, 'size_name');
            
                        $action = "";
                        if(!empty($size_name)) {
                            $action = "Size Deleted. Name - " .$size_name;
                        }
                        $columns = array(); $values = array();
                        $columns = array('deleted');
                        $values = array(1);
                        $msg = $obj->UpdateSQL($GLOBALS['size_table'], $unique_id, $columns, $values, $action);
                    }
                    else {
                        $msg = "Size cannot be deleted as it is assigned to product";
                    }
                }
                else {
                    $msg = "Invalid Size";
                }
            }
            else {
                $msg = $access_error;
            }
        }
        else {
            $msg = "Empty Size";
        }
        echo $msg;
        exit;
    }
    ?>