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
                                    <h3><?= $submitAllCount ?></h3>
                                    <p>总提交数</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box text-bg-success">
                                <div class="inner">
                                    <h3><?= $accuracy ?><sup class="fs-5">%</sup></h3>
                                    <p>正确率</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box text-bg-warning">
                                <div class="inner">
                                    <h3><?= $passstu ?></h3>
                                    <p>通过人数</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box text-bg-danger">
                                <div class="inner">
                                    <h3><?= $allsubmit ?></h3>
                                    <p>总提交人数</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12 connectedSortable">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title">上一题完成情况</h3>
                                </div>
                                <div class="card-body">
                                    <div id="revenue-chart"></div>
                                </div>
                            </div>
                        </div>

                        
                    </div>
                    <div class="col-lg-12 connectedSortable">
                    <div class="card text-dark bg-light  custom-border mb-4">
                        <div class="card-header border-0">
                            <h3 class="card-title">删除操作</h3>
                        </div>
                        <div class="card-body">
                            <!-- 删除操作 -->
                            <div class="form-row">
                            <div class="col-md-12" style="display: flex; justify-content: space-between; align-items: center;">
                                <div class="col-md-8">
                                    <label for="delete-problem-id">删除习题（输入习题ID）</label>
                                    <input type="number" class="form-control" id="delete-problem-id" placeholder="习题ID">
                                </div>
                                <button class="btn btn-danger mt-2" onclick="deleteProblem()">删除习题</button>
                            </div>

                                <div class="col-md-12"style="display: flex; justify-content: space-between; align-items: center;">
                                <div class="col-md-8">
                                    <label for="delete-psid">删除习题集（输入习题集ID）</label>
                                    <input type="number" class="form-control" id="delete-psid" placeholder="习题集ID">
                                    </div>
                                    <button class="btn btn-danger mt-2" onclick="deleteProblemSet()">删除习题集</button>
                                </div>

                                <div class="col-md-12" style="display: flex; justify-content: space-between; align-items: center;">
                                <div class="col-md-8">
                                    <label for="delete-cid">删除课程（输入课程ID）</label>
                                    <input type="number" class="form-control" id="delete-cid" placeholder="课程ID">
                                    </div>
                                    <button class="btn btn-danger mt-2" onclick="deleteCourse()" >删除课程</button>
                                </div>
                            </div>

                            <hr>

                            <!-- 新增操作，明显分隔 -->
                            <div class="form-group">
                            <div>
                                <h4 class="card-title">新增习题</h4>
                                </div>
                                <div>
                                <label ></label>
                                </div>
                                <label for="add-psid">习题ID (pid)</label>
                                <input type="number" class="form-control" id="add-pid" placeholder="输入习题ID">
                                <label for="add-psid">习题集ID (psid)</label>
                                <input type="number" class="form-control" id="add-psid" placeholder="输入习题集ID">

                                <label for="add-title">习题标题</label>
                                <input type="text" class="form-control" id="add-title" placeholder="输入习题标题">                               

                                <label for="add-cases">测试案例数</label>
                                <input type="number" class="form-control" id="add-cases" placeholder="输入测试案例数">

                                <label for="add-time_limit">时间限制</label>
                                <input type="number" class="form-control" id="add-time_limit" placeholder="输入时间限制">

                                <label for="add-memory_limit">内存限制</label>
                                <input type="number" class="form-control" id="add-memory_limit" placeholder="输入内存限制">

                                <label for="add-owner_id">拥有者ID</label>
                                <input type="number" class="form-control" id="add-owner_id" placeholder="输入拥有者ID">
                                
                                <button class="btn btn-success mt-2 " onclick="addProblem()" style="float: right;">新增习题</button>
                                <div>
                                <label ></label>
                                </div>
                                <div>
                                <label ></label>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group">
                                <div>
                                <h4 class="card-title">新增习题集</h4>
                                </div>
                                <div>
                                <label ></label>
                                </div>
                                <label for="add-psid-set">习题集ID (psid)</label>
                                <input type="number" class="form-control" id="add-psid-set" placeholder="输入习题集ID">

                                <label for="add-title-set">习题集标题</label>
                                <input type="text" class="form-control" id="add-title-set" placeholder="输入习题集标题">

                                <label for="add-description">描述</label>
                                <input type="text" class="form-control" id="add-description" placeholder="输入描述">

                                
                                <label for="add-start-time">开始时间</label>
                                <input type="datetime-local" class="form-control" id="add-start-time" placeholder="选择开始时间">


                                <label for="add-end-time">结束时间</label>
                                <input type="datetime-local" class="form-control" id="add-end-time" placeholder="选择结束时间">


                                <label for="add-cid-set">课程ID</label>
                                <input type="number" class="form-control" id="add-cid-set" placeholder="输入课程ID">

                                <label for="add-owner-id-set">拥有者ID</label>
                                <input type="number" class="form-control" id="add-owner-id-set" placeholder="输入拥有者ID">

                                <button class="btn btn-success mt-2" onclick="addProblemSet()" style="float: right;">新增习题集</button>
                                <div>
                                <label ></label>
                                </div>
                                <div>
                                <label ></label>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group">
                            <div><h4 class="card-title">新增课程</h4></div>
                            <div>
                                <label ></label>
                                </div>
                                <label for="add-cid-course">课程ID (cid)</label>
                                <input type="number" class="form-control" id="add-cid-course" placeholder="输入课程ID">

                                <label for="add-title-course">课程标题</label>
                                <input type="text" class="form-control" id="add-title-course" placeholder="输入课程标题">

                                <label for="add-description-course">课程描述</label>
                                <input type="text" class="form-control" id="add-description-course" placeholder="输入课程描述">

                                <label for="add-passcode">passcode</label>
                                <input type="text" class="form-control" id="add-passcode" placeholder="输入课程密码">

                                <label for="add-number">课程号</label>
                                <input type="text" class="form-control" id="add-number" placeholder="输入课程号">

                                <label for="add-owner-id-course">拥有者ID</label>
                                <input type="number" class="form-control" id="add-owner-id-course" placeholder="输入拥有者ID">

                                <button class="btn btn-success mt-2" onclick="addCourse()" style="float: right;">新增课程</button>
                                <div>
                                <label ></label>
                                </div>
                                <div>
                                <label ></label>
                                </div>
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
    

    <script>
        const submitsituation = {
            series: [{
                name: "总提交次数",
                data: <?= json_encode($total_submissions, JSON_NUMERIC_CHECK) ?>,
            },
            {
                name: "通过次数",
                data: <?= json_encode($passed_submissions, JSON_NUMERIC_CHECK) ?>,
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
                categories: <?= json_encode($dates) ?>,
            },
        };

        const submitsituation_chart = new ApexCharts(document.querySelector("#revenue-chart"), submitsituation);
        submitsituation_chart.render();

        




        //增删
        // 删除习题
            function deleteProblem() {
                const problemId = document.getElementById('delete-problem-id').value;

                if (problemId) {
                    $.ajax({
                        url: '<?= Url::to(["site/delete-problem"]) ?>',
                        type: 'POST',
                        data: { id: problemId },
                        success: function(response) {
                            alert(response.message);
                            location.reload(); // 刷新页面，显示删除后的状态
                        }
                    });
                } else {
                    alert('请输入习题ID');
                }
            }

            // 删除习题集
            function deleteProblemSet() {
                const psid = document.getElementById('delete-psid').value;

                if (psid) {
                    $.ajax({
                        url: '<?= Url::to(["site/delete-problem-set"]) ?>',
                        type: 'POST',
                        data: { id: psid },
                        success: function(response) {
                            alert(response.message);
                            location.reload(); // 刷新页面，显示删除后的状态
                        }
                    });
                } else {
                    alert('请输入习题集ID');
                }
            }

            // 删除课程
            function deleteCourse() {
                const cid = document.getElementById('delete-cid').value;

                if (cid) {
                    $.ajax({
                        url: '<?= Url::to(["site/delete-course"]) ?>',
                        type: 'POST',
                        data: { id: cid },
                        success: function(response) {
                            alert(response.message);
                            location.reload(); // 刷新页面，显示删除后的状态
                        }
                    });
                } else {
                    alert('请输入课程ID');
                }
            }

            // 新增习题
            function addProblem() {
                const pid = document.getElementById('add-pid').value;
                const psid = document.getElementById('add-psid').value;
                const title = document.getElementById('add-title').value;
                const cases = document.getElementById('add-cases').value;
                const timeLimit = document.getElementById('add-time_limit').value;
                const memoryLimit = document.getElementById('add-memory_limit').value;
                const ownerId = document.getElementById('add-owner_id').value;

                if (pid&&psid && title && cases && timeLimit && memoryLimit && ownerId) {
                    $.ajax({
                        url: '<?= Url::to(["site/add-problem"]) ?>',
                        type: 'POST',
                        data: {
                            pid: pid,
                            psid: psid,
                            title: title,
                            cases: cases,
                            time_limit: timeLimit,
                            memory_limit: memoryLimit,
                            owner_id: ownerId
                        },
                        success: function(response) {
                            const res = JSON.parse(response); // 解析返回的 JSON 数据
                            alert(res.message); // 提示新增结果
                            location.reload(); // 刷新页面，显示新增后的状态
                        }
                    });
                } else {
                    alert('请填写所有字段。');
                }
            }

            function addProblemSet() {
                const psidSet = document.getElementById('add-psid-set').value;
                const titleSet = document.getElementById('add-title-set').value;
                const description = document.getElementById('add-description').value;
                const startTime = document.getElementById('add-start-time').value;
                const endTime = document.getElementById('add-end-time').value;
                const cidSet = document.getElementById('add-cid-set').value;
                const ownerIdSet = document.getElementById('add-owner-id-set').value;

                if (psidSet && titleSet && description && startTime&& endTime && cidSet && ownerIdSet) {
                    $.ajax({
                        url: '<?= Url::to(["site/add-problem-set"]) ?>', // 调用后台的 `add-problem-set` 方法
                        type: 'POST',
                        data: {
                            psid_set: psidSet,
                            title_set: titleSet,
                            description: description,
                            start_time: startTime,
                            end_time: endTime,
                            cid_set: cidSet,
                            owner_id_set: ownerIdSet
                        },
                        success: function(response) {
                            const res = JSON.parse(response); // 解析返回的 JSON 数据
                            alert(res.message); // 提示新增结果
                            location.reload(); // 刷新页面，显示新增后的状态
                        }
                    });
                } else {
                    alert('请填写所有字段。');
                }
            }

            // 新增课程
            function addCourse() {
                const cidCourse = document.getElementById('add-cid-course').value;
                const titleCourse = document.getElementById('add-title-course').value;
                const descriptionCourse = document.getElementById('add-description-course').value;
                const passcode = document.getElementById('add-passcode').value;
                const number = document.getElementById('add-number').value;
                const ownerIdCourse = document.getElementById('add-owner-id-course').value;

                if (cidCourse && titleCourse && descriptionCourse && passcode && number && ownerIdCourse) {
                    $.ajax({
                        url: '<?= Url::to(["site/add-course"]) ?>',
                        type: 'POST',
                        data: {
                            cid_course: cidCourse,
                            title_course: titleCourse,
                            description_course: descriptionCourse,
                            passcode: passcode,
                            number: number,
                            owner_id_course: ownerIdCourse
                        },
                        success: function(response) {
                            const res = JSON.parse(response); // 解析返回的 JSON 数据
                            alert(res.message); // 提示新增结果
                            location.reload(); // 刷新页面，显示新增后的状态
                        }
                    });
                } else {
                    alert('请填写所有字段。');
                }
            }
    </script>
</body>

</html>