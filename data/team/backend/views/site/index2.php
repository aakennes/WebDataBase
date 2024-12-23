<?php
/**
* Team: 
* Coding by Cai Yuanhong 2213897; Huang Mingzhou 2211804; 20241221 
*/
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理后台</title>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
    <div class="app-wrapper"> <!--begin::Header-->
        <!-- Header -->
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img src="../../dist/assets/img/user2-160x160.jpg" class="user-image rounded-circle shadow"
                                alt="User Image">
                            <span class="d-none d-md-inline">Alexander Pierce</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                            <li class="user-header text-bg-primary">
                                <img src="../../dist/assets/img/user2-160x160.jpg" class="rounded-circle shadow"
                                    alt="User Image">
                                <p>
                                    Alexander Pierce - Web Developer
                                    <small>Member since Nov. 2023</small>
                                </p>
                            </li>
                            <li class="user-footer">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                                <a href="#" class="btn btn-default btn-flat float-end">Sign out</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>


        <!-- Sidebar -->
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <div class="sidebar-brand">
                <a href="./index.php" class="brand-link">
                    <span class="brand-text fw-light">管理后台</span>
                </a>
            </div>
            <div class="sidebar-wrapper">
                <nav>
                    <ul class="nav sidebar-menu flex-column">
                    <?php
                    use yii\helpers\Url;
                    ?>

                    <li class="nav-item">
                        <a href="<?= Url::to(['site/index']) ?>" class="nav-link">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>题目管理</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= Url::to(['site/index2']) ?>" class="nav-link active">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>完成情况</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= Url::to(['site/index3']) ?>" class="nav-link">
                            <i class="nav-icon bi bi-circle"></i>
                            <p>提交记录</p>
                        </a>
                    </li>
                    </ul>
                </nav>
            </div>
        </aside>
        
        <main class="app-main"> <!--begin::App Content Header-->
            <div class="app-content-header"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">完成情况</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="<?= Url::to(['site/index']) ?>">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    完成情况
                                </li>
                            </ol>
                        </div>
                    </div> <!--end::Row-->
                </div> <!--end::Container-->
            </div>
            <div class="app-content"> <!--begin::Container-->
                <div class="container-fluid"> <!-- Info boxes -->
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box"> <span class="info-box-icon text-bg-primary shadow-sm"> <i class="bi bi-gear-fill"></i> </span>
                                <div class="info-box-content"> <span class="info-box-text">总正确率</span> <span class="info-box-number">
                                        <?= $accuracy ?>
                                        <small>%</small> </span> </div> <!-- /.info-box-content -->
                            </div> <!-- /.info-box -->
                        </div> <!-- /.col -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box"> <span class="info-box-icon text-bg-danger shadow-sm"> <i class="bi bi-hand-thumbs-up-fill"></i> </span>
                                <div class="info-box-content"> <span class="info-box-text">提交次数</span> <span class="info-box-number"><?= $totalSubmissions ?></span> </div> <!-- /.info-box-content -->
                            </div> <!-- /.info-box -->
                        </div> <!-- /.col --> <!-- fix for small devices only --> <!-- <div class="clearfix hidden-md-up"></div> -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box"> <span class="info-box-icon text-bg-success shadow-sm"> <i class="bi bi-cart-fill"></i> </span>
                                <div class="info-box-content"> <span class="info-box-text">提交人次</span> <span class="info-box-number"><?= $totalUsers ?></span> </div> <!-- /.info-box-content -->
                            </div> <!-- /.info-box -->
                        </div> <!-- /.col -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box"> <span class="info-box-icon text-bg-warning shadow-sm"> <i class="bi bi-people-fill"></i> </span>
                                <div class="info-box-content"> <span class="info-box-text">需完成该习题集人数</span> <span class="info-box-number"><?= $allstu ?></span> </div> <!-- /.info-box-content -->
                            </div> <!-- /.info-box -->
                        </div> <!-- /.col -->
                    </div> <!-- /.row --> <!--begin::Row-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title">该习题集习题提交情况</h5>
                                    <div class="card-tools"> <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"> <i data-lte-icon="expand" class="bi bi-plus-lg"></i> <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> </button>
                                        <div class="btn-group"> <button type="button" class="btn btn-tool dropdown-toggle" data-bs-toggle="dropdown"> <i class="bi bi-wrench"></i> </button>
                                            <div class="dropdown-menu dropdown-menu-end" role="menu"> <a href="#" class="dropdown-item">Action</a> <a href="#" class="dropdown-item">Another action</a> <a href="#" class="dropdown-item">
                                                    Something else here
                                                </a> <a class="dropdown-divider"></a> <a href="#" class="dropdown-item">Separated link</a> </div>
                                        </div> <button type="button" class="btn btn-tool" data-lte-toggle="card-remove"> <i class="bi bi-x-lg"></i> </button>
                                    </div>
                                </div> <!-- /.card-header -->
                                <div class="card-body"> <!--begin::Row-->
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p class="text-center"> <strong>记录周期:  <?= $dates[0] ?> - <?= $dates[6] ?></strong> </p>
                                            <div id="sales-chart"></div>
                                        </div> <!-- /.col -->
                                        <div class="col-md-4">
                                            <p class="text-center"> <strong>Goal Completion</strong> </p>
                                            <div class="progress-group">
                                                Add Products to Cart
                                                <span class="float-end"><b>160</b>/200</span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar text-bg-primary" style="width: 80%"></div>
                                                </div>
                                            </div> <!-- /.progress-group -->
                                            <div class="progress-group">
                                                Complete Purchase
                                                <span class="float-end"><b>310</b>/400</span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar text-bg-danger" style="width: 75%"></div>
                                                </div>
                                            </div> <!-- /.progress-group -->
                                            <div class="progress-group"> <span class="progress-text">Visit Premium Page</span> <span class="float-end"><b>480</b>/800</span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar text-bg-success" style="width: 60%"></div>
                                                </div>
                                            </div> <!-- /.progress-group -->
                                            <div class="progress-group">
                                                Send Inquiries
                                                <span class="float-end"><b>250</b>/500</span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar text-bg-warning" style="width: 50%"></div>
                                                </div>
                                            </div> <!-- /.progress-group -->
                                        </div> <!-- /.col -->
                                    </div> <!--end::Row-->
                                </div> <!-- ./card-body -->
                                
                            </div> <!-- /.card -->
                        </div> <!-- /.col -->
                    </div> <!--end::Row--> <!--begin::Row-->
                    <div class="row"> <!-- Start col -->
                        <div class="col-md-8"> <!--begin::Row-->
                            
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Latest Orders</h3>
                                    <div class="card-tools"> <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"> <i data-lte-icon="expand" class="bi bi-plus-lg"></i> <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> </button> <button type="button" class="btn btn-tool" data-lte-toggle="card-remove"> <i class="bi bi-x-lg"></i> </button> </div>
                                </div> <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table m-0">
                                            <thead>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Item</th>
                                                    <th>Status</th>
                                                    <th>Popularity</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td> <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR9842</a> </td>
                                                    <td>Call of Duty IV</td>
                                                    <td> <span class="badge text-bg-success">
                                                            Shipped
                                                        </span> </td>
                                                    <td>
                                                        <div id="table-sparkline-1"></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR1848</a> </td>
                                                    <td>Samsung Smart TV</td>
                                                    <td> <span class="badge text-bg-warning">Pending</span> </td>
                                                    <td>
                                                        <div id="table-sparkline-2"></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR7429</a> </td>
                                                    <td>iPhone 6 Plus</td>
                                                    <td> <span class="badge text-bg-danger">
                                                            Delivered
                                                        </span> </td>
                                                    <td>
                                                        <div id="table-sparkline-3"></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR7429</a> </td>
                                                    <td>Samsung Smart TV</td>
                                                    <td> <span class="badge text-bg-info">Processing</span> </td>
                                                    <td>
                                                        <div id="table-sparkline-4"></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR1848</a> </td>
                                                    <td>Samsung Smart TV</td>
                                                    <td> <span class="badge text-bg-warning">Pending</span> </td>
                                                    <td>
                                                        <div id="table-sparkline-5"></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR7429</a> </td>
                                                    <td>iPhone 6 Plus</td>
                                                    <td> <span class="badge text-bg-danger">
                                                            Delivered
                                                        </span> </td>
                                                    <td>
                                                        <div id="table-sparkline-6"></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td> <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR9842</a> </td>
                                                    <td>Call of Duty IV</td>
                                                    <td> <span class="badge text-bg-success">Shipped</span> </td>
                                                    <td>
                                                        <div id="table-sparkline-7"></div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div> <!-- /.table-responsive -->
                                </div> <!-- /.card-body -->
                                
                            </div> <!-- /.card -->
                        </div> <!-- /.col -->
                        <div class="col-md-4"> <!-- Info Boxes Style 2 -->
                            
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Browser Usage</h3>
                                    <div class="card-tools"> <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"> <i data-lte-icon="expand" class="bi bi-plus-lg"></i> <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> </button> <button type="button" class="btn btn-tool" data-lte-toggle="card-remove"> <i class="bi bi-x-lg"></i> </button> </div>
                                </div> <!-- /.card-header -->
                                <div class="card-body"> <!--begin::Row-->
                                    <div class="row">
                                        <div class="col-12">
                                            <div id="pie-chart"></div>
                                        </div> <!-- /.col -->
                                    </div> <!--end::Row-->
                                </div> <!-- /.card-body -->
                                <div class="card-footer p-0">
                                    <ul class="nav nav-pills flex-column">
                                        <li class="nav-item"> <a href="#" class="nav-link">
                                                United States of America
                                                <span class="float-end text-danger"> <i class="bi bi-arrow-down fs-7"></i>
                                                    12%
                                                </span> </a> </li>
                                        <li class="nav-item"> <a href="#" class="nav-link">
                                                India
                                                <span class="float-end text-success"> <i class="bi bi-arrow-up fs-7"></i> 4%
                                                </span> </a> </li>
                                        <li class="nav-item"> <a href="#" class="nav-link">
                                                China
                                                <span class="float-end text-info"> <i class="bi bi-arrow-left fs-7"></i> 0%
                                                </span> </a> </li>
                                    </ul>
                                </div> <!-- /.footer -->
                            </div> <!-- /.card --> <!-- PRODUCT LIST -->
                            
                        </div> <!-- /.col -->
                    </div> <!--end::Row-->
                </div> <!--end::Container-->
            </div> <!--end::App Content-->
        </main> <!--end::App Main--> <!--begin::Footer-->
        
    </div> <!--end::App Wrapper--> <!--begin::Script--> <!--begin::Third Party Plugin(OverlayScrollbars)-->
    
    
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js" integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8=" crossorigin="anonymous"></script>
    <script>
        

        //-----------------------
        // - MONTHLY SALES CHART -
        //-----------------------

        const sales_chart_options = {
            series: [{
                name: "提交次数",
                data: <?= json_encode($total_submissions, JSON_NUMERIC_CHECK) ?>,
            },
            {
                name: "通过次数",
                data: <?= json_encode($passed_submissions, JSON_NUMERIC_CHECK) ?>,
            }],
            chart: {
                height: 180,
                type: "area",
                toolbar: {
                    show: false,
                },
            },
            legend: {
                show: false,
            },
            colors: ["#0d6efd", "#20c997"],
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: "smooth",
            },
            xaxis: {
                type: "datetime",
                categories:  <?= json_encode($dates) ?>,
            },
            tooltip: {
                x: {
                    format: "MMMM yyyy",
                },
            },
        };

        const sales_chart = new ApexCharts(
            document.querySelector("#sales-chart"),
            sales_chart_options,
        );
        sales_chart.render();

        //---------------------------
        // - END MONTHLY SALES CHART -
        //---------------------------

        function createSparklineChart(selector, data) {
            const options = {
                series: [{
                    data
                }],
                chart: {
                    type: "line",
                    width: 150,
                    height: 30,
                    sparkline: {
                        enabled: true,
                    },
                },
                colors: ["var(--bs-primary)"],
                stroke: {
                    width: 2,
                },
                tooltip: {
                    fixed: {
                        enabled: false,
                    },
                    x: {
                        show: false,
                    },
                    y: {
                        title: {
                            formatter: function(seriesName) {
                                return "";
                            },
                        },
                    },
                    marker: {
                        show: false,
                    },
                },
            };

            const chart = new ApexCharts(document.querySelector(selector), options);
            chart.render();
        }

        const table_sparkline_1_data = [
            25, 66, 41, 89, 63, 25, 44, 12, 36, 9, 54,
        ];
        const table_sparkline_2_data = [
            12, 56, 21, 39, 73, 45, 64, 52, 36, 59, 44,
        ];
        const table_sparkline_3_data = [
            15, 46, 21, 59, 33, 15, 34, 42, 56, 19, 64,
        ];
        const table_sparkline_4_data = [
            30, 56, 31, 69, 43, 35, 24, 32, 46, 29, 64,
        ];
        const table_sparkline_5_data = [
            20, 76, 51, 79, 53, 35, 54, 22, 36, 49, 64,
        ];
        const table_sparkline_6_data = [
            5, 36, 11, 69, 23, 15, 14, 42, 26, 19, 44,
        ];
        const table_sparkline_7_data = [
            12, 56, 21, 39, 73, 45, 64, 52, 36, 59, 74,
        ];

        createSparklineChart("#table-sparkline-1", table_sparkline_1_data);
        createSparklineChart("#table-sparkline-2", table_sparkline_2_data);
        createSparklineChart("#table-sparkline-3", table_sparkline_3_data);
        createSparklineChart("#table-sparkline-4", table_sparkline_4_data);
        createSparklineChart("#table-sparkline-5", table_sparkline_5_data);
        createSparklineChart("#table-sparkline-6", table_sparkline_6_data);
        createSparklineChart("#table-sparkline-7", table_sparkline_7_data);

        //-------------
        // - PIE CHART -
        //-------------

        const pie_chart_options = {
            series: [700, 500, 400, 600, 300, 100],
            chart: {
                type: "donut",
            },
            labels: ["Chrome", "Edge", "FireFox", "Safari", "Opera", "IE"],
            dataLabels: {
                enabled: false,
            },
            colors: [
                "#0d6efd",
                "#20c997",
                "#ffc107",
                "#d63384",
                "#6f42c1",
                "#adb5bd",
            ],
        };

        const pie_chart = new ApexCharts(
            document.querySelector("#pie-chart"),
            pie_chart_options,
        );
        pie_chart.render();

        //-----------------
        // - END PIE CHART -
        //-----------------
    </script> <!--end::Script-->
</body><!--end::Body-->
</html>
