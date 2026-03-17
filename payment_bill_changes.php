<?php
	include("include_files.php");

    if(isset($_REQUEST['view_party_details'])) {
        $type_id = filter_input(INPUT_GET, 'view_party_details', FILTER_SANITIZE_SPECIAL_CHARS);
        $type_id = trim($type_id);
        $type = filter_input(INPUT_GET, 'details_type', FILTER_SANITIZE_SPECIAL_CHARS);
        $type = trim($type);
        $details_list = array();
        if(!empty($type)) {
            $details_list = $obj->getTableRecords($GLOBALS['party_table'], 'party_id', $type_id, '');

			if(!empty($details_list)) {
				foreach($details_list as $data) {
					if(!empty($data['party_name']) && $data['party_name'] != $GLOBALS['null_value']) {
						$name = $obj->encode_decode('decrypt', $data['party_name']);
					}
					if(!empty($data['address']) && $data['address'] != $GLOBALS['null_value']) {
						$address = $obj->encode_decode('decrypt', $data['address']);
					}
					if(!empty($data['city']) && $data['city'] != $GLOBALS['null_value']) {
						$city = $obj->encode_decode('decrypt', $data['city']);
					}
					if(!empty($data['district']) && $data['district'] != $GLOBALS['null_value']) {
						$district = $obj->encode_decode('decrypt', $data['district']);
					}
					if(!empty($data['state']) && $data['state'] != $GLOBALS['null_value']) {
						$state = $obj->encode_decode('decrypt', $data['state']);
					}
					if(!empty($data['pincode']) && $data['pincode'] != $GLOBALS['null_value']) {
						$pincode = $obj->encode_decode('decrypt', $data['pincode']);
					}
					if(!empty($data['mobile_number']) && $data['mobile_number'] != $GLOBALS['null_value']) {
						$mobile_number = $obj->encode_decode('decrypt', $data['mobile_number']);
					}
					if(!empty($data['email']) && $data['email'] != $GLOBALS['null_value']) {
						$email = $obj->encode_decode('decrypt', $data['email']);
					}
					if(!empty($data['identification']) && $data['identification'] != $GLOBALS['null_value']) {
						$identification = $obj->encode_decode('decrypt', $data['identification']);
					}
				}	
			}

			?>
			<div class="row" style="margin-bottom: 20px;">
				<div class="col-lg-12 col-xl-12 d-flex">
					<div class="col-lg-4 col-xl-4 col-6"><b>Name </b></div>
					<div class="col-lg-8 col-xl-8 col-6" style="margin: 0 -35px;"><?php if(!empty($name)){ echo ": " .$name; }?> </div>
				</div>
			</div>
			<div class="row" style="margin-bottom: 20px;">
				<div class="col-lg-12 col-xl-12 d-flex">
					<div class="col-lg-4 col-xl-4 col-6"><b>Phone Number </b></div>
					<div class="col-lg-8 col-xl-8 col-6" style="margin: 0 -35px;"><?php if(!empty($mobile_number)){ echo ": " .$mobile_number; }?> </div>
				</div>
			</div>
			<?php if(!empty($email) && ($email != 'NULL')){ ?>
				<div class="row" style="margin-bottom: 20px;">
					<div class="col-lg-12 col-xl-12 d-flex">
						<div class="col-lg-4 col-xl-4 col-6"><b>Email </b></div>
						<div class="col-lg-8 col-xl-8 col-6" style="margin: 0 -35px;"><?php if(!empty($email)){ echo ": " .$email; }?> </div>
					</div>
				</div> <?php
			} ?>
			<?php if(!empty($address) && ($address != 'NULL')){ ?>
				<div class="row" style="margin-bottom: 20px;">
					<div class="col-lg-12 col-xl-12 d-flex">
						<div class="col-lg-4 col-xl-4 col-6"><b>Address </b></div>
						<div class="col-lg-8 col-xl-8 col-6" style="margin: 0 -35px;"><?php if(!empty($address)){ echo ": " .$address; }?> </div>
					</div>
				</div> <?php
			} 
			if(!empty($city) && ($city != 'NULL')){ ?>
				<div class="row" style="margin-bottom: 20px;">
					<div class="col-lg-12 col-xl-12 d-flex">
						<div class="col-lg-4 col-xl-4 col-6"><b>City </b></div>
						<div class="col-lg-8 col-xl-8 col-6" style="margin: 0 -35px;"><?php if(!empty($city)){ echo ": " .$city; }?> </div>
					</div>
				</div> <?php
			} ?>
			<?php if(!empty($district) && ($district != 'NULL')){ ?>
				<div class="row" style="margin-bottom: 20px;">
					<div class="col-lg-12 col-xl-12 d-flex">
						<div class="col-lg-4 col-xl-4 col-6"><b>District </b></div>
						<div class="col-lg-8 col-xl-8 col-6" style="margin: 0 -35px;"><?php if(!empty($district)){ echo ": " .$district; }?> </div>
					</div>
				</div> <?php
			} ?>
			<div class="row" style="margin-bottom: 20px;">
				<div class="col-lg-12 col-xl-12 d-flex">
					<div class="col-lg-4 col-xl-4 col-6"><b>State </b></div>
					<div class="col-lg-8 col-xl-8 col-6" style="margin: 0 -35px;"><?php if(!empty($state)){ echo ": " .$state; }?> </div>
				</div>
			</div>
			<?php if(!empty($identification) && ($identification != 'NULL')){ ?>
				<div class="row" style="margin-bottom: 20px;">
					<div class="col-lg-12 col-xl-12 d-flex">
						<div class="col-lg-4 col-xl-4 col-6"><b>Identification </b></div>
						<div class="col-lg-8 col-xl-8 col-6" style="margin: 0 -35px;"><?php if(!empty($identification)){ echo ": " .$identification; }?> </div>
					</div>
				</div> <?php
			}  
		
        }
    }

    if(isset($_REQUEST['party_id'])) {
        $party_id = filter_input(INPUT_GET, 'party_id', FILTER_SANITIZE_SPECIAL_CHARS);
        $party_id = trim($party_id);

        $list = array();
        $list = $obj->getPendingList($party_id);
        $party_name = ""; $opening_balance = 0; $opening_balance_type = "";
        
        $party_name = $obj->getTableColumnValue($GLOBALS['party_table'], 'party_id', $party_id, 'name_mobile_city');
        $party_name =  $party_name;
        $opening_balance = $obj->getTableColumnValue($GLOBALS['party_table'], 'party_id', $party_id, 'opening_balance');
        $opening_balance_type = $obj->getTableColumnValue($GLOBALS['party_table'], 'party_id', $party_id, 'opening_balance_type');
        
        $current_balance = 0; $current_type = "";
        $total_list =0;
        if(!empty($list)){
            foreach($list as $data){
                if($data['bill_type'] != 'Opening Balance'){
                    $total_list++;
                }
            }
        }
        ?>
        <div class="col-12">
            <div style="position:absolute; top:0; right:0; z-index:20; padding:2px 70px; font-weight:bold; color:red;">
                Total Records: <?php echo $total_list; ?>
            </div>
            <div class="table-responsive text-center paymentlisting-table-container" style="max-height:420px; overflow-y:auto;">
                <table class="table table-bordered nowrap cursor text-center smallfnt paymentlisting-table" style="font-size:15px; margin-bottom: 20px;">
                    <thead style="background-color:#0d4294;color:white;position:sticky;top:0;z-index:10;">
                        <tr style="font-weight:bold;">
                            <th>#</th>
                            <th>Bill No<br>Date</th>
                            <th>Bill Type</th>
                            <th>Particulars</th>
                            <th>Credit</th>
                            <th>Debit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $total_credit = 0; $total_debit = 0;
                            if(!empty($opening_balance) && $opening_balance != $GLOBALS['null_value']) {
                                ?>
                                <tr style="font-weight:bold;">
                                    <td colspan="4" class="text-end text-primary" style="font-weight:bold;">
                                        Opening Balance
                                    </td>
                                    <td class="text-end text-success">
                                        <?php
                                            if($opening_balance_type == 'Credit') {
                                                $total_credit += $opening_balance;
                                                echo $obj->numberFormat($opening_balance,2).'&nbsp';
                                            }
                                            else {
                                                echo '-';
                                            }
                                        ?>
                                    </td>
                                    <td class="text-end text-danger">
                                        <?php
                                            if($opening_balance_type == 'Debit') {
                                                $total_debit += $opening_balance;
                                                echo $obj->numberFormat($opening_balance,2).'&nbsp';
                                            }
                                            else {
                                                echo '-';
                                            }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            
                            $s_no = 1;
                            if(!empty($list)){
                                foreach($list as $data){ 
                                    if($data['bill_type'] != 'Opening Balance') { ?>
                                        <tr style="font-weight:bold;">
                                            <td class="text-center px-2 py-2">
                                                <?php echo $s_no; ?>
                                            </td>
                                            <td class="text-center px-2 py-2">
                                                <?php
                                                    if(!empty($data['bill_number'])){
                                                        $bill_number = $data['bill_number'];
                                                        echo $bill_number;
                                                    } else {
                                                        echo " - ";
                                                    }
                                                    
                                                    if(!empty($data['bill_date'])){
                                                        echo "<br>";
                                                        echo date('d-m-Y', strtotime($data['bill_date']));
                                                    } else {
                                                        echo " - ";
                                                    }
                                                    
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if(!empty($data['bill_type'])){
                                                        echo $data['bill_type'];
                                                    }  else {
                                                        echo " - ";
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $detail = "";
                                                    if (!empty($data['payment_mode_name']) && $data['payment_mode_name'] != $GLOBALS['null_value']) {
                                                        $detail .= $data['payment_mode_name'];
                                                    }
                                                    if (!empty($data['bank_name']) && $data['bank_name'] != 'NULL') {
                                                        $detail .= " - (" . $obj->encode_decode('decrypt', $data['bank_name']) . ")";
                                                    }

                                                    echo $detail;
                                                ?>
                                            </td>
                                            <td class="text-end text-success">
                                                <?php
                                                    if(!empty($data['credit']) && $data['credit'] != $GLOBALS['null_value']) {
                                                        $total_credit += $data['credit'];
                                                        echo $obj->numberFormat($data['credit'],2).'&nbsp';
                                                    }
                                                    else {
                                                        echo '-';
                                                    }
                                                ?>
                                            </td>
                                            <td class="text-end text-danger">
                                                <?php
                                                    if(!empty($data['debit'] && $data['debit'] != $GLOBALS['null_value'])) {
                                                        $total_debit += $data['debit'];
                                                        echo $obj->numberFormat($data['debit'],2).'&nbsp';
                                                    }
                                                    else {
                                                        echo '-';
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php 
                                        $s_no++;
                                        } 
                                }
                            }
                            else { ?>
                                <tr>
                                    <td colspan="6" class="text-center">Sorry! No records found</td>
                                </tr>
                            <?php } ?>
                            <tr class="bg-light tfoot" style="position:sticky;bottom:0;z-index:10;">
                                <?php
                                    if($total_credit > $total_debit) {
                                        $current_balance = $total_credit - $total_debit;
                                        $current_type = " Cr";
                                    }
                                    else if($total_credit < $total_debit) {
                                        $current_balance = $total_debit - $total_credit;
                                        $current_type = " Dr";
                                    }
                                    else {
                                        $current_balance = 0;
                                        $current_type = "";
                                    }
                                ?>
                                <?php if(!empty($total_credit) || (!empty($total_debit))){ ?>
                                    <td class="text-danger" colspan="6" style="font-weight:bold;">
                                        Current Balance : 
                                        <?php
                                            echo $obj->numberFormat($current_balance,2).$current_type;
                                        ?>
                                    </td>
                                <?php } ?>
                            </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
        $party_name_dec = $obj->encode_decode('decrypt', $party_name);
        echo "$$$".$party_name_dec." <span class='text-center text-danger'>(Balance : ".($obj->numberFormat($current_balance,2).$current_type).")</span>"; 
    }

    if(isset($_REQUEST['selected_bank_payment_mode'])) {
        $selected_bank_payment_mode = "";
        $selected_bank_payment_mode = filter_input(INPUT_GET, 'selected_bank_payment_mode', FILTER_SANITIZE_SPECIAL_CHARS);
        
        if(!empty($selected_bank_payment_mode)) {
            $bank_list = array();
            $bank_list = $obj->getTableRecords($GLOBALS['bank_table'], '', '','');
            $filtered_banks = array();
            foreach($bank_list as $bank) {
                $payment_modes = explode(',', $bank['payment_mode_id']);
                if (in_array($selected_bank_payment_mode, $payment_modes)) {
                    $filtered_banks[] = $bank;
                }
            }

            if(!empty($filtered_banks)){
                ?>
                    <option value="">Select Bank</option>
                    <?php
                        foreach ($filtered_banks as $list){
                            ?>
                            <option value="<?php if(!empty($list['bank_id'])){echo $list['bank_id'];} ?>"> 
                            <?php
                                $account_name = "";
                                $account_name = $obj->getTableColumnValue($GLOBALS['bank_table'], 'bank_id', $list['bank_id'], 'bank_name');
                                if(!empty($account_name)) {
                                    $account_name = $obj->encode_decode('decrypt', $account_name);
                                    echo $account_name;
                                }
                                ?>
                            </option>
                            <?php
                        }
                    ?>
                <?php
            }

        }
    }

    if(isset($_REQUEST['payment_row_index'])) {
        $payment_row_index = filter_input(INPUT_GET, 'payment_row_index', FILTER_SANITIZE_SPECIAL_CHARS);

        $payment_mode_id = filter_input(INPUT_GET, 'selected_payment_mode_id', FILTER_SANITIZE_SPECIAL_CHARS);
        $payment_mode_id = trim($payment_mode_id);

        $bank_id = filter_input(INPUT_GET, 'selected_bank_id', FILTER_SANITIZE_SPECIAL_CHARS);
        $bank_id = trim($bank_id);

        $amount = filter_input(INPUT_GET, 'selected_amount', FILTER_SANITIZE_SPECIAL_CHARS);
        $amount = trim($amount);
        ?>
        <tr class="payment_row" id="payment_row<?php if(!empty($payment_row_index)) { echo $payment_row_index; } ?>">
            <td class="sno text-center">
                <?php if(!empty($payment_row_index)) { echo $payment_row_index; } ?>
            </td>
            <td class="text-center">
                <?php
                    $payment_mode_name = "";
                    $payment_mode_name = $obj->getTableColumnValue($GLOBALS['payment_mode_table'], 'payment_mode_id', $payment_mode_id, 'payment_mode_name');
                    echo $payment_mode_name;
                ?>
                <input type="hidden" name="payment_mode_id[]" value="<?php if(!empty($payment_mode_id)) { echo $payment_mode_id; } ?>">
            </td>
            <td class="text-center">
                <?php
                    $bank_name = "";
                    $bank_name = $obj->getTableColumnValue($GLOBALS['bank_table'], 'bank_id', $bank_id, 'bank_name');
                    if(!empty($bank_name) && $bank_name != $GLOBALS['null_value']) {
                        echo $obj->encode_decode('decrypt', $bank_name);
                    }
                    else {
                        echo '-';
                    }   
                ?>
                <input type="hidden" name="bank_id[]" value="<?php if(!empty($bank_id)) { echo $bank_id; } ?>">
            </td>
            <td class="text-center">
                <input type="text" name="amount[]" style="width:75%!important;margin:auto!important;" class="form-control shadow-none px-1 text-center" value="<?php if(!empty($amount)) { echo $amount; } ?>" onfocus="Javascript:KeyboardControls(this,'number','','');" onkeyup="Javascript:PaymentTotal();InputBoxColor(this, 'text');">
            </td>
            <td class="text-center">
                <button class="btn btn-danger" type="button" onclick="Javascript:DeleteRow('payment_row', '<?php if(!empty($payment_row_index)) { echo $payment_row_index; } ?>');"><i class="fa fa-trash"></i></button>
            </td>
        </tr>
        <?php
    }
?>
