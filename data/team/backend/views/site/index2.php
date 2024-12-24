<?php
/**
* Team: 
* Coding by Cai Yuanhong 2213897; Huang Mingzhou 2211804; 20241221 
*/
use yii\helpers\Html;
use yii\helpers\Json; 
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
                                    <h5 class="card-title"><?=$setname?>习题提交情况</h5>
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
                                            <p class="text-center"> <strong>周期统计</strong> </p>
                                            <div class="progress-group">
                                                通过情况
                                                <span class="float-end"><b><?= array_sum($passed_submissions) ?></b>/ <?= array_sum($total_submissions) ?></span>
                                                <div class="progress progress-sm">
                                                    <?php
                                                        $total = array_sum($total_submissions);
                                                        $passed = array_sum($passed_submissions);
                                                        $percentage = $total > 0 ? ($passed / $total) * 100 : 0; // 避免除以零
                                                    ?>
                                                    <div class="progress-bar text-bg-primary" style="width: <?= number_format($percentage, 2) ?>%;"></div>
                                                </div>
                                            </div> <!-- /.progress-group -->
                                            <div class="progress-group">
                                                提交人数
                                                <span class="float-end"><b><?= $totalUniqueUsers ?> </b> / <?= $allstu ?> </span>
                                                <div class="progress progress-sm">
                                                    <?php
                                                        $percentage = $allstu > 0 ? ($totalUniqueUsers / $allstu) * 100 : 0; // 避免除以零
                                                    ?>
                                                    <div class="progress-bar text-bg-danger" style="width: <?= number_format($percentage, 2) ?>%"></div>
                                                </div>
                                            </div> <!-- /.progress-group -->
                                            <div class="progress-group"> <span class="progress-text">不及格提交次数</span> <span class="float-end"><b><?= $totalLowScoreSubmissions ?></b>/ <?= array_sum($total_submissions) ?></span>
                                                <div class="progress progress-sm">
                                                    <?php
                                                        $total = array_sum($total_submissions);
                                                        $percentage = $total > 0 ? ($totalLowScoreSubmissions / $total) * 100 : 0; // 避免除以零
                                                    ?>
                                                    <div class="progress-bar text-bg-success" style="width: <?= number_format($percentage, 2) ?>%"></div>
                                                </div>
                                            </div> <!-- /.progress-group -->
                                            <div class="progress-group">
                                                被完成题目数
                                                <span class="float-end"><b><?= $totaldone ?></b>/<?= $pids_num ?></span>
                                                <div class="progress progress-sm">
                                                    <?php
                                                        $percentage = $pids_num > 0 ? ($totaldone / $pids_num) * 100 : 0; // 避免除以零
                                                    ?>
                                                    <div class="progress-bar text-bg-warning" style="width: <?= number_format($percentage, 2) ?>%"></div>
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
                                    <h3 class="card-title"><?=$setname?>最近提交记录</h3>
                                    <div class="card-tools"> <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse"> <i data-lte-icon="expand" class="bi bi-plus-lg"></i> <i data-lte-icon="collapse" class="bi bi-dash-lg"></i> </button> <button type="button" class="btn btn-tool" data-lte-toggle="card-remove"> <i class="bi bi-x-lg"></i> </button> </div>
                                </div> <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover text-center m-0">
                                            <thead>
                                                <tr>
                                                    <th>PID</th>
                                                    <th>UID</th>
                                                    <th>Score</th>
                                                    <th>SubmissionTime</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($submissionData as $data): ?>
                                                    <tr>
                                                        <td> <?= Html::encode($data->pid) ?></td>
                                                        <td> <?= Html::encode($data->uid) ?> </td>
                                                        <td>
                                                            <?php 
                                                                $score = $data->score;
                                                                if ($score == 100) {
                                                                    echo "<span class='badge text-bg-success'>{$score}</span>";
                                                                } elseif ($score >= 60 && $score < 100) {
                                                                    echo "<span class='badge text-bg-warning'>{$score}</span>";
                                                                } else {
                                                                    echo "<span class='badge text-bg-danger'>{$score}</span>";
                                                                }
                                                            ?>
                                                        </td>
                                                        <td> <?= Yii::$app->formatter->asDatetime($data->when) ?> <!-- 提交时间 --> </td>
                                                    </tr>                                                    
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div> <!-- /.table-responsive -->
                                </div> <!-- /.card-body -->
                                
                            </div> <!-- /.card -->
                        </div> <!-- /.col -->
                        <div class="col-md-4"> <!-- Info Boxes Style 2 -->
                            
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">练习题集</h3>
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
                                        <?php foreach ($problemSets as $problemSet): ?>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link" 
                                                onclick="location.href='<?= \yii\helpers\Url::to(['site/index2', 'psid' => $problemSet->psid]) ?>'">
                                                    <?= Html::encode($problemSet->title) ?> <!-- 显示习题集标题 -->
                                                    <span class="float-end">
                                                        <i class="bi bi-arrow-right fs-7"></i>
                                                    </span>
                                                    <p class="small"><?= Html::encode($problemSet->description) ?></p> <!-- 显示描述 -->
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
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

        const submission_situation = {
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

        const submission_chart = new ApexCharts(
            document.querySelector("#sales-chart"),
            submission_situation,
        );
        submission_chart.render();


        //-------------
        // - PIE CHART -
        //-------------

        const completion_situation = {
            series:<?= json_encode($scoreRanges, JSON_NUMERIC_CHECK) ?>,
            chart: {
                type: "donut",
            },
            labels: ["100", "90-99", "80-89", "70-79", "60-69", "<60"],
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
            completion_situation,
        );
        pie_chart.render();

        //-----------------
        // - END PIE CHART -
        //-----------------
    </script> <!--end::Script-->
</body><!--end::Body-->
</html>
