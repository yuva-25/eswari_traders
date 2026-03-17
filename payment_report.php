<?php 
	$page_title = "Payment Report";
	include("include_user_check_and_files.php");
	$page_number = $GLOBALS['page_number']; $page_limit = $GLOBALS['page_limit'];
    
    $login_staff_id = "";
    if(isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id']) && !empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'])) {
        if(!empty($GLOBALS['user_type']) && $GLOBALS['user_type'] != $GLOBALS['admin_user_type']) {
            $login_staff_id = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'];
            $permission_module = $GLOBALS['reports_module'];
            include("permission_check.php");
        }
    }
    
    $from_date=""; $to_date="";
    $from_date = date('Y-m-d', strtotime('-7 days')); $to_date = date('Y-m-d');
    $current_date = date('Y-m-d');
    $party_list = array(); $party_count = 0;
   
    $bill_company_id = $GLOBALS['bill_company_id'];
    $payment_mode_list = array(); 
    $payment_mode_list = $obj->getTableRecords($GLOBALS['payment_mode_table'],'','', '');

    $bank_list = array(); 
    $bank_list = $obj->getTableRecords($GLOBALS['bank_table'], '','', '');

    $filter_customer_id =""; $filter_bill_type =""; $filter_party_type= "";

    if(isset($_POST['filter_customer_id'])) {
        $filter_customer_id = $_POST['filter_customer_id'];
    }

    if(isset($_POST['filter_bill_type'])) {
        $filter_bill_type = $_POST['filter_bill_type'];
    }

    if(isset($_POST['filter_party_type'])) {
        $filter_party_type = $_POST['filter_party_type'];
    }

    if(isset($_POST['from_date'])) {
        $from_date = $_POST['from_date'];
    }

    if(isset($_POST['to_date'])) {
        $to_date = $_POST['to_date'];
    }

    $filter_payment_mode_id="";
    if(isset($_POST['filter_payment_mode_id'])) {
        $filter_payment_mode_id = $_POST['filter_payment_mode_id'];
    }

    $filter_bank_id="";
    if(isset($_POST['filter_bank_id'])) {
        $filter_bank_id = $_POST['filter_bank_id'];
    }     
    
    $customer_list = array();
    $customer_list = $obj->getTableRecords($GLOBALS['party_table'],'','','');

    $payment_list =array();
    $payment_list = $obj->getPaymentReportList($from_date,$to_date,$filter_bill_type,$filter_party_type,$filter_customer_id,$filter_payment_mode_id,$filter_bank_id);

    $excel_name = "";
    $excel_name = "Payment Report( ".date('d-m-Y',strtotime($from_date ))." to ".date('d-m-Y',strtotime($to_date )).")";

    $company_list = array();
    $company_list =$obj->getTableRecords($GLOBALS['company_table'],'company_id',$GLOBALS['bill_company_id'],'');

    $company_name = ""; $address = ""; $city =""; $state = ""; $mobile_number = ""; $gst_number = "";

    if(!empty($company_list)){
        foreach($company_list as $data){
            if(!empty($data['name']) && $data['name'] != 'NULL'){
                $company_name = $data['name'];
            }
            if(!empty($data['address']) && $data['address'] != 'NULL'){
                $address = $data['address'];
            }
            if(!empty($data['city']) && $data['city'] != 'NULL'){
                $city = $data['city'];
            }
            if(!empty($data['state']) && $data['state'] != 'NULL'){
                $state = $data['state'];
            }
            if(!empty($data['mobile_number']) && $data['mobile_number'] != 'NULL'){
                $mobile_number = $data['mobile_number'];
            }
            if(!empty($data['gst_number']) && $data['gst_number'] != 'NULL'){
                $gst_number = $data['gst_number'];
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title> <?php if(!empty($project_title)) { echo $project_title; } ?> - <?php if(!empty($page_title)) { echo $page_title; } ?> </title>
	<?php 
	include "link_style_script.php"; ?>
    <script type="text/javascript" src="include/js/xlsx.full.min.js"></script>

</head>	
<body>
<?php include "header.php"; ?>
<!--Right Content-->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="border card-box d-none add_update_form_content" id="add_update_form_content" ></div>
                        <div class="border card-box bg-white" id="table_records_cover">
                            <div class="card-header align-items-center">
                                <form name="payment_report_form" method="POST">
                                    <div class="row justify-content-end p-2">   
                                        <div class="col-lg-2 col-md-4 col-6">
                                            <div class="form-group mb-2">
                                                <div class="form-label-group in-border">
                                                    <input type="date" id="from_date" name="from_date" value="<?php if(!empty($from_date)) { echo $from_date; } ?>" onchange="Javascript:getOverallReport();"class="form-control shadow-none" placeholder="" max="<?php if(!empty($current_date)) { echo $current_date; } ?>">
                                                    <label>From Date</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-4 col-6">
                                            <div class="form-group mb-2">
                                                <div class="form-label-group in-border">
                                                    <input type="date" id="to_date" name="to_date"  value="<?php if(!empty($to_date)) { echo $to_date; } ?>" onchange="Javascript:getOverallReport();" class="form-control shadow-none" placeholder="" max="<?php if(!empty($current_date)) { echo $current_date; } ?>">
                                                    <label>To Date</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-4 col-12">
                                            <div class="form-group">
                                                <div class="form-label-group in-border mb-0">
                                                    <select class="select2 select2-danger" name="filter_bill_type" data-dropdown-css-class="select2-danger" style="width: 100%;" onchange="Javascript:getBillType(this.value);">
                                                        <option value="">Select Bill Type</option>
                                                        <option value="1" <?php if(!empty($filter_bill_type)){ if($filter_bill_type == '1'){ echo "selected"; } } ?>>Voucher</option>
                                                        <option value="2" <?php if(!empty($filter_bill_type)){ if($filter_bill_type == '2'){ echo "selected"; } } ?>>Receipt</option>
                                                    </select>
                                                    <label>Bill Type</label>
                                                </div>
                                            </div>        
                                        </div> 
                                        <div class="col-lg-2 col-md-4 col-12">
                                            <div class="form-group">
                                                <div class="form-label-group in-border mb-0">
                                                    <select class="select2 select2-danger" name="filter_party_type" data-dropdown-css-class="select2-danger" style="width: 100%;" onchange="Javascript:getPartyType(this.value);">
                                                        <option value="">Select Party Type</option>
                                                        <option value="1" <?php if(!empty($filter_party_type)){ if($filter_party_type == '1'){ echo "selected"; } } ?>>Purchase</option>
                                                        <option value="2" <?php if(!empty($filter_party_type)){ if($filter_party_type == '2'){ echo "selected"; } } ?>>Sales</option>
                                                        <option value="3" <?php if(!empty($filter_party_type)){ if($filter_party_type == '3'){ echo "selected"; } } ?>>Both</option>
                                                    </select>
                                                    <label>Party Type</label>
                                                </div>
                                            </div>        
                                        </div> 
                                        <div class="col-lg-2 col-md-4 col-12">
                                            <div class="form-group">
                                                <div class="form-label-group in-border mb-0" id="customer_list">
                                                    <select class="select2 select2-danger" name="filter_customer_id" data-dropdown-css-class="select2-danger"  style="width: 100%;" onchange="Javascript:getOverallReport();">
                                                        <option value="">Select Customer Name</option> <?php
                                                        if(!empty($customer_list)) {
                                                            foreach($customer_list as $data) { 
                                                                if(!empty($data['party_id']) && $data['party_id'] != "NULL") {
                                                                ?>
                                                                    <option value="<?php if(!empty($data['party_id'])) { echo $data['party_id']; } ?>"<?php if(!empty($filter_customer_id)){ if($filter_customer_id == $data['party_id']){ echo "selected"; } } ?>> <?php
                                                                        if(!empty($data['party_name']) && $data['party_name'] != "NULL") {
                                                                            $data['party_name'] = $obj->encode_decode('decrypt', $data['party_name']);
                                                                            echo $data['party_name'];
                                                                            if(!empty($data['mobile_number']) && $data['mobile_number'] != $GLOBALS['null_value']) {
                                                                                $data['mobile_number'] = $obj->encode_decode('decrypt', $data['mobile_number']);
                                                                                echo " (".$data['mobile_number']. ") ";
                                                                            }
                                                                        } ?>
                                                                    </option>
                                                                <?php
                                                                }
                                                            }
                                                        } ?>
                                                    </select>
                                                    <label>Customer Name</label>
                                                </div>
                                            </div>        
                                        </div>
                                        <div class="col-lg-2 col-md-4 col-12">
                                            <div class="form-group">
                                                <div class="form-label-group in-border mb-0" id="payment_mode_list">
                                                    <select class="select2 select2-danger" name="filter_payment_mode_id" data-dropdown-css-class="select2-danger"  style="width: 100%;" onchange="Javascript:getOverallReport();">
                                                        <option value="">Select Payment Mode</option> <?php
                                                        if(!empty($payment_mode_list)) {
                                                            foreach($payment_mode_list as $data) { ?>
                                                                <option value="<?php if(!empty($data['payment_mode_id'])) { echo $data['payment_mode_id']; } ?>"<?php if(!empty($filter_payment_mode_id)){ if($filter_payment_mode_id == $data['payment_mode_id']){ echo "selected"; } } ?>> <?php
                                                                    if(!empty($data['payment_mode_name'])) {
                                                                        echo $data['payment_mode_name'];
                                                                    } ?>
                                                                </option> <?php
                                                            }
                                                        } ?>
                                                    </select>
                                                    <label>Select Payment Mode</label>
                                                </div>
                                            </div>        
                                        </div>
                                        <div class="col-lg-2 col-md-4 col-12">
                                            <div class="form-group">
                                                <div class="form-label-group in-border mb-0" id="bank_list">
                                                    <select class="select2 select2-danger" name="filter_bank_id" data-dropdown-css-class="select2-danger"  style="width: 100%;" onchange="Javascript:getOverallReport();">
                                                        <option value="">Select Bank Name</option> <?php
                                                        if(!empty($bank_list)) {
                                                            foreach($bank_list as $data) { ?>
                                                                <option value="<?php if(!empty($data['bank_id'])) { echo $data['bank_id']; } ?>"<?php if(!empty($filter_bank_id)){ if($filter_bank_id == $data['bank_id']){ echo "selected"; } } ?>> <?php
                                                                    if(!empty($data['bank_name'])) {
                                                                        $data['bank_name'] = $obj->encode_decode('decrypt', $data['bank_name']);
                                                                        echo $data['bank_name'];
                                                                    } 
                                                                    echo " - ";
                                                                    if(!empty($data['account_number'])) {
                                                                        $data['account_number'] = $obj->encode_decode('decrypt', $data['account_number']);
                                                                        echo $data['account_number'];
                                                                    } ?>
                                                                </option> <?php
                                                            }
                                                        } ?>
                                                    </select>
                                                    <label>Select Bank Name</label>
                                                </div>
                                            </div>        
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="ps-2 ">
                                                <a class="btn btn-success m-1" style="font-size:11px;" href="reports/rpt_payment_report.php?filter_customer_id=<?php if(!empty($filter_customer_id)) { echo $filter_customer_id; } ?>&filter_payment_mode_id=<?php if(!empty($filter_payment_mode_id)) { echo $filter_payment_mode_id; } ?>&filter_bank_id=<?php if(!empty($filter_bank_id)) { echo $filter_bank_id; } ?>&filter_bill_type=<?php if(!empty($filter_bill_type)) { echo $filter_bill_type; } ?>&filter_party_type=<?php if(!empty($filter_party_type)) { echo $filter_party_type; } ?>&from_date=<?php if(!empty($from_date)) { echo $from_date; } ?>&to_date=<?php if(!empty($to_date)) { echo $to_date; } ?>" target="_blank" > <i class="fa fa-print"></i> Print </a>
                                                <button class="btn btn-success m-1" style="font-size:11px;" type="button" onclick="ExportToExcel();"> <i class="fa fa-download"></i> Excel</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="row report_div m-0">
                                <div class="table-responsive">
                                    <table class="table table-bordered nowrap cursor text-center smallfnt" id="tbl_sales_list">
                                        <thead class="bg-light">
                                             <tr>
                                                <th colspan="9" class="text-center" style="border: 1px solid #dee2e6;font-weight: bold; font-size: 18px;">
                                                    Payment Report <?php if(!empty($from_date)){ echo " ( " .date('d-m-Y',strtotime($from_date )) ." to ". date('d-m-Y',strtotime($to_date )). " )"; }?>
                                                </th>
                                            </tr>
                                            <tr class="d-none header">
                                                <th colspan="3"></th>
                                                <th colspan="6"><?php echo $company_name; ?></th>
                                            </tr>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Date / Bill Number</th>
                                                <th>Bill Type</th>
                                                <th>Party Type</th>
                                                <th>Name</th>
                                                <th>Payment Type</th>
                                                <th>Remarks</th>
                                                <th>Credit</th>
                                                <th>Debit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                             <?php
                                                $grand_amount = 0; $total_amount=0;

                                                if (!empty($payment_list)) {
                                                    $index = 1;
                                                    $total_credit = 0;
                                                    $total_debit = 0;
                                                    
                                                    foreach ($payment_list as $data) {

                                                        if($data['bill_type'] == 'Receipt' || $data['bill_type'] == 'Voucher') {

                                                            $party_type = "";
                                                            $party_type = $data['party_type'];
                                                            if($party_type == '1'){
                                                                $party_type = 'Purchase';
                                                            } elseif ($party_type == '2'){
                                                                $party_type = 'Sales';
                                                            } elseif ($party_type == '3') {
                                                                $party_type = "Both";
                                                            }
                                                                                       
                                                            
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $index; ?></td>
                                                                <td> 
                                                                    <?php echo date('d-m-Y', strtotime($data['bill_date'])) ;
                                                                    ?>
                                                                    <br>
                                                                     <?php if(!empty($data['bill_number']) && $data['bill_number'] != $GLOBALS['null_value']) {
                                                                        echo trim($data['bill_number']); 
                                                                    } else {
                                                                        echo "-";
                                                                    }
                                                                    ?>
                                                                    &nbsp;
                                                                    <span style="font-size:9px;cursor:pointer;" onclick="Javascript:ShowBillPDF('<?php if(!empty($data['bill_id']) && $data['bill_id'] != $GLOBALS['null_value']) { echo $data['bill_id']; } ?>', '<?php if(!empty($data['bill_type']) && $data['bill_type'] != $GLOBALS['null_value']) { echo $data['bill_type']; } ?>')">
                                                                    <i class="fa fa-eye"></i>
                                                                    </span>

                                                                </td>
                                                                <td>
                                                                    <?php echo $data['bill_type']; ?>
                                                                </td>
                                                                <td>
                                                                    <?php 
                                                                        if(!empty($party_type)){
                                                                            echo $party_type;
                                                                        }else{
                                                                            echo "-";
                                                                        }
                                                                     ?>
                                                                </td>
                                                                <td>
                                                                    <?php 
                                                                        echo $obj->encode_decode('decrypt', $data['party_name']);
                                                                    ?>
                                                                </td>
                                                               <td class="">
                                                                    <?php 

                                                                    if(!empty($data['payment_mode_name']) && $data['payment_mode_name'] != $GLOBALS['null_value']) {
                                                                        $payment_mode_name = array();
                                                                        $payment_mode_name = explode(",", $data['payment_mode_name']);
                                                                        $payment_mode_name = array_reverse($payment_mode_name);
                                                                        $bank_id_arr = array();
                                                                        if(!empty($data['bank_id'])) {
                                                                            $bank_id_arr = explode(",",$data['bank_id']);
                                                                            $bank_id_arr = array_reverse($bank_id_arr);
                                                                        }
                                                                        for($i=0; $i < count($payment_mode_name); $i++) {
                                                                            $payment_mode = $payment_mode_name[$i];
                                                                            
                                                                            $amounts= array();
                                                                            if($data['bill_type'] == 'Receipt'){
                                                                                $amounts = explode(",", $data['credit']);
                                                                            }else if($data['bill_type'] == 'Voucher'){
                                                                                $amounts = explode(",", $data['debit']);
                                                                            }
                                                                            $amounts = array_reverse($amounts);
                                                                            
                                                                            $bank_name = "";
                                                                            if(!empty($bank_id_arr[$i])){
                                                                                $bank_name =  $obj->getTableColumnValue($GLOBALS['bank_table'], 'bank_id', $bank_id_arr[$i], 'bank_name');
                                                                                $bank_name = $obj->encode_decode('decrypt',$bank_name);
                                                                            }

                                                                            if(!empty($bank_name)){
                                                                                echo $payment_mode ." - ( ".$bank_name." ) - ".$obj->numberFormat($amounts[$i],2) ;
                                                                            }else{
                                                                                echo $payment_mode ." - ".$obj->numberFormat($amounts[$i],2) ;
                                                                            }  
                                                                            if($i < (count($payment_mode_name))-1) {
                                                                                echo ", <br>";
                                                                            }
                                                                        }  

                                                                    }else{
                                                                        echo "-";
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td class="text-center px-2 py-2">
                                                                    <?php
                                                                    if(!empty($data['bill_id'])) {
                                                                        if($data['bill_type'] == 'Receipt') {
                                                                            $remarks = $obj->getTableColumnValue($GLOBALS['receipt_table'], 'receipt_id', $data['bill_id'], 'narration');
                                                                            echo $obj->encode_decode("decrypt", $remarks);
                                                                        } else if($data['bill_type'] == 'Voucher') {
                                                                            $remarks = $obj->getTableColumnValue($GLOBALS['voucher_table'], 'voucher_id', $data['bill_id'], 'narration');
                                                                            echo $obj->encode_decode("decrypt", $remarks);
                                                                        } else {
                                                                            echo "-";
                                                                        }
                                                                    } else {
                                                                        echo "-";
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td class="text-end text-success px-2 py-2">
                                                                    <?php
                                                                    if(!empty($data['credit']))
                                                                    {
                                                                        echo $obj->numberFormat($data['credit'], 2);
                                                                        $total_credit += $data['credit'];
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td class="text-end text-danger px-2 py-2">
                                                                    <?php
                                                                    if(!empty($data['debit']))
                                                                    {
                                                                        echo $obj->numberFormat($data['debit'], 2);
                                                                        $total_debit += $data['debit'];
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                            
                                                            <?php $index++;
                                                        }
                                                    }
                                                    ?>
                                                    <tr>
                                                        <th class="text-end" colspan="7">Total</th>
                                                        <th class="text-end"><?php echo $obj->numberFormat($total_credit, 2); ?></th>
                                                        <th class="text-end"><?php echo $obj->numberFormat($total_debit, 2); ?></th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-end" colspan="7">Current Balance</th>
                                                        <th class="text-end">
                                                            <?php echo ($total_credit > $total_debit) ? $obj->numberFormat($total_credit - $total_debit, 2) : '0.00'; ?>
                                                        </th>
                                                        <th class="text-end">
                                                            <?php echo ($total_debit > $total_credit) ? $obj->numberFormat($total_debit - $total_credit, 2) : '0.00'; ?>
                                                        </th>
                                                    </tr>
                                                    <?php
                                                    
                                                }
                                                else {
                                                        ?>
                                                        <tr>
                                                            <td colspan="9" class="text-center">No records found</td>
                                                        </tr>								
                                            <?php } ?>
                                        </tbody>
                                    </table> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>          
<!--Right Content End-->
<?php include "footer.php"; ?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#payment_report").addClass("has-active");
        $("#report").addClass("has-active");
    });

   function getOverallReport() {
        $('span.infos').remove();
        $('.report_div').show();

        let from_date_display = $('input[name="from_date"]').val();
        let to_date_display   = $('input[name="to_date"]').val();

        if (!from_date_display || !to_date_display) {
            return false;
        }

        let date1 = new Date(from_date_display);
        let date2 = new Date(to_date_display);

        if (date1 <= date2) {
            $('form[name="payment_report_form"]').submit();
        } else {
            $('input[name="to_date"]').after(
                '<span class="infos text-danger">To Date must be greater than or equal to From Date (' + from_date_display + ')</span>'
            );
            $('.report_div').hide();
        }
    }
    
    function getBillType(bill_type){
        if(jQuery('select[name="filter_bill_type"]').length > 0) {
            jQuery('select[name="filter_bill_type"]').val(bill_type);
        }
        if(jQuery('form[name="payment_report_form"]').length > 0){
            jQuery('form[name="payment_report_form"]').submit();
        }
    }

    function getPartyType(party_type){
        if(jQuery('select[name="filter_party_type"]').length > 0) {
            jQuery('select[name="filter_party_type"]').val(party_type);
        }
        if(jQuery('form[name="payment_report_form"]').length > 0){
            jQuery('form[name="payment_report_form"]').submit();
        }
    }
   
    function ExportToExcel(type, fn, dl) {
        jQuery('.header').removeClass('d-none');
        var elt = document.getElementById('tbl_sales_list');
        var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
        if (dl) {
            XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' });
        } else {
            XLSX.writeFile(wb, fn || ('<?php echo $excel_name; ?>.' + (type || 'xlsx')));
        }
        jQuery('.header').addClass('d-none');
    }

    function ShowBillPDF(bill_id, type) {
        var url = "";
        bill_id = bill_id.trim();
        type = type.trim();
        if(type == 'Receipt') {
            url = "reports/rpt_receipt.php?view_receipt_id="+bill_id;
        } else if(type == 'Voucher') {
            url = "reports/rpt_voucher.php?view_voucher_id="+bill_id;
        }
        
        if(url != "") {
            window.open(url, "_blank");
        }
    }
</script>
</body>
</html>
