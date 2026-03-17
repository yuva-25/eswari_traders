<?php 
	$page_title = "Purchase Tax Report";
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

    $from_date = ""; $to_date = ""; $party_id = "";
    $from_date = date('Y-m-d', strtotime('-30 days')); $to_date = date('Y-m-d');
    if(isset($_POST['filter_from_date'])) {
        $from_date = $_POST['filter_from_date'];
        $from_date = trim($from_date);
        $from_date = date('Y-m-d', strtotime($from_date));
    }
    if(isset($_POST['filter_to_date'])) {
        $to_date = $_POST['filter_to_date'];
        $to_date = trim($to_date);
        $to_date = date('Y-m-d', strtotime($to_date));
    }
    if(isset($_POST['filter_party_id'])) {
        $party_id = $_POST['filter_party_id'];
        $party_id = trim($party_id);
    }
    $party_list = array();
    $party_list = $obj->getTableRecords($GLOBALS['party_table'], '', '', '');
    $report_list = array();
    $report_list = $obj->GetPurchaseTaxReportList($from_date, $to_date, $party_id);

    $excel_name = "";
    $excel_name = "Purchase Tax Report (".date('d-m-Y',strtotime($from_date))." to ".date('d-m-Y',strtotime($to_date)).")";
?>
<?php include "header.php"; ?>
<!--Right Content-->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <form name="purchase_tax_report_form" method="post">
                            <div class="border card-box d-none add_update_form_content" id="add_update_form_content" ></div>
                            <div class="border card-box" id="table_records_cover">
                                <div class="card-header align-items-center">
                                    <div class="row justify-content-end p-2">   
                                        <div class="col-lg-2 col-md-4 col-6">
                                            <div class="form-group mb-2">
                                                <div class="form-label-group in-border">
                                                    <input type="date" name="filter_from_date" class="form-control shadow-none" value="<?php if(!empty($from_date)) { echo $from_date; } ?>" onchange="Javascript:getOverallReport();">
                                                    <label>From Date</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-4 col-6">
                                            <div class="form-group mb-2">
                                                <div class="form-label-group in-border">
                                                    <input type="date" name="filter_to_date" class="form-control shadow-none" value="<?php if(!empty($to_date)) { echo $to_date; } ?>" onchange="Javascript:getOverallReport();">
                                                    <label>To Date</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-6">
                                            <div class="form-group mb-2">
                                                <div class="form-label-group in-border mb-0">
                                                <select class="select2 select2-danger" name="filter_party_id" data-dropdown-css-class="select2-danger" style="width: 100%;" onChange="Javascript:getOverallReport();">
                                                                    <option value="">Select Party</option>
                                                                    <?php
                                                                    if(!empty($party_list)) {
                                                                        foreach($party_list as $data) {
                                                                            ?>
                                                                            <option value="<?php if(!empty($data['party_id'])) { echo $data['party_id']; } ?>"<?php if(!empty($party_id)){ if($party_id == $data['party_id']){ echo "selected"; } } ?>>
                                                                                <?php
                                                                                    if(!empty($data['name_mobile_city'])) {
                                                                                        $data['name_mobile_city'] = $obj->encode_decode('decrypt', $data['name_mobile_city']);
                                                                                        echo $data['name_mobile_city'];
                                                                                    }
                                                                                ?>
                                                                            </option>
                                                                                <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            <label>Select Party</label>
                                                        </div>
                                                </div>
                                            </div> 
                                        </div>
                                        <!-- <div class="col-lg-2 col-md-6 col-12 text-end"> -->
                                             <?php if(!empty($report_list)) { ?>
                                                 <div class="col-lg-2 col-md-4 col-6 py-2 text-end ms-auto"> <button class="btn btn-danger m-1" title="Download Report" style="font-size:11px;" type="button" onclick="Javascript:ExportToExcel();"> <i class="fa fa-download"></i> Export </button> 
                                                </div>
                                            <?php } ?>
                                        <!-- </div>  -->
                                        
                                        <div class="col-sm-6 col-xl-8">
                                            <input type="hidden" name="page_number" value="<?php if(!empty($page_number)) { echo $page_number; } ?>">
                                            <input type="hidden" name="page_limit" value="<?php if(!empty($page_limit)) { echo $page_limit; } ?>">
                                            <input type="hidden" name="page_title" value="<?php if(!empty($page_title)) { echo $page_title; } ?>">
                                        </div>	
                                        
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="table-responsive">
                                         <table class="table table-nowrap table-bordered nowrap text-center table-hover" id="tbl_purchase_tax_report">
                                            <thead style="background-color:#333;color:white">
                                                <tr>
                                                    <th colspan="20" class="text-center" style="border: 1px solid #dee2e6;font-weight: bold; font-size: 18px;">
                                                        Purchase Tax Report <?php if(!empty($from_date)){ echo " (" .date('d-m-Y',strtotime($from_date )) ." to ". date('d-m-Y',strtotime($to_date)).")"; }?>
                                                    </th>
                                                </tr>
                                                
                                                <tr class="bg-dark" style="vertical-align:middle!important;">
                                                    <th rowspan="3">S.No</th>
                                                    <th rowspan="3">Bill No & Date</th>
                                                    <th rowspan="3">Supplier Name</th>
                                                    <th colspan="2">Tax Details</th>
                                                    <th rowspan="3">Charges Value</th>
                                                    <th rowspan="3">Taxable Value</th>
                                                    <th colspan="3">Tax Value</th>
                                                    <th rowspan="3">Total Tax Value</th>
                                                    <th rowspan="3">Bill Value</th>
                                                </tr>
                                                <tr class="bg-dark" style="vertical-align:middle!important;">
                                                    <th colspan="2">18%</th>
                                                    <th rowspan="2">CGST</th>
                                                    <th rowspan="2">SGST</th>
                                                    <th rowspan="2">IGST</th>
                                                </tr>  
                                                <tr class="bg-dark" style="vertical-align:middle!important;">
                                                    <th>HSN & Qty</th>
                                                    <th>Value</th>
                                                </tr>  
                                            </thead>
                                            <tbody class="smallfnt">
                                                <?php
                                                    $sno = 1; $overall_value = 0; $overall_charges = 0; 
                                                    $overall_taxable_value = 0; $overall_cgst = 0; $overall_sgst = 0; $overall_igst = 0; $cancelled = 0;$overall_tax_value = 0; $overall_bill_value = 0;
                                                    if(!empty($report_list)) {
                                                        foreach($report_list as $data) {
                                                            $splitup_hsn = array(); $splitup_amount = array(); $splitup_tax = array();
                                                            $splitup_quantity = array();

                                                            if(!empty($data['hsn_code']) && $data['hsn_code'] != $GLOBALS['null_value']) {
                                                                $splitup_hsn = explode(",", $data['hsn_code']);
                                                            }
                                                            if(!empty($data['splitup_amount']) && $data['splitup_amount'] != $GLOBALS['null_value']) {
                                                                $splitup_amount = explode(",", $data['splitup_amount']);
                                                            }
                                                            if($data['splitup_tax'] != $GLOBALS['null_value']) {
                                                                $splitup_tax = explode(",", $data['splitup_tax']);
                                                            }
                                                            if(!empty($data['splitup_quantity']) && $data['splitup_quantity'] != $GLOBALS['null_value']) {
                                                                $splitup_quantity = explode(",", $data['splitup_quantity']);
                                                            }
                                                            $eighteen_value = "";
                                                            $eighteen_product = "";

                                                            if(!empty($splitup_quantity)) {
                                                                for($i=0; $i < count($splitup_quantity); $i++) {
                                                                    if(empty($splitup_hsn[$i])){
                                                                        $splitup_hsn[$i] = "";
                                                                    }
                                                                    if($splitup_tax[$i] == '18') {
                                                                        if(!empty($eighteen_product)) {
                                                                            $eighteen_product .= "<br>".$splitup_hsn[$i]." :: ".$splitup_quantity[$i];
                                                                        }
                                                                        else {
                                                                            $eighteen_product = $splitup_hsn[$i]." :: ".$splitup_quantity[$i];
                                                                        }
                                                                        if(!empty($eighteen_value)) {
                                                                            $eighteen_value .= "<br>".number_format($splitup_amount[$i], 2);
                                                                        }
                                                                        else {
                                                                            $eighteen_value = number_format($splitup_amount[$i], 2);
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                            <tr class="<?php if($data['cancelled'] == '1'){ ?> text-danger<?php }else{?> text-dark  <?php } ?>">
                                                                <th><?php echo $sno++ ?></th>
                                                                <th>
                                                                    <?php
                                                                        if(!empty($data['purchase_number']) && $data['purchase_number'] != $GLOBALS['null_value']) {
                                                                            echo $data['purchase_number'];
                                                                        }
                                                                    ?>
                                                                    <br>
                                                                    <?php
                                                                        if(!empty($data['purchase_date']) && $data['purchase_date'] != "0000-00-00") {
                                                                            echo date('d-m-Y', strtotime($data['purchase_date']));
                                                                        }
                                                                    ?>
                                                                    <br>
                                                                    <?php 
                                                                    if($data['cancelled'] == '1'){
                                                                        echo "Cancelled";
                                                                    } ?>
                                                                </th>
                                                                <th>
                                                                    <?php
                                                                        if(!empty($data['party_name_mobile_city']) && $data['party_name_mobile_city'] != $GLOBALS['null_value']) {
                                                                            echo $obj->encode_decode('decrypt', $data['party_name_mobile_city']);
                                                                        }
                                                                        
                                                                        
                                                                    ?>
                                                                </th>
                                                                <th>
                                                                    <?php echo $eighteen_product; ?>
                                                                </th>
                                                                <th>
                                                                    <?php echo $eighteen_value; ?>
                                                                </th>
                                                                <th class="text-end">
                                                                    <?php
                                                                        if(!empty($data['extra_charges_value']) && $data['extra_charges_value'] != $GLOBALS['null_value']) {
                                                                            echo number_format($data['extra_charges_value'], 2);
                                                                            if(empty($data['cancelled'])){
                                                                                $overall_charges += $data['extra_charges_value'];
                                                                            }
                                                                        }
                                                                        else {
                                                                            echo '0.00';
                                                                        }  
                                                                    ?>
                                                                </th>
                                                                <th class="text-end">
                                                                    <?php
                                                                        if(!empty($data['taxable_value']) && $data['taxable_value'] != $GLOBALS['null_value']) {
                                                                            echo number_format($data['taxable_value'], 2);
                                                                            if(empty($data['cancelled'])){
                                                                                $overall_taxable_value += $data['taxable_value'];
                                                                            }
                                                                        }
                                                                        else {
                                                                            echo '0.00';
                                                                        }  
                                                                    ?>
                                                                </th>
                                                                <th class="text-end">
                                                                    <?php
                                                                        if(!empty($data['cgst_value'])) {
                                                                            echo number_format($data['cgst_value'], 2);
                                                                            if(empty($data['cancelled'])){
                                                                                $overall_cgst += $data['cgst_value'];
                                                                            }
                                                                        }
                                                                        else {
                                                                            echo '0.00';
                                                                        }
                                                                    ?>
                                                                </th>
                                                                <th class="text-end">
                                                                    <?php
                                                                        if(!empty($data['sgst_value'])) {
                                                                            echo number_format($data['sgst_value'], 2);
                                                                            if(empty($data['cancelled'])){
                                                                                $overall_sgst += $data['sgst_value'];
                                                                            }
                                                                        }
                                                                        else {
                                                                            echo '0.00';
                                                                        }
                                                                    ?>
                                                                </th>
                                                                <th class="text-end">
                                                                    <?php
                                                                        if(!empty($data['igst_value'])) {
                                                                            echo number_format($data['igst_value'], 2);
                                                                            if(empty($data['cancelled'])){
                                                                                $overall_igst += $data['igst_value'];
                                                                            }
                                                                        }
                                                                        else {
                                                                            echo '0.00';
                                                                        }
                                                                    ?>
                                                                </th>
                                                                <th class="text-end">
                                                                    <?php
                                                                        if(!empty($data['total_tax_value'])) {
                                                                            echo number_format($data['total_tax_value'], 2);
                                                                            if(empty($data['cancelled'])){
                                                                                $overall_tax_value += $data['total_tax_value'];
                                                                            }
                                                                        }
                                                                        else {
                                                                            echo '0.00';
                                                                        }
                                                                    ?>
                                                                </th>
                                                                <th class="text-end">
                                                                    <?php
                                                                        if(!empty($data['bill_total'])) {
                                                                            echo number_format($data['bill_total'], 2);
                                                                            if(empty($data['cancelled'])){
                                                                                $overall_bill_value += $data['bill_total'];
                                                                            }
                                                                        }
                                                                        else {
                                                                            echo '0.00';
                                                                        }
                                                                    ?>
                                                                </th>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                    else {
                                                        ?>
                                                        <tr>
                                                            <th colspan="20">Sorry! No Records Found.</th>
                                                        </tr>
                                                        <?php
                                                    }
                                                ?>
                                            </tbody>
                                            <?php
                                                if(!empty($report_list)) {
                                                    ?>
                                                    <tfoot class="bg-light">
                                                        <tr>
                                                            <th colspan="5">Total</th>
                                                            <th class="text-end">
                                                                <?php
                                                                    echo number_format($overall_charges, 2);
                                                                ?>
                                                            </th>
                                                            <th class="text-end">
                                                                <?php
                                                                    echo number_format($overall_taxable_value, 2);
                                                                ?>
                                                            </th>
                                                            <th class="text-end">
                                                                <?php
                                                                    echo number_format($overall_cgst, 2);
                                                                ?>
                                                            </th>
                                                            <th class="text-end">
                                                                <?php
                                                                    echo number_format($overall_sgst, 2);
                                                                ?>
                                                            </th>
                                                            <th class="text-end">
                                                                <?php
                                                                    echo number_format($overall_igst, 2);
                                                                ?>
                                                            </th>
                                                            <th class="text-end">
                                                                <?php
                                                                    echo number_format($overall_tax_value, 2);
                                                                ?>
                                                            </th>
                                                            <th class="text-end">
                                                                <?php
                                                                    echo number_format($overall_bill_value, 2);
                                                                ?>
                                                            </th>
                                                        </tr>
                                                    </tfoot>
                                                    <?php
                                                }
                                            ?>
                                         </table>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>  
            </div>
        </div>          
<!--Right Content End-->
<script>
    $(document).ready(function(){
        $("#purchasetaxreport").addClass("active");
        table_listing_records_filter();
    });
</script>
<script type="text/javascript">
    function getOverallReport(){
        if(jQuery('form[name="purchase_tax_report_form"]').length > 0){
            jQuery('form[name="purchase_tax_report_form"]').submit();
        }
    }
</script>
<script>
    function ExportToExcel(type, fn, dl) {
        jQuery('.header').removeClass('d-none');
        
        var elt = document.getElementById('tbl_purchase_tax_report');
        var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });

        if (dl) {
            XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' });
        } else {
            XLSX.writeFile(wb, fn || ('<?php echo $excel_name; ?>.' + (type || 'xlsx')));
        }
        jQuery('.header').addClass('d-none');
    }
</script>
<?php include "footer.php"; ?>
