<?php 
	$page_title = "Size";
	include("include_user_check_and_files.php");
	$page_number = $GLOBALS['page_number']; $page_limit = $GLOBALS['page_limit'];

    $login_staff_id = "";
    if(isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id']) && !empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'])) {
        if(!empty($GLOBALS['user_type']) && $GLOBALS['user_type'] != $GLOBALS['admin_user_type']) {
            $login_staff_id = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'];
            $permission_module = $GLOBALS['size_module'];
            include("permission_check.php");
        }
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
                                        <div class="col-lg-3 col-md-4 col-6">
                                            <div class="input-group">
                                                <input type="text" name = "search_text" class="form-control" style="height:34px;" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2">
                                                <span class="input-group-text" style="height:34px;" id="basic-addon2"><i class="bi bi-search"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-lg-1 col-md-2 col-4">
                                            <?php
                                                $add_access_error = "";
                                                if(!empty($login_staff_id)) {
                                                    $permission_action = $add_action;
                                                    include('permission_action.php');
                                                }
                                                if(empty($add_access_error)) { ?>
                                                    <button class="btn btn-danger float-end" style="font-size:11px;" type="button" onclick="Javascript:ShowModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '');"> <i class="fa fa-plus-circle"></i> Add </button>
                                                     <?php 
                                                } 
                                            ?>
                                    </div>
                                </div>
                                <div id="table_listing_records">
                                    <input type="hidden" name="page_title" value="<?php if(!empty($page_title)) { echo $page_title; } ?>">
                                    <?php
                                    $view_access_error = ""; $permission_module = $GLOBALS['size_module']; $permission_action = $view_action;
                                    if(!empty($login_staff_id)) {
                                          include('permission_action.php');
                                    }
                                    if(empty($view_access_error)) { ?>
                                       <?php include("size_table.php"); ?>
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
        $("#size").addClass("active");
        var changes_file = "size_changes.php";
        var tableId = "size_table";
        var processing = true;
        var ordering = true;
        var searching = false;
        var orderable = false;
        var targets = [0,4];
        var columns = [
            { "data": "sno", "className": "text-center" },
            { "data": "created_date_time", "className": "text-center" },
            { "data": "updated_date_time", "className": "text-center" },
            { "data": "size_name", "className": "text-center" },
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
    });
</script>