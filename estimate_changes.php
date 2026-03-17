<?php
	include("include_files.php");

    $login_staff_id = "";
    if(isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id']) && !empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'])) {
        if(!empty($GLOBALS['user_type']) && $GLOBALS['user_type'] != $GLOBALS['admin_user_type']) {
            $login_staff_id = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'];
            $permission_module = $GLOBALS['estimate_module'];
        }
    }

	if(isset($_REQUEST['show_estimate_id'])) { 
        $show_estimate_id = filter_input(INPUT_GET, 'show_estimate_id', FILTER_SANITIZE_SPECIAL_CHARS);

        $show_estimate_id = trim($show_estimate_id);

        	$conversion_update = 0;
        if(isset($_REQUEST['conversion_update'])) {
            $conversion_update = filter_input(INPUT_GET, 'conversion_update', FILTER_SANITIZE_SPECIAL_CHARS);
            $conversion_update = trim($conversion_update);
        }

        $product_ids = array(); $unit_ids = array(); $size_ids = array(); $quantity = array(); $rates = array(); $amounts = array(); $party_id = ""; $admin = 0; $notes = "";   $descriptions = array(); $hsn_codes = array();
        $current_date = date("Y-m-d");
        $estimate_date = date('Y-m-d'); $bill_number = ""; $party_id = ""; $product_count = 0; $gst_option = 2; $tax_option = 1;$tax_type = "";$party_state = ""; $company_state = "";

        $company_state = $obj->getTableColumnValue($GLOBALS['company_table'], 'company_id', $GLOBALS['bill_company_id'], 'state');
        
        $product_tax = array(); $product_count = 0; $order_form_number = "";
        $product_ids = array(); $product_names = array(); $unit_ids = array();$unit_names = array(); $product_quantity = array(); $product_price = array();$overall_tax = "";$product_tax = array(); $final_price = array(); $product_amount = $product_contains =  $product_per = $product_per_type =  array(); $discount = ""; $discount_name = ""; 
        $discount_value = 0; $extra_charges = ""; $extra_charges_name = ""; $extra_charges_value = 0; 
        $grand_total = 0; $delivery_date = "";$hsn_code = ""; $stock_type ="";
        $bank_id = "";
        
        if(!empty($show_estimate_id)) {
            $estimate_list = array();
            $estimate_list = $obj->getTableRecords($GLOBALS['estimate_table'], 'estimate_id', $show_estimate_id,'');

            if(!empty($conversion_update) && $conversion_update == '1') {
                $estimate_list = $obj->getTableRecords($GLOBALS['order_form_table'], 'order_form_id', $show_estimate_id,'');
            }else{
                $estimate_list = $obj->getTableRecords($GLOBALS['estimate_table'], 'estimate_id', $show_estimate_id,'');
            }
		
            if(!empty($estimate_list)) {
                foreach($estimate_list as $data) {
                    if(!empty($conversion_update) && $conversion_update == '1') {
                        if(!empty($data['estimate_date'])) {
                            $estimate_date = date('Y-m-d', strtotime($data['estimate_date']));
                        }
                        if(!empty($data['order_form_number']) && $data['order_form_number'] != $GLOBALS['null_value']) {
                            $order_form_number = $data['order_form_number'];
                        }
                    }else{
                        if(!empty($data['order_form_date'])) {
                            $estimate_date = date('Y-m-d', strtotime($data['order_form_date']));
                        }
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
                        $product_count = count($product_ids);
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
                    if(!empty($data['gst_option']) && $data['gst_option'] != $GLOBALS['null_value']) {
                        $gst_option = $data['gst_option'];
                    }
                    if(!empty($data['tax_option']) && $data['tax_option'] != $GLOBALS['null_value']) {
                        $tax_option = $data['tax_option'];
                    }
                    if(!empty($data['tax_type']) && $data['tax_type'] != $GLOBALS['null_value']) {
                        $tax_type = $data['tax_type'];
                    }
                    if(!empty($data['party_state']) && $data['party_state'] != $GLOBALS['null_value']) {
                        $party_state = $data['party_state'];
                    }
                    if(!empty($data['discount']) && $data['discount'] != $GLOBALS['null_value']) {
                        $discount = $data['discount'];
                    }
                    if(!empty($data['discount_name']) && $data['discount_name'] != $GLOBALS['null_value']) {
                        $discount_name = $obj->encode_decode('decrypt', $data['discount_name']);
                    }
                    if(!empty($data['discount_value']) && $data['discount_value'] != $GLOBALS['null_value']) {
                        $discount_value = $data['discount_value'];
                    }
                    if(!empty($data['extra_charges']) && $data['extra_charges'] != $GLOBALS['null_value']) {
                        $extra_charges = $data['extra_charges'];
                    }
                    if(!empty($data['extra_charges_name']) && $data['extra_charges_name'] != $GLOBALS['null_value']) {
                        $extra_charges_name = $obj->encode_decode('decrypt', $data['extra_charges_name']);
                    }
                    if(!empty($data['extra_charges_value']) && $data['extra_charges_value'] != $GLOBALS['null_value']) {
                        $extra_charges_value = $data['extra_charges_value'];
                    } 
                    if(!empty($data['bank_id']) && $data['bank_id'] != $GLOBALS['null_value']) {
                        $bank_id = $data['bank_id'];
                    }
                    if(!empty($data['product_tax']) && $data['product_tax'] != $GLOBALS['null_value']) {
                        $product_tax = explode(',', $data['product_tax']);
                    }
                }
            }
        }
        $unit_list = array();
        $unit_list = $obj->getTableRecords($GLOBALS['unit_table'], '', '', '');
        $party_list = array();
        $party_list = $obj->getPartyDetailList('2');
        $party_count = 0;
        if(!empty($party_list)) {
            $party_count = count($party_list);
        }
        $product_list = array();
        $product_list = $obj->getTableRecords($GLOBALS['product_table'], '', '', '');
        ?>
        <form class="poppins pd-20 redirection_form" name="estimate_form" method="POST">
			<div class="card-header">
				<div class="row p-2">
                    <div class="col-lg-8 col-md-8 col-8 align-self-center">
                        <?php if(empty($show_estimate_id) || !empty($conversion_update)) { ?>
						    <div class="h5">Add Estimate</div>
                        <?php }else { ?>
						    <div class="h5">Edit Estimate</div>
                        <?php } ?>
					</div>
					<div class="col-lg-4 col-md-4 col-4">
					    <?php if(!empty($conversion_update) && $conversion_update == '1') { ?>
                            <button class="btn btn-dark float-end" style="font-size:11px;" type="button" onclick="window.open('order_form.php','_self')"> <i class="fa fa-arrow-circle-o-left"></i> &ensp; Back </button>
                        <?php }else{?>
                                <button class="btn btn-dark float-end" style="font-size:11px;" type="button" onclick="window.open('estimate.php','_self')"> <i class="fa fa-arrow-circle-o-left"></i> &ensp; Back </button>
                        <?php } ?>

					</div>
				</div>
			</div>
              <?php if(!empty($order_form_number) && $order_form_number != $GLOBALS['null_value']){  ?>
                <div class="row justify-content-center p-3" >
                    <div class="col-lg-12 col-md-4 col-6 py-2 px-lg-1 text-center" style ="font-weight : bold;font-size: 20px;">
                    <?php echo 'Order Form No : ' .$order_form_number;  ?>
                    </div>
                </div>
            <?php } ?>

            <div class="row justify-content-center p-3">

                <input type="hidden" name="edit_id" value="<?php if(!empty($show_estimate_id) && empty($conversion_update)) { echo $show_estimate_id; } ?>">
                <?php if($conversion_update == '1') { ?>
                    <input type="hidden" name="conversion_update" value="1">
                    <input type="hidden" name="conversion_id" value="<?php if(!empty($show_estimate_id)) { echo $show_estimate_id; } ?>">
                <?php } ?> 
                <div class="col-lg-2 col-md-4 col-6 py-2 px-lg-1">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                            <input type="date" id="estimate_date" name="estimate_date" class="form-control shadow-none" placeholder="" value="<?php if(!empty($estimate_date)){ echo $estimate_date; }?>" max="<?php if(!empty($current_date)){ echo $current_date; }?>">
                            <label>Bill Date</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-6 py-2 px-lg-1">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                            <div class="input-group  flex-nowrap" <?php if(!empty($conversion_update) && $conversion_update == '1' && (!empty($show_estimate_id))) { ?> style="pointer-events:none;" <?php } ?>>
                                <select class="select2 select2-danger" name ="party_id" data-dropdown-css-class="select2-danger" style="width: 100%;" onchange="Javascript:getPartyState(this.value);" <?php if(!empty($conversion_update) && $conversion_update == '1' && (!empty($show_estimate_id))) { ?> tabindex = -1 <?php } ?>>
                                    <option value= "">Select Party</option>
                                    <?php if(!empty($party_list)) {
                                        foreach($party_list as $data) { ?>
                                            <option value="<?php if(!empty($data['party_id'])) { echo $data['party_id']; } ?>" <?php if(!empty($data['party_id']) && ($data['party_id'] == $party_id))  { ?>selected<?php } ?>><?php if(!empty($data['name_mobile_city'])) { echo $obj->encode_decode("decrypt",$data['name_mobile_city']); } ?></option>
                                    <?php }
                                    } ?>
                                </select>
                                <label>Select Party(*)</label>
					            <?php if(empty($conversion_update)){ ?>

                                    <div class="input-group-append">
                                        <button class="btn btn-success input-group-text" style="background-color:#20ac15;font-size:12px;width:100%;justify-content: center;" type="button" onClick="Javascript:CustomPartyModal(this);"><i class="fa fa-plus" style='color:white;'></i></button>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>    
                </div>
                <div class="col-lg-2 col-md-4 col-6 px-lg-1 py-2">
                    <div class="form-group mb-1">
                        <div class="flex-shrink-0">
                            <div class="form-check form-switch form-switch-right form-switch-md">
                                <label for="gst_option" class="form-label text-muted smallfnt">GST/Non GST</label>
                                <input class="form-check-input code-switcher" type="checkbox" name="gst_option" onchange="Javascript:GetTaxType(this,this.value);"
                                value="<?php echo $gst_option; ?>" <?php if ($gst_option == '1') echo 'checked'; ?> id="gst_option">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 py-2 d-none">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                            <select class="select2 select2-danger" name="tax_type" data-dropdown-css-class="select2-danger" style="width: 100%!important;" onchange="Javascript:GetTaxValue(this.value);">
                                <!-- <option value="">Select</option> -->
                                <!-- <option value="1" <?php if(!empty($tax_type) && $tax_type == '1') { ?>selected<?php } ?>>Productwise Tax</option> -->
                                <option value="2" <?php if(!empty($tax_type) && $tax_type == '2') { ?>selected<?php } ?>>Overall Tax</option>
                            </select>
                            <label>Tax Type <span class="text-danger">*</span></label>
                        </div>
                    </div>  
                </div>
                <div class="col-lg-3 col-md-6 col-12 py-2 d-none" id="tax_option_div">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                            <select name="tax_option" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;!important;" onchange="Javascript:calTotal();">
                                <option value="">Select</option>
                                <option value="1" <?php if($tax_option == 1 || empty($tax_option)) { ?>Selected<?php } ?>>Exclusive</option>
                                <option value="2" <?php if($tax_option == 2) { ?>Selected<?php } ?>>Inclusive</option>
                            </select>
                            <label>Tax Option <span class="text-danger">*</span></label>
                        </div>
                    </div> 
                </div>
            </div>    
            <div class="col-lg-3 col-md-6 col-12 py-2 d-none">
                <div class="form-group">
                    <div class="form-label-group in-border">
                        <select class="select2 select2-danger" name="overall_tax" data-dropdown-css-class="select2-danger" style="width: 100%!important;" onchange="Javascript:calTotal();">
                            <!-- <option value="">Select</option> -->
                            
                            <option value="18%" <?php if(!empty($overall_tax) && $overall_tax == '18%') { ?>selected<?php } ?>>18%</option>
                            
                        </select>
                        <label>Overall Tax <span class="text-danger">*</span></label>
                    </div>
                </div>  
            </div> 
            <div class="row justify-content-center p-3"> 
                <div class="col-lg-3 col-md-4 col-6 px-lg-1 py-2">
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
                    <button class="btn btn-danger py-2 add_product_button" style="font-size:12px; width:100%;" type="button" onclick="AddProductRow();">  Add </button>
                </div>
            </div>
            <div class="row justify-content-center">    
                <div class="col-lg-12">
                    <div class="table-responsive text-center">
                        <input type="hidden" name="product_row_count" value="<?php echo $product_count; ?>">
                        <input type="hidden" name="company_state" value="<?php echo $company_state; ?>">
                        <input type="hidden" name="party_state" value="<?php echo $party_state; ?>">
                        <table class="table nowrap cursor smallfnt w-100 table-bordered product_row_table">
                            <thead class="bg-dark smallfnt">
                                <tr>
                                    <th>#</th>
                                    <th style="width:300px;">Product</th>
                                    <th style="width:150px;">Unit</th>
                                    <th style="width:150px;">Size</th>
                                    <th style="width:100px;">HSN</th>
                                    <th style="width:100px;">QTY</th>
                                    <th tyle="width:100px;">Rate</th>
                                    <th style="min-width:100px;" class="tax_element d-none">Tax</th>
                                    <th style="min-width:100px;" class="final_price_element d-none">Final Rate</th>
                                    <th style="min-width:150px;">Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                             <tbody>
                                  <?php
                                    if(!empty($product_ids)) {
                                        for($i=0; $i < count($product_ids); $i++) { 
                                            if(!empty($product_ids[$i])){
                                                if(empty($product_tax[$i])){
                                                    $tax = ""; 
                                                    $tax =  $obj->getTableColumnValue($GLOBALS['product_table'],'product_id',$product_ids[$i],'product_tax');
                                                    $product_tax[$i] = $tax;
                                                }
                                                ?>
                                                <tr class="product_row" id="product_row<?php echo $i+1; ?>">
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
                                                                <input type="text" name="quantity[]" style="width:75%!important;margin:auto!important;" class="form-control shadow-none  text-center" value="<?php if(!empty($quantity[$i])) { echo $quantity[$i]; } ?>" onfocus="Javascript:KeyboardControls(this,'number','','');" onkeyup="Javascript:ProductRowCheck(this);">
                                                            </div>
                                                        </div> 
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="form-group">
                                                            <div class="form-label-group in-border">
                                                                <input type="text" name="rates[]" style="width:75%!important;margin:auto!important;" class="form-control shadow-none text-center" value="<?php if(!empty($rates[$i])) { echo number_format($rates[$i],2); } ?>" onfocus="Javascript:KeyboardControls(this,'number','','');" onkeyup="Javascript:ProductRowCheck(this);">
                                                            </div>
                                                        </div> 
                                                    </td>
                                                    <td class="text-center px-2 py-2 tax_element d-none" >
                                                        <select name="product_tax[]" class="form-control shadow-none product_tax" style="width:100%!important;" onchange="Javascript:calTotal();">
                                                            
                                                            <option value="0%" <?php if(!empty($product_tax[$i]) && $product_tax[$i] == '0%') { ?>selected<?php } ?>>0%</option>
                                                            <option value="5%" <?php if(!empty($product_tax[$i]) && $product_tax[$i] == '5%') { ?>selected<?php } ?>>5%</option>
                                                            <option value="12%" <?php if(!empty($product_tax[$i]) && $product_tax[$i] == '12%') { ?>selected<?php } ?>>12%</option>
                                                            <option value="18%" <?php if(!empty($product_tax[$i]) && $product_tax[$i] == '18%') { ?>selected<?php } ?>>18%</option>
                                                            <option value="28%" <?php if(!empty($product_tax[$i]) && $product_tax[$i] == '28%') { ?>selected<?php } ?>>28%</option>
                                                        </select>
                                                    </td>
                                                    <td class="text-center px-2 py-2 final_price_element d-none" >
                                                        <div class="form-group pe-2 text-end final_price"><?php if(!empty($final_price[$i])) { echo $final_price[$i]; } ?></div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="form-group">
                                                            <div class="form-label-group in-border">
                                                                <input type="text" name="amount[]" style="width:75%!important;margin:auto!important;" class="form-control shadow-none  text-center amount product_amount" value="<?php if(!empty($amounts[$i])) { echo number_format($amounts[$i],2); } ?>" readonly>
                                                            </div>
                                                        </div>    
                                                    </td>
                                                    <td class="text-center">
                                                        <button class="btn btn-danger" type="button" onclick="Javascript:DeleteRow('product_row', '<?php echo $i+1; ?>');"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                                 <?php
                                            }
                                        }
                                    } ?>

                            </tbody> 
                            <tfoot>
                                   <tr class="subtotal_row">
                                        <td colspan="6" class="text-end fw-bold">Subtotal : &nbsp;</td>
                                        <td colspan="2" class="text-end pe-2 fw-bold sub_total">0.00</td>
                                        <td></td>
                                    </tr>
                                  <?php
                                    if(!empty($discount_value)) {
                                        ?>
                                        <tr class="discount_row">
                                            <td colspan="4" class="text-right">
                                                <input type="text" style="width:200px; float:right;" name="discount_name" class="form-control" placeholder="Discount Name" value="<?php if(!empty($discount_name)) { echo $discount_name; } else { echo "Extra Discount"; } ?>">
                                            </td>
                                            <td colspan="2" class="text-right">
                                                <input style="width:200px;" type="text" name="discount" class="form-control" placeholder="Discount Value" onkeyup="Javascript:calTotal();" value="<?php if(!empty($discount)) { echo $discount; } ?>">
                                            </td>
                                            <td colspan="2" class="text-end pe-2 fw-bold discount_value">
                                                <?php if(!empty($discount_value)) { echo $discount_value; } ?>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <?php
                                    }
                                    else {
                                        ?>
                                        <tr class="discount_row">
                                            <td colspan="4" class="text-right">
                                                <input type="text" style="width:200px; float:right;" name="discount_name" class="form-control" placeholder="Discount Name" value="Extra Discount">
                                            </td>
                                            <td colspan="2" class="text-right">
                                                <input style="width:200px;" type="text" name="discount" class="form-control" placeholder="Discount Value" onkeyup="Javascript:calTotal();">
                                            </td>
                                            <td colspan="2" class="text-end pe-2 fw-bold discount_value">0.00</td>
                                            <td></td>
                                        </tr>
                                        <?php
                                    }
                                ?>
                                <tr class="discounted_total_row">
                                    <td colspan="6" class="text-end fw-bold">Discounted Total : &nbsp;</td>
                                    <td colspan="2" class="text-end pe-2 fw-bold discounted_total">0.00</td>
                                    <td></td>
                                </tr>
                                <?php
                                    if(!empty($extra_charges_value)) {
                                        ?>
                                        <tr class="charges_row">
                                            <td colspan="4" class="text-right">
                                                <input type="text" style="width:200px; float:right;" name="extra_charges_name" class="form-control" placeholder="Extra Charges Name" value="<?php if(!empty($extra_charges_name)) { echo $extra_charges_name; } else { echo "Extra Charges"; } ?>">
                                            </td>
                                            <td colspan="2" class="text-right">
                                                <input style="width:200px;" type="text" name="extra_charges" class="form-control" placeholder="Charges Value" onkeyup="Javascript:calTotal();" value="<?php if(!empty($extra_charges)) { echo $extra_charges; } ?>">
                                            </td>
                                            <td colspan="2" class="text-end pe-2 fw-bold extra_charges_value">
                                                <?php if(!empty($extra_charges_value)) { echo $extra_charges_value; } ?>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <?php
                                    } 
                                    else {
                                        ?>
                                        <tr class="charges_row">
                                            <td colspan="4" class="text-right">
                                                <input type="text" style="width:200px; float:right;" name="extra_charges_name" class="form-control" placeholder="Extra Charges Name" value="Extra Charges">
                                            </td>
                                            <td colspan="2" class="text-right">
                                                <input style="width:200px;" type="text" name="extra_charges" class="form-control" placeholder="Charges Value" onkeyup="Javascript:calTotal();">
                                            </td>
                                            <td colspan="2" class="text-end pe-2 fw-bold extra_charges_value">0.00</td>
                                            <td></td>
                                        </tr>
                                        <?php
                                    }
                                ?>
                                <tr class="extra_charges_total_row">
                                    <td colspan="6" class="text-end fw-bold">Total : &nbsp;</td>
                                    <td colspan="2" class="text-end pe-2 fw-bold extra_charges_total">0.00</td>
                                    <td></td>
                                </tr>
                                <tr class="cgst_value_row d-none">
                                    <td colspan="6" class="text-end fw-bold">CGST : &nbsp;</td>
                                    <td colspan="2" class="text-end pe-2 fw-bold cgst_value">0.00</td>
                                    <td></td>
                                </tr>
                                <tr class="sgst_value_row d-none">
                                    <td colspan="6" class="text-end fw-bold">SGST : &nbsp;</td>
                                    <td colspan="2" class="text-end pe-2 fw-bold sgst_value">0.00</td>
                                    <td></td>
                                </tr>
                                <tr class="igst_value_row d-none">
                                    <td colspan="6" class="text-end fw-bold">IGST : &nbsp;</td>
                                    <td colspan="2" class="text-end pe-2 fw-bold igst_value">0.00</td>
                                    <td></td>
                                </tr>
                                <tr class="total_tax_value_row d-none">
                                    <td colspan="6" class="text-end fw-bold">Total Tax : &nbsp;</td>
                                    <td colspan="2" class="text-end pe-2 fw-bold total_tax_value">0.00</td>
                                    <td></td>
                                </tr>
                                <tr class="round_off_row">
                                    <td colspan="6" class="text-end fw-bold">Round Off : &nbsp;</td>
                                    <td colspan="2" class="text-end pe-2 fw-bold round_off">0.00</td>
                                    <td></td>
                                </tr>
                                <tr class="bill_total_row">
                                    <td colspan="6" class="text-end fw-bold">Bill Amount : &nbsp;</td>
                                    <td colspan="2" class="text-end pe-2 fw-bold overall_total">0.00</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col-md-12 py-3 text-center">
                    <button class="btn btn-danger submit_button" type="button" onclick="Javascript:SaveModalContent(event, 'estimate_form', 'estimate_changes.php', 'estimate.php');">
                        Submit
                    </button>
                </div>
            </div>
            <script src="include/select2/js/select2.min.js"></script>
            <script src="include/select2/js/select.js"></script>
            <script type="text/javascript" src="include/js/tax_calculation.js"></script>
             <script type="text/javascript" src="include/js/bill_action.js"></script>
             <script  type="text/javascript" src="include/js/order_form.js"></script>

            <script type="text/javascript">
                jQuery(document).ready(function() {
                    if(jQuery('select[name="party_id"]').length > 0) {
                        var party_id = jQuery('select[name="party_id"]').val();
                    }
                    <?php if(!empty($show_estimate_id)){ ?>
                        getPartyState(party_id);
                        GetTaxType('<?php echo $gst_option; ?>');
                    <?php } ?>

                });
            </script>
        </form>
		<?php
    } 
      if(isset($_POST['edit_id'])) {
        $estimate_date = ""; $estimate_date_error = "";$bill_number = ""; $bill_number_error = ""; $party_id = ""; $party_id_error = ""; $product_ids = array(); $product_names = array(); $row_no = array(); $unit_ids = array(); $unit_names = array();$hsn_code = array(); $quantity = array();$rates = array(); $product_tax = array(); $size_ids = array(); $amount = array(); $sub_total = 0;  $notes = ""; $total_quantity = 0;$individual_array = array();
        $form_name = "estimate_form"; $estimate_error = ""; $total_amount = 0;
        $tax_option = "";  $tax_type = ""; $overall_tax = ""; $tax_option_error = ""; $gst_option = "";
        $edit_id = "";$discount_name = ""; $discount_name_error = ""; $discount = ""; $discount_error = ""; $discount_value = 0; $discounted_total = 0; $extra_charges_name = ""; $extra_charges_name_error = ""; $extra_charges = ""; $extra_charges_error = ""; $extra_charges_value = ""; $extra_charges_total = 0; $taxable_value = 0; $company_state = ""; $party_state = ""; $cgst_value = 0; $sgst_value = 0; $igst_value = 0; $round_off = ""; $total_tax_value = 0; $bill_total = 0; $total_quantity = 0; $total_amount = 0;  $conversion_update = 0;
        $product_tax = array(); $final_price = array(); $product_amount = array(); $sub_total = 0; 
        if(isset($_POST['edit_id'])){
            $edit_id = $_POST['edit_id'];
        }

        if(isset($_POST['conversion_update'])) {
            $conversion_update = $_POST['conversion_update'];
            $conversion_update = trim($conversion_update);
        }

        if(isset($_POST['conversion_id'])) {
            $conversion_id = $_POST['conversion_id'];
            $conversion_id = trim($conversion_id);
        }
        if(isset($_POST['estimate_date'])) {
            $estimate_date = trim($_POST['estimate_date']);
            $estimate_date_error = $valid->valid_date(date('Y-m-d', strtotime($estimate_date)), 'Bill Date', '1');
            if(!empty($estimate_date_error)) {
                if(!empty($valid_estimate)) {
                    $valid_estimate = $valid_estimate." ".$valid->error_display($form_name, 'estimate_date', $estimate_date_error, 'text');
                }
                else {
                    $valid_estimate = $valid->error_display($form_name, 'estimate_date', $estimate_date_error, 'text');
                }
            }
        }

        if(isset($_POST['party_id'])) {
            $party_id = trim($_POST['party_id']);
            $party_id_error = $valid->common_validation($party_id, ' Party', 'select');
            if(!empty($party_id_error)) {
                if(!empty($valid_estimate)) {
                    $valid_estimate = $valid_estimate." ".$valid->error_display($form_name, 'party_id', $party_id_error, 'select');
                }
                else {
                    $valid_estimate = $valid->error_display($form_name, 'party_id', $party_id_error, 'select');
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
                    if(!empty($valid_estimate)) {
                        $valid_estimate = $valid_estimate." ".$valid->error_display($form_name, 'notes', $notes_error, 'select');
                    }
                    else {
                        $valid_estimate = $valid->error_display($form_name, 'notes', $notes_error, 'select');
                    }
                }
                else {
                    $party_state = $obj->getTableColumnValue($GLOBALS['party_table'], 'notes', $notes, 'state');
                }
            }
        }

        if(isset($_POST['gst_option'])) {
            $gst_option = $_POST['gst_option'];
            $gst_option = trim($gst_option);
            $gst_option_error = $valid->common_validation($gst_option, 'GST option', 'input');

            if(isset($_POST['tax_type'])) {
                $tax_type = $_POST['tax_type'];
                $tax_type = trim($tax_type);
            }
        }
    
        if(empty($gst_option_error)) {
            if($gst_option != '1' && $gst_option != '2') {
                $gst_option_error = "Invalid GST option";
            }
        }
        if(!empty($gst_option_error)) {
            if(!empty($valid_estimate)) {
                $valid_estimate = $valid_estimate." ".$valid->error_display($form_name, 'gst_option', $gst_option_error, 'input');
            }
            else {
                $valid_estimate = $valid->error_display($form_name, 'gst_option', $gst_option_error, 'input');
            }
        }

        if($gst_option == '1') {

            $tax_type = 1;
            if(isset($_POST['tax_type'])) {

                $tax_type = $_POST['tax_type'];
                $tax_type = trim($tax_type);
            }

            $tax_type_error = $valid->common_validation($tax_type, 'Tax Type', 'select');
            if(empty($tax_type_error)) {
                if($tax_type != '1' && $tax_type != '2') {
                    $tax_type_error = "Invalid Tax Type";
                }
            }
            if(!empty($tax_type_error)) {
                if(!empty($valid_estimate)) {
                    $valid_estimate = $valid_estimate." ".$valid->error_display($form_name, 'tax_type', $tax_type_error, 'select');
                }
                else {
                    $valid_estimate = $valid->error_display($form_name, 'tax_type', $tax_type_error, 'select');
                }
            }

            $tax_option = $_POST['tax_option'];
            $tax_option = trim($tax_option);
            $tax_option_error = $valid->common_validation($tax_option, 'Tax Option', 'select');
            if(empty($tax_option_error)) {
                if($tax_option != '1' && $tax_option != '2') {
                    $tax_option_error = "Invalid Tax Option";
                }
            }
            if(!empty($tax_option_error)) {
                if(!empty($valid_estimate)) {
                    $valid_estimate = $valid_estimate." ".$valid->error_display($form_name, 'tax_option', $tax_option_error, 'select');
                }
                else {
                    $valid_estimate = $valid->error_display($form_name, 'tax_option', $tax_option_error, 'select');
                }
            }

            if($tax_type == '2') {
                $overall_tax = $_POST['overall_tax'];
                $overall_tax = trim($overall_tax);
                $overall_tax_error = $valid->common_validation($overall_tax, 'Overall Tax', 'select');
                if(!empty($overall_tax_error)) {
                    if(!empty($valid_estimate)) {
                        $valid_estimate = $valid_estimate." ".$valid->error_display($form_name, 'overall_tax', $overall_tax_error, 'select');
                    }
                    else {
                        $valid_estimate = $valid->error_display($form_name, 'overall_tax', $overall_tax_error, 'select');
                    }
                }
            }
        }

        if(isset($_POST['company_state'])) {
            $company_state = $_POST['company_state'];
            $company_state = trim($company_state);
        }
        if(isset($_POST['party_state'])) {
            $party_state = $_POST['party_state'];
            $party_state = trim($party_state);
        }

        if(isset($_POST['product_id'])) {
            $product_ids = $_POST['product_id'];
        }
        if(isset($_POST['product_tax'])) {
            $product_tax = $_POST['product_tax'];
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

                                   $final_price[$i] = $rates[$i];
                                if($gst_option == '1') { 
                                    if($tax_option == '2') {
                                        if($tax_type == '1') {
                                            $tax = 0;
                                            $tax = str_replace("%", "", $product_tax[$i]);
                                            $tax = trim($tax);
                                            if(empty($tax)){
                                                $tax = 0;
                                            }
                                            $final_price[$i] = ($rates[$i] * 100) / (100 + $tax);
                                            $final_price[$i] = number_format($final_price[$i], 2);
                                            $final_price[$i] = str_replace(",", "", $final_price[$i]);
                                        }else{
                                            $tax = 0;
                                            $tax = str_replace("%", "", $overall_tax);
                                            $tax = trim($tax);
                                            if(empty($tax)){
                                                $tax = 0;
                                            }
                                            $final_price[$i] = ($rates[$i] * 100) / (100 + $tax);
                                            $final_price[$i] = number_format($final_price[$i], 2);
                                            $final_price[$i] = str_replace(",", "", $final_price[$i]);
                                        }
                                         $amount[$i] = $quantity[$i] * $final_price[$i];
                                    }else{
                                         $amount[$i] = $quantity[$i] * $rates[$i];
                                    }
                                }else{
                                     $amount[$i] = $quantity[$i] * $rates[$i];

                                }
                                $product_amount[$i] = $amount[$i];
                                $product_amount[$i] = number_format($product_amount[$i], 2);
                                $product_amount[$i] = str_replace(",", "", $product_amount[$i]);

                                 $sub_total += $product_amount[$i];
                            }else{
                                if(!empty($valid_estimate)) {
                                    $valid_estimate = $valid_estimate." ".$valid->row_error_display($form_name, 'rates[]', $price_error, 'text', 'product_row', ($i+1));
                                }
                                else {
                                    $valid_estimate = $valid->row_error_display($form_name, 'rates[]', $price_error, 'text', 'product_row', ($i+1));
                                }
                            }
                               
                        }

                    }else{
                        if(!empty($valid_estimate)) {
                            $valid_estimate = $valid_estimate." ".$valid->row_error_display($form_name, 'quantity[]', $quantity_error, 'text', 'product_row', ($i+1));
                        }
                        else {
                            $valid_estimate = $valid->row_error_display($form_name, 'quantity[]', $quantity_error, 'text', 'product_row', ($i+1));
                        }
                    }
                    
                       
                }

                if(isset($hsn_code[$i])) {
                    $hsn_code[$i] = trim($hsn_code[$i]);

                    $hsn_error = "";
                    $hsn_error = $valid->valid_number($hsn_code[$i], 'hsn_code', '0','');
                 
                    if(!empty($hsn_error)){

                        if(!empty($valid_estimate)) {
                            $valid_estimate = $valid_estimate." ".$valid->row_error_display($form_name, 'hsn_code[]', $hsn_error, 'text', 'product_row', ($i+1));
                        }
                        else {
                            $valid_estimate = $valid->row_error_display($form_name, 'hsn_code[]', $hsn_error, 'text', 'product_row', ($i+1));
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

                            if(!empty($valid_estimate)) {
                                $valid_estimate = $valid_estimate." ".$valid->row_error_display($form_name, 'description[]', $description_error, 'text', 'product_row', ($i+1));
                            }
                            else {
                                $valid_estimate = $valid->row_error_display($form_name, 'description[]', $description_error, 'text', 'product_row', ($i+1));
                            }
                        }
                    }
                 
              
                        
                }
                if(empty($valid_estimate)) {

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
            $estimate_error = "Add Products";
        }

        $total_amount = $sub_total;
        if(isset($_POST['discount'])) {
            $discount = trim($_POST['discount']);
        }
        if(isset($_POST['discount_name'])) {
            $discount_name = trim($_POST['discount_name']);
            if(!empty($discount)) {
                $discount_name_error = $valid->valid_regular_expression($discount_name, 'Discount Name', 1,'50');
            }
        }
        if(!empty($discount_name_error)) {
            if(!empty($valid_estimate)) {
                $valid_estimate = $valid_estimate." ".$valid->error_display($form_name, 'discount_name', $discount_name_error, 'text');
            }
            else {
                $valid_estimate = $valid->error_display($form_name, 'discount_name', $discount_name_error, 'text');
            }
        }
        if(!empty($discount)) {
            if(strpos($discount, '%') !== false) {
                $discount_percent = str_replace('%', '', $discount);
                $discount_percent = trim($discount_percent);
                if(preg_match("/^[0-9]+(\\.[0-9]+)?$/", $discount_percent) && ($discount_percent > 0) && ($discount_percent < 100)){
                    $discount_value = ($discount_percent * $sub_total) / 100;
                }
                else {
                    $discount_error = "Invalid Discount";
                }
            }
            else {
                if(preg_match("/^[0-9]+(\\.[0-9]+)?$/", $discount) && ($discount > 0) && ($discount <= $sub_total)){
                    $discount_value = $discount;
                }
                else {
                   
                    $discount_error = "Invalid Discount";
                }
            }
            if(!empty($discount_value)) {
                $discount_value = number_format($discount_value, 2);
                $discount_value = str_replace(",", "", $discount_value);
                $total_amount = $total_amount - $discount_value;
            }
        }
        if(!empty($discount_error)) {
            if(!empty($valid_estimate)) {
                $valid_estimate = $valid_estimate." ".$valid->error_display($form_name, 'discount', $discount_error, 'text');
            }
            else {
                $valid_estimate = $valid->error_display($form_name, 'discount', $discount_error, 'text');
            }
        }
        $discounted_total = $total_amount;

        if(isset($_POST['extra_charges'])) {
            $extra_charges = trim($_POST['extra_charges']);
        }
        if(isset($_POST['extra_charges_name'])) {
            $extra_charges_name = trim($_POST['extra_charges_name']);
            if(!empty($extra_charges)) {
                $extra_charges_name_error = $valid->valid_regular_expression($extra_charges_name, 'Charges Name', 1,'50');
            }
        }
        if(!empty($extra_charges_name_error)) {
            if(!empty($valid_estimate)) {
                $valid_estimate = $valid_estimate." ".$valid->error_display($form_name, 'extra_charges_name', $extra_charges_name_error, 'text');
            }
            else {
                $valid_estimate = $valid->error_display($form_name, 'extra_charges_name', $extra_charges_name_error, 'text');
            }
        }
        if(!empty($extra_charges)) {
            if(strpos($extra_charges, '%') !== false) {
                $extra_charges_percent = str_replace('%', '', $extra_charges);
                $extra_charges_percent = trim($extra_charges_percent);
                if(preg_match("/^[0-9]+(\\.[0-9]+)?$/", $extra_charges_percent) && ($extra_charges_percent > 0) && ($extra_charges_percent < 100)){
                    $extra_charges_value = ($extra_charges_percent * $discounted_total) / 100;
                }
                else {
                    $extra_charges_error = "Invalid extra charges";
                }
            }
            else {
                if(preg_match("/^[0-9]+(\\.[0-9]+)?$/", $extra_charges) && ($extra_charges > 0) && ($extra_charges <= $discounted_total)){
                    $extra_charges_value = $extra_charges;
                }
                else {
                    $extra_charges_error = "Invalid extra charges";
                }
            }
            if(!empty($extra_charges_value)) {
                $extra_charges_value = number_format($extra_charges_value, 2);
                $extra_charges_value = str_replace(",", "", $extra_charges_value);
                $total_amount = $total_amount + $extra_charges_value;
            }
        }
        if(!empty($extra_charges_error)) {
            if(!empty($valid_estimate)) {
                $valid_estimate = $valid_estimate." ".$valid->error_display($form_name, 'extra_charges', $extra_charges_error, 'text');
            }
            else {
                $valid_estimate = $valid->error_display($form_name, 'extra_charges', $extra_charges_error, 'text');
            }
        }
        $extra_charges_total = $total_amount;

        $greater_tax = ""; $str_tax = ""; $extra_charges_tax = 0; $product_tax_value = array(); $stock_unique_ids = array();
        if($gst_option == '1' && empty($estimate_error) && empty($valid_estimate)) {
            $taxable_value = $total_amount;
            if($tax_type =='1'){
                if(!empty($product_ids)) {
                    for($j=0; $j < count($product_ids); $j++) {
                        $discounted_product_amount = 0; $tax_value = 0;
                        if(!empty($product_amount[$j])) {
                            $discounted_product_amount = $product_amount[$j];

                            if(!empty($discount)) {
                                $discount_percent = 0;
                                if(strpos($discount, '%') !== false) {
                                    $discount_percent = str_replace("%", "", $discount);
                                    $discount_percent = trim($discount_percent);
                                    $discounted_product_amount = $product_amount[$j] - (($product_amount[$j] * $discount_percent) / 100);
                                }
                                else {
                                    $discount_percent = ($discount / $sub_total) * 100;
                                    $discounted_product_amount = $product_amount[$j] - (($product_amount[$j] * $discount_percent) / 100);
                                }
                            }
                            $tax = 0;
                            if(!empty($product_tax[$j])) {
                                $tax = str_replace("%", "", $product_tax[$j]);
                                $tax = trim($tax);
                                $tax_value = ($discounted_product_amount * $tax) / 100;
                                $product_tax_value[$j] = $tax_value;
                                $total_tax_value += $tax_value;
                            }
                            if ($tax > $str_tax) {
                                $greater_tax = $tax;
                            } 
                            else {
                                $greater_tax = $str_tax;
                            }
                            $str_tax = $greater_tax;
                            $individual_array[] = array('tax'=>$tax, 'quantity'=>$quantity[$j],'taxable_value'=>$discounted_product_amount, 'tax_amount'=>$tax_value,'hsn_code'=>$hsn_code[$j]);
                        }
                    }
                    if(!empty($extra_charges_value)) {
                        $extra_charges_tax = ($extra_charges_value * $greater_tax) / 100;
                        if(!empty($extra_charges_tax)) {
                            $total_tax_value += $extra_charges_tax;
                        }
                        // $individual_array[] = array('tax'=>$greater_tax, 'quantity'=>0, 'taxable_value'=>$extra_charges_value, 'tax_amount'=>$extra_charges_tax,'hsn_code'=>'');
                    }
                }
            }else if($tax_type == '2') {
                $tax = "";
                if(!empty($overall_tax)) {
                    $tax = str_replace("%", "", $overall_tax);
                    $tax = trim($tax);
                    if(preg_match("/^[0-9]+(\\.[0-9]+)?$/", $tax)) {
                        $total_tax_value = ($extra_charges_total * $tax) / 100;
                    }else {
                        $estimate_error = "Invalid Overall tax";
                    }
                    if(!empty($product_ids) && empty($estimate_error) && empty($valid_estimate)) {
                        for($j=0; $j < count($product_ids); $j++) {
                            $discounted_product_amount = 0; $tax_value = 0;
                            if(!empty($product_amount[$j])) {
                                $discounted_product_amount = $product_amount[$j];
                                if(!empty($discount_value)) {
                                    $discount_percent = 0;
                                    $discount_percent = ($discount_value / $sub_total) * 100;
                                    $discounted_product_amount = $product_amount[$j] - (($product_amount[$j] * $discount_percent) / 100);
                                }
                                $tax_value = ($discounted_product_amount * $tax) / 100;
                                $individual_array[] = array('tax'=>$tax, 'quantity'=>$quantity[$j], 'taxable_value'=>$discounted_product_amount, 'tax_amount'=>$tax_value,'hsn_code'=>$hsn_code[$j]);
                            }
                        }
                        if(!empty($extra_charges_value)) {
                            $charges_tax = ($extra_charges_value * $tax) / 100;
                            // $individual_array[] = array('tax'=>$tax, 'quantity'=>0, 'taxable_value'=>$extra_charges_value, 'tax_amount'=>$charges_tax,'hsn_code'=>'');
                        }
                    }
                }
            
            }
            if(!empty($total_tax_value)) {
                $total_tax_value = number_format($total_tax_value, 2);
                $total_tax_value = str_replace(",", "", $total_tax_value);
                if($company_state == $party_state) {
                    $cgst_value = $total_tax_value / 2;
                    $cgst_value = number_format($cgst_value, 2);
                    $cgst_value = str_replace(",", "", $cgst_value);
                    $sgst_value = $total_tax_value / 2;
                    $sgst_value = number_format($sgst_value, 2);
                    $sgst_value = str_replace(",", "", $sgst_value);
                }
                else {
                    $igst_value = $total_tax_value;
                    $igst_value = number_format($igst_value, 2);
                    $igst_value = str_replace(",", "", $igst_value);
                }
                $total_amount = $total_amount + $total_tax_value;
            }
        }
        $total_amount = number_format((float)$total_amount, 2, '.', '');
        if(!empty($individual_array)) {
            array_multisort(array_column($individual_array, "tax"), SORT_ASC);
        }

		 $round_off = 0;
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
        $bill_total = $total_amount;

        if(empty($estimate_error) && empty($valid_estimate) && $total_amount <= '0') {
            $estimate_error = "Bill value cannot be 0";
        }
            if(!empty($edit_id) && empty($estimate_error) && empty($valid_estimate)) {

                if(!empty($product_ids)) {
                    for($j=0; $j < count($product_ids); $j++) {
                        $stock_unique_ids[] = $obj->getStockUniqueID($edit_id,$product_ids[$j], $unit_ids[$j],$size_ids[$j]);
                    }
                }
                $prev_stock_list = array();
                $prev_stock_list = $obj->PrevStockList($edit_id);
                if(!empty($prev_stock_list)) {
                    foreach($prev_stock_list as $data) {
                        $stock_id = "";
                        if(!empty($data['id']) && $data['id'] != $GLOBALS['null_value']) {
                            $stock_id = $data['id'];
                        }
                        if(!in_array($stock_id, $stock_unique_ids)) {
                            $columns = array(); $values = array();
                            $columns = array('deleted');
                            $values = array('1');
                            $stock_update_id = $obj->UpdateSQL($GLOBALS['stock_table'], $stock_id, $columns, $values, '');
                        }
                    }
                }
            }
        
        if(empty($estimate_error) && empty($valid_estimate)){
                  
          
            
            $check_user_id_ip_address = 0;
            $check_user_id_ip_address = $obj->check_user_id_ip_address();
            if(preg_match("/^\d+$/", $check_user_id_ip_address)) {
                 $splitup_tax = array(); $splitup_quantity = array(); $splitup_amount = array(); 
                $splitup_tax_amount = array(); $splitup_hsn_code = array();
                $final_array = $obj->CombineAndSumUp($individual_array);
                if(!empty($final_array)) {
                    foreach($final_array as $data) {
                        if (isset($data['hsn_code'])) {
                            if (is_array($data['hsn_code'])) {
                                $hsn_value = !empty($data['hsn_code'])  ? implode(',', $data['hsn_code']) : '';
                            } else {
                                $hsn_value = !empty($data['hsn_code']) ? $data['hsn_code'] : '';
                            }

                        } else {
                            $hsn_value = '';
                        }

                        $splitup_hsn_code[] = $hsn_value;
                        $splitup_tax[] = $data['tax'];
                        $splitup_quantity[] = $data['quantity'];
                        $splitup_amount[] = $data['taxable_value'];
                        $splitup_tax_amount[] = $data['tax_amount'];
                    }
                }   

                $order_form_id = "";
                if(!empty($conversion_id) && $conversion_update == '1') {
                    $order_form_id = $conversion_id;
                }
                else {
                    $order_form_id = $GLOBALS['null_value'];
                }
              
                if(!empty($estimate_date)) {
                    $estimate_date = date('Y-m-d', strtotime($estimate_date));
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

                if($gst_option == '1') {
                    if($tax_type == '1') {
                        $overall_tax = $GLOBALS['null_value'];
                    }
                    else if($tax_type == '2') {
                        $product_tax = $GLOBALS['null_value'];
                    }
                }
                else {
                    $product_tax = "";
                    $overall_tax = $GLOBALS['null_value'];
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

                if(!empty(array_filter($final_price, fn($value) => $value !== ""))) {
                    $final_price = implode(",", $final_price);
                }
                else {
                    $final_price = $GLOBALS['null_value'];
                }

                if($gst_option =='1'){
                    if($tax_type =='1'){
                        if(!empty(array_filter($product_tax, fn($value) => $value !== ""))) {
                            $product_tax = implode(",", $product_tax);
                        }
                        else {
                            $product_tax = $GLOBALS['null_value'];
                        }
                    }else{
                        $product_tax = $GLOBALS['null_value'];
                    }
                }

                if(!empty(array_filter($splitup_tax, fn($value) => $value !== ""))) {
                    $splitup_tax = implode(",", $splitup_tax);
                }
                else {
                    $splitup_tax = $GLOBALS['null_value'];
                }
                if(!empty(array_filter($splitup_quantity, fn($value) => $value !== ""))) {
                    $splitup_quantity = implode(",", $splitup_quantity);
                }
                else {
                    $splitup_quantity = $GLOBALS['null_value'];
                }
                if(!empty(array_filter($splitup_amount, fn($value) => $value !== ""))) {
                    $splitup_amount = implode(",", $splitup_amount);
                }
                else {
                    $splitup_amount = $GLOBALS['null_value'];
                }
                if(!empty(array_filter($product_tax_value, fn($value) => $value !== ""))) {
                    $product_tax_value = implode(",", $product_tax_value);
                }
                else {
                    $product_tax_value = $GLOBALS['null_value'];
                }
                if(!empty(array_filter($splitup_tax_amount, fn($value) => $value !== ""))) {
                    $splitup_tax_amount = implode(",", $splitup_tax_amount);
                }
                else {
                    $splitup_tax_amount = $GLOBALS['null_value'];
                }
                if(!empty(array_filter($splitup_hsn_code, fn($value) => $value !== ""))) {
                    $splitup_hsn_code = implode(",", $splitup_hsn_code);
                }
                else {
                    $splitup_hsn_code = $GLOBALS['null_value'];
                }

                
                if(empty($discount_value)) {
                    $discount_value = $GLOBALS['null_value'];
                    $discount_name = $GLOBALS['null_value'];
                    $discount = $GLOBALS['null_value'];
                }
                else {
                    if(!empty($discount_name)) {
                        $discount_name = htmlentities($discount_name, ENT_QUOTES);
                        $discount_name = $obj->encode_decode('encrypt', $discount_name);
                    }
                    else {
                        $discount_name = $obj->encode_decode('encrypt', 'Extra Discount');
                    }
                }
                if(empty($extra_charges_value)) {
                    $extra_charges_value = $GLOBALS['null_value'];
                    $extra_charges_name = $GLOBALS['null_value'];
                    $extra_charges = $GLOBALS['null_value'];
                }
                else {
                    if(!empty($extra_charges_name)) {
                        $extra_charges_name = htmlentities($extra_charges_name, ENT_QUOTES);
                        $extra_charges_name = $obj->encode_decode('encrypt', $extra_charges_name);
                    }
                    else {
                        $extra_charges_name = $obj->encode_decode('encrypt', 'Extra Charges');
                    }
                }
                $created_date_time = $GLOBALS['create_date_time_label']; $creator = $GLOBALS['creator'];
                $updated_date_time = $GLOBALS['create_date_time_label']; 
                $creator_name = $obj->encode_decode('encrypt', $GLOBALS['creator_name']);
                $update_stock = 0;$balance = 0;
                if(empty($edit_id)){
                   
                    $action = "New estimate Created.";
                    
                    $null_value = $GLOBALS['null_value'];
                    $columns = array(); $values = array();
                    $columns = array('created_date_time','updated_date_time', 'creator', 'creator_name','bill_company_id','estimate_id', 'estimate_date', 'estimate_number','size_id','size_name','party_id', 'party_name', 'party_mobile_number', 'party_name_mobile_city', 'party_details', 'product_id', 'product_name','unit_id', 'unit_name', 'quantity', 'rate', 'amount', 'sub_total', 'discount', 'discount_name', 'discount_value', 'discounted_total', 'extra_charges', 'extra_charges_name', 'extra_charges_value', 'extra_charges_total', 'extra_charges_tax', 'company_state', 'party_state', 'taxable_value', 'cgst_value', 'sgst_value', 'igst_value', 'total_tax_value','total_amount', 'total_quantity','description', 'notes', 'hsn_code','round_off', 'bill_total','splitup_tax', 'splitup_quantity', 'splitup_amount', 'splitup_tax_amount','gst_option', 'tax_option', 'tax_type', 'overall_tax', 'final_price',  'product_tax', 'product_tax_value','order_form_id', 'splitup_hsn_code','cancelled','deleted');
                    $values = array($created_date_time,$updated_date_time, $creator, $creator_name,$bill_company_id, $null_value,  $estimate_date,$null_value,$size_ids, $size_names, $party_id, $party_name, $party_mobile_number,  $party_name_mobile_city, $party_details, $product_ids, $product_names,$unit_ids, $unit_names, $quantity, $rates, $amount,$sub_total, $discount, $discount_name, $discount_value, $discounted_total, $extra_charges, $extra_charges_name, $extra_charges_value, $extra_charges_total, $extra_charges_tax, $company_state, $party_state, $taxable_value, $cgst_value, $sgst_value, $igst_value, $total_tax_value, $total_amount,$total_quantity, $description, $notes, $hsn_code,$round_off, $bill_total, $splitup_tax, $splitup_quantity, $splitup_amount, $splitup_tax_amount,$gst_option, $tax_option, $tax_type, $overall_tax,$final_price, $product_tax, $product_tax_value, $order_form_id,$splitup_hsn_code,0, 0);
                    $estimate_insert_id = $obj->InsertSQL($GLOBALS['estimate_table'], $columns, $values,'estimate_id', 'estimate_number', $action);
                    if(preg_match("/^\d+$/", $estimate_insert_id)) {
                        $update_stock = 1;$balance = 1;
                        $estimate_id = $obj->getTableColumnValue($GLOBALS['estimate_table'], 'id', $estimate_insert_id, 'estimate_id');
                                
                        $estimate_number = "";
                        $estimate_number = $obj->getTableColumnValue($GLOBALS['estimate_table'],'estimate_id',$estimate_id,'estimate_number');

                        $result = array('number' => '1', 'msg' => 'Estimate Successfully Created','redirection_page' =>'estimate.php','estimate_id' => $estimate_id);
                        	if(!empty($conversion_update) && $conversion_update == '1') { 
								$order_form_unique_id = "";
								$order_form_unique_id = $obj->getTableColumnValue($GLOBALS['order_form_table'], 'order_form_id', $order_form_id, 'id');
							
								if(preg_match("/^\d+$/", $order_form_unique_id)) {
									$action = "";
									$columns = array(); $values = array();			
									$columns = array('converted','conversion_number','conversion_id');
									$values = array(1,$estimate_number,$estimate_id);
									$msg = $obj->UpdateSQL($GLOBALS['order_form_table'], $order_form_unique_id, $columns, $values, $action);
									
								}
								else {
									$msg = "Invalid Order form";
								}   
							}
                    }
                    else {
                        $result = array('number' => '2', 'msg' => $estimate_insert_id);
                    }
                      
                }
                else
                {
                    $action = "estimate Updated.";
                    $getUniqueID = $obj->getTableColumnValue($GLOBALS['estimate_table'],'estimate_id',$edit_id,'id');
                    $null_value = $GLOBALS['null_value'];
                    $columns = array(); $values = array();
                    $columns = array('updated_date_time','creator_name','bill_company_id', 'estimate_date','party_id', 'party_name', 'party_mobile_number', 'party_name_mobile_city', 'party_details', 'product_id', 'product_name','unit_id', 'unit_name', 'quantity', 'rate', 'size_id','size_name', 'amount', 'total_amount',   'total_quantity','description', 'notes','hsn_code','sub_total', 'discount', 'discount_name', 'discount_value', 'discounted_total', 'extra_charges', 'extra_charges_name', 'extra_charges_value', 'extra_charges_total', 'extra_charges_tax', 'company_state', 'party_state', 'taxable_value', 'cgst_value', 'sgst_value', 'igst_value', 'total_tax_value','round_off', 'bill_total','splitup_tax', 'splitup_quantity', 'splitup_amount', 'splitup_tax_amount','gst_option', 'tax_option', 'tax_type', 'overall_tax', 'final_price',  'product_tax', 'product_tax_value','splitup_hsn_code');
                    $values = array( $updated_date_time, $creator_name,$bill_company_id,$estimate_date,$party_id, $party_name, $party_mobile_number,  $party_name_mobile_city, $party_details, $product_ids, $product_names,$unit_ids, $unit_names, $quantity, $rates, $size_ids,  $size_names,  $amount, $total_amount, $total_quantity, $description, $notes,$hsn_code,$sub_total, $discount, $discount_name, $discount_value, $discounted_total, $extra_charges, $extra_charges_name, $extra_charges_value, $extra_charges_total, $extra_charges_tax, $company_state, $party_state, $taxable_value, $cgst_value, $sgst_value, $igst_value, $total_tax_value,$round_off, $bill_total, $splitup_tax, $splitup_quantity, $splitup_amount, $splitup_tax_amount, $gst_option, $tax_option, $tax_type, $overall_tax,$final_price, $product_tax, $product_tax_value,$splitup_hsn_code);
                    $estimate_update_id = $obj->UpdateSQL($GLOBALS['estimate_table'], $getUniqueID, $columns, $values, $action);
                    if(preg_match("/^\d+$/", $estimate_update_id)) {
                        $update_stock = 1; $balance = 1;
                        $estimate_id = $edit_id;
                        $estimate_number = $obj->getTableColumnValue($GLOBALS['estimate_table'], 'estimate_id', $estimate_id, 'estimate_number');
                        $result = array('number' => '1', 'msg' => 'Updated Successfully','redirection_page' =>'estimate.php');
                    }
                    else {
                        $result = array('number' => '2', 'msg' => $estimate_update_id);
                    }	
                }
                // if($update_stock == '1' && !empty($estimate_id) && !empty($estimate_number)) {
                //     $remarks = $estimate_number;
                //     if(!empty($product_ids) && $product_ids != $GLOBALS['null_value']) {
                //         $product_ids = explode(",", $product_ids);
                //     }
                //     else {
                //         $product_ids = array();
                //     }
                //     if(!empty($unit_ids) && $unit_ids != $GLOBALS['null_value']) {
                //         $unit_ids = explode(",", $unit_ids);
                //     }
                //     else {
                //         $unit_ids = array();
                //     }
                //     if(!empty($quantity) && $quantity != $GLOBALS['null_value']) {
                //         $quantity = explode(",", $quantity);
                //     }
                //     else {
                //         $quantity = array();
                //     }
                //     if(!empty($size_ids) && $size_ids != $GLOBALS['null_value']) {
                //         $size_ids = explode(",", $size_ids);
                //     }
                //     else {
                //         $size_ids = array();
                //     }
                    
                //     if(!empty($product_ids)) {
                //         for($i=0; $i < count($product_ids); $i++) {
                //             $stock_update = $obj->StockUpdate($GLOBALS['estimate_table'], 'Out', $estimate_id, $estimate_number, $product_ids[$i], $unit_ids[$i],$size_ids[$i], $remarks, $estimate_date, $quantity[$i],$party_id); 
                //         }
                //     }
                // }
                if(!empty($balance) && $balance == 1) {
                    $credit  = 0; $debit = 0; $bill_type ="Estimate";
                    $bill_id = $estimate_id;
                    $bill_date = $estimate_date;
                    $bill_number =  $estimate_number;
                    $credit = 0;
                    $debit = $bill_total;
                    
                    $party_details = $obj->getTableColumnValue($GLOBALS['party_table'], 'party_id', $party_id, 'party_name');
                    $party_name = $party_details;
                    $party_type = $obj->getTableColumnValue($GLOBALS['party_table'], 'party_id', $party_id, 'party_type');
                    
                    $update_balance ="";
                    $update_balance = $obj->UpdateBalance($bill_company_id,$bill_id,$bill_number,$bill_date,$bill_type,$party_id,$party_name,$party_type,$GLOBALS['null_value'],$GLOBALS['null_value'],$GLOBALS['null_value'],$GLOBALS['null_value'],$GLOBALS['null_value'],$GLOBALS['null_value'],$credit,$debit);
                    
                } 


            } else {
                $result = array('number' => '2', 'msg' => 'Invalid IP');
            }
        }  else{
            if(!empty($valid_estimate)) {
                $result = array('number' => '3', 'msg' => $valid_estimate);
            }
            else if(!empty($estimate_error)) {
                $result = array('number' => '2', 'msg' => $estimate_error);
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
        $page_title = "estimate";
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
            1 => 'estimate_date',
            2 => 'entry_number',
            4 => 'party_mobile_number',
            5 => 'total',
            6 => '',
        ];
        if(!empty($order_column_index) && isset($columns[$order_column_index])) {
            $order_column = $columns[$order_column_index];
        }

        $totalRecords = 0;
        $totalRecords = count($obj->getEstimateRecordList($row, $rowperpage, $searchValue, $filter_from_date, $filter_to_date, $filter_party_id, $cancelled, $order_column, $order_direction));
        $filteredRecords = count($obj->getEstimateRecordList('', '', $searchValue, $filter_from_date, $filter_to_date, $filter_party_id, $cancelled, $order_column, $order_direction));

        $data = [];
        
        $estimateList = $obj->getEstimateRecordList($row, $rowperpage, $searchValue, $filter_from_date, $filter_to_date, $filter_party_id, $cancelled, $order_column, $order_direction);
        $sno = $row + 1;
        foreach ($estimateList as $val) {
            $created_date_time = $by_creator_name = ""; $updated_date_time = ""; $estimate_date = ""; $bill_number = ""; $party_name = "";$party_mobile_number =  $bill_total = 0;$estimate_number =""; $party_name_mobile_city ='';$product_count =0 ;
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
            if(!empty($val['estimate_date']) && $val['estimate_date'] != "0000-00-00") {
                $estimate_date = date('d-m-Y', strtotime($val['estimate_date']));
            }
            if(!empty($val['bill_number']) && $val['bill_number'] != $GLOBALS['null_value']) {
                $bill_number = $val['bill_number'];
            }
            if(!empty($val['total_amount']) && $val['total_amount'] != $GLOBALS['null_value']) {
                $bill_total = $obj->numberFormat($val['total_amount'],2);
            }
            if(!empty($val['estimate_number']) && $val['estimate_number'] != $GLOBALS['null_value']) {
                $estimate_number = $val['estimate_number'];
            }
            if(!empty($val['party_name_mobile_city']) && $val['party_name_mobile_city'] != $GLOBALS['null_value']){
                $party_name_mobile_city =  html_entity_decode($obj->encode_decode('decrypt',$val['party_name_mobile_city']));
            }
            if(!empty($val['product_id']) && $val['product_id'] != $GLOBALS['null_value']) {
                $product_ids = explode(',', $val['product_id']);
                $product_count = count($product_ids);
            }
            
            
            $action = ""; $edit_option = ""; $delete_option = ""; $print_option = ""; $a5_print_option = "";
            $edit_access_error = ""; $permission_module = $GLOBALS['estimate_module']; $permission_action = $edit_action;
            if(!empty($login_role_id)) {
                include("user_permission_action.php");
            }
            $delete_access_error = ""; $permission_module = $GLOBALS['estimate_module']; $permission_action = $delete_action;
            if(!empty($login_role_id)) {
                include("user_permission_action.php");
            }
            if(empty($edit_access_error) && empty($val['cancelled'])) {
                $edit_option = '<li><a class="dropdown-item" href="Javascript:ShowModalContent('.'\''.$page_title.'\''.', '.'\''.$val['estimate_id'].'\''.');"><i class="fa fa-pencil"></i>&nbsp; Edit</a></li>';
            }
            if(empty($delete_access_error) && empty($val['cancelled'])) {
                $delete_option = '<li><a class="dropdown-item" href="Javascript:DeleteModalContent('.'\''.$page_title.'\''.', '.'\''.$val['estimate_id'].'\''.');"><i class="fa fa-ban"></i>&nbsp; Cancel</a></li>';
            }
            $conversion_option = "";
            $print_option = '<li><a class="dropdown-item" target="_blank" href="reports/rpt_estimate_a4.php?view_estimate_id=' . $val['estimate_id'] . '"><i class="fa fa-print"></i>&nbsp; A4 Print</a></li>';

            // if(empty($edit_access_error) && empty($val['cancelled'])) {
            //     $conversion_option = '<li><a class="dropdown-item" href="Javascript:ShowBillConversion('.'\''.$page_title.'\''.', '.'\''.$val['estimate_id'].'\''.');"><i class="bi bi-arrow-left-right"></i>&nbsp; Conversion</a></li>';
            // }
            $action = '<div class="dropdown">
                            <a href="#" role="button" class="btn btn-dark py-1 px-2" id="dropdownMenuLink'.$val['estimate_id'].'" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink'.$val['estimate_id'].'">
                                '.$print_option.$edit_option.$delete_option.'
                            </ul>
                        </div>';

            $data[] = [
                "sno" => $sno++,
                "created_date_time" => $created_date_time,
                "updated_date_time" => $updated_date_time,
                "bill_date" => $estimate_date,
                "entry_number" => $estimate_number,
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




    if(isset($_REQUEST['product_row_index'])) {
        $product_row_index = filter_input(INPUT_GET, 'product_row_index', FILTER_SANITIZE_SPECIAL_CHARS);
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
        $hsn_code = ""; $description = ""; $tax = "";
        $hsn_code = $obj->getTableColumnValue($GLOBALS['product_table'], 'product_id', $product_id, 'hsn_code');
        $description = $obj->getTableColumnValue($GLOBALS['product_table'], 'product_id', $product_id, 'description');
        $tax = $obj->getTableColumnValue($GLOBALS['product_table'], 'product_id', $product_id, 'product_tax');

       
        ?>
        <tr class="product_row" id="product_row<?php if(!empty($product_row_index)) { echo $product_row_index; } ?>">
            <td class="sno text-center">
                <?php if(!empty($product_row_index)) { echo $product_row_index; } ?>
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
                        <input type="text" name="quantity[]" style="width:75%!important;margin:auto!important;" class="form-control shadow-none  text-center" value="<?php if(!empty($quantity)) { echo $quantity; } ?>" onfocus="Javascript:KeyboardControls(this,'number','','');" onkeyup="Javascript:ProductRowCheck(this);">
                    </div>
                </div> 
            </td>
            <td class="text-center">
                <div class="form-group">
                    <div class="form-label-group in-border">
                         <input type="text" name="rates[]" style="width:75%!important;margin:auto!important;" class="form-control shadow-none text-center" value="<?php if(!empty($rates)) { echo $rates; } ?>" onfocus="Javascript:KeyboardControls(this,'number','','');" onkeyup="Javascript:ProductRowCheck(this);">
                    </div>
                </div> 
            </td>
            <td class="text-center px-2 py-2 tax_element d-none">
                <select name="product_tax[]" class="form-control shadow-none product_tax" style="width:100%!important;" onchange="Javascript:ProductRowCheck(this);">
                    <?php if(!empty($tax)){ ?>
                            <option value="0%" <?php if(!empty($tax) && $tax == '0%') { ?>selected<?php } ?>>0%</option>
                            <option value="5%" <?php if(!empty($tax) && $tax == '5%') { ?>selected<?php } ?>>5%</option>
                            <option value="12%" <?php if(!empty($tax) && $tax == '12%') { ?>selected<?php } ?>>12%</option>
                            <option value="18%" <?php if(!empty($tax) && $tax == '18%') { ?>selected<?php } ?>>18%</option>
                            <option value="28%" <?php if(!empty($tax) && $tax == '28%') { ?>selected<?php } ?>>28%</option>
                        <?php
                        }else{?>
                            <option value="0%">0%</option>
                            <option value="5%">5%</option>
                            <option value="12%">12%</option>
                            <option value="18%">18%</option>
                            <option value="28%">28%</option>
                        <?php 
                        } ?>
                </select>
                
            </td>
            <td class="text-center px-2 py-3 final_price_element d-none">
                <div class="form-group pe-2 text-end final_price">0.00</div>
            </td>
            <td class="text-center">
                <div class="form-group">
                    <div class="form-label-group in-border">
                        <input type="text" name="amount[]" style="width:75%!important;margin:auto!important;" class="form-control shadow-none  text-center amount product_amount" value="<?php if(!empty($amount)) { echo $amount; } ?>" readonly>
                    </div>
                </div>    
            </td>
            <td class="text-center">
                <button class="btn btn-danger" type="button" onclick="Javascript:DeleteRow('product_row', '<?php if(!empty($product_row_index)) { echo $product_row_index; } ?>');"><i class="fa fa-trash"></i></button>
            </td>
                 <script type="text/javascript">
                if(jQuery('#product_row<?php if(!empty($product_row_index)) { echo $product_row_index; } ?>').find('select').length > 0) {
                    jQuery('#product_row<?php if(!empty($product_row_index)) { echo $product_row_index; } ?>').find('select').select2();
                }
                
            </script>
        </tr>
        <?php
    }

    if(isset($_REQUEST['delete_estimate_id'])) {
        $delete_estimate_id = trim(filter_input(INPUT_GET, 'delete_estimate_id', FILTER_SANITIZE_SPECIAL_CHARS));
        $msg = "";
        if(!empty($delete_estimate_id)) {	
            $estimate_unique_id = "";
            $estimate_unique_id = $obj->getTableColumnValue($GLOBALS['estimate_table'], 'estimate_id', $delete_estimate_id, 'id');
            $bill_number = "";
            $bill_number = $obj->getTableColumnValue($GLOBALS['estimate_table'], 'estimate_id', $delete_estimate_id, 'bill_number');
        
            $action = "";
            if(!empty($bill_number)) {
                $action = "estimate Cancelled. Bill No. - ".$bill_number;
            }
            
            if(empty($delete_access_error)) {
                $delete_id =  $obj->DeletePayment($delete_estimate_id);
                $columns = array(); $values = array();
                $columns = array('cancelled');
                $values = array(1);
                $msg = $obj->UpdateSQL($GLOBALS['estimate_table'], $estimate_unique_id, $columns, $values, $action);
            }
            else {
                $msg = $delete_access_error;
            }
            
           
        }
        else {
            $msg = "Empty estimate";
        }
        echo $msg;
        exit;	
    }

    ?>