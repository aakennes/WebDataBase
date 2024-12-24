<?php
/**
* Team: 
* Coding by Cai Yuanhong 2213897; Huang Mingzhou 2211804; 20241221 
*/
use yii\helpers\Html;
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
                            
                            <!-- 显示用户姓名 -->
                        <span class="d-none d-md-inline"><?= $username ?></span>
                        </a>
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
                            <a href="<?= Url::to(['site/index2']) ?>" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>完成情况</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= Url::to(['site/index3']) ?>" class="nav-link active">
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
                            <h3 class="mb-0">提交记录</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="<?= Url::to(['site/index']) ?>">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    提交记录
                                </li>
                            </ol>
                        </div>
                    </div> <!--end::Row-->
                </div> <!--end::Container-->
            </div>
            <div class="app-content"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card mb-4">
                                <div class="card-header border-0">
                                    <div class="d-flex justify-content-between">
                                        <h3 class="card-title">课程提交总通过率(%)</h3> 

                                    </div>
                                </div>
                                <div class="card-body">

                                    <div class="position-relative mb-4">
                                        <div id="submit_chart"></div>
                                    </div>

                                </div>
                            </div> <!-- /.card -->

                        </div> <!-- /.col-md-6 -->
                        <div class="col-lg-6">
                            <div class="card mb-4">
                                <div class="card-header border-0">
                                    <div class="d-flex justify-content-between">
                                        <h3 class="card-title">课程总提交情况</h3> 
                                    </div>
                                </div>
                                <div class="card-body">

                                    <div class="position-relative mb-4">
                                        <div id="course-chart"></div>
                                    </div>

                                </div>
                            </div> <!-- /.card -->

                        </div> <!-- /.col-md-6 -->
                        <div class="card mb-4">
                                <div class="card-header border-0">
                                    <h3 class="card-title">用户提交记录</h3>
                                    <div class="card-tools"> <a href="#" class="btn btn-tool btn-sm"> <i
                                                class="bi bi-download"></i> </a> <a href="#"
                                            class="btn btn-tool btn-sm"> <i class="bi bi-list"></i> </a> </div>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-striped align-middle">
                                        <thead>
                                            <tr>                                                
                                                <th>问题id</th>
                                                <th>提交用户id</th>
                                                <th>代码大小</th>
                                                <th>运行时间</th>
                                                <th>运行内存</th>
                                                <th>提交时间</th>
                                                <th>得分</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($submissionData as $data): ?>
                                                <tr>

                                                    <td><?= Html::encode($data->pid) ?></td> <!-- 问题id -->
                                                    <td>
                                                        <?= Html::encode($data->uid) ?> <!-- 提交用户id -->
                                                    </td>
                                                    <td>
                                                        <?= Html::encode($data->code_size) ?> <!-- 代码大小 -->
                                                    </td>
                                                    <td>
                                                        <?= Html::encode($data->run_time) ?> <!-- 运行时间 -->
                                                    </td>
                                                    <td>
                                                        <?= Html::encode($data->run_memory) ?> <!-- 运行内存 -->
                                                    </td>
                                                    <td>
                                                        <?= Yii::$app->formatter->asDatetime($data->when) ?> <!-- 提交时间 -->
                                                    </td>
                                                    <td>
                                                        <?= Html::encode($data->score) ?> <!-- 得分 -->
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div> <!-- /.card -->
                    </div> <!--end::Row-->
                </div> <!--end::Container-->
            </div> <!--end::App Content-->
        </main> <!--end::App Main--> <!--begin::Footer-->

    </div> <!--end::App Wrapper--> <!--begin::Script--> <!--begin::Third Party Plugin(OverlayScrollbars)-->

    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
        integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8=" crossorigin="anonymous"></script>
    <script>
        // NOTICE!! DO NOT USE ANY OF THIS JAVASCRIPT
        // IT'S ALL JUST JUNK FOR DEMO
        // ++++++++++++++++++++++++++++++++++++++++++

        const sub_chart_options = {
            series: [{
                name: <?= json_encode($courseNames[0]) ?>,
                data: <?= json_encode($results[0]['pass_rates'], JSON_NUMERIC_CHECK) ?>,
            },
            {
                name: <?= json_encode($courseNames[1]) ?>,
                data: <?= json_encode($results[1]['pass_rates'], JSON_NUMERIC_CHECK) ?>,
            },
            {
                name: <?= json_encode($courseNames[2]) ?>,
                data: <?= json_encode($results[2]['pass_rates'], JSON_NUMERIC_CHECK) ?>
            },
            ],
            chart: {
                height: 200,
                type: "line",
                toolbar: {
                    show: false,
                },
            },
            colors: ["#0d6efd", "#adb5bd","#ffc107"],
            stroke: {
                curve: "smooth",
            },
            grid: {
                borderColor: "#e7e7e7",
                row: {
                    colors: ["#f3f3f3", "transparent"], // takes an array which will be repeated on columns
                    opacity: 0.5,
                },
            },
            legend: {
                show: false,
            },
            markers: {
                size: 1,
            },
            xaxis: {
                categories: <?= json_encode($results[0]['dates']) ?>, // 使用日期数据
            },
        };

        const sub_chart = new ApexCharts(
            document.querySelector("#submit_chart"),
            sub_chart_options
        );
        sub_chart.render();

        const course_chart_options = {
            series: [{
                name: "提交次数",
                data: <?= json_encode($subCounts, JSON_NUMERIC_CHECK) ?>,
            },
            {
                name: "正确次数",
                data: <?= json_encode($finCounts, JSON_NUMERIC_CHECK) ?>,  
            },
            {
                name: "完成人数",
                data: <?= json_encode($finUsers, JSON_NUMERIC_CHECK) ?>
            },
            ],
            chart: {
                type: "bar",
                height: 200,
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: "55%",
                    endingShape: "rounded",
                },
            },
            legend: {
                show: false,
            },
            colors: ["#0d6efd", "#20c997", "#ffc107"],
            dataLabels: {
                enabled: false,
            },
            stroke: {
                show: true,
                width: 2,
                colors: ["transparent"],
            },
            xaxis: {
                categories: <?= json_encode($courseNames) ?>,
            },
            fill: {
                opacity: 1,
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "$ " + val + " 人";
                    },
                },
            },
        };

        const course_chart = new ApexCharts(
            document.querySelector("#course-chart"),
            course_chart_options
        );
        course_chart.render();
    </script> <!--end::Script-->
</body><!--end::Body-->

</html>