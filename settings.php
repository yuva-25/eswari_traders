<?php 
	$page_title = "Settings";
	include("include_user_check_and_files.php");
	$page_number = $GLOBALS['page_number']; $page_limit = $GLOBALS['page_limit'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title> <?php if(!empty($project_title)) { echo $project_title; } ?> - <?php if(!empty($page_title)) { echo $page_title; } ?> </title>
	<?php 
	include "link_style_script.php"; ?>
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
                        <div class="border card-box">
                            <div class="card-header align-items-center">
                                <!-- <div class="row p-2">
                                    <div class="col-lg-8 col-md-8 col-8 align-self-center">
                                        <div class="h5">Company Details</div>
                                    </div>
                                </div> -->
                            </div>
                            <!-- <table class="table nowrap cursor text-center smallfnt">
                                <thead class="bg-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Company Name</th>
                                        <th>Company Number</th>
                                        <th>City</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>01</td>
                                        <td>Oviya Crackers</td>
                                        <td>9087656745</td>
                                        <td>Madurai</td>
                                        <td>
                                            <a class="pe-2" href="#" onclick="Javascript:ShowModalContent();"><i class="fa fa-pencil"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>  -->
                        </div>
                        <div class="border card-box mt-4" id="table_records_cover">
                            <div class="card-header align-items-center">
                                <div class="row p-2">
                                    <div class="col-lg-8 col-md-8 col-8 align-self-center">
                                        <div class="h5">Settings</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row p-3">
                                <input type="hidden" name="edit_id" value="<?php if(!empty($show_user_id)) { echo $show_user_id; } ?>">
                                <div class="col-lg-3 col-md-3 col-12">
                                    <div class="form-group mb-2">
                                        <div class="form-label-group in-border">
                                            <input type="time" id="name" name="name" class="form-control shadow-none" placeholder="" required>
                                            <label>Morning In</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-12">
                                    <div class="form-group mb-2">
                                        <div class="form-label-group in-border">
                                            <input type="time" id="name" name="name" class="form-control shadow-none" placeholder="" required>
                                            <label>Morning Out</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-12">
                                    <div class="form-group mb-2">
                                        <div class="form-label-group in-border">
                                            <input type="time" id="name" name="name" class="form-control shadow-none" placeholder="" required>
                                            <label>Evening In</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-12">
                                    <div class="form-group mb-2">
                                        <div class="form-label-group in-border">
                                            <input type="time" id="name" name="name" class="form-control shadow-none" placeholder="" required>
                                            <label>Evening Out</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 pt-3 text-center">
                                    <button class="btn btn-dark" type="button">
                                        Submit
                                    </button>
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
        $("#company").addClass("active");
        table_listing_records_filter();
    });
</script>