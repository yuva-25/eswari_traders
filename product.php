<?php 
	$page_title = "Product";
	include("include_user_check_and_files.php");
	$page_number = $GLOBALS['page_number']; $page_limit = $GLOBALS['page_limit'];

    
    $login_staff_id = "";
    if(isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id']) && !empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'])) {
        if(!empty($GLOBALS['user_type']) && $GLOBALS['user_type'] != $GLOBALS['admin_user_type']) {
            $login_staff_id = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'];
            $permission_module = $GLOBALS['product_module'];
            include("permission_check.php");
        }
    }


    $product_list = array(); $product_count = 0;
    $product_list = $obj->getTableRecords($GLOBALS['product_table'], '', '', '');
    if(!empty($product_list)){
        $product_count = count($product_list);
    }

?>
<?php include "header.php"; ?>
<script type="text/javascript" src="include/js/product_upload.js"></script>

<!--Right Content-->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="border card-box d-none add_update_form_content" id="add_update_form_content" ></div>
                            <div class="border card-box" id="table_records_cover">
                                <div class="card-header align-items-center">
                                    <div class="row justify-content-end p-2">
                                        <!-- <div class="col-lg-3 col-md-4 col-6">
                                            <div class="input-group">
                                                <input type="text" name="search_text" class="form-control" style="height:34px;" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2">
                                                <span class="input-group-text" style="height:34px;" id="basic-addon2"><i class="bi bi-search"></i></span>
                                            </div>
                                        </div> -->
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group mb-0">
                                                <div class="form-label-group in-border pb-2">
                                                    <select name="filter_product_id" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                                        <option value="">Select</option>
                                                        <?php
                                                            if(!empty($product_list)) {
                                                                foreach($product_list as $data) {
                                                                    if(!empty($data['product_id']) && $data['product_id'] != $GLOBALS['null_value']) {
                                                                        ?>
                                                                        <option value="<?php echo $data['product_id']; ?>" <?php if($product_count == '1') { ?>selected<?php } ?>>
                                                                            <?php
                                                                                if(!empty($data['product_name']) && $data['product_name'] != $GLOBALS['null_value']) {
                                                                                    echo  $obj->encode_decode('decrypt',$data['product_name']);
                                                                                }
                                                                            ?>
                                                                        </option>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                    <label>Product</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-7 col-md-4 col-6 text-end">
                                            <input type="hidden" name="upload_type" value="">
                                            <?php if($product_count > 0) { ?>
                                                <button class="btn btn-success m-1" style="font-size:11px;" type="button" id="download_products" onClick="ExcelDownload();"> <i class="fa fa-download"></i> Download </button>
                                            <?php } 
                                            if(empty($add_access_error)) { ?>
                                                <button class="btn btn-primary m-1" style="font-size:11px;" type="button" id="product_upload_excel" onClick="Javascript:ProductUploadCheck('product');"> <i class="fa fa-upload"></i> Upload </button>
                                                <button class="btn btn-dark m-1" style="font-size:11px;" type="button" id="download_template" onClick="window.open('product_template.php','_self');"> <i class="fa fa-file"></i> Template </button>
                                            <?php } 
                                        
                                                $add_access_error = "";
                                                if(!empty($login_staff_id)) {
                                                    $permission_action = $add_action;
                                                    include('permission_action.php');
                                                }
                                                if(empty($add_access_error)) { ?>
                                                   <button class="btn btn-danger" style="font-size:11px;" type="button" onclick="Javascript:ShowModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '');"> <i class="fa fa-plus-circle"></i> Add </button>
                                                     <?php 
                                                } 
                                            ?>
                                            <input type="file" name="product_excel_upload" id="product_excel_upload" style="display: none;" accept=".xls,.xlsx" onChange="Javascript:getExcelData(this, 'product');">
                                        </div>
                                         <div class="row add_update_excel_form_content_excel px-0 mx-auto"></div>
                                    </div>
                                </div>
                                <div id="table_listing_records">
                                     <input type="hidden" name="page_title" value="<?php if(!empty($page_title)) { echo $page_title; } ?>">
                                    <?php
                                    $view_access_error = ""; $permission_module = $GLOBALS['product_module']; $permission_action = $view_action;
                                    if(!empty($login_staff_id)) {
                                          include('permission_action.php');
                                    }
                                    if(empty($view_access_error)) { ?>
                                       <?php include("product_table.php"); ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>  
            </div>
        </div>          
<!--Right Content End-->
<?php include "footer.php"; ?>
<script>
    $(document).ready(function(){
        $("#product").addClass("active");
        var changes_file = "product_changes.php";
        var tableId = "product_table";
        var processing = true;
        var ordering = true;
        var searching = false;
        var orderable = false;
        var targets = [0,5];
        var columns = [
            { "data": "sno", "className": "text-center" },
            { "data": "created_date_time", "className": "text-center" },
            { "data": "product_name", "className": "text-center" },
            { "data": "unit_name", "className": "text-center" },
            { "data": "hsn_code", "className": "text-center" },
            { "data": "action", "className": "text-center" }
        ];
        CreationDatatable(changes_file, tableId, processing, ordering, searching, orderable, targets, columns);

        if(jQuery('input[name="search_text"]').length > 0) {
            jQuery('input[name="search_text"]').on('keyup', function() {
                if(jQuery('.datatable').length > 0) {
                    jQuery('.datatable').DataTable().ajax.reload();
                }
            });
        }
         if(jQuery('select[name="filter_product_id"]').length > 0) {
            jQuery('select[name="filter_product_id"]').on('change', function() {
                 if(jQuery('.datatable').length > 0) {
                    jQuery('.datatable').DataTable().ajax.reload();
                }
            });
        }
    });
    function ExcelDownload() {
        var product_id = ""; var url = ""; 
        product_id = jQuery('select[name="filter_product_id"]').val();
        url = "product_download.php?product_id="+product_id;
        window.open(url,'_self');
    }
</script>