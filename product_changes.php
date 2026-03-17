<?php
	include("include_files.php");
    $login_staff_id = "";
    if(isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id']) && !empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'])) {
        if(!empty($GLOBALS['user_type']) && $GLOBALS['user_type'] != $GLOBALS['admin_user_type']) {
            $login_staff_id = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'];
            $permission_module = $GLOBALS['product_module'];
        }
    }
	if(isset($_REQUEST['show_product_id'])) { 
        $show_product_id = "";
        $show_product_id = filter_input(INPUT_GET, 'show_product_id', FILTER_SANITIZE_SPECIAL_CHARS);

        
        $add_custom = 0;
        if(isset($_REQUEST['add_custom'])) {
            $add_custom = $_REQUEST['add_custom'];
        }

        $custom_product_form = "";
		if(isset($_REQUEST['form_name'])) {
			$custom_product_form = $_REQUEST['form_name'];
			$custom_product_form = trim($custom_product_form);
		}

        
        $unit_id=""; $description = ""; $unit_id = ""; $unit_name = ""; $product_name = ""; $product_tax = ""; $hsn_code = 0; $size_id  = "";
        if(!empty($show_product_id)) {
            $product_list = array();
			$product_list = $obj->getTableRecords($GLOBALS['product_table'], 'product_id', $show_product_id, '');
            if(!empty($product_list)) {
                foreach($product_list as $data) {
                    if(!empty($data['product_name'])) {
                        $product_name = $obj->encode_decode('decrypt', $data['product_name']);
					}
					if(!empty($data['description'])) {
                        $description = $obj->encode_decode('decrypt', $data['description']);
						$description = htmlentities($description, ENT_QUOTES);
					}
					if(!empty($data['unit_id'])) {
                        $unit_id = $data['unit_id'];
					}			
                    if (!empty($data['product_tax']) && $data['product_tax'] != $GLOBALS['null_value']) {
                        $product_tax = $data['product_tax'];
                    }
                    if (!empty($data['hsn_code']) && $data['hsn_code'] != $GLOBALS['null_value']) {
                        $hsn_code = $data['hsn_code'];
                    }
                    if(!empty($data['size_id'])) {
                        $size_id = $data['size_id'];
					}	
                   
                }
            }
		}
		$unit_list = array();
	    $unit_list = $obj->getTableRecords($GLOBALS['unit_table'], '', '', ''); 

        $size_list = array();
	    $size_list = $obj->getTableRecords($GLOBALS['size_table'], '', '', '');

        
        ?>
        <form class="poppins pd-20 redirection_form" name="product_form" method="POST">
               <?php if(empty($add_custom) && $add_custom == 0) { ?>
                    <div class="card-header">
                        <div class="row p-2">
                            <div class="col-lg-8 col-md-8 col-8 align-self-center">
                                    <?php if(!empty($show_product_id)){ ?>
                                        <div class="h5">Edit Product</div>
                                    <?php 
                                    } else{ ?>
                                        <div class="h5">Add Product</div>
                                    <?php
                                    } ?>
                            </div>
                            <div class="col-lg-4 col-md-4 col-4">
                                <button class="btn btn-dark float-end" style="font-size:11px;" type="button" onclick="window.open('product.php','_self')"> <i class="fa fa-arrow-circle-o-left"></i> &ensp; Back </button>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <div class="row justify-content-center p-3">
                <input type="hidden" name="edit_id" value="<?php if(!empty($show_product_id)) { echo $show_product_id; } ?>">
                <input type="hidden" name="add_custom" value="<?php if(!empty($add_custom)) { echo $add_custom; } ?>">
                <input type="hidden" name="custom_product_form" value="<?php if(!empty($custom_product_form)) { echo $custom_product_form; } ?>">
                <div class="col-lg-3 col-md-4 col-12 px-lg-1 py-2">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                            <input type="text" id="product_name" value="<?php if(!empty($product_name)) { echo $product_name; } ?>" name="product_name" class="form-control shadow-none" onkeydown="Javascript:KeyboardControls(this,'',50,1);" placeholder="" required>
                            <label>Product Name *</label>
                        </div>
                        <div class="new_smallfnt">Contains Text, Symbols &amp;, -,',.</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-6 py-2 px-lg-1">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                            <select class="select2 select2-danger" data-dropdown-css-class="select2-danger"  name="unit_id" style="width: 100%;">
                                <option value="">Select Unit *</option>
                                 <?php if(!empty($unit_list)) {
                                    foreach($unit_list as $data) { ?>
                                        <option value="<?php if(!empty($data['unit_id'])) { echo $data['unit_id']; } ?>" <?php if(!empty($data['unit_id']) && ($data['unit_id'] == $unit_id))  { ?>selected<?php } ?>><?php if(!empty($data['unit_name'])) { echo $obj->encode_decode('decrypt', $data['unit_name']); } ?></option>
                                   <?php }
                                } ?>
                            </select>
                            <label>Select Unit</label>
                        </div>
                    </div>
                </div>  
                 <div class="col-lg-3 col-md-4 col-6 py-2 px-lg-1">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                            <select class="select2 select2-danger" data-dropdown-css-class="select2-danger"  name="size_id" style="width: 100%;">
                                <option value="">Select Size *</option>
                                 <?php if(!empty($size_list)) {
                                    foreach($size_list as $data) { ?>
                                        <option value="<?php if(!empty($data['size_id'])) { echo $data['size_id']; } ?>" <?php if(!empty($data['size_id']) && ($data['size_id'] == $size_id))  { ?>selected<?php } ?>><?php if(!empty($data['size_name'])) { echo $obj->encode_decode('decrypt',$data['size_name']); } ?></option>
                                   <?php }
                                } ?>
                            </select>
                            <label>Select Size</label>
                        </div>
                    </div>
                </div>  
                <div class="col-lg-2 col-md-4 col-12 px-lg-1 py-2">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                             <input type="text" id="hsn_code" value="<?php if(!empty($hsn_code)) { echo $hsn_code; } ?>" name="hsn_code" class="form-control shadow-none" onkeydown="Javascript:KeyboardControls(this,'number',15,1);" placeholder="" required>
                            <label>HSN Code </label>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-lg-2 col-md-4 col-12 px-lg-1 py-2">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                            <select class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" name = "product_tax">
                                <option value = "">Select Tax</option>
                                <option value="0%" <?php if($product_tax == "0%") { ?>selected<?php } ?>>0%</option>
                                <option value="5%" <?php if(!empty($product_tax) && $product_tax == "5%") { ?>selected<?php } ?>>5%</option>
                                <option value="12%" <?php if(!empty($product_tax) && $product_tax == "12%") { ?>selected<?php } ?>>12%</option>
                                <option value="18%" <?php if(!empty($product_tax) && $product_tax == "18%") { ?>selected<?php } ?>>18%</option>
                                <option value="28%" <?php if(!empty($product_tax) && $product_tax == "28%") { ?>selected<?php } ?>>28%</option>
                            </select>
                            <label>Select Tax</label>
                        </div>
                    </div>        
                </div> -->
                <div class="col-lg-3 col-md-4 col-12 px-lg-1 py-2">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                            <textarea class="form-control" id="description" name="description" onkeydown="Javascript:KeyboardControls(this,'',150,'1');" placeholder="Description"><?php if(!empty($description)){echo $description;}?></textarea>
                            <label>Description</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 pt-3 text-center">
                    <button class="btn btn-danger submit_button" type="button" onClick="Javascript:SaveModalContent(event,'product_form', 'product_changes.php', 'product.php');">
                    Submit
                </button>
                </div>
            </div>
            <script>
                <?php if(isset($add_custom) && $add_custom == '1') { ?>
                    jQuery('#CustomProductModal').on('shown.bs.modal', function () {
                        $(this).find('select').select2({
                            dropdownParent: $('#CustomProductModal') // important for select2 inside modal
                        });
                    });
                <?php } ?>  
            </script>
            <script src="include/select2/js/select2.min.js"></script>
            <script src="include/select2/js/select.js"></script>
        </form>
		<?php
    } 

     if(isset($_POST['edit_id'])) {	
        $product_name = ""; $product_name_error = ""; $unit_id = ""; $unit_id_error = ""; $hsn_code = 0; $hsn_code_error = ""; $product_tax = 0; $product_tax_error = ""; $description = ""; $description_error = ""; $form_name = "product_form"; $size_id = ""; $size_id_error = ""; $stock_maintain = 0;

        if(isset($_POST['edit_id'])) {
            $edit_id = $_POST['edit_id'];
            $edit_id = trim($edit_id);
        }

        $add_custom = 0;
        if(isset($_POST['add_custom'])) {
            $add_custom = $_POST['add_custom'];
        }
       
        if(isset($_POST['product_name'])) {
            $product_name = trim($_POST['product_name']);
            $product_name_error = $valid->valid_regular_expression($product_name,'Product Name','1','50');
        }
        if(!empty($product_name_error)) {
            if(!empty($valid_product)) {
				$valid_product = $valid_product." ".$valid->error_display($form_name, "product_name", $product_name_error, 'text');
			}
			else {
				$valid_product = $valid->error_display($form_name, "product_name", $product_name_error, 'text');
			}
		}

        
        if(isset($_POST['unit_id'])) {
            $unit_id = trim($_POST['unit_id']);
            $unit_id_error = $valid->common_validation($unit_id, 'Unit', 'select');
        }
        if(!empty($unit_id_error)) {
            if(!empty($valid_product)) {
				$valid_product = $valid_product." ".$valid->error_display($form_name, "unit_id", $unit_id_error, 'select');
			}
			else {
				$valid_product = $valid->error_display($form_name, "unit_id", $unit_id_error, 'select');
			}
		}

        
        if(isset($_POST['size_id'])) {
            $size_id = trim($_POST['size_id']);
            $size_id_error = $valid->common_validation($size_id, 'Size', 'select');
        }
        if(!empty($size_id_error)) {
            if(!empty($valid_product)) {
				$valid_product = $valid_product." ".$valid->error_display($form_name, "size_id", $size_id_error, 'select');
			}
			else {
				$valid_product = $valid->error_display($form_name, "size_id", $size_id_error, 'select');
			}
		}


        

        if (isset($_POST['hsn_code'])) {
            $hsn_code = $_POST['hsn_code'];
            $hsn_code = trim($hsn_code);
            $hsn_code_error = $valid->valid_number($hsn_code, 'hsn_code', '0', '6');
            
            if (!empty($hsn_code_error)) {
                if (!empty($valid_product)) {
                    $valid_product = $valid_product . " " . $valid->error_display($form_name, 'hsn_code', $hsn_code_error, 'text');
                } else {
                    $valid_product = $valid->error_display($form_name, 'hsn_code', $hsn_code_error, 'text');
                }
            }
        }

        $allowed_taxes = ['0%', '5%', '12%', '18%', '28%'];

        if (isset($_POST['product_tax'])) {
            $product_tax = $_POST['product_tax'];
            $product_tax = trim($product_tax);
            if(!empty($product_tax)) {
                if (!in_array($product_tax, $allowed_taxes, true)) {
                    $product_tax_error =  "Invalid tax value!";                     
                }
            }
            // $product_tax_error = $valid->valid_number($product_tax, 'product_tax', '1', '5');
            
            if (!empty($product_tax_error)) {
                if (!empty($valid_product)) {
                    $valid_product = $valid_product . " " . $valid->error_display($form_name, 'product_tax', $product_tax_error, 'select');
                } else {
                    $valid_product = $valid->error_display($form_name, 'product_tax', $product_tax_error, 'select');
                }
            }
        }

        if(isset($_POST['description'])) {
            $description = trim($_POST['description']);
            $description_error = $valid->valid_address($description,'Description','','150');
        }
        if(!empty($description_error)) {
            if(!empty($valid_product)) {
				$valid_product = $valid_product." ".$valid->error_display($form_name, "description", $description_error, 'text');
			}
			else {
				$valid_product = $valid->error_display($form_name, "description", $description_error, 'text');
			}
		}



        $access_error = ""; $permission_module = $GLOBALS['product_module']; $permission_action = "";
        if(!empty($login_staff_id)) {
            if(!empty($edit_id)) {
                $permission_action = $edit_action;
            }
            else {
                $permission_action = $add_action;
            }
            include('permission_action.php');
        }

        if(!empty($access_error) && empty($product_error)) {
            $product_error = $access_error;
        }
        
        

        $result = "";
        if (empty($valid_product) && empty($product_error)) {
            $check_user_id_ip_address = "";
            $check_user_id_ip_address = $obj->check_user_id_ip_address();
            if (preg_match("/^\d+$/", $check_user_id_ip_address)) {
                $lower_case_name = ""; $unit_name = ""; $subunit_name = "";
                
                if (!empty($product_name)) {
                    $lower_case_name = strtolower($product_name);
                    $product_name = $obj->encode_decode('encrypt', $product_name);
                    $lower_case_name = $obj->encode_decode('encrypt', $lower_case_name);
                } else {
                    $product_name = $GLOBALS['null_value'];
                    $lower_case_name = $GLOBALS['null_value'];
                }
                if(empty($hsn_code)) {
                    $hsn_code = $GLOBALS['null_value'];
                }
                if(empty($product_tax)) {
                    $product_tax = $GLOBALS['null_value'];
                }

                if (!empty($unit_id)) {
                    $unit_name = $obj->getTableColumnValue($GLOBALS['unit_table'], 'unit_id', $unit_id, 'unit_name');
                } else {
                    $unit_id = $GLOBALS['null_value'];
                    $unit_name = $GLOBALS['null_value'];
                }
                if(!empty($description)) {
                    $description = $obj->encode_decode('encrypt', $description);
                    $description = html_entity_decode($description);
                }else{
                    $description = $GLOBALS['null_value'];
                }
                
                
                if (!empty($size_id)) {
                    $size_name = $obj->getTableColumnValue($GLOBALS['size_table'], 'size_id', $size_id, 'size_name');
                } else {
                    $size_id = $GLOBALS['null_value'];
                    $size_name = $GLOBALS['null_value'];
                }
               
                
                
                $prev_product_id = "";
                $product_error = "";
                if (!empty($lower_case_name)) {
                    $prev_product_id = $obj->getTableColumnValue($GLOBALS['product_table'], 'lower_case_name', $lower_case_name, 'product_id');
                    if (!empty($prev_product_id) && ($prev_product_id != $edit_id)) {
                        $product_error = "This Product name already exists";
                    }
                }
                $bill_company_id = $GLOBALS['bill_company_id'];
                $created_date_time = $GLOBALS['create_date_time_label'];
                $updated_date_time = $GLOBALS['create_date_time_label'];
                $creator = $GLOBALS['creator'];
                $creator_name = $obj->encode_decode('encrypt', $GLOBALS['creator_name']);
                $update_stock = 0; $stock_remove = 0;
                if (empty($edit_id)) {
                    if (empty($prev_product_id)) {
                        $action = "";
                        if (!empty($product_name)) {
                            $action = "New Product Created - " .$obj->encode_decode("decrypt", $product_name);
                        }
                        $null_value = $GLOBALS['null_value'];
                        $columns = array('created_date_time', 'updated_date_time', 'creator', 'creator_name', 'bill_company_id', 'product_id', 'product_name', 'lower_case_name', 'unit_id', 'unit_name','size_id', 'size_name','hsn_code','product_tax','description','deleted');
                        $values = array($created_date_time,$updated_date_time, $creator, $creator_name, $bill_company_id, $null_value,  $product_name, $lower_case_name, $unit_id, $unit_name,$size_id, $size_name, $hsn_code, $product_tax, $description, '0');
                        $product_insert_id = $obj->InsertSQL($GLOBALS['product_table'], $columns, $values, 'product_id', '', $action);
                        if (preg_match("/^\d+$/", $product_insert_id)) {
                            $product_id = $obj->getTableColumnValue($GLOBALS['product_table'], 'id', $product_insert_id, 'product_id');
                            if($stock_maintain == 1) {
                                $update_stock = 1;
                            }
                            $product_id = $obj->getTableColumnValue($GLOBALS['product_table'],'id',$product_insert_id,'product_id')	;
                            $result = array('number' => '1', 'msg' => 'Product Successfully Created', 'product_id' => $product_id);
                        } else {
                            $result = array('number' => '2', 'msg' => $product_insert_id);
                        }
                    } else {
                        if (!empty($product_error)) {
                            $result = array('number' => '2', 'msg' => $product_error);
                        }
                    }
                } else {
                    if (empty($prev_product_id) || $prev_product_id == $edit_id) {
                        $getUniqueID = "";
                        $getUniqueID = $obj->getTableColumnValue($GLOBALS['product_table'], 'product_id', $edit_id, 'id');
                        if (preg_match("/^\d+$/", $getUniqueID)) {
                            $action = "";
                            if (!empty($product_name)) {
                                $action = "Product Updated - " . $obj->encode_decode("decrypt", $product_name);
                            }

                            $columns = array();
                            $values = array();
                            $columns = array('updated_date_time','creator_name',  'product_name', 'lower_case_name', 'unit_id', 'unit_name','size_id', 'size_name','hsn_code','product_tax','description');
                            $values = array($updated_date_time, $creator_name,$product_name, $lower_case_name, $unit_id, $unit_name, $size_id, $size_name, $hsn_code, $product_tax, $description);
                            $entry_update_id = $obj->UpdateSQL($GLOBALS['product_table'], $getUniqueID, $columns, $values, $action);
                            if (preg_match("/^\d+$/", $entry_update_id)) {
                                if($stock_maintain == 1) {
                                    $update_stock = 1; $stock_remove = 1;
                                }
                                $product_id = $edit_id;
                                $result = array('number' => '1', 'msg' => 'Updated Successfully');

                            } else {
                                $result = array('number' => '2', 'msg' => $entry_update_id);
                            }
                        }
                    } else {
                        if (!empty($product_error)) {
                            $result = array('number' => '2', 'msg' => $product_error);
                        }
                    }
                }
                
                 
            } else {
                $result = array('number' => '2', 'msg' => 'Invalid IP');
            }
        } else {
            if (!empty($valid_product)) {
                $result = array('number' => '3', 'msg' => $valid_product);
            } else if (!empty($product_error)) {
                $result = array('number' => '2', 'msg' => $product_error);
            }
        }


        if(!empty($result)) {
			$result = json_encode($result);
		}
		echo $result; exit;
    }
    if(isset($_POST['draw'])){
        $draw = trim($_POST['draw']);

        if(isset($_POST['start'])) {
            $row = trim($_POST['start']);
        }
        if(isset($_POST['length'])) {
            $rowperpage = trim($_POST['length']);
        }
        $page_title = "Product";
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
            2 => 'product_name',
            3 => 'unit_name',
            4 => 'hsn_code',
            5 => '',
        ];
        if(!empty($order_column_index) && isset($columns[$order_column_index])) {
            $order_column = $columns[$order_column_index];
        }

        $search_text = "";
        if(isset($_POST['search_text'])) {
            $search_text = trim($_POST['search_text']);
        }
        $filter_category_id = "";
        if(isset($_POST['filter_category_id'])) {
            $filter_category_id = trim($_POST['filter_category_id']);
        }
        $filter_product_id = "";
        if(isset($_POST['filter_product_id'])) {
            $filter_product_id = trim($_POST['filter_product_id']);
        }
        
        $login_staff_id = "";
        if($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type'] == $GLOBALS['staff_user_type']) {
            $login_staff_id =  $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'];
        }

        $totalRecords = 0;
        $totalRecords = count($obj->getProductList($row, $rowperpage, $order_column, $order_direction, $search_text,$filter_product_id));
        $filteredRecords = count($obj->getProductList('', '', $order_column, $order_direction, $search_text,$filter_product_id));

        $data = [];
        $ProductList = $obj->getProductList($row, $rowperpage, $order_column, $order_direction, $search_text,$filter_product_id);
        
        $sno = $row + 1;
        foreach ($ProductList as $val) {
            $created_date_time = ""; $updated_date_time = "";  $product_type = "";$product_name = "";  $unit_name = "";  $hsn_code = ""; $product_tax = "";
            if(!empty($val['created_date_time']) && $val['created_date_time'] != $GLOBALS['null_value']) {
                $created_date_time = date('d-m-Y H:i:s', strtotime($val['created_date_time']));
            }
            if(!empty($val['updated_date_time']) && $val['updated_date_time'] != $GLOBALS['null_value']) {
                $updated_date_time = date('d-m-Y H:i:s', strtotime($val['updated_date_time']));
            }
            if(!empty($val['product_type']) && $val['product_type'] != $GLOBALS['null_value']){
                $type = $val['product_type'];
            }
            if(!empty($val['product_name']) && $val['product_name'] != $GLOBALS['null_value']){
                $product_name = $obj->encode_decode('decrypt',$val['product_name']);
            }
            if(!empty($val['unit_name']) && $val['unit_name'] != $GLOBALS['null_value']){
                $unit_name = $obj->encode_decode('decrypt',$val['unit_name']);
            }
            if(!empty($val['hsn_code']) && $val['hsn_code'] != $GLOBALS['null_value']){
                $hsn_code = $val['hsn_code'];
            }
            if(!empty($val['product_tax']) && $val['product_tax'] != $GLOBALS['null_value']){
                $product_tax = $val['product_tax'];
            }else{
                $product_tax = "-";
            }

            $linked_count = 0;
            $linked_count = $obj->GetLinkedCount($GLOBALS['product_table'], $val['product_id']);

            $action = ""; $edit_option = ""; $delete_option = "";
            $edit_access_error = ""; $permission_module = $GLOBALS['product_module']; $permission_action = $edit_action;
            if(!empty($login_staff_id)) {
                include('permission_action.php');
            }
            $delete_access_error = ""; $permission_module = $GLOBALS['product_module']; $permission_action = $delete_action;
            if(!empty($login_staff_id)) {
                include('permission_action.php');
            }
            if(empty($edit_access_error)){
                $edit_option = '<li><a class="dropdown-item" href="Javascript:ShowModalContent('.'\''.$page_title.'\''.', '.'\''.$val['product_id'].'\''.');"><i class="fa fa-pencil"></i>&nbsp; Edit</a></li>';
            }
            if(empty($delete_access_error)){
                if(!empty($linked_count)) { 
                    $delete_option = '<li><a class="dropdown-item text-secondary" style="pointer-events: none; cursor: default;"><i class="fa fa-trash"></i>&nbsp; Delete</a></li>';
                }else{
                    $delete_option = '<li><a class="dropdown-item" href="Javascript:DeleteModalContent('.'\''.$page_title.'\''.', '.'\''.$val['product_id'].'\''.');"><i class="fa fa-trash"></i>&nbsp; Delete</a></li>';
                }
            }
            if(empty($edit_access_error) || empty($delete_access_error)){
                $action = '<div class="dropdown">
                            <a href="#" role="button" class="btn btn-dark py-1 px-2" id="dropdownMenuLink'.$val['product_id'].'" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink'.$val['product_id'].'">
                                '.$edit_option.$delete_option.'
                            </ul>
                        </div>';
            }
            $data[] = [
                "sno" => $sno++,
                "created_date_time" => $created_date_time,
                "product_name" => $product_name,
                "unit_name" => $unit_name,
                "hsn_code" => $hsn_code,
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
    
    if(isset($_REQUEST['check_product_count'])){
        $check_product_count = $_REQUEST['check_product_count'];
       
        $product_list = array();
        $product_list = $obj->getTableRecords($GLOBALS['product_table'], '', '','');
        
        if(!empty($product_list)){
            echo $product_count = count($product_list);
        }
    }

    if(isset($_REQUEST['clear_product_tables'])) {
        $clear_product_tables = $_REQUEST['clear_product_tables'];
        if(!empty($clear_product_tables) && $clear_product_tables == 1) {
            $clear_records = 1;
            $tables = array($GLOBALS['product_table']);
            $clear_records = $obj->setClearTableRecords($tables);
            echo $clear_records;
            exit;
        }
    }

    if(isset($_REQUEST['delete_product_id'])) {
        $delete_product_id = filter_input(INPUT_GET, 'delete_product_id', FILTER_SANITIZE_SPECIAL_CHARS);
        $msg = "";
        if(!empty($delete_product_id)) {
            $access_error = ""; $permission_module = $GLOBALS['product_module']; $permission_action = $delete_action;
            if(!empty($login_staff_id)) {
                include('permission_action.php');
            }
            if(empty($access_error)) {
                $unique_id = "";
                $unique_id = $obj->getTableColumnValue($GLOBALS['product_table'], 'product_id', $delete_product_id, 'id');
                if(preg_match("/^\d+$/", $unique_id)) {
                    $linked_count = 0;
                    $linked_count = $obj->GetLinkedCount($GLOBALS['product_table'], $delete_product_id);
                    if(empty($linked_count)) {
                        $product_name = "";
                        $product_name = $obj->getTableColumnValue($GLOBALS['product_table'], 'product_id', $delete_product_id, 'product_name');
            
                        $action = "";
                        if(!empty($product_name)) {
                            $action = "Product Deleted. Name - " .$product_name;
                        }
                        $columns = array(); $values = array();
                        $columns = array('deleted');
                        $values = array(1);
                        $msg = $obj->UpdateSQL($GLOBALS['product_table'], $unique_id, $columns, $values, $action);
                    }
                    else {
                        $msg = "Product cannot be deleted as it is assigned to Product";
                    }
                }
                else {
                    $msg = "Invalid Product";
                }
            }
            else {
                $msg = $access_error;
            }
        }
        else {
            $msg = "Empty Product";
        }
        echo $msg;
        exit;
    }
?>