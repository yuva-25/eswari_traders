<?php
	include("include_files.php");

    $login_staff_id = "";
    if(isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id']) && !empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'])) {
        if(!empty($GLOBALS['user_type']) && $GLOBALS['user_type'] != $GLOBALS['admin_user_type']) {
            $login_staff_id = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'];
            $permission_module = $GLOBALS['order_form_module'];
        }
    }

	if(isset($_REQUEST['show_order_form_id'])) { 
        $show_order_form_id = filter_input(INPUT_GET, 'show_order_form_id', FILTER_SANITIZE_SPECIAL_CHARS);

        $show_order_form_id = trim($show_order_form_id);
        $product_ids = array(); $unit_ids = array(); $size_ids = array(); $quantity = array(); $rates = array(); $amounts = array(); $party_id = ""; $admin = 0; $notes = "";   $descriptions = array(); $hsn_codes = array();
        $current_date = date("Y-m-d");
        $order_form_date = date("Y-m-d");


        if(!empty($show_order_form_id)) {
            $order_form_list = array();
            $order_form_list = $obj->getTableRecords($GLOBALS['order_form_table'], 'order_form_id', $show_order_form_id,'');
            if(!empty($order_form_list)) {
                foreach($order_form_list as $data) {
                    if(!empty($data['order_form_date'])) {
                        $order_form_date = date('Y-m-d', strtotime($data['order_form_date']));
                    }
                    if(!empty($data['party_id']) && $data['party_id'] != $GLOBALS['null_value']) {
                        $party_id = $data['party_id'];
                    }
                    if(!empty($data['notes']) && $data['notes'] != $GLOBALS['null_value']) {
                        $notes = $obj->encode_decode('decrypt',$data['notes']);
                    }
                    if(!empty($data['description']) && $data['description'] != $GLOBALS['null_value']) {
                        $description = explode(',',$data['description']);
                    }
                    if(!empty($data['quantity']) && $data['quantity'] != $GLOBALS['null_value']) {
                        $quantity = explode(',',$data['quantity']);
                    }
                    if(!empty($data['unit_id']) && $data['unit_id'] != $GLOBALS['null_value']) {
                        $unit_ids = explode(',',$data['unit_id']);
                    }
                    if(!empty($data['hsn_code']) && $data['hsn_code'] != $GLOBALS['null_value']) {
                        $hsn_codes = explode(',',$data['hsn_code']);
                    }
                    if(!empty($data['product_id']) && $data['product_id'] != $GLOBALS['null_value']) {
                        $product_ids = explode(',',$data['product_id']);
                    }
                     if(!empty($data['size_id']) && $data['size_id'] != $GLOBALS['null_value']) {
                        $size_ids = explode(',',$data['size_id']);
                    }
                     if(!empty($data['rate']) && $data['rate'] != $GLOBALS['null_value']) {
                        $rates = explode(',',$data['rate']);
                    }
                    if(!empty($data['amount']) && $data['amount'] != $GLOBALS['null_value']) {
                        $amounts = explode(',',$data['amount']);
                    }
                }
            }
        }
        $unit_list = array();
        $unit_list = $obj->getTableRecords($GLOBALS['unit_table'], '', '', '');
        $party_list = array();
        $party_list = $obj->getTableRecords($GLOBALS['party_table'], '', '', '');
        $product_list = array();
        $product_list = $obj->getTableRecords($GLOBALS['product_table'], '', '', '');
        ?>

        <form class="poppins pd-20 redirection_form" name="order_form_form" method="POST">
			<div class="card-header">
				<div class="row p-2">
					<div class="col-lg-8 col-md-8 col-8 align-self-center">
                        <?php if(empty($show_order_form_id)) { ?>
						    <div class="h5">Add Order Form</div>
                        <?php }else { ?>
						    <div class="h5">Edit Order Form</div>
                        <?php } ?>
					</div>
					<div class="col-lg-4 col-md-4 col-4">
						<button class="btn btn-dark float-end" style="font-size:11px;" type="button" onclick="window.open('order_form.php','_self')"> <i class="fa fa-arrow-circle-o-left"></i> &ensp; Back </button>
					</div>
				</div>
			</div>
            <div class="row justify-content-center p-3">
                <input type="hidden" name="edit_id" value="<?php if(!empty($show_order_form_id)) { echo $show_order_form_id; } ?>">
                <div class="col-lg-2 col-md-4 col-6 py-2 px-lg-1">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                            <input type="date"  name="order_form_date" class="form-control shadow-none" placeholder=""  value="<?php if(!empty($order_form_date)){ echo $order_form_date; }?>" max="<?php if(!empty($current_date)){ echo $current_date; }?>">
                            <label>Order Form Date</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-6 py-2 px-lg-1">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                             <div class="input-group  flex-nowrap">
                                <select class="select2 select2-danger" name ="party_id" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                    <option value= "">Select Party</option>
                                    <?php if(!empty($party_list)) {
                                        foreach($party_list as $data) { ?>
                                            <option value="<?php if(!empty($data['party_id'])) { echo $data['party_id']; } ?>" <?php if(!empty($data['party_id']) && ($data['party_id'] == $party_id))  { ?>selected<?php } ?>><?php if(!empty($data['name_mobile_city'])) { echo $obj->encode_decode("decrypt",$data['name_mobile_city']); } ?></option>
                                    <?php }
                                    } ?>
                                </select>
                                <label>Select Party(*)</label>
                                <div class="input-group-append">
                                    <button class="btn btn-success input-group-text" style="background-color:#20ac15;font-size:12px;width:100%;justify-content: center;" type="button" onClick="Javascript:CustomPartyModal(this);"><i class="fa fa-plus" style='color:white;'></i></button>
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>    
            <div class="row justify-content-center p-3"> 
                <div class="col-lg-2 col-md-4 col-6 px-lg-1 py-2">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                            <div class="input-group  flex-nowrap">
                                <select class="select2 select2-danger" name="selected_product_id" data-dropdown-css-class="select2-danger" style="width: 100%;" onchange ="javascript:getProductUnitSize();">
                                    <option value= "">Select Product</option>
                                    <?php if(!empty($product_list)) {
                                        foreach($product_list as $data) { ?>
                                            <option value="<?php if(!empty($data['product_id'])) { echo $data['product_id']; } ?>" ><?php if(!empty($data['product_name'])) { echo $obj->encode_decode("decrypt",$data['product_name']); } ?></option>
                                    <?php }
                                    } ?>
                                </select>
                                <label>Select Product</label>
                                <div class="input-group-append">
                                    <button class="btn btn-success input-group-text" style="background-color:#20ac15;font-size:12px;width:100%;justify-content: center;" type="button" onClick="Javascript:CustomProductModal(this);"><i class="fa fa-plus" style='color:white;'></i></button>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="col-lg-2 col-md-4 col-6 px-lg-1 py-2">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                            <select class="select2 select2-danger"  name="selected_unit_id" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                 <option value= "">Select unit</option>
                                <?php if(!empty($unit_list)) {
                                    foreach($unit_list as $data) { ?>
                                        <option value="<?php if(!empty($data['unit_id'])) { echo $data['unit_id']; } ?>" ><?php if(!empty($data['unit_name'])) { echo $obj->encode_decode("decrypt",$data['unit_name']); } ?></option>
                                <?php }
                                } ?>
                            </select>
                            <label>Select Unit</label>
                        </div>
                    </div> 
                </div>
                <div class="col-lg-2 col-md-4 col-6 px-lg-1 py-2">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                            <select class="select2 select2-danger"  name="selected_size_id" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                 <option value= "">Select size</option>
                                <?php if(!empty($size_list)) {
                                    foreach($size_list as $data) { ?>
                                        <option value="<?php if(!empty($data['size_id'])) { echo $data['size_id']; } ?>" ><?php if(!empty($data['size_name'])) { echo $obj->encode_decode("decrypt",$data['size_name']); } ?></option>
                                <?php }
                                } ?>
                            </select>
                            <label>Select Size</label>
                        </div>
                    </div> 
                </div>
                <div class="col-lg-1 col-md-3 col-6 px-lg-1 py-2">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                            <input type="text" id="" name="selected_quantity" class="form-control shadow-none" onfocus="Javascript:KeyboardControls(this,'number',8,'');" onkeyup ="javascript:CalcAmount();">
                            <label>QTY</label>
                        </div>
                    </div> 
                </div>
                <div class="col-lg-1 col-md-3 col-6 px-lg-1 py-2 customer_type">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                            <input type="text" id="" name="selected_rate" class="form-control shadow-none" onfocus="Javascript:KeyboardControls(this,'number',8,'');"  onkeyup ="javascript:CalcAmount();">
                            <label>Rate</label>
                        </div>
                    </div> 
                </div>
                <div class="col-lg-1 col-md-3 col-6 px-lg-1 py-2 customer_type">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                            <input type="text" id="" name="selected_amount" class="form-control shadow-none" onfocus="Javascript:KeyboardControls(this,'number',8,'');" readonly>
                            <label>Amount</label>
                        </div>
                    </div> 
                </div>
                <div class="col-lg-1 col-md-2 col-6 px-lg-1  py-2">
                    <button class="btn btn-danger py-2 add_order_button" style="font-size:12px; width:100%;" type="button" onclick="AddOrderFormRow();">  Add </button>
                </div>
            </div>
            <div class="row justify-content-center">    
                <div class="col-lg-10">
                    <div class="table-responsive text-center">
                        <input type="hidden" name="order_form_row_count" value="0">
                        <table class="table nowrap cursor smallfnt w-100 table-bordered order_form_row_table">
                            <thead class="bg-dark smallfnt">
                                <tr>
                                    <th>#</th>
                                    <th style="width:250px;">Product</th>
                                    <th style="width:150px;">Unit</th>
                                    <th style="width:150px;">Size</th>
                                    <th style="width:200px;">HSN</th>
                                    <th style="width:200px;">QTY</th>
                                    <th class ="customer_type" style="width:200px;">rates</th>
                                    <th class ="customer_type" style="width:200px;">Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                  <?php
                                    if(!empty($product_ids)) {
                                        for($i=0; $i < count($product_ids); $i++) { 
                                            if(!empty($product_ids[$i])){
                                                ?>
                                                <tr class="order_form_row" id="order_form_row<?php echo $i+1; ?>">
                                                   <td class="text-center px-2 py-2 sno">
                                                        <?php echo $i+1; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="form-group">
                                                                <div class="form-label-group in-border">
                                                                    <?php
                                                                        $product_name = "";
                                                                        $product_name = $obj->getTableColumnValue($GLOBALS['product_table'], 'product_id', $product_ids[$i], 'product_name');
                                                                        echo $obj->encode_decode('decrypt', $product_name);
                                                                    ?>
                                                                
                                                                </div>
                                                            </div>
                                                        <textarea name="description[]" ><?php if(!empty($description[$i])  && $description[$i] != $GLOBALS['null_value']) { echo $obj->encode_decode('decrypt',$description[$i]); } ?></textarea>
                                                        <input type="hidden" name="product_id[]" value="<?php if(!empty($product_ids[$i])) { echo $product_ids[$i]; } ?>">
                                                        <input type="hidden" name="product_tax[]" value="<?php if(!empty($product_tax)) { echo $product_tax; } ?>">

                                                    </td>
                                                    <td class="text-center">
                                                        <?php
                                                            $unit_name = "";
                                                            $unit_name = $obj->getTableColumnValue($GLOBALS['unit_table'], 'unit_id', $unit_ids[$i], 'unit_name');
                                                            if(!empty($unit_name) && $unit_name != $GLOBALS['null_value']) {
                                                                echo  $obj->encode_decode('decrypt', $unit_name);
                                                            }
                                                            else {
                                                                echo '-';
                                                            }   
                                                        ?>
                                                        <input type="hidden" name="unit_id[]" value="<?php if(!empty($unit_ids[$i])) { echo $unit_ids[$i]; } ?>">
                                                    </td>
                                                    <td class="text-center">
                                                        <?php
                                                            $size_name = "";
                                                            $size_name = $obj->getTableColumnValue($GLOBALS['size_table'], 'size_id', $size_ids[$i], 'size_name');
                                                            if(!empty($size_name) && $size_name != $GLOBALS['null_value']) {
                                                                echo   $obj->encode_decode('decrypt',$size_name);
                                                            }
                                                            else {
                                                                echo '-';
                                                            }   
                                                        ?>
                                                        <input type="hidden" name="size_id[]" value="<?php if(!empty($size_ids[$i])) { echo $size_ids[$i]; } ?>">
                                                    </td>
                                                    <td>
                                                        <div class="form-group">
                                                            <div class="form-label-group in-border">
                                                                <input type="text" name="hsn_code[]" class="form-control shadow-none" onfocus="Javascript:KeyboardControls(this,'number',8,'');" value="<?php if(!empty($hsn_codes[$i]) && $hsn_codes[$i] != $GLOBALS['null_value']) { echo $hsn_codes[$i]; } ?>">
                                                            </div>
                                                        </div> 
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="form-group">
                                                            <div class="form-label-group in-border">
                                                                <input type="text" name="quantity[]" style="width:75%!important;margin:auto!important;" class="form-control shadow-none  text-center" value="<?php if(!empty($quantity[$i])) { echo $quantity[$i]; } ?>" onfocus="Javascript:KeyboardControls(this,'number','','');" onkeyup="Javascript:OrderProductRowCheck(this);">
                                                            </div>
                                                        </div> 
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="form-group">
                                                            <div class="form-label-group in-border">
                                                                <input type="text" name="rates[]" style="width:75%!important;margin:auto!important;" class="form-control shadow-none text-center" value="<?php if(!empty($rates[$i])) { echo number_format($rates[$i],2); } ?>" onfocus="Javascript:KeyboardControls(this,'number','','');" onkeyup="Javascript:OrderProductRowCheck(this);">
                                                            </div>
                                                        </div> 
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="form-group">
                                                            <div class="form-label-group in-border">
                                                                <input type="text" name="amount[]" style="width:75%!important;margin:auto!important;" class="form-control shadow-none  text-center amount" value="<?php if(!empty($amounts[$i])) { echo number_format($amounts[$i],2); } ?>" readonly>
                                                            </div>
                                                        </div>    
                                                    </td>
                                                    <td class="text-center">
                                                        <button class="btn btn-danger" type="button" onclick="Javascript:DeleteOrderRow('order_form_row', '<?php echo $i+1; ?>');"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                                 <?php
                                            }
                                        }
                                    } ?>
                            </tbody> 
                            <tfoot>
                                <tr>
                                    <td colspan="6" class="text-end">Total :</td>
                                    <td colspan="2" class="text-end overall_total"></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col-lg-5 col-md-3 col-6 px-lg-1 py-2">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                             <textarea class="form-control" id="notes" name="notes" onkeydown="Javascript:KeyboardControls(this,'',150,'1');" placeholder=" Notes"><?php if(!empty($notes)){ echo $notes; } ?></textarea>
                            <label> Notes</label>
                        </div>
                    </div> 
                </div>
                <div class="col-md-12 py-3 text-center">
                    <button class="btn btn-danger submit_button" type="button"  onClick="Javascript:SaveModalContent(event, 'order_form_form', 'order_form_changes.php', 'order_form.php');">
                        Submit
                    </button>
                </div>
            </div>
            <script>
                jQuery(document).ready(function() {

                    jQuery('input[name="selected_amount"]').on("keypress", function(e) {
                        if (e.keyCode == 13) {
                            if(jQuery('.add_order_button').length > 0) {
                                jQuery('.add_order_button').trigger('click');
                            }
                        }
                    });
                    calTotalValue();
                });

            </script>
            <script src="include/select2/js/select2.min.js"></script>
            <script src="include/select2/js/select.js"></script>
            <script src="include/js/order_form.js"></script>
        </form>
		<?php
    } 

    if(isset($_POST['edit_id'])) {
        $order_form_date = ""; $order_form_date_error = "";$bill_number = ""; $bill_number_error = ""; $party_id = ""; $party_id_error = ""; $product_ids = array(); $product_names = array(); $row_no = array(); $unit_ids = array(); $unit_names = array();$hsn_code = array(); $quantity = array();$rates = array(); $product_tax = array(); $size_ids = array(); $amount = array(); $sub_total = 0;  $notes = ""; $total_quantity = 0;
        $form_name = "order_form_form"; $order_form_error = ""; $total_amount = 0;
        $edit_id = "";
        if(isset($_POST['edit_id'])){
            $edit_id = $_POST['edit_id'];
        }

        if(isset($_POST['order_form_date'])) {
            $order_form_date = trim($_POST['order_form_date']);
            $order_form_date_error = $valid->valid_date(date('Y-m-d', strtotime($order_form_date)), 'Bill Date', '1');
            if(!empty($order_form_date_error)) {
                if(!empty($valid_order_form)) {
                    $valid_order_form = $valid_order_form." ".$valid->error_display($form_name, 'order_form_date', $order_form_date_error, 'text');
                }
                else {
                    $valid_order_form = $valid->error_display($form_name, 'order_form_date', $order_form_date_error, 'text');
                }
            }
        }

        if(isset($_POST['party_id'])) {
            $party_id = trim($_POST['party_id']);
            $party_id_error = $valid->common_validation($party_id, ' Party', 'select');
            if(!empty($party_id_error)) {
                if(!empty($valid_order_form)) {
                    $valid_order_form = $valid_order_form." ".$valid->error_display($form_name, 'party_id', $party_id_error, 'select');
                }
                else {
                    $valid_order_form = $valid->error_display($form_name, 'party_id', $party_id_error, 'select');
                }
            }
            else {
                $party_state = $obj->getTableColumnValue($GLOBALS['party_table'], 'party_id', $party_id, 'state');
            }
        }
        if(isset($_POST['notes'])) {
            $notes = trim($_POST['notes']);
            if(!empty($notes)){
              $notes_error = $valid->common_validation($notes, 'Notes', 'select');
                if(!empty($notes_error)) {
                    if(!empty($valid_order_form)) {
                        $valid_order_form = $valid_order_form." ".$valid->error_display($form_name, 'notes', $notes_error, 'select');
                    }
                    else {
                        $valid_order_form = $valid->error_display($form_name, 'notes', $notes_error, 'select');
                    }
                }
                else {
                    $party_state = $obj->getTableColumnValue($GLOBALS['party_table'], 'notes', $notes, 'state');
                }
            }
        }

       
        if(isset($_POST['product_id'])) {
            $product_ids = $_POST['product_id'];
        }
        if(isset($_POST['row_no'])) {
            $row_no = $_POST['row_no'];
        }
        if(isset($_POST['unit_id'])) {
            $unit_ids = $_POST['unit_id'];
        }
        if(isset($_POST['quantity'])) {
            $quantity = $_POST['quantity'];
        }
        if(isset($_POST['rates'])) {
            $rates = $_POST['rates'];
        }
        if(isset($_POST['product_tax'])) {
            $product_tax = $_POST['product_tax'];
        }
        if(isset($_POST['size_id'])) {
            $size_ids = $_POST['size_id'];
        }
        if(isset($_POST['description'])) {
            $description = $_POST['description'];
        }
        if(isset($_POST['hsn_code'])) {
            $hsn_code = $_POST['hsn_code'];
        }
        if(!empty($product_ids)) {
            for($i=0; $i < count($product_ids); $i++) {

                $product_ids[$i] = trim($product_ids[$i]);
                $unit_ids[$i] = trim($unit_ids[$i]);
                $size_ids[$i] = trim($size_ids[$i]);
                if(isset($quantity[$i])) {
                    $quantity[$i] = trim($quantity[$i]);

                    $quantity_error = "";
                    $quantity_error = $valid->valid_number($quantity[$i], 'Qty', '1','8');
                   
                    if(empty($quantity_error) && $quantity[$i] > 99999) {
                        $quantity_error = "Max Value : 99999";
                    }
                    if(empty($quantity_error)){

                        if(isset($rates[$i])) {
                            $rates[$i] = trim($rates[$i]);

                            $price_error = "";
                            $price_error = $valid->valid_price($rates[$i], 'rate', '1','');
                            if(empty($price_error) && $rates[$i] > 9999999.99) {
                                $price_error = "Max Value : 9999999.99";
                            }
                            if(empty($price_error)){
                                 $total_quantity += $quantity[$i];
                                 $amount[$i] = $quantity[$i] * $rates[$i];
                                 $total_amount += $amount[$i];
                            }else{
                                if(!empty($valid_order_form)) {
                                    $valid_order_form = $valid_order_form." ".$valid->row_error_display($form_name, 'rates[]', $price_error, 'text', 'order_form_row', ($i+1));
                                }
                                else {
                                    $valid_order_form = $valid->row_error_display($form_name, 'rates[]', $price_error, 'text', 'order_form_row', ($i+1));
                                }
                            }
                               
                        }

                    }else{
                        if(!empty($valid_order_form)) {
                            $valid_order_form = $valid_order_form." ".$valid->row_error_display($form_name, 'quantity[]', $quantity_error, 'text', 'order_form_row', ($i+1));
                        }
                        else {
                            $valid_order_form = $valid->row_error_display($form_name, 'quantity[]', $quantity_error, 'text', 'order_form_row', ($i+1));
                        }
                    }
                    
                       
                }

                if(isset($hsn_code[$i])) {
                    $hsn_code[$i] = trim($hsn_code[$i]);

                    $hsn_error = "";
                    $hsn_error = $valid->valid_number($hsn_code[$i], 'hsn_code', '0','');
                 
                    if(!empty($hsn_error)){

                        if(!empty($valid_order_form)) {
                            $valid_order_form = $valid_order_form." ".$valid->row_error_display($form_name, 'hsn_code[]', $hsn_error, 'text', 'order_form_row', ($i+1));
                        }
                        else {
                            $valid_order_form = $valid->row_error_display($form_name, 'hsn_code[]', $hsn_error, 'text', 'order_form_row', ($i+1));
                        }
                    }
                        
                }
                if(isset($description[$i])) {
                    $description[$i] = trim($description[$i]);
                    $description_error = "";
                    $description_error = $valid->common_validation($description[$i], 'description', '0','');
                    if(empty($description_error)){
                        $description[$i] = $obj->encode_decode('encrypt',$description[$i]);

                    }else{
                        if(!empty($description[$i]) && !empty($description_error)){

                            if(!empty($valid_order_form)) {
                                $valid_order_form = $valid_order_form." ".$valid->row_error_display($form_name, 'description[]', $description_error, 'text', 'order_form_row', ($i+1));
                            }
                            else {
                                $valid_order_form = $valid->row_error_display($form_name, 'description[]', $description_error, 'text', 'order_form_row', ($i+1));
                            }
                        }
                    }
                 
              
                        
                }
                if(empty($valid_order_form)) {

                    $product_name = "";
                    $product_name = $obj->getTableColumnValue($GLOBALS['product_table'], 'product_id', $product_ids[$i], 'product_name');
                    $product_names[$i] = $product_name;

                    $unit_name = "";
                    $unit_name = $obj->getTableColumnValue($GLOBALS['unit_table'], 'unit_id', $unit_ids[$i], 'unit_name');
                    $unit_names[$i] = $unit_name;

                         $size_name = "";
                    $size_name = $obj->getTableColumnValue($GLOBALS['size_table'], 'size_id', $size_ids[$i], 'size_name');
                    $size_names[$i] = $size_name;

                }
        
            }
        }
        else {
            $order_form_error = "Add Products";
        }

		/* $round_off = 0;
		if(!empty($total_amount)) {	
			if (strpos( $total_amount, "." ) !== false) {
				$pos = strpos($total_amount, ".");
				$decimal = substr($total_amount, ($pos + 1), strlen($total_amount));
				if($decimal != "00") {
					if(strlen($decimal) == 1) {
						$decimal = $decimal."0";
					}
					if($decimal >= 50) {				
						$round_off = 100 - $decimal;
						if($round_off < 10) {
							$round_off = "0.0".$round_off;
						}
						else {
							$round_off = "0.".$round_off;
						}
						
						$total_amount = $total_amount + $round_off;
					}
					else {
						$decimal = "0.".$decimal;
						$round_off = "-".$decimal;
						$total_amount = $total_amount - $decimal;
					}
				}
			}
		}
         */
        if(empty($order_form_error) && empty($valid_order_form) && $total_amount <= '0') {
            $order_form_error = "Bill value cannot be 0";
        }
      
        
        if(empty($order_form_error) && empty($valid_order_form)){
           
            $check_user_id_ip_address = 0;
            $check_user_id_ip_address = $obj->check_user_id_ip_address();
            if(preg_match("/^\d+$/", $check_user_id_ip_address)) {
         
              
                if(!empty($order_form_date)) {
                    $order_form_date = date('Y-m-d', strtotime($order_form_date));
                }
                $bill_company_id =$GLOBALS['bill_company_id'];
                $bill_company_details = "";
                if (!empty($bill_company_id)) {
                    $bill_company_details = $obj->BillCompanyDetails($bill_company_id);
                }
                $party_name = ""; $party_mobile_number = "";  $party_name_mobile_city = ""; $party_details = "";
                if(!empty($party_id)) {
                    $party_name = $obj->getTableColumnValue($GLOBALS['party_table'], 'party_id', $party_id, 'party_name');
                    $party_mobile_number = $obj->getTableColumnValue($GLOBALS['party_table'], 'party_id', $party_id, 'mobile_number');
                    $party_name_mobile_city = $obj->getTableColumnValue($GLOBALS['party_table'], 'party_id', $party_id, 'name_mobile_city');
                    $party_details = $obj->getTableColumnValue($GLOBALS['party_table'], 'party_id', $party_id, 'party_details');
                }
                else {
                    $party_id = $GLOBALS['null_value'];
                    $party_name = $GLOBALS['null_value'];
                    $party_mobile_number = $GLOBALS['null_value'];
                    $party_name_mobile_city = $GLOBALS['null_value'];
                    $party_details = $GLOBALS['null_value'];
                }

                
                if(!empty(array_filter($product_ids, fn($value) => $value !== ""))) {
                    $product_ids = implode(",", $product_ids);
                }
                else {
                    $product_ids = $GLOBALS['null_value'];
                }
                if(!empty(array_filter($product_names, fn($value) => $value !== ""))) {
                    $product_names = implode(",", $product_names);
                }
                else {
                    $product_names = $GLOBALS['null_value'];
                }
                if(!empty(array_filter($unit_ids, fn($value) => $value !== ""))) {
                    $unit_ids = implode(",", $unit_ids);
                }
                else {
                    $unit_ids = $GLOBALS['null_value'];
                }
                if(!empty(array_filter($unit_names, fn($value) => $value !== ""))) {
                    $unit_names = implode(",", $unit_names);
                }
                else {
                    $unit_names = $GLOBALS['null_value'];
                }
                if(!empty(array_filter($size_ids, fn($value) => $value !== ""))) {
                    $size_ids = implode(",", $size_ids);
                }
                else {
                    $size_ids = $GLOBALS['null_value'];
                }
                if(!empty(array_filter($size_names, fn($value) => $value !== ""))) {
                    $size_names = implode(",", $size_names);
                }
                else {
                    $size_names = $GLOBALS['null_value'];
                }
                if(!empty($description)) {
                    $description = implode(",", $description);
                }
                else {
                    $description = $GLOBALS['null_value'];
                }
                if(!empty($quantity)) {
                    $quantity = implode(",", $quantity);
                }
                else {
                    $quantity = $GLOBALS['null_value'];
                }
                if(!empty($rates)) {
                    $rates = implode(",", $rates);
                }
                else {
                    $rates = $GLOBALS['null_value'];
                }
                if(!empty($amount)) {
                    $amount = implode(",", $amount);
                }
                else {
                    $amount = $GLOBALS['null_value'];
                }
                if(!empty($notes)) {
                    $notes = $obj->encode_decode('encrypt',$notes);
                }
                else {
                    $notes = $GLOBALS['null_value'];
                }

                if(!empty($hsn_code)) {
                    $hsn_code = implode(",", $hsn_code);
                }
                else {
                    $hsn_code = $GLOBALS['null_value'];
                }
                $created_date_time = $GLOBALS['create_date_time_label']; $creator = $GLOBALS['creator'];
                $updated_date_time = $GLOBALS['create_date_time_label']; 
                $creator_name = $obj->encode_decode('encrypt', $GLOBALS['creator_name']);
                $update_stock = 0;$balance = 0;
                if(empty($edit_id)){
                   
                    $action = "New order_form Created.";
                    
                    $null_value = $GLOBALS['null_value'];
                    $columns = array(); $values = array();
                    $columns = array('created_date_time','updated_date_time', 'creator', 'creator_name','bill_company_id','order_form_id', 'order_form_date', 'order_form_number','size_id','size_name','party_id', 'party_name', 'party_mobile_number', 'party_name_mobile_city', 'party_details', 'product_id', 'product_name','unit_id', 'unit_name', 'quantity', 'rate', 'amount', 'total_amount', 'total_quantity','description', 'notes', 'hsn_code','cancelled','deleted');
                    $values = array($created_date_time,$updated_date_time, $creator, $creator_name,$bill_company_id, $null_value,  $order_form_date,$null_value,$size_ids, $size_names, $party_id, $party_name, $party_mobile_number,  $party_name_mobile_city, $party_details, $product_ids, $product_names,$unit_ids, $unit_names, $quantity, $rates, $amount, $total_amount,$total_quantity, $description, $notes, $hsn_code,0, 0);
                    $order_form_insert_id = $obj->InsertSQL($GLOBALS['order_form_table'], $columns, $values,'order_form_id', 'order_form_number', $action);
                    if(preg_match("/^\d+$/", $order_form_insert_id)) {
                        $update_stock = 1;$balance = 1;
                        $order_form_id = $obj->getTableColumnValue($GLOBALS['order_form_table'], 'id', $order_form_insert_id, 'order_form_id');
                                
                        $order_form_number = "";
                        $order_form_number = $obj->getTableColumnValue($GLOBALS['order_form_table'],'order_form_id',$order_form_id,'order_form_number');

                        $result = array('number' => '1', 'msg' => 'Order form Successfully Created','redirection_page' =>'order_form.php','order_form_id' => $order_form_id);
                    }
                    else {
                        $result = array('number' => '2', 'msg' => $order_form_insert_id);
                    }
                      
                }
                else
                {
                    $action = "order_form Updated.";
                    $getUniqueID = $obj->getTableColumnValue($GLOBALS['order_form_table'],'order_form_id',$edit_id,'id');
                    $null_value = $GLOBALS['null_value'];
                    $columns = array(); $values = array();
                    $columns = array('updated_date_time','creator_name','bill_company_id', 'order_form_date','party_id', 'party_name', 'party_mobile_number', 'party_name_mobile_city', 'party_details', 'product_id', 'product_name','unit_id', 'unit_name', 'quantity', 'rate', 'size_id','size_name', 'amount', 'total_amount',   'total_quantity','description', 'notes','hsn_code');
                    $values = array( $updated_date_time, $creator_name,$bill_company_id,$order_form_date,$party_id, $party_name, $party_mobile_number,  $party_name_mobile_city, $party_details, $product_ids, $product_names,$unit_ids, $unit_names, $quantity, $rates, $size_ids,  $size_names,  $amount, $total_amount, $total_quantity, $description, $notes,$hsn_code);
                    $order_form_update_id = $obj->UpdateSQL($GLOBALS['order_form_table'], $getUniqueID, $columns, $values, $action);
                    if(preg_match("/^\d+$/", $order_form_update_id)) {
                        $order_form_id = $edit_id;
                        $order_form_number = $obj->getTableColumnValue($GLOBALS['order_form_table'], 'order_form_id', $order_form_id, 'order_form_number');
                        $result = array('number' => '1', 'msg' => 'Updated Successfully','redirection_page' =>'order_form.php');
                    }
                    else {
                        $result = array('number' => '2', 'msg' => $order_form_update_id);
                    }	
                }


            } else {
                $result = array('number' => '2', 'msg' => 'Invalid IP');
            }
        }  else{
            if(!empty($valid_order_form)) {
                $result = array('number' => '3', 'msg' => $valid_order_form);
            }
            else if(!empty($order_form_error)) {
                $result = array('number' => '2', 'msg' => $order_form_error);
            }
        }
        if(!empty($result)) {
            $result = json_encode($result);
        }
        echo $result; exit;

    }

    
    if(isset($_POST['draw'])){
        $draw = trim($_POST['draw']);

        $searchValue = ""; $filter_from_date = ""; $filter_to_date = ""; $filter_party_id = ""; $cancelled = 0;
        if(isset($_POST['start'])) {
            $row = trim($_POST['start']);
        }
        if(isset($_POST['length'])) {
            $rowperpage = trim($_POST['length']);
        }
        if(isset($_POST['search_text'])) {
            $searchValue = trim($_POST['search_text']);
        }
        if(isset($_POST['filter_from_date'])) {
            $filter_from_date = trim($_POST['filter_from_date']);
        }
        if(isset($_POST['filter_to_date'])) {
            $filter_to_date = trim($_POST['filter_to_date']);
        }
        if(isset($_POST['filter_party_id'])) {
            $filter_party_id = trim($_POST['filter_party_id']);
        }
    
        if(isset($_POST['cancelled'])) {
            $cancelled = trim($_POST['cancelled']);
        }
        $page_title = "order_form";
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
            1 => 'order_form_date',
            2 => 'entry_number',
            4 => 'party_mobile_number',
            5 => 'total',
            6 => '',
        ];
        if(!empty($order_column_index) && isset($columns[$order_column_index])) {
            $order_column = $columns[$order_column_index];
        }

        $totalRecords = 0;
        $totalRecords = count($obj->getOrderFormList($row, $rowperpage, $searchValue, $filter_from_date, $filter_to_date, $filter_party_id, $cancelled, $order_column, $order_direction));
        $filteredRecords = count($obj->getOrderFormList('', '', $searchValue, $filter_from_date, $filter_to_date, $filter_party_id, $cancelled, $order_column, $order_direction));

        $data = [];
        
        $order_formList = $obj->getOrderFormList($row, $rowperpage, $searchValue, $filter_from_date, $filter_to_date, $filter_party_id, $cancelled, $order_column, $order_direction);
        
        $sno = $row + 1;
        foreach ($order_formList as $val) {
            $created_date_time = $by_creator_name = ""; $updated_date_time = ""; $order_form_date = ""; $bill_number = ""; $party_name = "";$party_mobile_number =  $bill_total = 0;$order_form_number =""; $party_name_mobile_city ='';$product_count =0 ;
            if(!empty($val['created_date_time']) && $val['created_date_time'] != $GLOBALS['null_value']) {
                $created_date_time = date('d-m-Y H:i:s', strtotime($val['created_date_time']));
            }
            if(!empty($val['updated_date_time']) && $val['updated_date_time'] != $GLOBALS['null_value']) {
                $updated_date_time = date('d-m-Y H:i:s', strtotime($val['updated_date_time']));
            }
            if(!empty($val['creator_name']) && $val['creator_name'] != $GLOBALS['null_value']){
                $by_creator_name = html_entity_decode($obj->encode_decode('decrypt', $val['creator_name']));
            }
            if(!empty($by_creator_name)) {
                $updated_date_time .= "<br>By : ".$by_creator_name;
            }
            if(!empty($val['order_form_date']) && $val['order_form_date'] != "0000-00-00") {
                $order_form_date = date('d-m-Y', strtotime($val['order_form_date']));
            }
            if(!empty($val['bill_number']) && $val['bill_number'] != $GLOBALS['null_value']) {
                $bill_number = $val['bill_number'];
            }
            if(!empty($val['total_amount']) && $val['total_amount'] != $GLOBALS['null_value']) {
                $bill_total = $obj->numberFormat($val['total_amount'],2);
            }
            if(!empty($val['order_form_number']) && $val['order_form_number'] != $GLOBALS['null_value']) {
                $order_form_number = $val['order_form_number'];
            }
            if(!empty($val['party_name_mobile_city']) && $val['party_name_mobile_city'] != $GLOBALS['null_value']){
                $party_name_mobile_city =  html_entity_decode($obj->encode_decode('decrypt',$val['party_name_mobile_city']));
            }
            if(!empty($val['product_id']) && $val['product_id'] != $GLOBALS['null_value']) {
                $product_ids = explode(',', $val['product_id']);
                $product_count = count($product_ids);
            }
            
            
            $action = ""; $edit_option = ""; $delete_option = ""; $print_option = ""; $a5_print_option = ""; $customer_copy_print_option = "";
            $edit_access_error = ""; $permission_module = $GLOBALS['order_form_module']; $permission_action = $edit_action;
            if(!empty($login_role_id)) {
                include("permission_action.php");
            }
            $delete_access_error = ""; $permission_module = $GLOBALS['order_form_module']; $permission_action = $delete_action;
            if(!empty($login_role_id)) {
                include("permission_action.php");
            }
            if(empty($edit_access_error) && empty($val['cancelled'])) {
                $edit_option = '<li><a class="dropdown-item" href="Javascript:ShowModalContent('.'\''.$page_title.'\''.', '.'\''.$val['order_form_id'].'\''.');"><i class="fa fa-pencil"></i>&nbsp; Edit</a></li>';
            }
            if(empty($delete_access_error) && empty($val['cancelled'])) {
                $delete_option = '<li><a class="dropdown-item" href="Javascript:DeleteModalContent('.'\''.$page_title.'\''.', '.'\''.$val['order_form_id'].'\''.');"><i class="fa fa-ban"></i>&nbsp; Cancel</a></li>';
            }
            $conversion_option = "";
            $print_option = '<li><a class="dropdown-item" target="_blank" href="reports/rpt_order_form_office_copy.php?view_order_form_id=' . $val['order_form_id'] . '"><i class="fa fa-print"></i>&nbsp;Office Copy Print</a></li>';
             $customer_copy_print_option = '<li><a class="dropdown-item" target="_blank" href="reports/rpt_order_form_customer_copy.php?view_order_form_id=' . $val['order_form_id'] . '"><i class="fa fa-print"></i>&nbsp;Customer Copy Print</a></li>';

             if(empty($edit_access_error) && empty($val['cancelled'])) {
                $conversion_option = '<li><a class="dropdown-item" href="Javascript:ShowBillConversion('.'\''.$page_title.'\''.', '.'\''.$val['order_form_id'].'\''.');"><i class="bi bi-arrow-left-right"></i>&nbsp; Conversion</a></li>';
            }
            $action = '<div class="dropdown">
                            <a href="#" role="button" class="btn btn-dark py-1 px-2" id="dropdownMenuLink'.$val['order_form_id'].'" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink'.$val['order_form_id'].'">
                                '.$print_option.$customer_copy_print_option.$edit_option.$conversion_option.$delete_option.'
                            </ul>
                        </div>';

            $data[] = [
                "sno" => $sno++,
                "created_date_time" => $created_date_time,
                "updated_date_time" => $updated_date_time,
                "bill_date" => $order_form_date,
                "entry_number" => $order_form_number,
                "party_mobile_number" => $party_name_mobile_city,
                "total" => $bill_total,
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


    if(isset($_REQUEST['product_id'])) {
        $selected_product_id = filter_input(INPUT_GET, 'product_id', FILTER_SANITIZE_SPECIAL_CHARS);
        $selected_product_id = trim($selected_product_id);
        $size_id = ""; $unit_id = "";
        $size_name = ""; $unit_name = "";

        $unit_list = array();
        $unit_list = $obj->getTableRecords($GLOBALS['unit_table'], '', '', '');
   
        $size_list = array();
        $size_list = $obj->getTableRecords($GLOBALS['size_table'], '', '', '');

        if(!empty($selected_product_id)){

                $unit_id = $obj->getTableColumnValue($GLOBALS['product_table'], 'product_id', $selected_product_id, 'unit_id');
                $size_id = $obj->getTableColumnValue($GLOBALS['product_table'], 'product_id', $selected_product_id, 'size_id');
                
                $unit_name = $obj->getTableColumnValue($GLOBALS['unit_table'], 'unit_id', $unit_id, 'unit_name');
                $size_name = $obj->getTableColumnValue($GLOBALS['size_table'], 'size_id', $size_id, 'size_name');
                 /*
                if(!empty($unit_list)) {
                    foreach($unit_list as $data) {  ?>
                
                        <option value="<?php if(!empty($data['unit_id'])) { echo $data['unit_id']; } ?>" <?php if(!empty($data['unit_id']) && ($data['unit_id'] == $unit_id))  { ?>selected<?php } ?>><?php if(!empty($data['unit_name'])) { echo $obj->encode_decode('decrypt', $data['unit_name']); } ?></option>
                         
                    }
                }*/ ?>
                <option value="<?php echo $unit_id; ?>" selected>
                    <?php echo $obj->encode_decode('decrypt', $unit_name); ?>
                </option>   

                $$$
                
                <option value="<?php echo $size_id; ?>" selected>
                    <?php echo $obj->encode_decode('decrypt', $size_name); ?>
                </option>   
                <?php

        }else{
            ?>
                <option value=""> select unit</option>
                $$$
                <option value=""> select size</option>

            <?php
        }
    }


    if(isset($_REQUEST['order_form_row_index'])) {
        $order_form_row_index = filter_input(INPUT_GET, 'order_form_row_index', FILTER_SANITIZE_SPECIAL_CHARS);
        $product_id = filter_input(INPUT_GET, 'selected_product_id', FILTER_SANITIZE_SPECIAL_CHARS);
        $product_id = trim($product_id);
        $unit_id = filter_input(INPUT_GET, 'selected_unit_id', FILTER_SANITIZE_SPECIAL_CHARS);
        $unit_id = trim($unit_id);
        $size_id = filter_input(INPUT_GET, 'selected_size_id', FILTER_SANITIZE_SPECIAL_CHARS);
        $size_id = trim($size_id);
        $quantity = filter_input(INPUT_GET, 'selected_quantity', FILTER_SANITIZE_SPECIAL_CHARS);
        $quantity = trim($quantity);
        $rates = filter_input(INPUT_GET, 'selected_rate', FILTER_SANITIZE_SPECIAL_CHARS);
        $rates = trim($rates);
        $amount = filter_input(INPUT_GET, 'selected_amount', FILTER_SANITIZE_SPECIAL_CHARS);
        $amount = trim($amount);
        $hsn_code = ""; $description = ""; $product_tax = "";
        $hsn_code = $obj->getTableColumnValue($GLOBALS['product_table'], 'product_id', $product_id, 'hsn_code');
        $description = $obj->getTableColumnValue($GLOBALS['product_table'], 'product_id', $product_id, 'description');
        $product_tax = $obj->getTableColumnValue($GLOBALS['product_table'], 'product_id', $product_id, 'product_tax');

       
        ?>
        <tr class="order_form_row" id="order_form_row<?php if(!empty($order_form_row_index)) { echo $order_form_row_index; } ?>">
            <td class="sno text-center">
                <?php if(!empty($order_form_row_index)) { echo $order_form_row_index; } ?>
            </td>
            <td class="text-center">
                  <div class="form-group">
                        <div class="form-label-group in-border">
                            <?php
                                $product_name = "";
                                $product_name = $obj->getTableColumnValue($GLOBALS['product_table'], 'product_id', $product_id, 'product_name');
                                echo $obj->encode_decode('decrypt', $product_name);
                            ?>
                        
                        </div>
                    </div>
                 <textarea name="description[]" ><?php if(!empty($description)  && $description != $GLOBALS['null_value']) { echo $obj->encode_decode('decrypt',$description); } ?></textarea>
                <input type="hidden" name="product_id[]" value="<?php if(!empty($product_id)) { echo $product_id; } ?>">
                <input type="hidden" name="product_tax[]" value="<?php if(!empty($product_tax)) { echo $product_tax; } ?>">

            </td>
            <td class="text-center">
                <?php
                    $unit_name = "";
                    $unit_name = $obj->getTableColumnValue($GLOBALS['unit_table'], 'unit_id', $unit_id, 'unit_name');
                    if(!empty($unit_name) && $unit_name != $GLOBALS['null_value']) {
                        echo  $obj->encode_decode('decrypt', $unit_name);
                    }
                    else {
                        echo '-';
                    }   
                ?>
                <input type="hidden" name="unit_id[]" value="<?php if(!empty($unit_id)) { echo $unit_id; } ?>">
            </td>
            <td class="text-center">
                <?php
                    $size_name = "";
                    $size_name = $obj->getTableColumnValue($GLOBALS['size_table'], 'size_id', $size_id, 'size_name');
                    if(!empty($size_name) && $size_name != $GLOBALS['null_value']) {
                        echo   $obj->encode_decode('decrypt',$size_name);
                    }
                    else {
                        echo '-';
                    }   
                ?>
                <input type="hidden" name="size_id[]" value="<?php if(!empty($size_id)) { echo $size_id; } ?>">
            </td>
            <td>
                <div class="form-group">
                    <div class="form-label-group in-border">
                        <input type="text" name="hsn_code[]" class="form-control shadow-none" onfocus="Javascript:KeyboardControls(this,'number',8,'');" value="<?php if(!empty($hsn_code) && $hsn_code != $GLOBALS['null_value']) { echo $hsn_code; } ?>">
                    </div>
                </div> 
            </td>
            <td class="text-center">
                <div class="form-group">
                    <div class="form-label-group in-border">
                        <input type="text" name="quantity[]" style="width:75%!important;margin:auto!important;" class="form-control shadow-none  text-center" value="<?php if(!empty($quantity)) { echo $quantity; } ?>" onfocus="Javascript:KeyboardControls(this,'number','','');" onkeyup="Javascript:OrderProductRowCheck(this);">
                    </div>
                </div> 
            </td>
            <td class="text-center">
                <div class="form-group">
                    <div class="form-label-group in-border">
                         <input type="text" name="rates[]" style="width:75%!important;margin:auto!important;" class="form-control shadow-none text-center" value="<?php if(!empty($rates)) { echo $rates; } ?>" onfocus="Javascript:KeyboardControls(this,'number','','');" onkeyup="Javascript:OrderProductRowCheck(this);">
                    </div>
                </div> 
            </td>
            <td class="text-center">
                <div class="form-group">
                    <div class="form-label-group in-border">
                        <input type="text" name="amount[]" style="width:75%!important;margin:auto!important;" class="form-control shadow-none  text-center amount" value="<?php if(!empty($amount)) { echo $amount; } ?>" readonly>
                    </div>
                </div>    
            </td>
            <td class="text-center">
                <button class="btn btn-danger" type="button" onclick="Javascript:DeleteOrderRow('order_form_row', '<?php if(!empty($order_form_row_index)) { echo $order_form_row_index; } ?>');"><i class="fa fa-trash"></i></button>
            </td>
        </tr>
        <?php
    }

    if(isset($_REQUEST['delete_order_form_id'])) {
        $delete_order_form_id = trim(filter_input(INPUT_GET, 'delete_order_form_id', FILTER_SANITIZE_SPECIAL_CHARS));
        $msg = "";
        if(!empty($delete_order_form_id)) {	
            $order_form_unique_id = "";
            $order_form_unique_id = $obj->getTableColumnValue($GLOBALS['order_form_table'], 'order_form_id', $delete_order_form_id, 'id');
        
            if(preg_match("/^\d+$/", $order_form_unique_id)) {
                $bill_number = "";
                $bill_number = $obj->getTableColumnValue($GLOBALS['order_form_table'], 'order_form_id', $delete_order_form_id, 'bill_number');
            
                $action = "";
                if(!empty($bill_number)) {
                    $action = "order_form Cancelled. Bill No. - ".$bill_number;
                }
               
                if(empty($delete_access_error)) {
                    $columns = array(); $values = array();
                    $columns = array('cancelled');
                    $values = array(1);
                    $msg = $obj->UpdateSQL($GLOBALS['order_form_table'], $order_form_unique_id, $columns, $values, $action);
                }
                else {
                    $msg = $delete_access_error;
                }
              
            }
            else {
                $msg = "Invalid order form";
            }
        }
        else {
            $msg = "Empty Order form";
        }
        echo $msg;
        exit;	
    }

    ?>