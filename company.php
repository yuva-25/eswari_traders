<?php 
	$page_title = "Company";
	include("include_user_check_and_files.php");
	$page_number = $GLOBALS['page_number']; $page_limit = $GLOBALS['page_limit'];
    if(isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type']) && !empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type'])) {
        if($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type'] != $GLOBALS['admin_user_type']) {
            header("Location:index.php");
        }
    }
    $company_count = 0;
    $company_list = array();
    $company_list = $obj->getTableRecords($GLOBALS['company_table'], '', '', '');
    if(!empty($company_list)) {
        $company_count = count($company_list);
    }
?>
<?php include "header.php"; ?>
<!--Right Content-->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 pt-2">
                        <div class="card">
                            <div class="border card-box d-none add_update_form_content pt-2" id="add_update_form_content" ></div>
                            <div class="border card-box" id="table_records_cover">
                                <div class="card-header align-items-center">
                                    <div class="row justify-content-end p-2">
                                        <!-- <div class="col-lg-3 col-md-4 col-8">
                                            <div class="input-group">
                                                <input type="text" name="search_text" class="form-control" style="height:34px;" placeholder="Search By Company Name" aria-label="Search" aria-describedby="basic-addon2" onkeyup="Javascript:table_listing_records_filter();">
                                                <span class="input-group-text" style="height:34px;" id="basic-addon2"><i class="bi bi-search"></i></span>
                                            </div>
                                        </div> -->
                                        <div class="col-lg-3 col-md-2 col-4">
                                            <!-- <button class="btn btn-danger float-end" style="font-size:11px;" type="button" onclick="Javascript:ShowModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '');"> <i class="fa fa-plus-circle"></i> Add </button> -->
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-4">
                                            <?php if($company_count < $GLOBALS['max_company_count']) { ?>
                                                <button class="btn btn-danger float-end" style="font-size:11px;" type="button" onclick="Javascript:ShowModalContent('<?php if(!empty($page_title)) { echo $page_title; } ?>', '');"> <i class="fa fa-plus-circle"></i> Add </button>
                                            <?php } else { ?>
                                                <div class="new_smallfnt">Max <?php echo $GLOBALS['max_company_count']; ?> Company Allowed</div>
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
                                <div id="table_listing_records"></div>
                            </div>
                        </div>
                    </div>    
                </div>  
            </div>
        </div>          
<!--Right Content End-->
<script>
    $(document).ready(function(){
        $("#company").addClass("active");
        table_listing_records_filter();
    });
</script>
<?php include "footer.php"; ?>
