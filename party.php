<?php 
	$page_title = "Party";
	include("include_user_check_and_files.php");
	$page_number = $GLOBALS['page_number']; $page_limit = $GLOBALS['page_limit'];

    $login_staff_id = "";
    if(isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id']) && !empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'])) {
        if(!empty($GLOBALS['user_type']) && $GLOBALS['user_type'] != $GLOBALS['admin_user_type']) {
            $login_staff_id = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'];
            $permission_module = $GLOBALS['party_module'];
            include('permission_check.php');
        }
    }

    $party_list = array(); $party_count = 0;
    $party_list = $obj->getTableRecords($GLOBALS['party_table'], '', '', '');
    if(!empty($party_list)){
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
                                        <!-- <div class="col-lg-3 col-md-4 col-6">
                                            <div class="input-group">
                                                <input type="text" name = "search_text" class="form-control" style="height:34px;" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2">
                                                <span class="input-group-text" style="height:34px;" id="basic-addon2"><i class="bi bi-search"></i></span>
                                            </div>
                                        </div> -->
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
                                                                        <option value="<?php echo $data['party_id']; ?>" <?php if($party_count == '1') { ?>selected<?php } ?>>
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
                                                    <label>Party</label>
                                                </div>
                                            </div>
                                        </div>
                                         <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group mb-0">
                                                <div class="form-label-group in-border pb-2">
                                                    <select name="filter_party_type" class="select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                                        <option value="">Select</option>
                                                        <option value="1">Purchase</option>
                                                        <option value="2">Sales</option>
                                                        <option value="3">Both</option>
                                                    </select>
                                                    <label>Type</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-4 col-6 text-end">
                                            <!-- <button class="btn btn-success m-1" style="font-size:11px;" type="button" onclick="Javascript:ShowModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '');"> <i class="fa fa-print"></i> Print </button> -->
                                            <?php
                                            $add_access_error = "";
                                            if(!empty($login_staff_id)) {
                                                $permission_action = $add_action;
                                                include('permission_action.php');
                                            }
                                            if(empty($add_access_error)) { ?>
                                                      <button class="btn btn-danger" style="font-size:11px;" type="button" onclick="Javascript:ShowModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '');"> <i class="fa fa-plus-circle"></i> Add </button>
                                              
                                                <?php 
                                            } ?>
                                        </div>
                                        <form name="table_listing_form" method="post">
                                             <input type="hidden" name="page_title" value="<?php if(!empty($page_title)) { echo $page_title; } ?>">
                                            <?php
                                            $view_access_error = ""; $permission_module = $GLOBALS['party_module']; $permission_action = $view_action;
                                            if(!empty($login_staff_id)) {
                                                include('permission_action.php');
                                            }
                                            if(empty($view_access_error)) { ?>
                                            <?php include("party_table.php"); ?>
                                            <?php } ?>
                                           
                                        </form>
                                    </div>
                                </div>
                                <div id="table_listing_records"></div>
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
        $("#party").addClass("active");
        var changes_file = "party_changes.php";
        var tableId = "party_table";
        var processing = true;
        var ordering = true;
        var searching = false;
        var orderable = false;
        var targets = [0,5];
        var columns = [
            { "data": "sno", "className": "text-center" },
            { "data": "created_date_time", "className": "text-center" },
            { "data": "party_type", "className": "text-center" },
            { "data": "party_name", "className": "text-center" },
            { "data": "mobile_number", "className": "text-center" },
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

        if(jQuery('select[name="filter_party_id"]').length > 0) {
            jQuery('select[name="filter_party_id"]').on('change', function() {
                if(jQuery('.datatable').length > 0) {
                    jQuery('.datatable').DataTable().ajax.reload();
                }
            });
        }

        if(jQuery('select[name="filter_party_type"]').length > 0) {
            jQuery('select[name="filter_party_type"]').on('change', function() {
                if(jQuery('.datatable').length > 0) {
                    jQuery('.datatable').DataTable().ajax.reload();
                }
            });
        }

    });
</script>
