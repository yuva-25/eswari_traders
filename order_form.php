<?php 
	$page_title = "Order Form";
	include("include_user_check_and_files.php");
	$page_number = $GLOBALS['page_number']; $page_limit = $GLOBALS['page_limit'];
   $login_staff_id = "";
    if(isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id']) && !empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'])) {
        if(!empty($GLOBALS['user_type']) && $GLOBALS['user_type'] != $GLOBALS['admin_user_type']) {
            $login_staff_id = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'];
            $permission_module = $GLOBALS['order_form_module'];
            include("permission_check.php");
        }
    }
    $from_date = date('Y-m-d', strtotime('-30 days')); $to_date = date('Y-m-d');

      $party_list = array();
    $party_list = $obj->getTableRecords($GLOBALS['party_table'],'','','');
    $party_count = 0;
    if(!empty($party_list)) {
        $party_count = count($party_list);
    }
?>
<?php include "header.php"; ?>
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
                                     <div class="col-lg-2 col-md-4 col-6">
                                        <div class="form-group mb-0">
                                            <div class="form-label-group in-border pb-2">
                                                <input type="date" name="filter_from_date" class="form-control shadow-none" value="<?php if(!empty($from_date)) { echo $from_date; } ?>" onchange="Javascript:checkDateCheck();" placeholder="">
                                                <label>From Date</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-6">
                                        <div class="form-group mb-0">
                                            <div class="form-label-group in-border pb-2">
                                                <input type="date" name="filter_to_date" class="form-control shadow-none" value="<?php if(!empty($to_date)) { echo $to_date; } ?>" onchange="Javascript:checkDateCheck();" placeholder="">
                                                <label>To Date</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group mb-0">
                                            <div class="form-label-group in-border pb-2">
                                                <select name="filter_party_id" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                                    <option value="">Select</option>
                                                    <?php
                                                        if(!empty($party_list)) {
                                                            foreach($party_list as $data) {
                                                                if(!empty($data['party_id']) && $data['party_id'] != $GLOBALS['null_value']) {
                                                                    ?>
                                                                    <option value="<?php echo $data['party_id']; ?>" >
                                                                        <?php
                                                                            if(!empty($data['name_mobile_city']) && $data['name_mobile_city'] != $GLOBALS['null_value']) {
                                                                                echo  $obj->encode_decode('decrypt',$data['name_mobile_city']);
                                                                            }
                                                                        ?>
                                                                    </option>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                                <label>Sales Party</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-6">
                                        <div class="input-group">
                                            <input type="text" name="search_text" class="form-control" style="height:34px;" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2">
                                            <span class="input-group-text" style="height:34px;" id="basic-addon2"><i class="bi bi-search"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-6 text-end">
                                               <?php 
                                        $add_access_error = ""; $permission_module = $GLOBALS['order_form_module']; $permission_action = $add_action;
                                        if(!empty($login_role_id)) {
                                            include("permission_action.php");
                                        }
                                        if(empty($add_access_error)) { ?>
                                            <button class="btn btn-danger m-1 " style="font-size:11px;" type="button" onclick="Javascript:ShowModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '');"> <i class="fa fa-plus-circle"></i> Add </button>   
                                        <?php } ?>
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
                            <div id="table_listing_records">
                                <?php 
                                $view_access_error = ""; $permission_module = $GLOBALS['order_form_module']; $permission_action = $view_action;
                                if(!empty($login_role_id)) {
                                    include("permission_action.php");
                                }
                                if(empty($view_access_error)) { ?>
                                    <input type="hidden" name="page_title" value="<?php if(!empty($page_title)) { echo $page_title; } ?>">
                                    <div class="new">
                                        <ul class="new nav nav-pills my-3 justify-content-center" id="pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="pills-active-tab" data-bs-toggle="pill" data-bs-target="#pills-active" type="button" role="tab" aria-controls="pills-active" aria-selected="true">Active Bill</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="pills-cancel-tab" data-bs-toggle="pill" data-bs-target="#pills-cancel" type="button" role="tab" aria-controls="pills-cancel" aria-selected="false">Cancelled Bill</button>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="pills-tabContent">
                                            <div class="tab-pane fade show active" id="pills-active" role="tabpanel" aria-labelledby="pills-active-tab" tabindex="0">
                                                <?php 
                                                    $cancelled = 0;
                                                    $table_id = "table-active";
                                                    include("order_form_table.php"); 
                                                ?>
                                            </div>
                                            <div class="tab-pane fade" id="pills-cancel" role="tabpanel" aria-labelledby="pills-cancel-tab" tabindex="0">
                                                <?php 
                                                    $cancelled = 1;
                                                    $table_id = "table-cancel";
                                                    include("order_form_table.php"); 
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
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
        $("#orderform").addClass("active");
        // table_listing_records_filter();
    });
</script>

<script>
    jQuery(document).ready(function(){
        jQuery("#order_form").addClass("active");
         var tableId = "";
        if(jQuery('.tab-pane.active .datatable').length > 0) {
            var tableId = jQuery('.tab-pane.active .datatable').attr('id');
        }

        var changes_file = "order_form_changes.php";
        var processing = true;
        var ordering = true;
        var searching = false;
        var orderable = false;
        var targets = [0,6];
        var columns = [
            { "data": "sno", "className": "text-center" },
            { "data": "created_date_time", "className": "text-center" },
            { "data": "updated_date_time", "className": "text-center" },
            { "data": "bill_date", "className": "text-center" },
            { "data": "entry_number", "className": "text-center" },
            { "data": "party_mobile_number", "className": "text-center" },
            { "data": "total", "className": "text-center" },
            { "data": "action", "className": "text-center" }
        ];
        CreationDatatable(changes_file, tableId, processing, ordering, searching, orderable, targets, columns);
        
        if(jQuery('button[data-bs-toggle="pill"]').length > 0) {
            jQuery('button[data-bs-toggle="pill"]').on('shown.bs.tab', function (e) {
                var targetPaneId = jQuery(e.target).attr('data-bs-target');
                var tableId = jQuery(targetPaneId).find('.datatable').attr('id');
                CreationDatatable(changes_file, tableId, processing, ordering, searching, orderable, targets, columns);
            });
        }
       
        if(jQuery('input[name="search_text"]').length > 0) {
            jQuery('input[name="search_text"]').on('keyup', function() {
                if(jQuery('.tab-pane.active .datatable').length > 0) {
                    jQuery('.tab-pane.active .datatable').DataTable().ajax.reload();
                }
            });
        }
        if(jQuery('input[name="filter_from_date"]').length > 0) {
            jQuery('input[name="filter_from_date"]').on('change', function() {
                if(jQuery('.tab-pane.active .datatable').length > 0) {
                    jQuery('.tab-pane.active .datatable').DataTable().ajax.reload();
                }
            });
        }
        if(jQuery('input[name="filter_to_date"]').length > 0) {
            jQuery('input[name="filter_to_date"]').on('change', function() {
                if(jQuery('.tab-pane.active .datatable').length > 0) {
                    jQuery('.tab-pane.active .datatable').DataTable().ajax.reload();
                }
            });
        }
        if(jQuery('select[name="filter_party_id"]').length > 0) {
            jQuery('select[name="filter_party_id"]').on('change', function() {
                if(jQuery('.tab-pane.active .datatable').length > 0) {
                    jQuery('.tab-pane.active .datatable').DataTable().ajax.reload();
                }
            });
        }

    });
</script>
<?php include "footer.php"; ?>
