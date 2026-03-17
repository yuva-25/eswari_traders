<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    
      
    include("include/label.php");
    include("include/functions.php");
    include("include/validation.php");
    
    // $obj = new billing();
    // $valid = new validation();

    $obj = new Functions($basic_obj, $creation_obj, $billing_obj, $report_obj, $payment_obj);
    $valid = new validation();

    $project_title = "";
    $project_title = $obj->getProjectTitle();

    $view_action = 'V'; $add_action = 'A';
    $edit_action =  'E'; $delete_action = 'D';
    
    $_POST = sanitizePost(); $_GET  = sanitizeGet(); $_REQUEST = sanitizeRequest();
?>