<?php 
	$page_title = "Sales Stock";
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


    $to_date = "";$from_date = "";$filter_product_id="";$filter_party_id=""; $filter_unit_id = ""; $filter_size_id = "";
    $from_date = date('Y-m-d', strtotime('-30 days')); $to_date = date("Y-m-d"); 

    if(isset($_POST['filter_party_id'])) {
        $filter_party_id = $_POST['filter_party_id'];
    }
    if(isset($_POST['from_date'])) {
        $from_date = $_POST['from_date'];
    }
    if(isset($_POST['to_date'])) {
        $to_date = $_POST['to_date'];
    }

    if(isset($_POST['filter_product_id'])) {
        $filter_product_id = $_POST['filter_product_id'];
    }

    if(isset($_POST['filter_unit_id'])) {
        $filter_unit_id = $_POST['filter_unit_id'];
    }

    if(isset($_POST['filter_size_id'])) {
        $filter_size_id = $_POST['filter_size_id'];
    }

    if(!empty($filter_product_id)){
        $product_unit_id = ""; $product_size_id = "";
        $product_unit_id = $obj->getTableColumnValue($GLOBALS['product_table'], 'product_id',$filter_product_id, 'unit_id');
        $product_size_id = $obj->getTableColumnValue($GLOBALS['product_table'], 'product_id',$filter_product_id, 'size_id');

        $filter_unit_id = $product_unit_id;
        $filter_size_id = $product_size_id;
    }

    $excel_name = "";
    $excel_name = "Sales Report( ".date('d-m-Y',strtotime($from_date ))." to ".date('d-m-Y',strtotime($to_date )).")";

    $party_list = array();
    $party_list = $obj->getTableRecords($GLOBALS['party_table'], '', '', '');

    $product_list = array();
    $product_list = $obj->getTableRecords($GLOBALS['product_table'], '', '', '');

    $size_list = array();
    $size_list = $obj->getTableRecords($GLOBALS['size_table'], '', '', '');

    $unit_list = array();
    $unit_list = $obj->getTableRecords($GLOBALS['unit_table'], '', '', '');

    $total_records_list = array();
    if(empty($filter_product_id)) {
        $total_records_list = $obj->getSalesStockReportList($filter_party_id,$filter_product_id);
    }
    else if(!empty($filter_product_id)) {
        $total_records_list = $obj->getSalesDetailStockReportList($from_date, $to_date,$filter_party_id,$filter_product_id,$filter_size_id,$filter_unit_id);
    }
    // print_r($total_records_list);

