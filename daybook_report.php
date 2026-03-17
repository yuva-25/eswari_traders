<?php 
	$page_title = "Day Book";
	include("include_user_check_and_files.php");
	$page_number = $GLOBALS['page_number']; $page_limit = $GLOBALS['page_limit'];

    $loginner_id = "";
    if(isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id']) && !empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'])) {
        if(!empty($GLOBALS['user_type']) && $GLOBALS['user_type'] != $GLOBALS['admin_user_type']) {
            $loginner_id = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'];
            $permission_module = $GLOBALS['reports_module'];
            include("permission_check.php");
        }
    }

    $from_date = date('Y-m-d'); $to_date = date("Y-m-d");
    if(isset($_POST['from_date'])) {
        $from_date = $_POST['from_date'];
    }
    if(isset($_POST['to_date'])) {
        $to_date = $_POST['to_date'];
    }
    
    $filter_party_id="";
    if(isset($_POST['filter_party_id'])) {
        $filter_party_id = $_POST['filter_party_id'];
    }

    $filter_payment_mode_id = "";
    if(isset($_POST['filter_payment_mode_id'])) {
        $filter_payment_mode_id = $_POST['filter_payment_mode_id'];
    }

    $bill_type="";
    if(isset($_POST['bill_type'])){
        $bill_type = $_POST['bill_type'];
    }

    $customer_list = array();
    $customer_list = $obj->getTableRecords($GLOBALS['party_table'], '', '','');
   
    $total_records_list = array();
    $total_records_list = $obj->getDayBookReportList($GLOBALS['bill_company_id'], $from_date, $to_date, $filter_party_id, $filter_payment_mode_id, $bill_type);
    
    $payment_mode_list = array();
    $payment_mode_list = $obj->getTableRecords($GLOBALS['payment_mode_table'], '', '','');
  
    $current_date = date('Y-m-d');

    $excel_name = "";
    if(!empty($from_date) && !empty($to_date)){
        $excel_name = "Daybook Report( ".date('d-m-Y',strtotime($from_date ))." to ".date('d-m-Y',strtotime($to_date )).")";
    }else{
        $excel_name = "Daybook Report"; 
    }

    $selected_payment_mode_name = '';
    foreach ($payment_mode_list as $mode) {
        if ($mode['payment_mode_id'] == $filter_payment_mode_id) {
            if(!empty($mode['payment_mode_name'])) {
                 $selected_payment_mode_name = $mode['payment_mode_name'];
            }
            break;
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title> <?php if(!empty($project_title)) { echo $project_title; } ?> - <?php if(!empty($page_title)) { echo $page_title; } ?> </title>
	<?php include "link_style_script.php"; ?>
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
                        <div class="border card-box" id="table_records_cover">
                            <div class="card-header align-items-center">
                                <form name="daybook_report_form" method="POST">
                                    <div class="row p-2">   
                                            <div class="col-lg-2 col-md-3 col-6 py-2">
                                                <div class="form-group mb-2">
                                                    <div class="form-label-group in-border">
                                                        <input type="date" id="from_date" name="from_date" class="form-control shadow-none" placeholder="" onchange="Javascript:getReport();" value="<?php if(!empty($from_date)){ echo $from_date; }?>" max="<?php if(!empty($current_date)){ echo $current_date; }?>" required>
                                                        <label>From Date</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3 col-6 py-2">
                                                <div class="form-group mb-2">
                                                    <div class="form-label-group in-border">
                                                        <input type="date" id="to_date" name="to_date"  class="form-control shadow-none" placeholder="" onchange="Javascript:getReport();"  value="<?php if(!empty($to_date)){ echo $to_date; }?>" max="<?php if(!empty($current_date)){ echo $current_date; }?>" required>
                                                        <label>To Date</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-4 col-12 py-2">
                                                <div class="form-group mb-2">
                                                    <div class="form-label-group in-border mb-0">
                                                        <select class="select2 select2-danger" name="bill_type" data-dropdown-css-class="select2-danger"  style="width: 100%;" onchange="Javascript:getReport();">
                                                            <option value="">Select Bill Type</option>
                                                            <option value="Estimate" <?php if(!empty($bill_type) && ($bill_type == 'Estimate')) { ?> selected <?php } ?>>Estimate</option>
                                                            <option value="Invoice" <?php if(!empty($bill_type) && ($bill_type == 'Invoice')) { ?> selected <?php } ?>>Invoice</option>
                                                            <option value="Purchase" <?php if(!empty($bill_type) && ($bill_type == 'Purchase')) { ?> selected <?php } ?>>Purchase</option>
                                                            <option value="Voucher" <?php if(!empty($bill_type) && ($bill_type == 'Voucher')) { ?> selected <?php } ?>>Voucher</option>
                                                            <option value="Receipt" <?php if(!empty($bill_type) && ($bill_type == 'Receipt')) { ?> selected <?php } ?>>Receipt</option>
                                                        </select>
                                                        <label>Bill Type</label>
                                                    </div>
                                                </div>        
                                            </div>

                                            <div class="col-lg-2 col-md-4 col-12 py-2">
                                                <div class="form-group">
                                                    <div class="form-label-group in-border mb-0" id="customer_list">
                                                        <select class="select2 select2-danger" name="filter_party_id" data-dropdown-css-class="select2-danger"  style="width: 100%;" onchange="Javascript:getReport();">
                                                            <option value="">Select Party</option> <?php
                                                            if(!empty($customer_list)) {
                                                                foreach($customer_list as $data) { 
                                                                    if(!empty($data['party_id']) && $data['party_id'] != "NULL") {
                                                                    ?>
                                                                        <option value="<?php if(!empty($data['party_id'])) { echo $data['party_id']; } ?>"<?php if(!empty($filter_party_id)){ if($filter_party_id == $data['party_id']){ echo "selected"; } } ?>> <?php
                                                                            if(!empty($data['name_mobile_city'])) {
                                                                                $data['name_mobile_city'] = $obj->encode_decode('decrypt', $data['name_mobile_city']);
                                                                                echo $data['name_mobile_city'];
                                                                            } ?>
                                                                        </option>
                                                                    <?php
                                                                    }
                                                                }
                                                            } ?>
                                                        </select>
                                                        <label>Party Name</label>
                                                    </div>
                                                </div>        
                                            </div>

                                            <div class="col-lg-2 col-md-4 col-12 py-2">
                                                <div class="form-group">
                                                    <div class="form-label-group in-border mb-0" id="payment_mode_list">
                                                        <select class="select2 select2-danger" name="filter_payment_mode_id" data-dropdown-css-class="select2-danger"  style="width: 100%;" onchange="Javascript:getReport();">
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
                                                        <label>Payment Mode</label>
                                                    </div>
                                                </div>        
                                            </div>
                                                
                                            <div class="col-lg-2 col-md-5 col-12 py-2 text-end">
                                                <button class="btn btn-danger" style="font-size:11px;" type="button" onClick="ExportToExcel()"><i class="fa fa-download"></i>&ensp; Export </button>
                                                <a class="btn btn-success m-1" style="font-size:11px;" href="reports/rpt_daybook_report.php?filter_party_id=<?php if(!empty($filter_party_id)) { echo $filter_party_id; } ?>&filter_payment_mode_id=<?php if(!empty($filter_payment_mode_id)) { echo $filter_payment_mode_id; } ?>&filter_bill_type=<?php if(!empty($bill_type)) { echo $bill_type; } ?>&from_date=<?php if(!empty($from_date)) { echo $from_date; } ?>&to_date=<?php if(!empty($to_date)) { echo $to_date; } ?>" target="_blank" > <i class="fa fa-print"></i> Print </a>
                                            </div>
                                    </div>
                                </form>
                            </div>
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-bordered nowrap cursor text-center smallfnt" id="tbl_daybook_list">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>S.No</th>
                                                <th>Date/Bill Number</th>
                                                <th>Bill Type</th>
                                                <th>Party Type</th>
                                                <th>Party Name</th>
                                                <th>Payment Mode</th>
                                                <th>Remarks</th>
                                                <th>Credit</th>
                                                <th>Debit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $credit_total = 0; 
                                                $debit_total = 0;

                                                if (!empty($total_records_list)) {
                                                    $i = 1;
                                                    foreach ($total_records_list as $data) {
                                                        $party_type = "";
                                                        if(!empty($data['party_type'])) {
                                                            if($data['party_type'] == '1'){
                                                                $party_type = 'Purchase';
                                                            } elseif ($data['party_type'] == '2'){
                                                                $party_type = 'Sales';
                                                            } elseif ($data['party_type'] == '3') {
                                                                $party_type = "Both";
                                                            }
                                                        }
                                                        
                                                        ?>
                                                        <tr>
                                                            <td><?= $i++; ?></td>
                                                            <td> 
                                                                <?php echo (!empty($data['bill_date'])) ? date('d-m-Y', strtotime($data['bill_date'])) : ""; ?>
                                                                <br>
                                                                <?php echo (!empty($data['bill_number']) && $data['bill_number'] != $GLOBALS['null_value']) ? $data['bill_number'] : ""; ?>
                                                            </td>
                                                            <td><?php echo $data['bill_type']; ?></td>
                                                            <td><?php echo (!empty($party_type)) ? $party_type : "-"; ?></td>
                                                            <td><?php echo (!empty($data['party_name'])) ? $obj->encode_decode('decrypt', $data['party_name']) : "-"; ?></td>
                                                            <td><?php echo (!empty($data['payment_mode_name']) && $data['payment_mode_name'] != 'NULL') ? $data['payment_mode_name'] : "-"; ?></td>
                                                            <td class="text-center">
                                                                <?php
                                                                $remarks = "-";
                                                                if($data['bill_type'] == 'Receipt') {
                                                                    $remarks = $obj->getTableColumnValue($GLOBALS['receipt_table'], 'receipt_id', $data['bill_id'], 'narration');
                                                                } else if($data['bill_type'] == 'Voucher') {
                                                                    $remarks = $obj->getTableColumnValue($GLOBALS['voucher_table'], 'voucher_id', $data['bill_id'], 'narration');
                                                                }
                                                                echo ($remarks != $GLOBALS['null_value'] && !empty($remarks)) ? $obj->encode_decode("decrypt", $remarks) : "-";
                                                                ?>
                                                            </td>
                                                            <td class="text-end">
                                                                <?php
                                                                if(!empty($data['credit'])){
                                                                    echo $obj->numberFormat($data['credit'],2);
                                                                    $credit_total += $data['credit'];
                                                                } else { echo "0.00"; }
                                                                ?>
                                                            </td>
                                                            <td class="text-end">
                                                                <?php
                                                                if(!empty($data['debit'])){
                                                                    echo $obj->numberFormat($data['debit'],2);
                                                                    $debit_total += $data['debit'];
                                                                } else { echo "0.00"; }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <?php 
                                                    } ?>
                                                    <tr class="fw-bold bg-light">
                                                        <td colspan="7" class="text-end">Total</td>
                                                        <td class="text-end"><?php echo $obj->numberFormat($credit_total,2); ?></td>
                                                        <td class="text-end"><?php echo $obj->numberFormat($debit_total,2); ?></td>
                                                    </tr>
                                                    <tr class="fw-bold">
                                                        <th class="text-end" colspan="7">Difference</th>
                                                        <th class="text-end">
                                                            <?php echo ($credit_total > $debit_total) ? $obj->numberFormat($credit_total - $debit_total, 2) : '0.00'; ?>
                                                        </th>
                                                        <th class="text-end">
                                                            <?php echo ($debit_total > $credit_total) ? $obj->numberFormat($debit_total - $credit_total, 2) : '0.00'; ?>
                                                        </th>
                                                    </tr>
                                                    <?php
                                                } else { ?>
                                                    <tr><td colspan="9" class="text-center">No Records Found</td></tr>
                                                    <?php 
                                                } 
                                            ?>
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
<script type="text/javascript" src="include/js/xlsx.full.min.js"></script>
<script>
    jQuery(document).ready(function(){
        jQuery('.add_update_form_content').find('select').select2();
    });

    $(document).ready(function(){
        $("#daybook_report").addClass("active");
    });

    function getReport(){
        if(jQuery('form[name="daybook_report_form"]').length > 0){
            jQuery('form[name="daybook_report_form"]').submit();
        } 
    }

    function ExportToExcel(type, fn, dl) {
        var elt = document.getElementById('tbl_daybook_list');
        var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
        return dl ?
        XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
        XLSX.writeFile(wb, fn || ('<?php echo $excel_name; ?>.' + (type || 'xlsx')));
    }
</script>
</body>
</html>
