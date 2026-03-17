<?php
	include("include_files.php");

    $login_staff_id = "";
    if(isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id']) && !empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'])) {
        if(!empty($GLOBALS['user_type']) && $GLOBALS['user_type'] != $GLOBALS['admin_user_type']) {
            $login_staff_id = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'];
            $permission_module = $GLOBALS['unit_module'];
        }
    }


	if(isset($_REQUEST['show_unit_id'])) { 
        $show_unit_id = "";
        $show_unit_id = filter_input(INPUT_GET, 'show_unit_id', FILTER_SANITIZE_SPECIAL_CHARS);

        $unit_name = "";
        if(!empty($show_unit_id)) {
            $unit_list = array();
            $unit_list = $obj->getTableRecords($GLOBALS['unit_table'], 'unit_id', $show_unit_id, '');
            if(!empty($unit_list)) {
                foreach ($unit_list as $data) {
                    if(!empty($data['unit_name'])) {
                        $unit_name = $obj->encode_decode('decrypt', $data['unit_name']);
                    }
                }
            }
        } 
        ?>
        <form class="poppins pd-20 redirection_form" name="unit_form" method="POST">
			<div class="card-header">
				<div class="row p-2">
					<div class="col-lg-8 col-md-8 col-8 align-self-center">
						<?php if(!empty($show_unit_id)){ ?>
                            <div class="h5">Edit Unit</div>
                        <?php 
                        } else{ ?>
                            <div class="h5">Add Unit</div>
                        <?php
                        } ?>
					</div>
					<div class="col-lg-4 col-md-4 col-4">
						<button class="btn btn-dark float-end" style="font-size:11px;" type="button" onclick="window.open('unit.php','_self')"> <i class="fa fa-arrow-circle-o-left"></i> &ensp; Back </button>
					</div>
				</div>
			</div>
            <div class="row justify-content-center p-3">
                <input type="hidden" name="edit_id" value="<?php if(!empty($show_unit_id)) { echo $show_unit_id; } ?>">
                <div class="col-lg-3 col-md-6 col-12 py-2">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                            <div class="input-group">
                                <input type="text" id="unit_name" name="unit_name" value="<?php if(!empty($unit_name)) { echo $unit_name; } ?>" class="form-control shadow-none" onkeydown="Javascript:KeyboardControls(this,'',50,1);" placeholder="" required="">
                                <label>Unit</label>
                                <?php if(empty($show_unit_id)) { ?>
                                    <div class="input-group-append">
                                        <button class="btn btn-danger" onclick="Javascript:addCreationDetails('unit');"  type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="new_smallfnt">Don't Allow "~ ! $ ^ < > * + = % { } [ ] | ? (Should have atleast one alphabet)"</div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center"> 
                <?php if(empty($show_unit_id)) { ?>
                    <div class="col-lg-6">
                        <div class="table-responsive text-center">
                            <table class="table nowrap cursor smallfnt w-100 table-bordered added_unit_table">
                                <input type="hidden" name="unit_count" value="0">   
                                <thead class="bg-dark smallfnt">
                                    <tr style="white-space:pre;">
                                        <th>#</th>
                                        <th>Unit Name</th>
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
                    <button class="btn btn-danger submit_button" type="button" onClick="Javascript:SaveModalContent(event,'unit_form', 'unit_changes.php', 'unit.php');">
                        Submit
                    </button>
                </div>
            </div>
            <script src="js/select2/js/select2.min.js"></script>
            <script src="js/select2/js/select.js"></script>
            <script type="text/javascript" src="include/js/creation_module.js"></script>
            <script>
                $(document).ready(function() {
                    jQuery('input[name="unit_name"]').on("keypress", function(e) {
                        if(e.keyCode == 50) {
                            addCreationDetails('unit');
                            return false;
                        }
                    });
                });
            </script>
        </form>
		<?php
    } 
    if (isset($_REQUEST['unit_row_index'])) {
        $unit_row_index = filter_input(INPUT_POST, 'unit_row_index', FILTER_SANITIZE_SPECIAL_CHARS);
        $selected_unit_name = filter_input(INPUT_POST, 'selected_unit_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $selected_unit_name = str_replace("@@@", "&", $selected_unit_name);                
        $tr = "
            <tr class='unit_row' id='unit_row{$unit_row_index}'>
                <td class='text-center sno'>{$unit_row_index}</td>
                <td class='text-center'>
                    {$selected_unit_name}
                    <input type='hidden' name='unit_names[]' value='{$selected_unit_name}'>
                </td>
                <td class='text-center product_pad'>
                    <button class='btn btn-danger align-self-center px-2 py-1' type='button'
                        onclick=\"DeleteCreationRow('unit', '{$unit_row_index}')\">
                        <i class='fa fa-trash' aria-hidden='true'></i>
                    </button>
                </td>
            </tr>
        ";

        echo json_encode($tr);
        exit;
    }
    if(isset($_POST['edit_id'])) {
        $unit_name = array(); $unit_name_error = ""; $single_lower_case_name = "";
        $valid_unit = ""; $form_name = "unit_form"; $unit_error = "";
        $single_unit_name = ""; $prev_unit_id = ""; $lower_case_name = array();

        $edit_id = "";
        if(isset($_POST['edit_id'])) {
            $edit_id = $_POST['edit_id'];
            $edit_id = trim($edit_id);
        }
        if(!empty($edit_id)) {
            if(isset($_POST['unit_name'])) {
                $single_unit_name = $_POST['unit_name'];
                $single_unit_name = trim($single_unit_name);
                $unit_name_error = $valid->valid_regular_expression($single_unit_name, "Unit Name", "1", "50");
            }
            if(!empty($unit_name_error)) {
                $valid_unit = $valid->error_display($form_name, "unit_name", $unit_name_error, 'text');
            }
            else {
                $single_unit_name = htmlentities($single_unit_name, ENT_QUOTES);
                $single_lower_case_name = strtolower($single_unit_name);
                $single_unit_name = $obj->encode_decode('encrypt',$single_unit_name);
                if(!empty($single_lower_case_name)) {
                    $prev_unit_id = $obj->CheckUnitAlreadyExists($single_lower_case_name);
                    if(!empty($prev_unit_id)) {
                        if($prev_unit_id != $edit_id) {
                            $unit_error = "This Unit name - " . $single_lower_case_name . " is already exist";
                        }
                    }
                }
            }
        }

        if(empty($edit_id)) {
            if(isset($_POST['unit_names'])) {
                $unit_name = $_POST['unit_names'];
            }
            $inputbox_unit_name = "";
            $inputbox_unit_name = $_POST['unit_name'];

            if(!empty($inputbox_unit_name) && empty($unit_name)) {
                $unit_add_error = "Click Add Button to Append Unit";
                if(!empty($unit_add_error)) {
                    $valid_unit = $valid->error_display($form_name, "unit_name", $unit_add_error, 'text');
                }
            } else if(empty($inputbox_unit_name) && empty($unit_name)) {
                $unit_add_error = "Enter Unit Name";
                if(!empty($unit_add_error)) {
                    $valid_unit = $valid->error_display($form_name, "unit_name", $unit_add_error, 'text');
                }
            } else if(!empty($inputbox_unit_name)) {
                $unit_add_error = "Click Add Button to Append Unit";
                if(!empty($unit_add_error)) {
                    $valid_unit = $valid->error_display($form_name, "unit_name", $unit_add_error, 'text');
                }
            }
            if(!empty($unit_name)) {
                for ($p = 0; $p < count($unit_name); $p++) {
                    if(!preg_match("/^(?=.*[a-zA-Z])[^`~!$^<>*+={}\[\]|?]+$/", $unit_name[$p]) || strlen($unit_name[$p]) > 50) {
                        $unit_name_error = "Invalid Unit name - " . $unit_name[$p];
                    }
                    else {
                        $unit_name[$p] = htmlentities($unit_name[$p], ENT_QUOTES);
                        $lower_case_name[$p] = strtolower($unit_name[$p]);
                        $unit_name[$p] = $obj->encode_decode('encrypt',$unit_name[$p]);
                    }
                }
            }
        }

        $access_error = ""; $permission_module = $GLOBALS['unit_module']; $permission_action = "";
        if(!empty($login_staff_id)) {
            if(!empty($edit_id)) {
                $permission_action = $edit_action;
            }
            else {
                $permission_action = $add_action;
            }
            include('permission_action.php');
        }

        if(!empty($access_error) && empty($unit_name_error)) {
            $unit_name_error = $access_error;
        }

        $result = "";
        if(empty($valid_unit) && empty($unit_name_error)) {
            $check_user_id_ip_address = 0;
            $check_user_id_ip_address = $obj->check_user_id_ip_address();

            if(preg_match("/^\d+$/", $check_user_id_ip_address)) {
                for ($i = 0; $i < count($lower_case_name); $i++) {
                    if(!empty($lower_case_name[$i])) {
                        $prev_unit_id = $obj->CheckUnitAlreadyExists($lower_case_name[$i]);
                        if(!empty($prev_unit_id)) {
                            $unit_error = "This Unit name - " . $lower_case_name[$i] . " is already exist";
                        }
                    }
                }
                $created_date_time = $GLOBALS['create_date_time_label'];
                $updated_date_time = $GLOBALS['create_date_time_label'];
                $creator = $GLOBALS['creator'];
                $bill_company_id = $GLOBALS['bill_company_id'];
                $creator_name = $obj->encode_decode('encrypt', $GLOBALS['creator_name']);

                if(empty($unit_error)) {
                    if(empty($edit_id)) {
                        $action = array();
                        for ($p = 0; $p < count($unit_name); $p++) {
                            if(empty($prev_unit_id)) {
                                if(!empty($unit_name[$p])) {
                                    $action[$p] = "New Unit Created. Name - " . $obj->encode_decode('decrypt', $unit_name[$p]);
                                }

                                $null_value = $GLOBALS['null_value'];
                                $columns = array('created_date_time','updated_date_time', 'creator', 'creator_name','bill_company_id','unit_id', 'unit_name', 'lower_case_name', 'deleted');
                                $values = array($created_date_time, $updated_date_time, $creator, $creator_name,  $bill_company_id,$null_value, $unit_name[$p], $lower_case_name[$p], 0);

                                $unit_insert_id = $obj->InsertSQL($GLOBALS['unit_table'], $columns, $values, 'unit_id', '', $action[$p]);		
                                if(preg_match("/^\d+$/", $unit_insert_id)) {								
                                    $result = array('number' => '1', 'msg' => 'Unit Successfully Created');						
                                }
                                else {
                                    $result = array('number' => '2', 'msg' => $unit_insert_id);
                                }
                            } 
                            else {
                                $result = array('number' => '2', 'msg' => $unit_error);
                            }
                        }
                    } 
                    else if(!empty($edit_id)) {
                        $getUniqueID = "";
                        $getUniqueID = $obj->getTableColumnValue($GLOBALS['unit_table'], 'unit_id', $edit_id, 'id');
                        if(preg_match("/^\d+$/", $getUniqueID)) {
                            $action = "";
                            if(!empty($single_unit_name)) {
                                $action = "Unit Updated. Name - " . $obj->encode_decode('decrypt',$single_unit_name);
                            }
                            $columns = array(); $values = array();
                            $columns = array('updated_date_time','creator_name', 'unit_name', 'lower_case_name');
                            $values = array($updated_date_time, $creator_name, $single_unit_name, $single_lower_case_name);
                            $unit_update_id = $obj->UpdateSQL($GLOBALS['unit_table'], $getUniqueID, $columns, $values, $action);
                            if(preg_match("/^\d+$/", $unit_update_id)) {
                                $result = array('number' => '1', 'msg' => 'Updated Successfully');
                            } 
                            else {
                                $result = array('number' => '2', 'msg' => $unit_update_id);
                            }
                        }
                    }
                } 
                else {
                    $result = array('number' => '2', 'msg' => $unit_error);
                }
            } 
            else {
                $result = array('number' => '2', 'msg' => 'Invalid IP');
            }
        }
        else {
            if(!empty($valid_unit)) {
                $result = array('number' => '3', 'msg' => $valid_unit);
            } else if(!empty($unit_name_error)) {
                $result = array('number' => '2', 'msg' => $unit_name_error);		
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
        $page_title = "Unit";
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
            3 => 'unit_name',
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
        $totalRecords = count($obj->getUnitList($row, $rowperpage, $order_column, $order_direction, $search_text));
        $filteredRecords = count($obj->getUnitList('', '', $order_column, $order_direction, $search_text));

        $data = [];

        $UnitList = $obj->getUnitList($row, $rowperpage, $order_column, $order_direction, $search_text);
        
        $sno = $row + 1;
        foreach ($UnitList as $val) {
            $created_date_time = ""; $updated_date_time = ""; $unit_name = ""; $unit_type = "";
            if(!empty($val['created_date_time']) && $val['created_date_time'] != $GLOBALS['null_value']) {
                $created_date_time = date('d-m-Y H:i:s', strtotime($val['created_date_time']));
            }
            if(!empty($val['updated_date_time']) && $val['updated_date_time'] != $GLOBALS['null_value']) {
                $updated_date_time = date('d-m-Y H:i:s', strtotime($val['updated_date_time']));
            }
            if(!empty($val['unit_name']) && $val['unit_name'] != $GLOBALS['null_value']){
                $unit_name = html_entity_decode($val['unit_name']);
                $unit_name = $obj->encode_decode('decrypt', $unit_name);
            }
            
            $linked_count = 0;
            $linked_count = $obj->GetLinkedCount($GLOBALS['unit_table'], $val['unit_id']);

            $action = ""; $edit_option = ""; $delete_option = "";
            $edit_access_error = ""; $permission_module = $GLOBALS['unit_module']; $permission_action = $edit_action;
            if(!empty($login_staff_id)) {
                include('permission_action.php');
            }
            $delete_access_error = ""; $permission_module = $GLOBALS['unit_module']; $permission_action = $delete_action;
            if(!empty($login_staff_id)) {
                include('permission_action.php');
            }

            if(empty($edit_access_error)){
                $edit_option = '<li><a class="dropdown-item" href="Javascript:ShowModalContent('.'\''.$page_title.'\''.', '.'\''.$val['unit_id'].'\''.');"><i class="fa fa-pencil"></i>&nbsp; Edit</a></li>';
            }

            if(empty($delete_access_error)){
                if(!empty($linked_count)) { 
                    $delete_option = '<li><a class="dropdown-item text-secondary" style="pointer-events: none; cursor: default;"><i class="fa fa-trash"></i>&nbsp; Delete</a></li>';
                }else{
                    $delete_option = '<li><a class="dropdown-item" href="Javascript:DeleteModalContent('.'\''.$page_title.'\''.', '.'\''.$val['unit_id'].'\''.');"><i class="fa fa-trash"></i>&nbsp; Delete</a></li>';
                }
            }
            
            if(empty($edit_access_error) || empty($delete_access_error)){
                $action = '<div class="dropdown">
                            <a href="#" role="button" class="btn btn-dark py-1 px-2" id="dropdownMenuLink'.$val['unit_id'].'" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink'.$val['unit_id'].'">
                                '.$edit_option.$delete_option.'
                            </ul>
                        </div>';
            }

            $data[] = [
                "sno" => $sno++,
                "created_date_time" => $created_date_time,
                "updated_date_time" => $updated_date_time,
                "unit_name" => $unit_name,
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

    if(isset($_REQUEST['delete_unit_id'])) {
        $delete_unit_id = filter_input(INPUT_GET, 'delete_unit_id', FILTER_SANITIZE_SPECIAL_CHARS);
        $msg = "";
        if(!empty($delete_unit_id)) {
            $access_error = ""; $permission_module = $GLOBALS['unit_module']; $permission_action = $delete_action;
            if(!empty($login_staff_id)) {
                include('permission_action.php');
            }
            if(empty($access_error)) {
                $unique_id = "";
                $unique_id = $obj->getTableColumnValue($GLOBALS['unit_table'], 'unit_id', $delete_unit_id, 'id');
                if(preg_match("/^\d+$/", $unique_id)) {
                    $linked_count = 0;
                    $linked_count = $obj->GetLinkedCount($GLOBALS['unit_table'], $delete_unit_id);
                    if(empty($linked_count)) {
                        $unit_name = "";
                        $unit_name = $obj->getTableColumnValue($GLOBALS['unit_table'], 'unit_id', $delete_unit_id, 'unit_name');
            
                        $action = "";
                        if(!empty($unit_name)) {
                            $action = "Unit Deleted. Name - " .$unit_name;
                        }
                        $columns = array(); $values = array();
                        $columns = array('deleted');
                        $values = array(1);
                        $msg = $obj->UpdateSQL($GLOBALS['unit_table'], $unique_id, $columns, $values, $action);
                    }
                    else {
                        $msg = "Unit cannot be deleted as it is assigned to product";
                    }
                }
                else {
                    $msg = "Invalid Unit";
                }
            }
            else {
                $msg = $access_error;
            }
        }
        else {
            $msg = "Empty Unit";
        }
        echo $msg;
        exit;
    }
    ?>