<?php
	include("include_files.php");

    $login_staff_id = "";
    if(isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id']) && !empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'])) {
        if(!empty($GLOBALS['user_type']) && $GLOBALS['user_type'] != $GLOBALS['admin_user_type']) {
            $login_staff_id = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'];
            $permission_module = $GLOBALS['payment_mode_module'];
        }
    }
	if(isset($_REQUEST['show_payment_mode_id'])) { 
        $show_payment_mode_id = filter_input(INPUT_GET, 'show_payment_mode_id', FILTER_SANITIZE_SPECIAL_CHARS);
        $show_payment_mode_id =trim($show_payment_mode_id);
        $payment_mode_name = ""; 
        if(!empty($show_payment_mode_id)){
            $payment_mode_list = array();
            $payment_mode_list = $obj->getTableRecords($GLOBALS['payment_mode_table'],'payment_mode_id',$show_payment_mode_id,'');
            if(!empty($payment_mode_list)){
                foreach($payment_mode_list as $data){
                    if(!empty($data['payment_mode_name']) && $data['payment_mode_name'] != $GLOBALS['null_value']){
                        $payment_mode_name = $data['payment_mode_name'];
                    }
                }
            }
        }
        ?>
        <form class="poppins pd-20 redirection_form" name="payment_mode_form" method="POST">
            <div class="card-header">
				<div class="row p-2">
					<div class="col-lg-8 col-md-8 col-8 align-self-center">
                        <?php if(!empty($show_payment_mode_id)) { ?>
                            <div class="h5">Edit Payment Mode</div>
                        <?php } else { ?>
						    <div class="h5">Add Payment Mode</div>
                        <?php } ?>
					</div>
					<div class="col-lg-4 col-md-4 col-4">
						<button class="btn btn-dark float-end" style="font-size:11px;" type="button" onclick="window.open('payment_mode.php','_self')"> <i class="fa fa-arrow-circle-o-left"></i> &ensp; Back </button>
					</div>
				</div>
			</div>
			<div class="row justify-content-center p-3">
				<input type="hidden" name="edit_id" value="<?php if(!empty($show_payment_mode_id)) { echo $show_payment_mode_id; } ?>">
				<div class="col-lg-8 col-md-10 col-10">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-8 col-12">
                            <div class="form-label-group in-border">
                                <div class="input-group mb-1">
                                    <input type="text" id="payment_mode_name" name="payment_mode_name"   class="form-control shadow-none" value="<?php if(!empty($payment_mode_name)){echo $payment_mode_name;} ?>" onkeydown="Javascript:KeyboardControls(this,'text',25,'');" onkeyup="Javascript:InputBoxColor(this,'text');">
                                    <label>Payment Mode <span class="text-danger">*</span></label>
                                    <?php if(empty($show_payment_mode_id)){ ?>
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary" type="button" onClick="Javascript:addCreationDetails('payment_mode');"><i class="fa fa-plus"></i></button>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="new_smallfnt">Text Only (Character up to 25)</div>
                        </div> 
                    </div>
                </div>     
                <?php if(empty($show_payment_mode_id)){ ?>
                    <div class="col-lg-6 col-md-8 col-12 mt-3">
                        <div class="table-responsive smallfnt text-center">
                            <input type="hidden" name="payment_mode_count" value="0">
                            <table class="table nowrap cursor table-bordered text-center added_payment_mode_table">
                                <thead class="bg-dark">
                                    <tr class="text-white">
                                        <th>S.No</th>
                                        <th>Payment Mode</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>    
                        </div>
                    </div>
                <?php } ?>
                <div class="col-md-12 pt-3 text-center">
                    <button class="btn btn-dark submit_button" type="button" onClick="Javascript:SaveModalContent(event,'payment_mode_form', 'payment_mode_changes.php', 'payment_mode.php');">
                        Submit
                    </button>
                </div>
			</div>
            <script>
                $(document).ready(function() {
                    jQuery('#payment_mode_name').on("keypress", function(e) {
                        if (e.keyCode == 13) {
                            addCreationDetails('payment_mode');
                            return false; 
                        }
                    });
                });
            </script>
        </form>
		<?php
    } 

    if(isset($_POST['edit_id'])) {
        $payment_mode_name = array(); $payment_mode_name_error = ""; $single_lower_case_name = "";
        $valid_payment_mode = ""; $form_name = "payment_mode_form"; $payment_mode_error = "";
        $single_payment_mode_name = ""; $prev_payment_mode_id = ""; $lower_case_name = array();
        $bill_company_id = $GLOBALS['bill_company_id'];

        $edit_id = "";
        if(isset($_POST['edit_id'])) {
            $edit_id = $_POST['edit_id'];
            $edit_id = trim($edit_id);
        }
        if(!empty($edit_id)) {
            if(isset($_POST['payment_mode_name'])) {
                $single_payment_mode_name = $_POST['payment_mode_name'];
                $single_payment_mode_name = trim($single_payment_mode_name);
                $payment_mode_name_error = $valid->valid_regular_expression($single_payment_mode_name, "payment_mode Name", "1", "50");
            }
            if(!empty($payment_mode_name_error)) {
                $valid_payment_mode = $valid->error_display($form_name, "payment_mode_name", $payment_mode_name_error, 'text');
            }
            else {
                $single_payment_mode_name = htmlentities($single_payment_mode_name, ENT_QUOTES);
                $single_lower_case_name = strtolower($single_payment_mode_name);
                if(!empty($single_lower_case_name)) {
                    $prev_payment_mode_id = $obj->CheckPaymentModeAlreadyExists($bill_company_id, $single_lower_case_name);
                    if(!empty($prev_payment_mode_id)) {
                        if($prev_payment_mode_id != $edit_id) {
                            $payment_mode_error = "This payment_mode name - " . $single_lower_case_name . " is already exist";
                        }
                    }
                }
            }
        }

        if(empty($edit_id)) {
            if(isset($_POST['payment_mode_names'])) {
                $payment_mode_name = $_POST['payment_mode_names'];
            }
            $inputbox_payment_mode_name = "";
            $inputbox_payment_mode_name = $_POST['payment_mode_name'];

            if(!empty($inputbox_payment_mode_name) && empty($payment_mode_name)) {
                $payment_mode_add_error = "Click Add Button to Append payment_mode";
                if(!empty($payment_mode_add_error)) {
                    $valid_payment_mode = $valid->error_display($form_name, "payment_mode_name", $payment_mode_add_error, 'text');
                }
            } else if(empty($inputbox_payment_mode_name) && empty($payment_mode_name)) {
                $payment_mode_add_error = "Enter payment_mode Name";
                if(!empty($payment_mode_add_error)) {
                    $valid_payment_mode = $valid->error_display($form_name, "payment_mode_name", $payment_mode_add_error, 'text');
                }
            } else if(!empty($inputbox_payment_mode_name)) {
                $payment_mode_add_error = "Click Add Button to Append payment_mode";
                if(!empty($payment_mode_add_error)) {
                    $valid_payment_mode = $valid->error_display($form_name, "payment_mode_name", $payment_mode_add_error, 'text');
                }
            }
            if(!empty($payment_mode_name)) {
                for ($p = 0; $p < count($payment_mode_name); $p++) {
                    if(!preg_match("/^(?=.*[a-zA-Z])[^`~!$^<>*+={}\[\]|?]+$/", $payment_mode_name[$p]) || strlen($payment_mode_name[$p]) > 50) {
                        $payment_mode_name_error = "Invalid payment_mode name - " . $payment_mode_name[$p];
                    }
                    else {
                        $payment_mode_name[$p] = htmlentities($payment_mode_name[$p], ENT_QUOTES);
                        $lower_case_name[$p] = strtolower($payment_mode_name[$p]);
                    }
                }
            }
        }

        $access_error = ""; $permission_module = $GLOBALS['payment_mode_module']; $permission_action = "";
        if(!empty($login_staff_id)) {
            if(!empty($edit_id)) {
                $permission_action = $edit_action;
            }
            else {
                $permission_action = $add_action;
            }
            include('permission_action.php');
        }

        if(!empty($access_error) && empty($payment_mode_name_error)) {
            $payment_mode_name_error = $access_error;
        }

        $result = "";
        if(empty($valid_payment_mode) && empty($payment_mode_name_error)) {
            $check_user_id_ip_address = 0;
            $check_user_id_ip_address = $obj->check_user_id_ip_address();

            if(preg_match("/^\d+$/", $check_user_id_ip_address)) {
                if(empty($edit_id)) {
                    for ($i = 0; $i < count($lower_case_name); $i++) {
                        if(!empty($lower_case_name[$i])) {
                            $prev_payment_mode_id = $obj->CheckPaymentModeAlreadyExists($bill_company_id, $lower_case_name[$i]);
                            if(!empty($prev_payment_mode_id)) {
                                $payment_mode_error = "This payment_mode name - " . $lower_case_name[$i] . " already exists";
                            }
                        }
                    }
                }
                $created_date_time = $GLOBALS['create_date_time_label'];
                $updated_date_time = $GLOBALS['create_date_time_label'];
                $creator = $GLOBALS['creator'];
                $creator_name = $obj->encode_decode('encrypt', $GLOBALS['creator_name']);

                if(empty($payment_mode_error)) {
                    if(empty($edit_id)) {
                        $action_log = array();
                        for ($p = 0; $p < count($payment_mode_name); $p++) {
                            if(!empty($payment_mode_name[$p])) {
                                $action_log[$p] = "New payment_mode Created. Name - " . $payment_mode_name[$p];
                            }

                            $null_value = $GLOBALS['null_value'];
                            $columns = array('created_date_time','updated_date_time', 'creator', 'creator_name','bill_company_id','payment_mode_id', 'payment_mode_name', 'lower_case_name', 'deleted');
                            $values = array($created_date_time, $updated_date_time, $creator, $creator_name,  $bill_company_id,$null_value, $payment_mode_name[$p], $lower_case_name[$p], 0);

                            $payment_mode_insert_id = $obj->InsertSQL($GLOBALS['payment_mode_table'], $columns, $values, 'payment_mode_id', '', $action_log[$p]);		
                            if(preg_match("/^\d+$/", $payment_mode_insert_id)) {								
                                $result = array('number' => '1', 'msg' => 'payment_mode Successfully Created');						
                            }
                            else {
                                $result = array('number' => '2', 'msg' => $payment_mode_insert_id);
                            }
                        }
                    } 
                    else if(!empty($edit_id)) {
                        $getUniqueID = "";
                        $getUniqueID = $obj->getTableColumnValue($GLOBALS['payment_mode_table'], 'payment_mode_id', $edit_id, 'id');
                        if(preg_match("/^\d+$/", $getUniqueID)) {
                            $action_log = "";
                            if(!empty($single_payment_mode_name)) {
                                $action_log = "payment_mode Updated. Name - " . $single_payment_mode_name;
                            }

                            $columns = array(); $values = array();
                            $columns = array('updated_date_time','creator_name', 'payment_mode_name', 'lower_case_name');
                            $values = array($updated_date_time, $creator_name, $single_payment_mode_name, $single_lower_case_name);
                            $payment_mode_update_id = $obj->UpdateSQL($GLOBALS['payment_mode_table'], $getUniqueID, $columns, $values, $action_log);
                            if(preg_match("/^\d+$/", $payment_mode_update_id)) {
                                $result = array('number' => '1', 'msg' => 'Updated Successfully');
                            } 
                            else {
                                $result = array('number' => '2', 'msg' => $payment_mode_update_id);
                            }
                        }
                    }
                } 
                else {
                    $result = array('number' => '2', 'msg' => $payment_mode_error);
                }
            } 
            else {
                $result = array('number' => '2', 'msg' => 'Invalid IP');
            }
        }
        else {
            if(!empty($valid_payment_mode)) {
                $result = array('number' => '3', 'msg' => $valid_payment_mode);
            } else if(!empty($payment_mode_name_error)) {
                $result = array('number' => '2', 'msg' => $payment_mode_name_error);		
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
        $page_title = "Payment Mode";
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
            3 => 'payment_mode_name',
            4 => '',
        ];
        if(!empty($order_column_index) && isset($columns[$order_column_index])) {
            $order_column = $columns[$order_column_index];
        }

        $search_text = "";
        if(isset($_POST['search_text'])) {
            $search_text = trim($_POST['search_text']);
        }

        $totalRecords = 0;
        $totalRecords = count($obj->getPaymentModeTable($row, $rowperpage, $order_column, $order_direction, $search_text));
        $filteredRecords = count($obj->getPaymentModeTable('', '', $order_column, $order_direction, $search_text));

        $data = [];

        $payment_modeList = $obj->getPaymentModeTable($row, $rowperpage, $order_column, $order_direction, $search_text);
        
        $sno = $row + 1;
        foreach ($payment_modeList as $val) {
            $created_date_time = ""; $updated_date_time = ""; $payment_mode_name = ""; $payment_mode_type = "";
            if(!empty($val['created_date_time']) && $val['created_date_time'] != $GLOBALS['null_value']) {
                $created_date_time = date('d-m-Y H:i:s', strtotime($val['created_date_time']));
            }
            if(!empty($val['updated_date_time']) && $val['updated_date_time'] != $GLOBALS['null_value']) {
                $updated_date_time = date('d-m-Y H:i:s', strtotime($val['updated_date_time']));
            }
            if(!empty($val['payment_mode_name']) && $val['payment_mode_name'] != $GLOBALS['null_value']){
                $payment_mode_name = html_entity_decode($val['payment_mode_name']);
            }
            
            $linked_count = 0;
            $linked_count = $obj->GetLinkedCount($GLOBALS['payment_mode_table'], $val['payment_mode_id']);

            $action = ""; $edit_option = ""; $delete_option = "";
            $edit_access_error = ""; $permission_module = $GLOBALS['payment_mode_module']; $permission_action = $edit_action;
            if(!empty($login_staff_id)) {
                include('permission_action.php');
            }
            $delete_access_error = ""; $permission_module = $GLOBALS['payment_mode_module']; $permission_action = $delete_action;
            if(!empty($login_staff_id)) {
                include('permission_action.php');
            }

            if(empty($edit_access_error)){
                $edit_option = '<li><a class="dropdown-item" href="Javascript:ShowModalContent('.'\''.$page_title.'\''.', '.'\''.$val['payment_mode_id'].'\''.');"><i class="fa fa-pencil"></i>&nbsp; Edit</a></li>';
            }

            if(empty($delete_access_error)){
                if(!empty($linked_count)) { 
                    $delete_option = '<li><a class="dropdown-item text-secondary" style="pointer-events: none; cursor: default;"><i class="fa fa-trash"></i>&nbsp; Delete</a></li>';
                }else{
                    $delete_option = '<li><a class="dropdown-item" href="Javascript:DeleteModalContent('.'\''.$page_title.'\''.', '.'\''.$val['payment_mode_id'].'\''.');"><i class="fa fa-trash"></i>&nbsp; Delete</a></li>';
                }
            }
            
            if(empty($edit_access_error) || empty($delete_access_error)){
                $action = '<div class="dropdown text-center">
                            <a href="#" role="button" class="btn btn-dark py-1 px-2 border-0" id="dropdownMenuLink'.$val['payment_mode_id'].'" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink'.$val['payment_mode_id'].'">
                                '.$edit_option.$delete_option.'
                            </ul>
                        </div>';
            }

            $data[] = [
                "sno" => $sno++,
                "created_date_time" => $created_date_time,
                "updated_date_time" => $updated_date_time,
                "payment_mode_name" => $payment_mode_name,
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
        exit;
    } 
    

    if(isset($_REQUEST['delete_payment_mode_id'])) {
        $delete_payment_mode_id = $_REQUEST['delete_payment_mode_id'];
        $msg = "";
        if(!empty($delete_payment_mode_id)) {	
             $access_error = ""; $permission_module = $GLOBALS['payment_mode_module']; $permission_action = $delete_action;
            if(!empty($login_staff_id)) {
                include('permission_action.php');
            }
            if(empty($access_error)) {
                $payment_mode_unique_id = "";
                $payment_mode_unique_id = $obj->getTableColumnValue($GLOBALS['payment_mode_table'], 'payment_mode_id', $delete_payment_mode_id, 'id');
                if(preg_match("/^\d+$/", $payment_mode_unique_id)) {
                    $payment_mode_name = "";
                    $payment_mode_name = $obj->getTableColumnValue($GLOBALS['payment_mode_table'], 'payment_mode_id', $delete_payment_mode_id, 'payment_mode_name');
                    $action_log = "";
                    if(!empty($payment_mode_name)) {
                        $action_log = "Payment Mode Deleted - ".$payment_mode_name;
                    }
                    $linked_count = 0;
                    $linked_count = $obj->GetLinkedCount($GLOBALS['payment_mode_table'], $delete_payment_mode_id); 
                
                    if(empty($linked_count)) {
                        $columns = array(); $values = array();			
                        $columns = array('deleted');
                        $values = array(1);
                        $msg = $obj->UpdateSQL($GLOBALS['payment_mode_table'], $payment_mode_unique_id, $columns, $values, $action_log);
                    }
                    else {
                        $msg = "This payment mode is associated with other screens";
                    }
                }
            } else {
                $msg = $access_error;
            }
        } else {
            $msg = "Empty Payment Mode";
        }
        echo $msg;
        exit;	
    }

    if (isset($_REQUEST['payment_mode_row_index'])) {

        $payment_mode_row_index = $_REQUEST['payment_mode_row_index'];
        $selected_payment_mode_name = $_REQUEST['selected_payment_mode_name'];
        $selected_payment_mode_name = str_replace("@@@", "&", $selected_payment_mode_name);

        $tr = "<tr class='payment_mode_row' id='payment_mode_row{$payment_mode_row_index}'>
                <td class='text-center sno'>{$payment_mode_row_index}</td>
                <td class='text-center'>
                    {$selected_payment_mode_name}
                    <input type='hidden' name='payment_mode_names[]' value='{$selected_payment_mode_name}'>
                </td>
                <td class='text-center product_pad'>
                    <button class='btn btn-danger px-2 py-1' type='button'
                    onclick=\"DeleteCreationRow('payment_mode','{$payment_mode_row_index}')\">
                    <i class='fa fa-trash'></i>
                    </button>
                </td>
            </tr>";

        echo json_encode($tr);
        exit;
}
?>
