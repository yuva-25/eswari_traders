<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
<head>
    <meta charset="utf-8">
    <title>Eswari Traders</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="js/layout.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="include/select2/css/select2.min.css">
    <link rel="stylesheet" href="include/select2/css/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="include/css/modify.css">
    <link rel="stylesheet" href="css/app.min.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/popper.min.js"></script>
    <script src="js/jquery.min.js"></script>
</head>
<body>
<div id="layout-wrapper">
    <header id="page-topbar">
        <div class="layout-width">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box horizontal-logo">
                        <a href="index.html" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="images/logo.webp" alt="Eswari Traders" height="60">
                            </span>
                            <span class="logo-lg">
                                <img src="images/logo.webp" alt="Eswari Traders" height="70">
                            </span>
                        </a>
                        <a href="index.html" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="images/logo.webp" alt="Eswari Traders" height="60">
                            </span>
                            <span class="logo-lg">
                                 <img src="images/logo.webp" alt="Eswari Traders" height="70">
                            </span>
                        </a>
                    </div>
                    <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                        <span class="hamburger-icon">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>
                    <!-- App Search-->
                    <!-- <form class="app-search d-none d-md-block">
                        <div class="position-relative">
                            <input type="text" class="form-control" placeholder="Search..." autocomplete="off" id="search-options" value="">
                            <span class="bi bi-search search-widget-icon"></span>
                            <span class="bi bi-x-circle search-widget-icon search-widget-icon-close d-none" id="search-close-options"></span>
                        </div>
                        <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown">
                            <div data-simplebar style="max-height: 320px;">
                                <div class="dropdown-header">
                                    <h6 class="text-overflow text-muted mb-0 text-uppercase">Recent Searches</h6>
                                </div>
                            </div>    
                        </div>
                    </form> -->
                    <div class="h6 align-self-center mb-0"> <?php if(!empty($page_title )) { echo $page_title ; } ?> </div>
                </div>
                <div class="d-flex align-items-center">
                    <!-- <div class="dropdown d-md-none topbar-head-dropdown header-item">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-search fs-18"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">
                            <form class="p-3">
                                <div class="form-group m-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                        <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> -->
                    <!-- <div class="ms-1 header-item d-none d-sm-flex">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
                            <i class='bi bi-fullscreen fs-18'></i>
                        </button>
                    </div>
                    <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                            <i class='bi bi-bell-fill fs-18'></i>
                            <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">3<span class="visually-hidden">unread messages</span></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
                            <div class="dropdown-head bg-primary bg-pattern rounded-top">
                                <div class="p-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0 fs-16 fw-semibold text-white"> Notifications </h6>
                                        </div>
                                        <div class="col-auto dropdown-tabs">
                                            <span class="badge bg-light-subtle text-body fs-13"> 4 New</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-2 pt-2">
                                    <ul class="nav nav-tabs dropdown-tabs nav-tabs-custom" data-dropdown-tabs="true" id="notificationItemsTab" role="tablist">
                                        <li class="nav-item waves-effect waves-light">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#all-noti-tab" role="tab" aria-selected="true">
                                                All (4)
                                            </a>
                                        </li>
                                        <li class="nav-item waves-effect waves-light">
                                            <a class="nav-link" data-bs-toggle="tab" href="#messages-tab" role="tab" aria-selected="false">
                                                Messages
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-content position-relative" id="notificationItemsTabContent">
                                <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                                    <div data-simplebar style="max-height: 300px;" class="pe-2">
                                        <div class="text-reset notification-item d-block dropdown-item position-relative">
                                            <div class="d-flex">
                                                <div class="avatar-xs me-3 flex-shrink-0">
                                                    <span class="avatar-title bg-info-subtle text-info rounded-circle fs-16">
                                                        <i class="bi bi-patch-check-fill"></i>
                                                    </span>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 mb-2 lh-base">Your <b>Elite</b> author Graphic
                                                            Optimization <span class="text-secondary">reward</span> is ready!
                                                        </h6>
                                                    </a>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="bi bi-clock"></i> Just 30 sec ago</span>
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <div class="form-check notification-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="all-notification-check01">
                                                        <label class="form-check-label" for="all-notification-check01"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-reset notification-item d-block dropdown-item position-relative">
                                            <div class="d-flex">
                                                <img src="images/avatar-1.jpg" class="me-3 rounded-circle avatar-xs flex-shrink-0" alt="user-pic">
                                                <div class="flex-grow-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 mb-1 fs-13 fw-semibold">Angela Bernier</h6>
                                                    </a>
                                                    <div class="fs-13 text-muted">
                                                        <p class="mb-1">Answered to your comment on the cash flow forecast's graph</p>
                                                    </div>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="bi bi-clock"></i> 48 min ago</span>
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <div class="form-check notification-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="all-notification-check02">
                                                        <label class="form-check-label" for="all-notification-check02"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade py-2 ps-2" id="messages-tab" role="tabpanel" aria-labelledby="messages-tab">
                                    <div data-simplebar style="max-height: 300px;" class="pe-2">
                                        <div class="text-reset notification-item d-block dropdown-item">
                                            <div class="d-flex">
                                                <img src="images/avatar-1.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                                <div class="flex-grow-1">
                                                    <a href="#!" class="stretched-link">
                                                        <h6 class="mt-0 mb-1 fs-13 fw-semibold">James Lemire</h6>
                                                    </a>
                                                    <div class="fs-13 text-muted">
                                                        <p class="mb-1">We talked about a project on linkedin.</p>
                                                    </div>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span><i class="bi bi-clock"></i> 30 min ago</span>
                                                    </p>
                                                </div>
                                                <div class="px-2 fs-15">
                                                    <div class="form-check notification-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="messages-notification-check01">
                                                        <label class="form-check-label" for="messages-notification-check01"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="notification-actions" id="notification-actions">
                                    <div class="d-flex text-muted justify-content-center">
                                        Select <div id="select-content" class="text-body fw-semibold px-1">0</div> Result <button type="button" class="btn btn-link link-danger p-0 ms-3" data-bs-toggle="modal" data-bs-target="#removeNotificationModal">Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="dropdown ms-sm-3 header-item topbar-user">
                        <?php
                            $company_count = 0;
                            $company_count = $obj->CompanyCount();
                            $login_user_name = ""; $login_user_type = ""; $login_role_id = ""; $login_role_name = "";
                            $sidebar_admin_user = 0; $sidebar_payment_mode = 0; $sidebar_bank = 0; $sidebar_unit =0;
                            $sidebar_size = 0; $sidebar_party = 0; $sidebar_product = 0; $sidebar_order_form = 0; $sidebar_report = 0; $sidebar_estimate = 0; $sidebar_invoice = 0; $sidebar_quotation = 0;
                            if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id']) && isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'])) {
                                $login_user_name = $obj->getTableColumnValue($GLOBALS['user_table'], 'user_id', $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'], 'name');
                                if(!empty($login_user_name)) {
                                    $login_user_name = $obj->encode_decode('decrypt', $login_user_name);
                                }
                                $login_role_id = $obj->getTableColumnValue($GLOBALS['user_table'], 'user_id', $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'], 'role_id');
                                if(!empty($login_role_id) && $login_role_id != $GLOBALS['null_value']) {
                                    $login_role_name = $obj->getTableColumnValue($GLOBALS['role_table'], 'role_id', $login_role_id, 'role_name');
                                    if(!empty($login_role_name) && $login_role_name != $GLOBALS['null_value']) {
                                        $login_role_name = $obj->encode_decode('decrypt', $login_role_name);
                                    }
                                }
                                else {
                                    $login_role_name = "Super Admin";
                                }
                            }
                            if($company_count > 0) {
                                if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type']) && isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type'])) {
                                    $login_user_type = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_type'];
                                    if($login_user_type == $GLOBALS['admin_user_type']) {
                                        $sidebar_admin_user = 1;
                                    }
                                    else if($login_user_type == $GLOBALS['staff_user_type']) {
                                        $staff_id = "";
                                        if(!empty($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id']) && isset($_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'])) {
                                            $staff_id = $_SESSION[$GLOBALS['site_name_user_prefix'].'_user_id'];
                                        }
                                        if(!empty($staff_id)) {
                                            $staff_role_id = "";
                                            $staff_role_id = $obj->getTableColumnValue($GLOBALS['user_table'], 'user_id', $staff_id, 'role_id');
                                        
                                            if(!empty($staff_role_id)){
                                                
                                                $staff_role_name = $obj->getTableColumnValue($GLOBALS['role_table'],'role_id', $staff_role_id, 'role_name');
                                                $staff_role_name = $obj->encode_decode('decrypt',$staff_role_name);
                                            }
                                            $sidebar_payment_mode = $obj->CheckStaffAccessPage($staff_id,$GLOBALS['bill_company_id'],$GLOBALS['payment_mode_module']);
                                            $sidebar_bank = $obj->CheckStaffAccessPage($staff_id,$GLOBALS['bill_company_id'],$GLOBALS['bank_module']);
                                            $sidebar_unit = $obj->CheckStaffAccessPage($staff_id,$GLOBALS['bill_company_id'],$GLOBALS['unit_module']);
                                            $sidebar_size = $obj->CheckStaffAccessPage($staff_id,$GLOBALS['bill_company_id'],$GLOBALS['size_module']);
                                            $sidebar_party = $obj->CheckStaffAccessPage($staff_id,$GLOBALS['bill_company_id'],$GLOBALS['party_module']);
                                            $sidebar_product = $obj->CheckStaffAccessPage($staff_id,$GLOBALS['bill_company_id'],$GLOBALS['product_module']);
                                            // $sidebar_order_form = $obj->CheckStaffAccessPage($staff_id,$GLOBALS['bill_company_id'],$GLOBALS['order_form_module']);
                                            $sidebar_estimate = $obj->CheckStaffAccessPage($staff_id,$GLOBALS['bill_company_id'],$GLOBALS['estimate_module']);
                                            $sidebar_invoice = $obj->CheckStaffAccessPage($staff_id,$GLOBALS['bill_company_id'],$GLOBALS['invoice_module']);
                                            $sidebar_quotation = $obj->CheckStaffAccessPage($staff_id,$GLOBALS['bill_company_id'],$GLOBALS['quotation_module']);
                                            $sidebar_purchase = $obj->CheckStaffAccessPage($staff_id,$GLOBALS['bill_company_id'],$GLOBALS['purchase_module']);

                                            $sidebar_voucher = $obj->CheckStaffAccessPage($staff_id,$GLOBALS['bill_company_id'],$GLOBALS['voucher_module']);
                                            $sidebar_receipt = $obj->CheckStaffAccessPage($staff_id,$GLOBALS['bill_company_id'],$GLOBALS['receipt_module']);
                                            $sidebar_report = $obj->CheckStaffAccessPage($staff_id,$GLOBALS['bill_company_id'],$GLOBALS['reports_module']);
                                            
                                        }
                                    }
                                }
                            }
                        ?>
                        <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="d-flex align-items-center">
                                <img class="rounded-circle header-profile-user" src="images/avatar-1.jpg" alt="Header Avatar">
                                <span class="text-start ms-xl-2">
                                    <!-- <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">Eswari Traders</span>
                                    <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">Admin</span> -->
                                
                                    <?php if(!empty($login_user_name)) { ?>
                                        <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?php echo $login_user_name; ?> </span>
                                    <?php } ?>
                                    <?php if(!empty($login_user_type)) { ?>
                                        <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">
                                            <?php if(!empty($staff_role_name)) { echo $staff_role_name; } else {
                                                if(!empty($login_user_type)) { echo $login_user_type; }
                                            } ?>
                                    </span>
                                    <?php } ?>
                                </span>
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                           <?php if(!empty($login_user_name)) { ?>

                            <h6 class="dropdown-header">Welcome <?php echo $login_user_name; ?> !</h6>
                            <?php } ?>
                            <!-- <a class="dropdown-item" href="#"><i class="bi bi-person-circle text-muted fs-14 align-middle me-1"></i> <span class="align-middle">Profile</span></a> -->
                            <a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right text-muted fs-14 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- removeNotificationModal -->
    <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        <i class="bi bi-trash h1"></i>
                        <div class="pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>Are you sure ?</h4>
                            <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- App Menu -->
    <div class="app-menu navbar-menu">
        <div class="navbar-brand-box">
            <a href="dashboard.php" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="images/amazing.png" alt="Eswari Traders" height="50">
                </span>
                <span class="logo-lg">
                    <div class="h5 py-3 text-white">Eswari Traders</div>
                </span>
            </a>
            <a href="dashboard.php" class="logo logo-light">
                <span class="logo-sm">
                    <img src="images/amazing.png" alt="Eswari Traders" height="50">
                </span>
                <span class="logo-lg">
                     <div class="h5 py-3 text-white">Eswari Traders</div>
                </span>
            </a>
            <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                <i class="bi bi-arrow-right-circle"></i>
            </button>
        </div>
        <div id="scrollbar">
            <div class="container-fluid">
                <div id="two-column-menu"></div>
                <ul class="navbar-nav" id="navbar-nav">
                    <li class="nav-item" id="dashboard">
                        <a class="nav-link menu-link" href="dashboard.php">
                            <i class="bi bi-speedometer"></i> <span>Dashboard</span>
                        </a>
                    </li>
                    <?php if($login_user_type == $GLOBALS['admin_user_type']) { ?>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#admin" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="creation">
                            <i class="bi bi-person-circle"></i> <span>Admin</span>
                        </a>
                        <div class="collapse menu-dropdown" id="admin">
                            
                            <ul class="nav nav-lg flex-column">
                                <?php if($login_user_type == $GLOBALS['admin_user_type']) { ?>
                                    <li class="nav-item" id="company">
                                        <a href="company.php" class="nav-link"><i class="bi bi-dash"></i> Company </a>
                                    </li>
                                <?php } ?>
                                <?php if((!empty($sidebar_admin_user) && $sidebar_admin_user == '1')){ ?>
                                    <li class="nav-item" id="role">
                                        <a href="role.php" class="nav-link"><i class="bi bi-dash"></i> Role </a>
                                    </li>
                                    <li class="nav-item" id="user">
                                        <a href="user.php" class="nav-link"><i class="bi bi-dash"></i> User </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </li>
                    <?php } ?>
                    <?php if((!empty($sidebar_admin_user) && $sidebar_admin_user == '1')  || (!empty($sidebar_bank) && $sidebar_bank == '1')  || (!empty($sidebar_unit) && $sidebar_unit == '1') || (!empty($sidebar_size) && $sidebar_size == '1') || (!empty($sidebar_bank) && $sidebar_bank == '1')  ||  (!empty($sidebar_product) && $sidebar_product == '1') ||  (!empty($sidebar_party) && $sidebar_party == '1')){ ?>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#creation" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="creation">
                            <i class="bi bi-folder-plus"></i> <span>Creation</span>
                        </a>
                        <div class="collapse menu-dropdown" id="creation">
                            <ul class="nav nav-lg flex-column">
                                <?php if((!empty($sidebar_admin_user) && $sidebar_admin_user == '1') || (!empty($sidebar_unit) && $sidebar_unit == '1')){ ?>
                                <li class="nav-item" id="unit">
                                    <a href="unit.php" class="nav-link"><i class="bi bi-dash"></i> Unit </a>
                                </li>
                                <?php } ?>
                                <?php if((!empty($sidebar_admin_user) && $sidebar_admin_user == '1') || (!empty($sidebar_size) && $sidebar_size == '1')){ ?>
                                <li class="nav-item" id="size">
                                    <a href="size.php" class="nav-link"><i class="bi bi-dash"></i> Size </a>
                                </li>
                                <?php } ?>
                                <?php if((!empty($sidebar_admin_user) && $sidebar_admin_user == '1') || (!empty($sidebar_payment_mode) && $sidebar_payment_mode == '1')){ ?>
                                <li class="nav-item" id="payment_mode">
                                    <a href="payment_mode.php" class="nav-link"><i class="bi bi-dash"></i> Payment Mode </a>
                                </li>
                                <?php } ?>
                                <?php if((!empty($sidebar_admin_user) && $sidebar_admin_user == '1') || (!empty($sidebar_bank) && $sidebar_bank == '1')){ ?>
                                <li class="nav-item" id="bank">
                                    <a href="bank.php" class="nav-link"><i class="bi bi-dash"></i> Bank </a>
                                </li>
                                <?php } ?>
                                <?php if((!empty($sidebar_admin_user) && $sidebar_admin_user == '1') || (!empty($sidebar_product) && $sidebar_product == '1')){ ?>
                                <li class="nav-item" id="product">
                                    <a href="product.php" class="nav-link"><i class="bi bi-dash"></i> Product </a>
                                </li>
                                <?php } ?>
                                <?php if((!empty($sidebar_admin_user) && $sidebar_admin_user == '1') || (!empty($sidebar_party) && $sidebar_party == '1')){ ?>
                                <li class="nav-item" id="party">
                                    <a href="party.php" class="nav-link"><i class="bi bi-dash"></i>Party </a>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </li>
                    <?php } ?>
                     <?php if((!empty($sidebar_admin_user) && $sidebar_admin_user == '1') || (!empty($sidebar_purchase) && $sidebar_purchase == '1')){ ?>
                    <li class="nav-item" id="purchase">
                        <a class="nav-link menu-link" href="purchase.php">
                            <i class="bi bi-cart"></i><span>Purchase</span>
                        </a>
                    </li>
                    <?php } ?>
                    <!-- <?php if((!empty($sidebar_admin_user) && $sidebar_admin_user == '1') || (!empty($sidebar_order_form) && $sidebar_order_form == '1')){ ?>
                    <li class="nav-item" id="orderform">
                        <a class="nav-link menu-link" href="order_form.php">
                            <i class="bi bi-card-list"></i><span>Order Form</span>
                        </a>
                    </li>
                    <?php } ?> -->
                     <?php if((!empty($sidebar_admin_user) && $sidebar_admin_user == '1') || (!empty($sidebar_quotation) && $sidebar_quotation == '1')){ ?>
                    <li class="nav-item" id="quotation">
                        <a class="nav-link menu-link" href="quotation.php">
                            <i class="bi bi-card-checklist"></i><span>Quotation</span>
                        </a>
                    </li>
                    <?php } ?>
                    <?php if((!empty($sidebar_admin_user) && $sidebar_admin_user == '1') || (!empty($sidebar_estimate) && $sidebar_estimate == '1')){ ?>
                    <li class="nav-item" id="estimate">
                        <a class="nav-link menu-link" href="estimate.php">
                            <i class="bi bi-currency-rupee"></i><span>Estimate</span>
                        </a>
                    </li>
                    <?php } ?>
                    <?php if((!empty($sidebar_admin_user) && $sidebar_admin_user == '1') || (!empty($sidebar_invoice) && $sidebar_invoice == '1')){ ?>
                    <li class="nav-item" id="invoice">
                        <a class="nav-link menu-link" href="invoice.php">
                            <i class="bi bi-receipt"></i><span>Invoice</span>
                        </a>
                    </li>
                    <?php } ?>
                    <?php if((!empty($sidebar_admin_user) && $sidebar_admin_user == '1') || (!empty($sidebar_voucher) && $sidebar_voucher == '1') || (!empty($sidebar_receipt) && $sidebar_receipt == '1')) { ?>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#payment" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="creation">
                                <i class="bi bi-currency-rupee"></i> <span>Payment</span>
                            </a>
                            <div class="collapse menu-dropdown" id="payment">
                                <ul class="nav nav-lg flex-column">
                                    <?php if($sidebar_admin_user == 1 || $sidebar_voucher == 1) { ?>
                                    <li class="nav-item" id="voucher">
                                        <a href="voucher.php" class="nav-link"><i class="bi bi-dash"></i> Voucher </a>
                                    </li>
                                    <?php } ?>
                                    <?php if($sidebar_admin_user == 1 || $sidebar_receipt == 1) { ?>
                                    <li class="nav-item" id="receipt">
                                        <a href="receipt.php" class="nav-link"><i class="bi bi-dash"></i> Receipt </a>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </li>
                    <?php } ?>
                    <?php if((!empty($sidebar_admin_user) && $sidebar_admin_user == '1') || (!empty($sidebar_report) && $sidebar_report == '1')){ ?>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#report" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="creation">
                            <i class="bi bi-database"></i> <span>Reports</span>
                        </a>
                        <div class="collapse menu-dropdown" id="report">
                            <ul class="nav nav-lg flex-column">
                                <!-- <li class="nav-item" id="salesstock">
                                    <a href="sales_stock.php" class="nav-link"><i class="bi bi-dash"></i> Sales Stock </a>
                                </li> -->
                                <!-- <li class="nav-item" id="orderform">
                                    <a href="order_form_report.php" class="nav-link"><i class="bi bi-dash"></i> Order Form Report </a>
                                </li> -->
                                <!-- <li class="nav-item" id="estimatereport">
                                    <a href="estimate_report.php" class="nav-link"><i class="bi bi-dash"></i> Estimate Report </a>
                                </li> -->
                                <li class="nav-item" id="purchasereport">
                                    <a href="purchase_report.php" class="nav-link"><i class="bi bi-dash"></i> Purchase Report </a>
                                </li>
                                 <li class="nav-item" id="purchasetaxreport">
                                    <a href="purchasetax_report.php" class="nav-link"><i class="bi bi-dash"></i> Purchase Tax Report </a>
                                </li>
                                <li class="nav-item" id="salesreport">
                                    <a href="sales_report.php" class="nav-link"><i class="bi bi-dash"></i> Sales Report </a>
                                </li>
                                <li class="nav-item" id="salestaxreport">
                                    <a href="salestax_report.php" class="nav-link"><i class="bi bi-dash"></i> Sales Tax Report </a>
                                </li>
                                <li class="nav-item" id="pending_balance_report">
                                    <a href="pendingbalance_report.php" class="nav-link"><i class="bi bi-dash"></i> Pending Balance Report </a>
                                </li>
                                <li class="nav-item" id="payment_report">
                                    <a href="payment_report.php" class="nav-link"><i class="bi bi-dash"></i> Payment Report </a>
                                </li>
                                <li class="nav-item" id="daybook_report">
                                    <a href="daybook_report.php" class="nav-link"><i class="bi bi-dash"></i> Daybook Report </a>
                                </li>
                              
                            </ul>
                        </div>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="sidebar-background"></div>
    </div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>