?>
<?php include "header.php"; ?>
<!--Right Content-->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="border card-box d-none add_update_form_content" id="add_update_form_content" ></div>
                        <div class="border card-box" id="table_records_cover">
                            <form name="sales_stock_report_form" method="post">
                                <div class="card-header align-items-center">
                                    <div class="row  p-2">
                                        <?php if(!empty($filter_product_id)){ ?>   
                                            <div class="col-lg-2 col-md-4 col-6">
                                                <div class="form-group mb-2">
                                                    <div class="form-label-group in-border">
                                                        <input type="date" id="from_date" name="from_date" class="form-control shadow-none" placeholder="" value="<?php if(!empty($from_date)) { echo $from_date; } ?>"  max="<?php if(!empty($current_date)) { echo $current_date; } ?>" onchange = "Javascript:getOverallReport();">
                                                            <label>From Date</label>
                                                        <label>From Date</label>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php if(!empty($filter_product_id)){ ?>
                                            <div class="col-lg-2 col-md-4 col-6">
                                                <div class="form-group mb-2">
                                                    <div class="form-label-group in-border">
                                                        <input type="date" id="to_date" name="to_date" class="form-control shadow-none" placeholder="" value="<?php if(!empty($to_date)) { echo $to_date; } ?>"  max="<?php if(!empty($current_date)) { echo $current_date; } ?>" onchange = "Javascript:getOverallReport();">
                                                        <label>To Date</label>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="col-lg-2 col-md-4 col-6">
                                            <div class="form-group mb-2">
                                                <div class="form-label-group in-border mb-0">
                                                    <select class="select2 select2-danger" name="filter_party_id" data-dropdown-css-class="select2-danger" style="width: 100%;" onChange="Javascript:getOverallReport();">
                                                                <option value="">Select Party</option>
                                                                <?php
                                                                if(!empty($party_list)) {
                                                                    foreach($party_list as $data) {
                                                                        ?>
                                                                        <option value="<?php if(!empty($data['party_id'])) { echo $data['party_id']; } ?>"<?php if(!empty($filter_party_id)){ if($filter_party_id == $data['party_id']){ echo "selected"; } } ?>>
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
                                        <div class="col-lg-2 col-md-4 col-6">
                                            <div class="form-group mb-2">
                                                <div class="form-label-group in-border mb-0">
                                                    <select class="select2 select2-danger" name="filter_product_id" data-dropdown-css-class="select2-danger" style="width: 100%;" onChange="Javascript:getOverallReport();">
                                                                <option value="">Select Product</option>
                                                                <?php
                                                                if(!empty($product_list)) {
                                                                    foreach($product_list as $data) {
                                                                        ?>
                                                                        <option value="<?php if(!empty($data['product_id'])) { echo $data['product_id']; } ?>"<?php if(!empty($filter_product_id)){ if($filter_product_id == $data['product_id']){ echo "selected"; } } ?>>
                                                                            <?php
                                                                                if(!empty($data['product_name'])) {
                                                                                    $data['product_name'] = $obj->encode_decode('decrypt', $data['product_name']);
                                                                                    echo $data['product_name'];
                                                                                }
                                                                            ?>
                                                                        </option>
                                                                            <?php
                                                                    }
                                                                }
                                                                ?>
                                                        </select>
                                                        <label>Select Product</label>
                                                </div>
                                            </div> 
                                        </div>

                                        <?php if(!empty($filter_product_id)){ ?>

                                            <div class="col-lg-2 col-md-4 col-6">
                                                <div class="form-group mb-2">
                                                    <div class="form-label-group in-border mb-0">
                                                        <select class="select2 select2-danger" name="filter_unit_id" data-dropdown-css-class="select2-danger" style="width: 100%;" onChange="Javascript:getOverallReport();">
                                                                    <option value="">Select Unit</option>
                                                                    <?php
                                                                    if(!empty($unit_list)) {
                                                                        foreach($unit_list as $data) {
                                                                            ?>
                                                                            <option value="<?php if(!empty($data['unit_id'])) { echo $data['unit_id']; } ?>"<?php if(!empty($filter_unit_id)){ if($filter_unit_id == $data['unit_id']){ echo "selected"; } } ?>>
                                                                                <?php
                                                                                    if(!empty($data['unit_name'])) {
                                                                                        $data['unit_name'] = $obj->encode_decode('decrypt', $data['unit_name']);
                                                                                        echo $data['unit_name'];
                                                                                    }
                                                                                ?>
                                                                            </option>
                                                                                <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                            </select>
                                                            <label>Select Unit</label>
                                                    </div>
                                                </div> 
                                            </div>

                                            <div class="col-lg-2 col-md-4 col-6">
                                                <div class="form-group mb-2">
                                                    <div class="form-label-group in-border mb-0">
                                                        <select class="select2 select2-danger" name="filter_size_id" data-dropdown-css-class="select2-danger" style="width: 100%;" onChange="Javascript:getOverallReport();">
                                                                    <option value="">Select Size</option>
                                                                    <?php
                                                                    if(!empty($size_list)) {
                                                                        foreach($size_list as $data) {
                                                                            ?>
                                                                            <option value="<?php if(!empty($data['size_id'])) { echo $data['size_id']; } ?>"<?php if(!empty($filter_size_id)){ if($filter_size_id == $data['size_id']){ echo "selected"; } } ?>>
                                                                                <?php
                                                                                    if(!empty($data['size_name'])) {
                                                                                        $data['size_name'] = $obj->encode_decode('decrypt', $data['size_name']);
                                                                                        echo $data['size_name'];
                                                                                    }
                                                                                ?>
                                                                            </option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                            </select>
                                                            <label>Select Size</label>
                                                    </div>
                                                </div> 
                                            </div>
                                        <?php } ?>

                                        <div class="col-lg-2 col-md-6 col-12 text-end">
                                            <button class="btn btn-success m-1 float-end" style="font-size:11px;" type="button" onClick="window.open('reports/rpt_sales_stock_report_a4.php?filter_party_id=<?php echo $filter_party_id; ?>&from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>&filter_unit_id=<?php echo $filter_unit_id;?>&filter_size_id=<?php echo $filter_size_id;?>&filter_product_id=<?php echo $filter_product_id;?>')"> <i class="fa fa-print"></i> Print </button>
                                            <button class="btn btn-danger m-1" style="font-size:11px;" type="button" onclick="Javascript:ExportToExcel();"> <i class="fa fa-download"></i> Export </button>  
                                        </div> 
                                        <form name="table_listing_form" method="post">
                                            <div class="col-sm-6 col-xl-8">
                                                <input type="hidden" name="page_number" value="<?php if(!empty($page_number)) { echo $page_number; } ?>">
                                                <input type="hidden" name="page_limit" value="<?php if(!empty($page_limit)) { echo $page_limit; } ?>">
                                                <input type="hidden" name="page_title" value="<?php if(!empty($page_title)) { echo $page_title; } ?>">
                                            </div>	
                                        </form>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div class="table-responsive">
                                    <?php if(empty($filter_product_id)) { ?>
                                        <table class="table table-bordered nowrap cursor text-center smallfnt" id="tbl_sales_stock_report" >
                                             <thead class="bg-light">
                                                <tr>
                                                    <th colspan="3" class="text-center" style="border: 1px solid #dee2e6;font-weight: bold; font-size: 18px;">
                                                        Sales Stock Report
                                                    </th>
                                                </tr>
                                                <tr class = "fs-6">
                                                    <th>S.No</th>
                                                    <th>Product Name</th>
                                                    <th>Sales Stock</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $total_stock = 0;
                                                    if(!empty($total_records_list)) { 
                                                        foreach($total_records_list as $key => $data) { 
                                                            $inward_unit = 0; $outward_unit = 0;  
                                                            $outward_unit = $obj->getOutwardQty('', '','',$data['product_id'],$filter_party_id); ?>
                                                         <tr>
                                                            <th class = "fs-6">
                                                                <?php echo $key+1; ?>
                                                            </th>

                                                            <th onclick="Javascript:ShowSalesStockProduct('<?php if(!empty($data['product_id']) && $data['product_id'] != $GLOBALS['null_value']) { echo $data['product_id']; } ?>');" style="cursor:pointer!important;" class="fw-semibold fs-6">
                                                                <?php
                                                                  if(!empty($data['product_id'])){
                                                                    $product_name = "";
                                                                    $product_name = $obj->getTableColumnValue($GLOBALS['product_table'], 'product_id', $data['product_id'], 'product_name');
                                                                    echo $obj->encode_decode('decrypt', $product_name);
                                                                  }else{
                                                                    echo "-";
                                                                  }
                                                                ?>
                                                            </th>
                                                            <th class = "fs-6">
                                                                <?php
                                                                    
                                                                    if(!empty($outward_unit)){
                                                                        echo $outward_unit." ";
                                                                        $total_stock += $outward_unit;
                                                                    } 
                                                                ?>
                                                            </th>

                                                         </tr>

                                                        <?php }
                                                    }else {
                                                        ?>
                                                        <tr>
                                                            <td colspan="3" class="text-center">Sorry! No records found</td>
                                                        </tr>
                                                        <?php 
                                                    } 
                                                ?>
                                                <tr class = "fs-6">
                                                    <th colspan="2" class="text-end">Total</th>
                                                    <th><?php echo $total_stock; ?></th>
                                                </tr>
                                            </tbody>
                                        </table> 
                                    <?php } else{ ?>  
                                         <table class="table table-bordered nowrap text-center smallfnt" id="tbl_sales_stock_report">
                                            <thead style="font-size:13px!important;font-weight:bold!important;">
                                                <tr style="vertical-align:middle!important;">
                                                    <th colspan="8" style="font-size:18px; ">
                                                        <?php
                                                            $inward_unit = 0; $outward_unit = 0; $inward_sub_unit = 0; $outward_sub_unit = 0;
                                                            $outward_unit = $obj->getOutwardQty('', $filter_unit_id,$filter_size_id,$filter_product_id,$filter_party_id);
                                                            $display_outward_total = 0;
                                                            $display_outward_total += $outward_unit;
                                                            if(!empty($filter_product_id)){
                                                                $unit_name = ""; $product_name = "";
                                                                $unit_name = $obj->getTableColumnValue($GLOBALS['product_table'], 'product_id',$filter_product_id, 'unit_name');
                                                                $unit_name = $obj->encode_decode('decrypt', $unit_name);
                                                                $product_name = $obj->getTableColumnValue($GLOBALS['product_table'], 'product_id',$filter_product_id, 'product_name');
                                                                $product_name = $obj->encode_decode('decrypt', $product_name);
                                                            }
                                                        ?>
                                                        <?php  if(empty($stock_type)) {  ?>
                                                        <span class="ms-auto fs-6"  style="font-size:13px;"><?php if(!empty($product_name)){echo $product_name." "; } ?>(Stock : <?php echo $display_outward_total." ".$unit_name; ?>)</span>
                                                        <?php  }  ?>
                                                    </th>
                                                </tr>
                                                <tr class="bg-success fs-6" style="vertical-align:middle!important;">
                                                    <th>#</th>
                                                    <th>Date</th>
                                                    <th>Type</th>
                                                    <th>Party</th>
                                                    <th>Unit</th>
                                                    <th>Size</th>
                                                    <th>Outward Unit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $total_inward = 0; $total_outward = 0;
                                                    if(!empty($total_records_list)) { 
                                                        foreach($total_records_list as $key => $data) { ?>
                                                            <tr>
                                                                <th class = "fs-6"><?php echo $key+1; ?></th>
                                                                <th class = "fs-6">
                                                                    <?php 
                                                                        if(!empty($data['stock_date'])) {
                                                                            echo date('d-m-Y', strtotime($data['stock_date']));
                                                                        }
                                                                    ?>
                                                                </th>
                                                                <th class = "fs-6">
                                                                    <?php 
                                                                        if(!empty($data['stock_type'])) {
                                                                            echo $data['stock_type'];
                                                                        }
                                                                    ?>
                                                                </th>
                                                                <th class = "fs-6">
                                                                    <?php
                                                                        if(!empty($data['party_id']) && $data['party_id'] != $GLOBALS['null_value']) {
                                                                            $party_name = ""; $product_name = "";
                                                                            $party_name = $obj->getTableColumnValue($GLOBALS['party_table'], 'party_id',$data['party_id'], 'name_mobile_city');
                                                                            echo $obj->encode_decode('decrypt',$party_name); 
                                                                        }
                                                                        else {
                                                                            echo '-';
                                                                        }
                                                                    ?>
                                                                </th>
                                                                 <th class = "fs-6">
                                                                    <?php
                                                                        if(!empty($data['unit_name']) && $data['unit_name'] != $GLOBALS['null_value']) {
                                                                            echo $obj->encode_decode('decrypt',$data['unit_name']); 
                                                                        }
                                                                        else {
                                                                            echo '-';
                                                                        }
                                                                    ?>
                                                                </th>
                                                                <th class = "fs-6">
                                                                    <?php
                                                                        if(!empty($data['size_name']) && $data['size_name'] != $GLOBALS['null_value']) {
                                                                            echo $obj->encode_decode('decrypt',$data['size_name']); 
                                                                        }
                                                                        else {
                                                                            echo '-';
                                                                        }
                                                                    ?>
                                                                </th>
                                                               
                                                                <th class = "fs-6">
                                                                    <?php
                                                                        if($data['outward_unit'] != $GLOBALS['null_value']) {
                                                                            $total_outward += $data['outward_unit'];
                                                                            echo $data['outward_unit'];
                                                                        }
                                                                    ?>
                                                                </th>
                                                            </tr>
                                                            <?php 
                                                        } 
                                                        ?>
                                                        <tr>
                                                            <th colspan="6" class="text-end fs-6" style="text-align: end;">Total &ensp;</th>
                                                            <th class = "fs-6"><?php echo $total_outward; ?></th>
                                                        </tr>
                                                        
                                                        <?php
                                                    }  
                                                    else {
                                                            ?>
                                                        <tr>
                                                            <td colspan="10" class="text-center">Sorry! No records found</td>
                                                        </tr>
                                                        <?php 
                                                    } 
                                                ?>
                                            </tbody>
                                        </table>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>          
<!--Right Content End-->
<script>
    $(document).ready(function(){
        $("#salesstock").addClass("active");
        table_listing_records_filter();
    });
</script>
<?php include "footer.php"; ?>

<script type="text/javascript">
    function getOverallReport(){
        if(jQuery('form[name="sales_stock_report_form"]').length > 0){
            jQuery('form[name="sales_stock_report_form"]').submit();

        }  
    }
    function ShowSalesStockProduct(product_id) {
        if(product_id !=''){
            if(jQuery('select[name="filter_product_id"]').length > 0) {
                jQuery('select[name="filter_product_id"]').val(product_id);
            }   
        }
        getOverallReport();
    }
</script>


<script>
    function ExportToExcel(type, fn, dl) {
        var elt = document.getElementById('tbl_sales_stock_report');
        var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
        return dl ?
        XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
        XLSX.writeFile(wb, fn || ('sales_stock_report.' + (type || 'xlsx')));
        window.open("sales_stock.php","_self");
    }
</script>

