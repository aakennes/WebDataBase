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

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
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
                        <li class="nav-item menu-open">
                            <ul class="nav nav-treeview">
                            <?php
                            use yii\helpers\Url;
                            ?>

                            <li class="nav-item">
                                <a href="<?= Url::to(['site/index']) ?>" class="nav-link active">
                                    <i class="nav-icon bi bi-circle"></i>
                                    <p>题目管理</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= Url::to(['site/index2']) ?>" class="nav-link">
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
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">题目管理</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">题目管理</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box text-bg-primary">
                                <div class="inner">
                                    <h3>150</h3>
                                    <p>New Orders</p>
                                </div>
                                <a href="#" class="small-box-footer">More info <i class="bi bi-link-45deg"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box text-bg-success">
                                <div class="inner">
                                    <h3>53<sup class="fs-5">%</sup></h3>
                                    <p>Bounce Rate</p>
                                </div>
                                <a href="#" class="small-box-footer">More info <i class="bi bi-link-45deg"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box text-bg-warning">
                                <div class="inner">
                                    <h3>44</h3>
                                    <p>User Registrations</p>
                                </div>
                                <a href="#" class="small-box-footer">More info <i class="bi bi-link-45deg"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box text-bg-danger">
                                <div class="inner">
                                    <h3>65</h3>
                                    <p>Unique Visitors</p>
                                </div>
                                <a href="#" class="small-box-footer">More info <i class="bi bi-link-45deg"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-7 connectedSortable">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">Sales Value</h3>
                                </div>
                                <div class="card-body">
                                    <div id="revenue-chart"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5 connectedSortable">
                            <div class="card text-white bg-primary bg-gradient border-primary mb-4">
                                <div class="card-header border-0">
                                    <h3 class="card-title">Sales Value</h3>
                                </div>
                                <div class="card-body">
                                    <div id="world-map" style="height: 220px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js" crossorigin="anonymous"></script>

    <script>
        const sales_chart_options = {
            series: [{
                name: "Digital Goods",
                data: [28, 48, 40, 19, 86, 27, 90],
            },
            {
                name: "Electronics",
                data: [65, 59, 80, 81, 56, 55, 40],
            }],
            chart: {
                height: 300,
                type: "area",
                toolbar: {
                    show: false,
                },
            },
            xaxis: {
                type: "datetime",
                categories: [
                    "2023-01-01", "2023-02-01", "2023-03-01", "2023-04-01", "2023-05-01", "2023-06-01", "2023-07-01",
                ],
            },
        };

        const sales_chart = new ApexCharts(document.querySelector("#revenue-chart"), sales_chart_options);
        sales_chart.render();

        const map = new jsVectorMap({
            selector: "#world-map",
            map: "world",
        });
    </script>
</body>

</html>