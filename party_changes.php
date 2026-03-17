<?php
	include("include_files.php");
     $login_staff_id = "";
    if(isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id']) && !empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'])) {
        if(!empty($GLOBALS['user_type']) && $GLOBALS['user_type'] != $GLOBALS['admin_user_type']) {
            $login_staff_id = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'];
            $permission_module = $GLOBALS['party_module'];
        } 
    }
	if(isset($_REQUEST['show_party_id'])) { 
        $show_party_id = $_REQUEST['show_party_id'];
        $show_party_id = trim($show_party_id);

        $add_custom = 0;
        if(isset($_REQUEST['add_custom'])) {
            $add_custom = $_REQUEST['add_custom'];
        }

        $custom_party_form = "";
		if(isset($_REQUEST['form_name'])) {
			$custom_party_form = $_REQUEST['form_name'];
			$custom_party_form = trim($custom_party_form);
		}

        $country = "India";$state = "";$district = "";$city = "";$party_name = "";$mobile_number = "";$address = "";$pincode = ""; $pincode = ""; $state = "Tamil Nadu"; $identification = ""; $party_type = ""; $district = ""; $city = ""; $opening_balance = ""; $opening_balance_type = "";
        
        if(!empty($show_party_id)){
            $party_list = array();
            $party_list = $obj->getTableRecords($GLOBALS['party_table'],'party_id',$show_party_id,'');
            if(!empty($party_list)) {
                foreach($party_list as $data){ 
                    if(!empty($data['party_name']) && $data['party_name'] != $GLOBALS['null_value']){
                        $party_name = $obj->encode_decode("decrypt",$data['party_name']);
                        $party_name = html_entity_decode($party_name);
                    }
                    if(!empty($data['mobile_number']) && $data['mobile_number'] != $GLOBALS['null_value']){
                        $mobile_number = $obj->encode_decode("decrypt",$data['mobile_number']);
                    }
                    if(!empty($data['state']) && $data['state'] != $GLOBALS['null_value']){
                        $state = $obj->encode_decode("decrypt",$data['state']);
                    }
                    if(!empty($data['district']) && $data['district'] != $GLOBALS['null_value']){
                        $district = $obj->encode_decode("decrypt",$data['district']);
                    }
                    if(!empty($data['city']) && $data['city'] != $GLOBALS['null_value']){
                        $city = $obj->encode_decode("decrypt",$data['city']);
                    }
                    if(!empty($data['address']) && $data['address'] != $GLOBALS['null_value']){
                        $address = $obj->encode_decode("decrypt",$data['address']);
                        $address = html_entity_decode($address);
                    } 
                    if(!empty($data['pincode']) && $data['pincode'] != $GLOBALS['null_value']){
                        $pincode = $obj->encode_decode("decrypt",$data['pincode']);
                    }
                    if(!empty($data['email']) && $data['email'] != $GLOBALS['null_value']){
                        $email = $data['email'];
                    }
                    if(!empty($data['party_type']) && $data['party_type'] != $GLOBALS['null_value']){
                        $party_type = $data['party_type'];
                    }
                    if(!empty($data['gst_number']) && $data['gst_number'] != $GLOBALS['null_value']){
                        $gst_number = $obj->encode_decode("decrypt",$data['gst_number']);
                    }
                    if(!empty($data['identification']) && $data['identification'] != $GLOBALS['null_value']){
                        $identification = $obj->encode_decode("decrypt",$data['identification']);
                    }
                    if(!empty($data['opening_balance']) && $data['opening_balance'] != $GLOBALS['null_value']){
                        $opening_balance = $data['opening_balance'];
                    }
                    if(!empty($data['opening_balance_type']) && $data['opening_balance_type'] != $GLOBALS['null_value']){
                        $opening_balance_type = $data['opening_balance_type'];
                    }
                  
                    
                }
            }
        }
        ?>
        <form class="poppins pd-20 redirection_form" name="party_form" method="POST">
            <?php if(empty($add_custom) && $add_custom == 0) { ?>
                <div class="card-header">
                    <div class="row p-2">
                        <div class="col-lg-8 col-md-8 col-8 align-self-center">
                            <div class="h5">Add Party</div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-4">
                            <button class="btn btn-dark float-end" style="font-size:11px;" type="button" onclick="window.open('party.php','_self')"> <i class="fa fa-arrow-circle-o-left"></i> &ensp;Back </button>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="row p-3">
                <input type="hidden" name="edit_id" value="<?php if(!empty($show_party_id)) { echo $show_party_id; } ?>">
                <input type="hidden" name="add_custom" value="<?php if(!empty($add_custom)) { echo $add_custom; } ?>">
                <div class="col-lg-3 col-md-4 col-12 py-2 px-lg-1">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                            <select class="select2 select2-danger" name="party_type" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                <option value="">Select Type</option>
                                <option value="1" <?php if(!empty($party_type) && ($party_type == '1')){ echo "selected"; } ?>>Purchase</option>
                                <option value="2" <?php if(!empty($party_type) && ($party_type == '2')){ echo "selected"; } ?>>Sales</option>
                                <option value="3" <?php if(!empty($party_type) && ($party_type == '3')){ echo "selected"; } ?>>Both</option>
                            </select>
                            <label>Party Type <span class="text-danger">*</span></label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-12 px-lg-1 py-2">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                              <input type="text" id="party_name" name="party_name" class="form-control shadow-none" onkeydown="Javascript:KeyboardControls(this,'text','',1);" placeholder="" value="<?php if(!empty($party_name)){ echo $party_name; } ?>" required>
                            <label>Party Name (*)</label>
                        </div>
                        <div class="new_smallfnt">Contains Text, Symbols &amp;, -,',.</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-12 px-lg-1 py-2">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                            <input type="text" id="mobile_number" name="mobile_number" class="form-control shadow-none" onkeydown="Javascript:KeyboardControls(this,'mobile_number',10,1);" placeholder="" value="<?php if(!empty($mobile_number)){ echo $mobile_number; } ?>" required>
                            <label>Contact Number (*)</label>
                        </div>
                        <div class="new_smallfnt">Numbers Only (only 10 digits)</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-12 px-lg-1 py-2">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                           <textarea class="form-control" id="address" name="address" onkeydown="Javascript:KeyboardControls(this,'',150,'1');" placeholder="Enter Your Address"><?php if(!empty($address)){ echo $address; } ?></textarea>
                            <label>Address</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-12 py-2 px-lg-1">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                            <input type="text" id="email" name="email" class="form-control shadow-none" onkeydown="Javascript:KeyboardControls(this,'',50,'1');" placeholder="" value="<?php if(!empty($email)){ echo $email; } ?>" required>
                            <label>Email</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-6 py-2 px-lg-1">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                           <div class="w-100" style="display:none;">
                                <select class="select2 select2-danger" name="country" id="country" onchange="Javascript:getCountries('party',this.value,'','','');" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                    <option>India</option>
                                </select>
                            </div>
                            <select class="select2 select2-danger" data-dropdown-css-class="select2-danger"  style="width: 100%;" name="state" onchange="Javascript:getStates('party',this.value,'','');">
                                <option value="">Select State</option>
                            </select>
                            <label>Select State(*)</label>
                        </div>
                    </div>        
                </div>
               <div class="col-lg-3 col-md-4 col-6 py-2 px-lg-1">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                            <select name="district" class="select2 select2-danger" data-dropdown-css-class="select2-danger"  style="width: 100%;" onchange="Javascript:getDistricts('party',this.value,'');">
                                <option value="">Select District</option>
                            </select>
                            <label>Select District</label>
                        </div>
                    </div>        
                </div>
                <div class="col-lg-3 col-md-4 col-12 px-lg-1 py-2">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                            <input type="text" id="identification" name="identification" class="form-control shadow-none" value="<?php if(!empty($identification)){echo $identification;} ?>" onkeydown="Javascript:KeyboardControls(this,'',50,'');">
                            <label>Identification</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-6 py-2 px-lg-1">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                            <select name="city" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" onchange="Javascript:getCities('party','',this.value);">
                                <option>Select City</option>
                            </select>
                            <label>Select City</label>
                        </div>
                    </div>        
                </div>
                 <div class="col-lg-3 col-md-4 col-12 py-2 d-none" id="others_city_cover">
                    <div class="form-group mb-1">
                        <div class="form-label-group in-border">
                            <input type="text" id="others_city" name="others_city" class="form-control shadow-none" value="<?php if(!empty($others_city)){echo $others_city;} ?>"onkeydown="Javascript:KeyboardControls(this,'text',30,1);">
                            <label>Others city (*)</label>
                        </div>
                        <div class="new_smallfnt">Text Only(Max Char: 30)</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-12 px-lg-1 py-2">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                         <input type="text" id="pincode" name="pincode" class="form-control shadow-none" onfocus="Javascript:KeyboardControls(this,'mobile_number',6,'1');" placeholder="" value="<?php if(!empty($pincode)){ echo $pincode; } ?>" required>
                            <label>Pincode</label>
                        </div>
                        <div class="new_smallfnt">Numbers Only (only 6 digits)</div>
                    </div>
                </div>
                 <div class="col-lg-3 col-md-4 col-12 py-2 px-lg-1">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                            <input type="text" id="gst_number" name="gst_number" class="form-control shadow-none" onkeydown="Javascript:KeyboardControls(this,'',16,'1');" placeholder="" value="<?php if(!empty($gst_number)){ echo $gst_number; } ?>" required>
                            <label>GST Number</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-12 px-lg-1 py-2">
                    <div class="form-group">
                        <div class="form-label-group in-border">
                            <div class="input-group">
                                <?php 
                                    $opening_balance_count = 0;
                                    $opening_balance_count = $obj->PartyOpeningList($show_party_id);

                                    if(!empty($opening_balance_count)){ ?>
                                        <input type="text" id="opening_balance" name="opening_balance" class="form-control shadow-none" required  value="<?php echo $opening_balance; ?>" readonly> 
                                        <?php
                                    } else { ?>
                                        <input type="text" id="opening_balance" name="opening_balance" class="form-control shadow-none" required  value="<?php echo $opening_balance; ?>" onfocus="Javascript:KeyboardControls(this,'number',8,1);" maxlength="8">
                                        <?php
                                    }
                                ?>
                                
                                <label>Opening Balance</label>
                                <div class="input-group-append" style="width:40%!important;">
                                  <select name="opening_balance_type" class="select2 select2-danger" placeholder="Select Opening Balance Type" style="width: 100%;">
                                    <option value="">Type</option>
                                    <option value="Credit" <?php if(!empty($opening_balance_type) && $opening_balance_type == "Credit"){ echo "selected"; } ?>>Credit</option>
                                    <option value="Debit" <?php if(!empty($opening_balance_type) && $opening_balance_type == "Debit"){ echo "selected"; } ?>>Debit</option>
                                </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 pt-3 text-center">
                    <button class="btn btn-danger submit_button" type="button" onClick="Javascript:SaveModalContent(event,'party_form', 'party_changes.php', 'party.php');">
                        Submit
                    </button>
                </div>
            </div>
             <script type="text/javascript">
                getCountries('party','<?php if(!empty($country)) { echo $country; } ?>', '<?php if(!empty($state)) { echo $state; } ?>', '<?php if(!empty($district)) { echo $district; } ?>', '<?php if(!empty($city)) { echo $city; } ?>');
            </script>
             <script>
                <?php if(isset($add_custom) && $add_custom == '1') { ?>
                    jQuery('#CustomPartyModal').on('shown.bs.modal', function () {
                        $(this).find('select').select2({
                            dropdownParent: $('#CustomPartyModal') // important for select2 inside modal
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
        $party_name = ""; $party_name_error = "";  $mobile_number = ""; $mobile_number_error = ""; $district = ""; $district_error = ""; $others_city = ""; $others_city_error = "";   $pincode_error = ""; $pincode = ""; $identification = ""; $identification_error = ""; $address = ""; $address_error = ""; $state = ""; $state_error = ""; $city = ""; $city_error = "";$party_error="";$valid_party = ""; $form_name = "party_form"; $party_type = "";
        $opening_balance = 0; $opening_balance_error = ""; $opening_balance_type = ""; $opening_balance_type_error = "";
         $edit_id = ""; $add_custom = 0;$custom_party_form ="";

        if(isset($_POST['edit_id'])) {
            $edit_id = $_POST['edit_id'];
            $edit_id = trim($edit_id);
        }
        if(isset($_POST['add_custom'])) {
            $add_custom = $_POST['add_custom'];
        }
        if(isset($_POST['custom_party_form'])) {
            $custom_party_form = $_POST['custom_party_form'];
        }
        if(isset($_POST['party_type'])) {
            $party_type = $_POST['party_type'];
            $party_type = trim($party_type);
            $party_type_error = $valid->common_validation($party_type,'Party Type','select');
            
            if(!empty($party_type_error)) {
                if(!empty($valid_party)) {
                    $valid_party = $valid_party." ".$valid->error_display($form_name, "party_type", $party_type_error, 'select');
                }
                else {
                    $valid_party = $valid->error_display($form_name, "party_type", $party_type_error, 'select');
                }
            }
        }
        if(isset($_POST['party_name'])){
            $party_name = $_POST['party_name'];
            $party_name = trim($party_name);
        
            // if(!empty($party_name) && strlen($party_name) > 50) {
            //     $party_name_error = "Only 50 characters allowed";
            // }
            if(empty($party_name)){
                $party_name_error = "Enter the party name";
            }
            else {
                $party_name_error = $valid->valid_name_text($party_name,'party_name','','');
            }
            if(!empty($party_name_error)) {
                $valid_party = $valid->error_display($form_name, "party_name", $party_name_error, 'text');			
            }
        }

        
        if(isset($_POST['mobile_number'])) {
            $mobile_number = $_POST['mobile_number'];
            $mobile_number = trim($mobile_number);
            // if(empty($mobile_number))
            // {
            //     $mobile_number_error ="Enter mobile number";
            // }
            // else
            // {
                $mobile_number_error = $valid->valid_mobile_number($mobile_number, "Mobile number", "1");
                
            // }
            if(!empty($mobile_number_error)) {
                if(!empty($valid_party)) {
                    $valid_party = $valid_party." ".$valid->error_display($form_name, "mobile_number", $mobile_number_error, 'text');
                }
                else {
                    $valid_party = $valid->error_display($form_name, "mobile_number", $mobile_number_error, 'text');
                }
            }
        }


        if(isset($_POST['email'])) {
            $email = $_POST['email'];
            $email = trim($email);
            $email_error = $valid->valid_email($email, "email", "",'150');
            if(!empty($email_error)) {
                if(!empty($valid_party)) {
                    $valid_party = $valid_party." ".$valid->error_display($form_name, "email", $email_error, 'text');
                }
                else {
                    $valid_party = $valid->error_display($form_name, "email", $email_error, 'text');
                }
            }
        }
      

        if(isset($_POST['address'])) {
            $address = $_POST['address'];
            $address = trim($address);
            if(!empty($address)) {
                if(strlen($address) > 150) {
                    $address_error = "Only 150 characters allowed";
                }
                else {
                    $address_error = $valid->valid_address($address, "address", "0","150");   
                }
            }  
            if(!empty($address_error)) {
                if(!empty($valid_party)) {
                    $valid_party = $valid_party." ".$valid->error_display($form_name, "address", $address_error, 'textarea');
                }
                else {
                    $valid_party = $valid->error_display($form_name, "address", $address_error, 'textarea');
                }
            }  
        }

        if(isset($_POST['state'])) {
            $state = $_POST['state'];
            $state = trim($state);
            if(empty($state)){
                $state_error = "Select the state";
            }else{
                $state_error = $valid->common_validation($state,'State','select');
            }
            if(!empty($state_error)) {
                if(!empty($valid_party)) {
                    $valid_party = $valid_party." ".$valid->error_display($form_name, "state", $state_error, 'select');
                }
                else {
                    $valid_party = $valid->error_display($form_name, "state", $state_error, 'select');
                }
            }
        }

        if(isset($_POST['district'])) {
            $district = $_POST['district'];
            $district = trim($district);
            if(!empty($district)){
                $district_error = $valid->common_validation($district,'District','');
                if(!empty($district_error)) {
                    if(!empty($valid_party)) {
                        $valid_party = $valid_party." ".$valid->error_display($form_name, "district", $district_error, 'select');
                    }
                    else {
                        $valid_party = $valid->error_display($form_name, "district", $district_error, 'select');
                    }
                }
            }
        }

        if(isset($_POST['city'])) {
            $city = $_POST['city'];
            $city = trim($city);
            if(!empty($city)){
                $city_error = $valid->common_validation($city,'City','');
                if(!empty($city_error)) {
                    if(!empty($valid_party)) {
                        $valid_party = $valid_party." ".$valid->error_display($form_name, "city", $city_error, 'select');
                    }
                    else {
                        $valid_party = $valid->error_display($form_name, "city", $city_error, 'select');
                    }
                }
                else{
                    if(isset($_POST['others_city']))
                    {
                        $others_city = $_POST['others_city'];
                        $others_city = trim($others_city);
                        if(!empty($city) && $city == "Others") {
                            if(!empty($others_city) && strlen($others_city) > 30) {
                                $others_city_error = "Only 30 characters allowed";
                            }
                            else {
                                $others_city_error = $valid->valid_text($others_city,'City','0','30');
                            }
                            if(!empty($others_city_error)) {
                                if(!empty($valid_party)) {
                                    $valid_party = $valid_party." ".$valid->error_display($form_name, "others_city", $others_city_error, 'text');
                                }
                                else {
                                    $valid_party = $valid->error_display($form_name, "others_city", $others_city_error, 'text');
                                }
                            }
                            else {
                                $city = $others_city;
                                $city = trim($city);
                            }
                        }
                    }
                }
            }
        }

        if(isset($_POST['pincode'])){
            $pincode = $_POST['pincode'];
            if(!empty($pincode)) {
                $pincode_error = $valid->valid_pincode($pincode, "Pincode", "0");
                if(!empty($pincode_error)) {
                    if(!empty($valid_party)) {
                        $valid_party = $valid_party." ".$valid->error_display($form_name, "pincode", $pincode_error, 'text');
                    }
                    else {
                        $valid_party = $valid->error_display($form_name, "pincode", $pincode_error, 'text');
                    }
                }
            } 
        }

        if(isset($_POST['gst_number'])) 
        {
            $gst_number = $_POST['gst_number'];
            $gst_number = trim($gst_number);
            if(!empty($gst_number)) {
                $gst_number_error = $valid->valid_gst_number($gst_number, 'gst_number', '0'); 
            }
            if(!empty($gst_number_error)) {
                if(!empty($valid_party)) {
                    $valid_party = $valid_party." ".$valid->error_display($form_name, "gst_number", $gst_number_error, 'text');
                }
                else {
                    $valid_party = $valid->error_display($form_name, "gst_number", $gst_number_error, 'text');
                }
            }
        }

        if(isset($_POST['identification'])) {
            $identification = $_POST['identification'];
            $identification = trim($identification);
            if(!empty($identification)) {
                $identification_error = $valid->valid_address($identification, 'identification', '0', '150');
            }
            if(!empty($identification_error)) {
                if(!empty($valid_party)) {
                    $valid_party = $valid_party." ".$valid->error_display($form_name, "identification", $identification_error, 'text');
                }
                else {
                    $valid_party = $valid->error_display($form_name, "identification", $identification_error, 'text');
                }
            }
        }

        if (isset($_POST['opening_balance'])) {
			$opening_balance = $_POST['opening_balance'];
			$opening_balance = trim($opening_balance);
		}
		if (isset($_POST['opening_balance_type'])) {
			$opening_balance_type = $_POST['opening_balance_type'];
			$opening_balance_type = trim($opening_balance_type);
		}

      

        $access_error = ""; $permission_module = $GLOBALS['party_module']; $permission_action = "";
        if(!empty($login_staff_id)) {
            if(!empty($edit_id)) {
                $permission_action = $edit_action;
            }
            else {
                $permission_action = $add_action;
            }
            include('permission_action.php');
        }

       
        $result = "";
        if(empty($valid_party) && (empty($access_error))) {
            $check_user_id_ip_address = 0;
            $check_user_id_ip_address = $obj->check_user_id_ip_address();	
            if(preg_match("/^\d+$/", $check_user_id_ip_address)) {
                $bill_company_id =$GLOBALS['bill_company_id'];
    
                $name_mobile_city = ""; $party_details = ""; $lower_case_name=""; $product_name="";
                if(!empty($party_name)) {
                    $party_name = html_entity_decode($party_name);
                    $lower_case_name = strtolower($party_name);
                    $lower_case_name = html_entity_decode($lower_case_name);
                    $lower_case_name = $obj->encode_decode('encrypt', $lower_case_name);
                }
                if(!empty($party_name)) {
                    $name_mobile_city = $party_name;
                    $party_details = $party_name;
                    $party_name = $obj->encode_decode('encrypt', $party_name);
                }
               
                if(!empty($pincode)) {
                    $pincode = $obj->encode_decode('encrypt', $pincode);
                } else {
                    $pincode = $GLOBALS['null_value'];
                }
                if(!empty($address)) {
                    if(!empty($party_details)) {
                        $party_details = $party_details."<br>".str_replace("\r\n", "<br>", $address);
                    }
                    $address = $obj->encode_decode('encrypt', $address);
                }
                else {
                    $address = $GLOBALS['null_value'];
                }
                
                if(!empty($city)) {
                    if(!empty($party_details)) {
                        $party_details = $party_details."<br>".$city;
                    }
                }
                if(!empty($district)) {
                    if(!empty($party_details)) {
                        $party_details = $party_details."<br>".$district."(Dist.)";
                    }
                }
                if(!empty($state)) {
                    if(!empty($party_details)) {
                        $party_details = $party_details."<br>".$state;
                    }
                    $state = $obj->encode_decode('encrypt', $state);
                }
                if(!empty($mobile_number)) {
                    $mobile_number = str_replace(" ", "", $mobile_number);

                    if(!empty($party_details)) {
                        $party_details = $party_details."<br>"."Mobile : ".$mobile_number;
                    }
                    if(!empty($name_mobile_city)) {
                        $name_mobile_city = $name_mobile_city." (".$mobile_number.")";
                        if(!empty($city)) {
                            $name_mobile_city = $name_mobile_city." - ".$city;
                        }
                       
                    }
                   
                    $mobile_number = $obj->encode_decode('encrypt', $mobile_number);
                }else {
                    $mobile_number = $GLOBALS['null_value'];
                }
                if(!empty($name_mobile_city)){
                    $name_mobile_city = $obj->encode_decode('encrypt', $name_mobile_city);
                }
                if(!empty($gst_number)) {
                    if(!empty($party_details)) {
                        $party_details = $party_details."<br>"."GST IN : ".$gst_number;
                    }
                    $gst_number = $obj->encode_decode('encrypt', $gst_number);
                }
                else {
                    $gst_number = $GLOBALS['null_value'];
                }
                if(!empty($city)) {
                    $city = $obj->encode_decode('encrypt', $city);
                }
                else{
                    $city = $GLOBALS['null_value'];
                }
               
                if(!empty($district)) {
                    $district = $obj->encode_decode('encrypt', $district);
                }
                else{
                    $district = $GLOBALS['null_value'];
                }
                
                if(!empty($party_details)) {
                    $party_details = $obj->encode_decode('encrypt', $party_details);
                }
                $prev_party_id = ""; $party_error = "";	$prev_party_name ="";
                if(!empty($mobile_number)) {
                    $prev_party_id = $obj->PartyMobileExists($mobile_number,$GLOBALS['party_table'],'party_id');
                    // $prev_party_id = $obj->getTableColumnValue($GLOBALS['party_table'], 'party_id', $mobile_number, 'mobile_number');

                    if(!empty($prev_party_id) && $prev_party_id != $edit_id) {
                        $prev_party_name = $obj->getTableColumnValue($GLOBALS['party_table'],'party_id',$prev_party_id,'party_name');
                        $prev_party_name = $obj->encode_decode("decrypt",$prev_party_name);
                        $party_error = "This Mobile Number is already exist in ".$prev_party_name;
                        
                    }
                }
                
                
                $created_date_time = $GLOBALS['create_date_time_label']; $creator = $GLOBALS['creator'];
                $updated_date_time = $GLOBALS['create_date_time_label'];
                $creator_name = $obj->encode_decode('encrypt', $GLOBALS['creator_name']);
                $null_value = $GLOBALS['null_value'];
                $balance = 0;
                if(empty($edit_id)) {
                    if(empty($prev_party_id)) {
                        $action = "";
                        if(!empty($name_mobile_city)) {
                            $action = "New party Created. Details - ".$obj->encode_decode('decrypt', $name_mobile_city);
                        }
                        $null_value = $GLOBALS['null_value'];
                        $columns = array('created_date_time','updated_date_time', 'creator', 'creator_name','bill_company_id', 'party_id','party_type', 'party_name', 'mobile_number', 'name_mobile_city', 'address', 'state', 'district', 'city', 'party_details','lower_case_name','pincode','others_city','gst_number', 'email', 'identification', 'deleted', 'opening_balance', 'opening_balance_type');
                        $values = array($created_date_time, $updated_date_time, $creator, $creator_name,$bill_company_id, $null_value,$party_type, $party_name, $mobile_number, $name_mobile_city, $address, $state, $district, $city, $party_details,$lower_case_name,$pincode,$others_city,$gst_number, $email, $identification, 0, $opening_balance, $opening_balance_type);
                        $party_insert_id = $obj->InsertSQL($GLOBALS['party_table'], $columns, $values, 'party_id', '', $action);
                        if(preg_match("/^\d+$/", $party_insert_id)) {	
                            $balance = 1;
                            $party_id = "";
                            $party_id = $obj->getTableColumnValue($GLOBALS['party_table'], 'id', $party_insert_id, 'party_id');
                            // $result = array('number' => '1', 'msg' => 'party Successfully Created','party_id' => $party_id);

                            if(empty($add_custom)){
                                $result = array('number' => '1', 'msg' => 'Party Successfully Created', 'party_id' => $party_id);
                            }else{							
                                if($custom_party_form =='purchase_entry_form'){
                                    $result = array('number' => '1', 'msg' => 'Party Successfully Created', 'party_id' => $party_id,'screen' => 'purchase_entry');
                                }if($custom_party_form =='purchase_invoice_form'){
                                    $result = array('number' => '1', 'msg' => 'Party Successfully Created', 'party_id' => $party_id,'screen' => 'purchase_invoice');
                                }if($custom_party_form =='quotation_form'){
                                    $result = array('number' => '1', 'msg' => 'Party Successfully Created', 'party_id' => $party_id,'screen' => 'quotation');
                                }if($custom_party_form =='estimate_form'){
                                    $result = array('number' => '1', 'msg' => 'Party Successfully Created', 'party_id' => $party_id,'screen' => 'estimate');
                                }
                                else{
                                    $result = array('number' => '1', 'msg' => 'Party Successfully Created', 'party_id' => $party_id,'screen' => 'sales_invoice');
                                }
                            }
                        }
                        else {
                            $result = array('number' => '2', 'msg' => $party_insert_id);
                        }
                    }
                    else {
                        $result = array('number' => '2', 'msg' => $party_error);
                    }
                }
                else {
                    if(empty($prev_party_id) || $prev_party_id == $edit_id) {
                        $getUniqueID = ""; $party_id = $edit_id;
                        $getUniqueID = $obj->getTableColumnValue($GLOBALS['party_table'], 'party_id', $edit_id, 'id');
                        if(preg_match("/^\d+$/", $getUniqueID)) {
                            $action = "";
                            if(!empty($name_mobile_city)) {
                                $action = "party Updated. Details - ".$obj->encode_decode('decrypt', $name_mobile_city);
                            }
                        
                            $columns = array(); $values = array();						
                            $columns = array('updated_date_time','creator_name','party_name', 'mobile_number', 'name_mobile_city', 'address', 'state', 'district', 'city', 'party_details','lower_case_name','others_city','gst_number', 'email', 'party_type', 'pincode', 'identification', 'opening_balance', 'opening_balance_type');
                            $values = array($updated_date_time,$creator_name, $party_name, $mobile_number, $name_mobile_city, $address, $state, $district, $city, $party_details,$lower_case_name,$others_city,$gst_number, $email, $party_type, $pincode, $identification, $opening_balance, $opening_balance_type);
                            $party_update_id = $obj->UpdateSQL($GLOBALS['party_table'], $getUniqueID, $columns, $values, $action);
                            if(preg_match("/^\d+$/", $party_update_id)) {	
                                $balance = 1;
                                $result = array('number' => '1', 'msg' => 'Updated Successfully');	
                                $party_id = $edit_id;
                            }
                            else {
                                $result = array('number' => '2', 'msg' => $party_update_id);
                            }							
                        }
                    }
                    else {
                        $result = array('number' => '2', 'msg' => $party_error);
                    }
                }
                
                if($balance == 1 ) {
                    if(!empty($party_id) && !empty($opening_balance)) {
                        $credit  = 0; $debit = 0; $bill_type ="Opening Balance";
                        $bill_id = $party_id;
                        $bill_date = "1970-01-01";
                        $bill_number =  $GLOBALS['null_value'];
                        $credit = 0;
                        $party_type = "";
                        $party_type = $obj->getTableColumnValue($GLOBALS['party_table'], 'party_id', $party_id, 'party_type');
                        
                        $update_balance ="";
                        $update_balance = $obj->UpdateBalance($bill_company_id,$bill_id,$bill_number,$bill_date,$bill_type,$party_id,$party_name,$party_type,$GLOBALS['null_value'],$GLOBALS['null_value'],$GLOBALS['null_value'],$GLOBALS['null_value'],$opening_balance,$opening_balance_type,$credit,$debit);
                    }
                }

              
            }
            else {
                $result = array('number' => '2', 'msg' => 'Invalid IP');
            }
        }
        else {
            if(!empty($valid_party)) {
                $result = array('number' => '3', 'msg' => $valid_party);
            }
            if(!empty($access_error)) {
                $result = array('number' => '2', 'msg' => $access_error);
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
        $page_title = "party";
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
            2 => 'party_type',
            3 => 'party_name',
            4 => 'mobile_number',
            5 => '',
        ];
        if(!empty($order_column_index) && isset($columns[$order_column_index])) {
            $order_column = $columns[$order_column_index];
        }

        $search_text = "";
        if(isset($_POST['search_text'])) {
            $search_text = trim($_POST['search_text']);
        }

        $filter_party_id = "";
        if(isset($_POST['filter_party_id'])) {
            $filter_party_id = trim($_POST['filter_party_id']);
        }

        $filter_party_type = "";
        if(isset($_POST['filter_party_type'])) {
            $filter_party_type = trim($_POST['filter_party_type']);
        }

        $login_staff_id = "";
        if($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type'] == $GLOBALS['staff_user_type']) {
            $login_staff_id =  $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'];
        }

        $totalRecords = 0;
        $totalRecords = count($obj->getpartyList($row, $rowperpage, $order_column, $order_direction, $search_text, $filter_party_id, $filter_party_type));
        $filteredRecords = count($obj->getpartyList('', '', $order_column, $order_direction, $search_text, $filter_party_id, $filter_party_type));

        $data = [];

        $partyList = $obj->getpartyList($row, $rowperpage, $order_column, $order_direction,$search_text, $filter_party_id, $filter_party_type);
        
        $sno = $row + 1;
        foreach ($partyList as $val) {
            $created_date_time = ""; $updated_date_time = ""; $party_name = ""; 
            if(!empty($val['created_date_time']) && $val['created_date_time'] != $GLOBALS['null_value']) {
                $created_date_time = date('d-m-Y H:i:s', strtotime($val['created_date_time']));
            }
            if(!empty($val['updated_date_time']) && $val['updated_date_time'] != $GLOBALS['null_value']) {
                $updated_date_time = date('d-m-Y H:i:s', strtotime($val['updated_date_time']));
            }
            if(!empty($val['party_name']) && $val['party_name'] != $GLOBALS['null_value']){
                $party_name = $obj->encode_decode("decrypt",$val['party_name']);
                // echo $party_name = html_entity_decode($val['party_name']);
            }
             if(!empty($val['mobile_number']) && $val['mobile_number'] != $GLOBALS['null_value']){
                $mobile_number = $obj->encode_decode("decrypt",$val['mobile_number']);
                // echo $party_name = html_entity_decode($val['party_name']);
            }
            
            $linked_count = 0;
            $linked_count = $obj->GetLinkedCount($GLOBALS['party_table'], $val['party_id']);

            $action = ""; $edit_option = ""; $delete_option = "";
            $edit_access_error = ""; $permission_module = $GLOBALS['party_module']; $permission_action = $edit_action;
            if(!empty($login_staff_id)) {
                include('permission_action.php');
            }
            $delete_access_error = ""; $permission_module = $GLOBALS['party_module']; $permission_action = $delete_action;
            if(!empty($login_staff_id)) {
                include('permission_action.php');
            }
            if(empty($edit_access_error)){
                $edit_option = '<li><a class="dropdown-item" href="Javascript:ShowModalContent('.'\''.$page_title.'\''.', '.'\''.$val['party_id'].'\''.');"><i class="fa fa-pencil"></i>&nbsp; Edit</a></li>';
            }

            if(empty($delete_access_error)){
                if(!empty($linked_count)) { 
                    $delete_option = '<li><a class="dropdown-item text-secondary" style="pointer-events: none; cursor: default;"><i class="fa fa-trash"></i>&nbsp; Delete</a></li>';
                }else{
                    $delete_option = '<li><a class="dropdown-item" href="Javascript:DeleteModalContent('.'\''.$page_title.'\''.', '.'\''.$val['party_id'].'\''.');"><i class="fa fa-trash"></i>&nbsp; Delete</a></li>';
                }
            }
            
            if(empty($edit_access_error) || empty($delete_access_error)){
                $action = '<div class="dropdown">
                            <a href="#" role="button" class="btn btn-dark py-1 px-2" id="dropdownMenuLink'.$val['party_id'].'" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink'.$val['party_id'].'">
                                '.$edit_option.$delete_option.'
                            </ul>
                        </div>';
            }

            $party_type_label = "";
            if($val['party_type'] == '1'){
                $party_type_label = 'Purchase';
            }else if($val['party_type'] == '2'){
                $party_type_label = 'Sales';
            }else if($val['party_type'] == '3'){
                $party_type_label = 'Both';
            }

            $data[] = [
                "sno" => $sno++,
                "created_date_time" => $created_date_time,
                "party_type" => $party_type_label,
                "party_name" => $party_name,
                "mobile_number" => $mobile_number,
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
    if(isset($_REQUEST['delete_party_id'])) {
        $delete_party_id = filter_input(INPUT_GET, 'delete_party_id', FILTER_SANITIZE_SPECIAL_CHARS);
        $msg = "";
        if(!empty($delete_party_id)) {
            $access_error = ""; $permission_module = $GLOBALS['party_module']; $permission_action = $delete_action;
            if(!empty($login_staff_id)) {
                include('permission_action.php');
            }
            if(empty($access_error)) {
                $unique_id = "";
                $unique_id = $obj->getTableColumnValue($GLOBALS['party_table'], 'party_id', $delete_party_id, 'id');
                if(preg_match("/^\d+$/", $unique_id)) {
                    $linked_count = 0;
                    $linked_count = $obj->GetLinkedCount($GLOBALS['party_table'], $delete_party_id);
                    if(empty($linked_count)) {
                        $party_name = "";
                        $party_name = $obj->getTableColumnValue($GLOBALS['party_table'], 'party_id', $delete_party_id, 'party_name');
            
                        $action = "";
                        if(!empty($party_name)) {
                            $action = "party Deleted. Name - " .$party_name;
                        }
                        $columns = array(); $values = array();
                        $columns = array('deleted');
                        $values = array(1);
                        $msg = $obj->UpdateSQL($GLOBALS['party_table'], $unique_id, $columns, $values, $action);
                    }
                    else {
                        $msg = "party cannot be deleted as it is assigned to product";
                    }
                }
                else {
                    $msg = "Invalid party";
                }
            }
            else {
                $msg = $access_error;
            }
        }
        else {
            $msg = "Empty Category";
        }
        echo $msg;
        exit;
    }
?>