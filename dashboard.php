<?php 
	$page_title = "Dashboard";
	include("include_user_check_and_files.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title> <?php if(!empty($project_title)) { echo $project_title; } ?> - <?php if(!empty($page_title)) { echo $page_title; } ?> </title>
	<?php include "link_style_script.php"; ?>
    <style>
        .metric-row {
            margin-bottom: 1.25rem;
            border-radius: 0.25rem;
            align-items: stretch;
            display: flex;
            flex-wrap: wrap;
            margin-right: -10px;
            margin-left: -10px;
        }
        .metric-row .metric {
            margin: 0.5rem 0;
            min-height: 8.5rem;
        }
        .card-header {
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }

        canvas {
            max-width: 100%;
        }

    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>	
<body onload="updatesaleschart();">
<?php include "header.php"; ?>
 <?php
    			$estimate_count = 0;
			$invoice_count = 0;
			$order_form_count = 0;
            $dashboard_count = array();
        $dashboard_count = $obj->getDashboardCounList();
        if(!empty($dashboard_count)){
            $list = explode("$$$",$dashboard_count);
               $order_form_count = $list[0];
            $estimate_count = $list[1];
            $invoice_count = $list[2];
        }

        $to_date = date('Y-m-d');$current_date = date('Y-m-d');
        $from_date = date('Y-m-d', strtotime('-7 days'));
     
        $recent_sales_list =array();
        $recent_sales_list = $obj->getRecentSales();
        ?>
<!-- Start right Content here -->
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
           <h3 class="mb-4 fw-bold">Total Activity</h3>
            <div class="row metric-row g-3">

                <div class="col-lg-4 col-md-4 col-12">
                    <div class="card dashboard-card order-card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5><?php echo $order_form_count; ?></h5>
                                <span>Order Form</span>
                            </div>
                            <div class="icon-box">
                                <i class="bi bi-file-earmark"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-12">
                    <div class="card dashboard-card estimate-card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5><?php echo $estimate_count; ?></h5>
                                <span>Estimate</span>
                            </div>
                            <div class="icon-box">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-12">
                    <div class="card dashboard-card invoice-card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5><?php echo $invoice_count; ?></h5>
                                <span>Invoice</span>
                            </div>
                            <div class="icon-box">
                                <i class="bi bi-wallet2"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row m-3">
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="card sales-card h-100">
                        <div class="card-header sales-header">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-bar-chart-fill p-2"></i>
                                <span>Total Sales Invoice</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="filter-box mb-4">
                                <div class="row g-3 justify-content-center">
                                    <div class="col-lg-4 col-md-5 col-6">
                                        <div class="form-label-group in-border">
                                            <input type="date" name="from_date"
                                                class="form-control shadow-none"
                                                onchange="checkDateCheck();table_listing_records_filter();updatesaleschart();"
                                                value="<?php echo $from_date ?? ''; ?>"
                                                max="<?php echo $current_date ?? ''; ?>"
                                                required>
                                            <label>From Date</label>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-5 col-6">
                                        <div class="form-label-group in-border">
                                            <input type="date" name="to_date"
                                                class="form-control shadow-none"
                                                onchange="checkDateCheck();table_listing_records_filter();updatesaleschart();"
                                                value="<?php echo $to_date ?? ''; ?>"
                                                max="<?php echo $current_date ?? ''; ?>"
                                                required>
                                            <label>To Date</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Chart -->
                            <div class="chart-box">
                                <canvas id="salesStackedChart"></canvas>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row m-3">
                <div class="col-lg-12 col-md-6 col-12 pt-3">
                    <div class="recent-sales-wrapper">
                        <div class="card recent-sales-card">
                            <div class="card-header recent-sales-header p-5">
                                <i class="fa fa-receipt me-2 m-3"></i> Recent Sales List
                            </div>

                            <div class="card-body p-2">
                                <div class="table-responsive">
                                    <table class="table recent-sales-table text-center smallfnt">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Bill Number</th>
                                                <th>Date</th>
                                                <th>Customer Name</th>
                                                <th class="text-end">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (!empty($recent_sales_list)) {
                                                $sno = 1;
                                                foreach ($recent_sales_list as $data) {
                                            ?>
                                            <tr>
                                                <td><?= $sno; ?></td>
                                                <td><?= $data['bill_number'] ?? ''; ?></td>
                                                <td>
                                                    <?= !empty($data['bill_date']) ? date("d-m-Y", strtotime($data['bill_date'])) : ''; ?>
                                                </td>
                                                <td>
                                                    <?= !empty($data['party_name']) ? $obj->encode_decode("decrypt", $data['party_name']) : ''; ?>
                                                </td>
                                                <td class="text-end fw-semibold text-success">
                                                    <?= !empty($data['bill_total']) ? number_format($data['bill_total'], 2) : ''; ?>
                                                </td>
                                            </tr>
                                            <?php
                                                    $sno++;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- End Page-content -->   
<?php include "footer.php"; ?>
<script>
    $(document).ready(function(){
        $("#dashboard").addClass("active");
    });
</script>  

<script>

let stackedSalesChart = null;

function updatesaleschart() {
    const fromDate = document.querySelector('[name="from_date"]').value;
    const toDate = document.querySelector('[name="to_date"]').value;
    if (!fromDate || !toDate) return;

    // Remove "No data" message if exists
    $('#salesStackedChart').next('p.no-data-msg').remove();

    $.ajax({
        url: 'common_changes.php?get_sales_chart=1',
        type: 'GET',
        data: {
            from_date: fromDate,
            to_date: toDate
        },
        dataType: 'json',
        success: function (response) {
            const ctx = document.getElementById('salesStackedChart').getContext('2d');

            if (response.success && Array.isArray(response.data) && response.data.length > 1) {
                const raw = response.data;

                const labels = [];
                const totalBills = [];
                const totalValues = [];

                for (let i = 1; i < raw.length; i++) {
                    // labels.push(raw[i][0]);      
                         const dateObj = new Date(raw[i][0]);
                    let formattedDate = raw[i][0];

                    if (!isNaN(dateObj)) {
                        const d = String(dateObj.getDate()).padStart(2, '0');
                        const m = String(dateObj.getMonth() + 1).padStart(2, '0');
                        const y = dateObj.getFullYear();
                        formattedDate = `${d}-${m}-${y}`;
                    }

                    labels.push(formattedDate);   
                    totalBills.push(raw[i][1]);     
                    totalValues.push(raw[i][2]);    
                }

                if (stackedSalesChart) stackedSalesChart.destroy();

                stackedSalesChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Total Bills',
                                data: totalBills,
                                backgroundColor: '#b0120a',
                                stack: 'combined'
                            },
                            {
                                label: 'Total Bill Values',
                                data: totalValues,
                                backgroundColor: '#ffab91',
                                stack: 'combined'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,                        
                        plugins: {
                            title: {
                                display: true,
                                // text: 'Total Sales Invoice'
                            }
                        },
                        scales: {
                            x: {
                                stacked: true,
                                title: {
                                    display: true,
                                    text: 'Dates'
                                }
                            },
                            y: {
                                stacked: true,
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Sales'
                                }
                            }
                        }
                    }
                });
            } else {
                if (stackedSalesChart) stackedSalesChart.destroy();
                ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
                $('#salesStackedChart').after('<p class="no-data-msg" style="text-align:center;">No chart data found.</p>');
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", error);
            $('#salesStackedChart').after('<p class="no-data-msg" style="text-align:center;">Error loading data.</p>');
        }
    });
}

</script>