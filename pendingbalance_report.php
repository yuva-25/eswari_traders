<?php 
	$page_title = "Pending Balance Report";
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
    
    $filter_party_id =""; 
    $bill_company_id =$GLOBALS['bill_company_id'];

    $to_date = date('Y-m-d');  $current_date = date('Y-m-d');
    $from_date = date('Y-m-d', strtotime('-30 days', strtotime($to_date)));

    if(isset($_POST['from_date'])) {
        $from_date = $_POST['from_date'];
    }
    
    if(isset($_POST['to_date'])) {
        $to_date = $_POST['to_date'];
    }

    if(isset($_POST['filter_party_id'])) {
        $filter_party_id = $_POST['filter_party_id'];
    }

    $filter_bill_type ="";
    if(isset($_POST['bill_type'])) {
        $filter_bill_type = $_POST['bill_type']; 
    }

    $party_list =array();
    $party_list = $obj->getTableRecords($GLOBALS['party_table'],'','','');
    
    $total_records_list =array();
    $total_records_list = $obj->customer_balance_report($bill_company_id,$filter_party_id,$from_date,$to_date,$filter_bill_type);
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title> <?php if(!empty($project_title)) { echo $project_title; } ?> - <?php if(!empty($page_title)) { echo $page_title; } ?> </title>
	<?php include "link_style_script.php"; ?>
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
                        <div class="card bg-white border">
                            <div class="card-header align-items-center">
                                <form name="pending_balance_report_form" method="POST">
                                    <div class="row px-2">
                                        <div class="col-lg-3 col-md-4 col-12">
                                            <div class="form-group">
                                                <div class="form-label-group in-border mb-0">
                                                    <select class="select2 select2-danger" name="filter_party_id" data-dropdown-css-class="select2-danger"  style="width: 100%;" onchange="Javascript:getReport();">
                                                        <option value="">Select Party</option>
                                                        <?php
                                                            if(!empty($party_list)) {
                                                                foreach($party_list as $data) {
                                                                    ?>
                                                                    <option value="<?php if(!empty($data['party_id'])) { echo $data['party_id']; } ?>" <?php if(!empty($filter_party_id)){ if($filter_party_id == $data['party_id']){ echo "selected"; } } ?>>
                                                                        <?php
                                                                            if(!empty($data['party_name'])) {
                                                                                echo $obj->encode_decode('decrypt', $data['party_name']);
                                                                                if(!empty($data['mobile_number'])) {
                                                                                    echo " (".$obj->encode_decode('decrypt', $data['mobile_number']).")";
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </option>
                                                                    <?php
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                    <label>Party Name</label>
                                                </div>
                                            </div>        
                                        </div>
                                        <?php if(!empty($filter_party_id)){ ?>
                                        <div class="col-lg-2 col-md-4 col-6">
                                            <div class="form-group mb-1">
                                                <div class="form-label-group in-border pb-2">
                                                    <input type="date" id="from_date" name="from_date" class="form-control shadow-none" onchange="Javascript:getReport();" value="<?php if(!empty($from_date)){ echo $from_date; }?>" max="<?php if(!empty($current_date)){ echo $current_date; }?>">
                                                    <label>From Date</label>
                                                </div>
                                            </div>
                                        </div>
                                        <?php  } ?>
                                        <div class="col-lg-2 col-md-4 col-6">
                                            <div class="form-group mb-1">
                                                <div class="form-label-group in-border pb-2">
                                                    <input type="date" id="to_date" name="to_date" class="form-control shadow-none"  onchange="Javascript:getReport();"  value="<?php if(!empty($to_date)){ echo $to_date; }?>" max="<?php if(!empty($current_date)){ echo $current_date; }?>">
                                                    <label>To Date</label>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if(!empty($filter_party_id)){ ?>
                                        <div class="col-lg-2 col-md-4 col-6">
                                            <div class="form-group mb-2">
                                                <div class="form-label-group in-border mb-0">
                                                    <select class="select2 select2-danger" name="bill_type" data-dropdown-css-class="select2-danger"  style="width: 100%;" onchange="Javascript:getReport();">
                                                        <option value="">Select Bill Type</option>
                                                        <option value="Estimate" <?php if(!empty($filter_bill_type) && ($filter_bill_type == 'Estimate')) { ?> selected <?php } ?>>Estimate</option>
                                                        <option value="Invoice" <?php if(!empty($filter_bill_type) && ($filter_bill_type == 'Invoice')) { ?> selected <?php } ?>>Invoice</option>
                                                        <option value="Voucher" <?php if(!empty($filter_bill_type) && ($filter_bill_type == 'Voucher')) { ?> selected <?php } ?>>Voucher</option>
                                                        <option value="Receipt" <?php if(!empty($filter_bill_type) && ($filter_bill_type == 'Receipt')) { ?> selected <?php } ?>>Receipt</option>
                                                    </select>
                                                    <label>Bill Type</label>
                                                </div>
                                            </div>        
                                        </div>
                                        <?php } ?>
                                        <div class="col-lg-2 col-md-4 col-12">
                                            <button class="btn btn-success" type="button" onClick="window.open('reports/rpt_pending_balance.php?filter_customer_id=<?php echo $filter_party_id; ?>&from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>&bill_type=<?php echo $filter_bill_type; ?>', '_blank')"> <i class="fa fa-print"></i> Print </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="row m-0 p-3 report_div">
                                <div class="table-responsive">
                                    <?php if(!empty($filter_party_id)) { ?>
                                        <table class="table table-bordered nowrap cursor text-center smallfnt">
                                            <thead class="bg-light text-dark">
                                                <tr>
                                                    <th colspan="9" class="text-center h5 py-2">
                                                        Pending Payment Report - <?php
                                                            $party_name = $obj->getTableColumnValue($GLOBALS['party_table'], 'party_id', $filter_party_id, 'party_name');
                                                            echo $obj->encode_decode('decrypt', $party_name);
                                                        ?>
                                                        <div class="small mt-1"><?php echo "( ".date('d-m-Y', strtotime($from_date)) ." to " .date('d-m-Y', strtotime($to_date))." )"; ?></div>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Date</th>
                                                    <th>Bill No</th>
                                                    <th>Bill Type</th>
                                                    <th>Party Type</th>
                                                    <th>Payment Mode</th>
                                                    <th>Remarks</th>
                                                    <th>Credit</th>
                                                    <th>Debit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $total_credit = 0; $total_debit = 0;
                                                    $opening_balance_list = $obj->getOpeningBalance($filter_party_id,$from_date,$to_date,$bill_company_id);
                                                    
                                                    $opening_debit = 0; $opening_credit = 0;
                                                    if(!empty($opening_balance_list)) {
                                                        foreach($opening_balance_list as $data) {
                                                            if(!empty($data['debit'])) { $opening_debit += $data['debit']; }
                                                            if(!empty($data['credit'])) { $opening_credit += $data['credit']; }
                                                            if(!empty($data['opening_balance'])) {
                                                                if($data['opening_balance_type'] == 'Credit') { $opening_credit += $data['opening_balance']; }
                                                                if($data['opening_balance_type'] == 'Debit') { $opening_debit += $data['opening_balance']; }
                                                            }
                                                        }
                                                    }
                                                    
                                                    if($opening_credit != $opening_debit){
                                                        $ob_credit = ($opening_credit > $opening_debit) ? ($opening_credit - $opening_debit) : 0;
                                                        $ob_debit = ($opening_debit > $opening_credit) ? ($opening_debit - $opening_credit) : 0;
                                                        ?>
                                                        <tr>
                                                            <th colspan="7" class="text-end">Opening Balance</th>
                                                            <th class="text-end text-success"><?php if($ob_credit > 0) echo $obj->numberFormat($ob_credit, 2); ?></th>
                                                            <th class="text-end text-danger"><?php if($ob_debit > 0) echo $obj->numberFormat($ob_debit, 2); ?></th>
                                                        </tr>
                                                        <?php 
                                                        $total_credit += $ob_credit;
                                                        $total_debit += $ob_debit;
                                                    }

                                                    if(!empty($total_records_list)) {
                                                        $index = 1;
                                                        foreach ($total_records_list as $data) {
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $index; ?></td>
                                                                <td><?php echo date('d-m-Y', strtotime($data['bill_date'])); ?></td>
                                                                <td><?php echo $data['bill_number']; ?></td>
                                                                <td><?php echo $data['bill_type']; ?></td>
                                                                <td>
                                                                    <?php 
                                                                        $pt = $data['party_type']; 
                                                                        if($pt == '1') echo "Purchase";
                                                                        else if($pt == '2') echo "Sales";
                                                                        else if($pt == '3') echo "Both";
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php 
                                                                        if(!empty($data['payment_mode_name']) && $data['payment_mode_name'] != $GLOBALS['null_value']) {
                                                                             echo $data['payment_mode_name'];
                                                                        } else echo "-";
                                                                    ?>
                                                                </td>
                                                                <td><?php echo !empty($data['remarks']) ? $data['remarks'] : "-"; ?></td>
                                                                <td class="text-end text-success"><?php if(!empty($data['credit'])) { echo $obj->numberFormat($data['credit'],2); $total_credit += $data['credit']; } ?></td>
                                                                <td class="text-end text-danger"><?php if(!empty($data['debit'])) { echo $obj->numberFormat($data['debit'],2); $total_debit += $data['debit']; } ?></td>
                                                            </tr>
                                                            <?php $index++;
                                                        }
                                                    } else if($opening_credit == $opening_debit) {
                                                        echo "<tr><td colspan='9'>No records found</td></tr>";
                                                    }
                                                ?>
                                            </tbody>
                                            <tfoot class="bg-light">
                                                <tr>
                                                    <th colspan="7" class="text-end">Total</th>
                                                    <th class="text-end"><?php echo $obj->numberFormat($total_credit, 2); ?></th>
                                                    <th class="text-end"><?php echo $obj->numberFormat($total_debit, 2); ?></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="7" class="text-end">Pending Balance</th>
                                                    <th class="text-end text-success"><?php if($total_credit > $total_debit) echo $obj->numberFormat($total_credit - $total_debit, 2) . " Cr"; ?></th>
                                                    <th class="text-end text-danger"><?php if($total_debit > $total_credit) echo $obj->numberFormat($total_debit - $total_credit, 2) . " Dr"; ?></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    <?php } else { ?>
                                        <table class="table table-bordered nowrap cursor text-center smallfnt">
                                            <thead class="bg-light text-dark">
                                                <tr>
                                                    <th colspan="4" class="text-center h5 py-2">Overall Pending Balance Report - <?php echo date('d-m-Y'); ?></th>
                                                </tr>
                                                <tr>
                                                    <th style="width: 50px;">S.No</th>
                                                    <th>Party Name</th>
                                                    <th style="width: 150px;">Debit</th>
                                                    <th style="width: 150px;">Credit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    if(!empty($total_records_list)) {
                                                        $sno = 1;
                                                        $grand_credit = 0; $grand_debit = 0;
                                                        foreach($total_records_list as $data) {
                                                            if(empty($data['balance'])) continue;
                                                            ?>
                                                            <tr onclick="Javascript:showpartyList('<?php echo $data['party_id']; ?>');" style="cursor:pointer">
                                                                <td><?php echo $sno++; ?></td>
                                                                <td class="text-start">
                                                                    <?php 
                                                                        echo $obj->encode_decode('decrypt',$data['party_name']); 
                                                                        if(!empty($data['party_mobile_number'])) echo " (".$obj->encode_decode('decrypt',$data['party_mobile_number']).")";
                                                                    ?>
                                                                </td>
                                                                <td class="text-end text-danger">
                                                                    <?php if($data['balance'] < 0) { echo $obj->numberFormat(abs($data['balance']), 2); $grand_debit += abs($data['balance']); } ?>
                                                                </td>
                                                                <td class="text-end text-success">
                                                                    <?php if($data['balance'] > 0) { echo $obj->numberFormat($data['balance'], 2); $grand_credit += $data['balance']; } ?>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                        <tr class="bg-light font-weight-bold">
                                                            <th colspan="2" class="text-end">Grand Total</th>
                                                            <th class="text-end"><?php echo $obj->numberFormat($grand_debit, 2); ?></th>
                                                            <th class="text-end"><?php echo $obj->numberFormat($grand_credit, 2); ?></th>
                                                        </tr>
                                                        <?php
                                                    } else {
                                                        echo "<tr><td colspan='4'>No records found</td></tr>";
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>
    <?php include "footer.php"; ?>       
<script>
    $(document).ready(function(){
        $("#pending_balance_report").addClass("has-active");
        $("#report").addClass("has-active");
    });
    function getReport(){
        if(jQuery('form[name="pending_balance_report_form"]').length > 0){
            jQuery('form[name="pending_balance_report_form"]').submit();
        } 
    }
    function showpartyList(party_id) {
        if(jQuery('select[name="filter_party_id"]').length > 0) {
            jQuery('select[name="filter_party_id"]').val(party_id);
        }
        getReport();
    }
</script>
</body>
</html>
