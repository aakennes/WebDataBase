<?php
/**
* Team: 通宵达旦
* Coding by Cai Yuanhong 2213897; 20241222 
*/
?>
<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Problem;
use app\models\ProblemMaintainer;
use app\models\Solution;
use app\models\ProblemsetUser;
use app\models\Problemset;
use app\models\Course;
use app\models\User;
use app\models\CourseUser;
use yii\helpers\ArrayHelper;
use app\models\Usercon;
use app\models\ProblemsetMaintainer;

class SiteController extends Controller
{   

    // 删除习题
    public function actionDeleteProblem()
    {
        $id = Yii::$app->request->post('id');
        $model = $this->findProblem($id);

        // 从 session 中获取 uid
        $sessionUid = Yii::$app->session->get('uid', null);
        
        // 如果 session 中没有 uid，则抛出异常
        if ($sessionUid === null) {
            throw new \yii\web\BadRequestHttpException('无法找到有效的 UID');
        }
        
        $uid = $sessionUid;
        if( $model&& $model->owner_id == $uid){
            $this->deleteRelatedRecords($model);
        if ( $model->delete()) {
            // 删除成功
            Yii::$app->session->setFlash('success', '习题删除成功');
            
        } else {
            Yii::$app->session->setFlash('error', '习题删除失败');
            
        }
        }

        return $this->redirect(['index']);
    }
    // 删除与习题相关的其他记录
    private function deleteRelatedRecords($problem)
    {
        
        Yii::$app->db->createCommand()
            ->delete('problem_maintainer', ['pid' => $problem->pid])
            ->execute();

        Yii::$app->db->createCommand()
            ->delete('problem_user', ['pid' => $problem->pid])
            ->execute();

        Yii::$app->db->createCommand()
            ->delete('solution', ['pid' => $problem->pid])
            ->execute();
    }

    // 删除习题集
    public function actionDeleteProblemSet()
    {   
        $id = Yii::$app->request->post('id');
        $model = $this->findProblemSet($id);

        // 从 session 中获取 uid
        $sessionUid = Yii::$app->session->get('uid', null);
        
        // 如果 session 中没有 uid，则抛出异常
        if ($sessionUid === null) {
            throw new \yii\web\BadRequestHttpException('无法找到有效的 UID');
        }
        
        $uid = $sessionUid;
        if( $model&& $model->owner_id == $uid){
            $this->deleteRelatedRecords2($model);
        if ( $model->delete()) {
            // 删除成功
            Yii::$app->session->setFlash('success', '习题集删除成功');
        } else {
            Yii::$app->session->setFlash('error', '习题集删除失败');
        }
    }

        return $this->redirect(['index']);
    }
    // 删除与习题相关的其他记录
    private function deleteRelatedRecords2($problem)
    {
        
        Yii::$app->db->createCommand()
            ->delete('problemset_maintainer', ['psid' => $problem->psid])
            ->execute();

        Yii::$app->db->createCommand()
            ->delete('problemset_user', ['psid' => $problem->psid])
            ->execute();

        Yii::$app->db->createCommand()
            ->delete('problem', ['psid' => $problem->psid])
            ->execute();
    }

    // 删除课程
    public function actionDeleteCourse()
    {   
        $id = Yii::$app->request->post('id');
        $model = $this->findCourse($id);

        // 从 session 中获取 uid
        $sessionUid = Yii::$app->session->get('uid', null);
        
        // 如果 session 中没有 uid，则抛出异常
        if ($sessionUid === null) {
            throw new \yii\web\BadRequestHttpException('无法找到有效的 UID');
        }
        
        $uid = $sessionUid;
        if( $model&& $model->owner_id == $uid){
        if ($model && $model->delete()) {
            $this->deleteRelatedRecords3($model);
            // 删除成功
            Yii::$app->session->setFlash('success', '课程删除成功');
        } else {
            Yii::$app->session->setFlash('error', '课程删除失败');
        }
    }
        return $this->redirect(['index']);
    }
    // 删除与习题相关的其他记录
    private function deleteRelatedRecords3($problem)
    {
        
        Yii::$app->db->createCommand()
            ->delete('problemset', ['cid' => $problem->cid])
            ->execute();

        Yii::$app->db->createCommand()
            ->delete('course_user', ['cid' => $problem->cid])
            ->execute();

        
    }

    // 查找习题
    protected function findProblem($id)
    {
        if (($model = Problem::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('找不到对应的习题。');
    }

    // 查找习题集
    protected function findProblemSet($id)
    {
        if (($model = Problemset::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('找不到对应的习题集。');
    }

    // 查找课程
    protected function findCourse($id)
    {
        if (($model = Course::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('找不到对应的课程。');
    }

    // 新增习题
    public function actionAddProblem()
    {
        // 创建新的 Problem 模型
        $model = new Problem();

        $modelm = new ProblemMaintainer();
        // 检查请求是否为 AJAX 且是 POST 请求
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            // 加载 POST 数据
            $data = Yii::$app->request->post();
            
            // 使用获取的数据赋值到模型
            $model->pid = $data['pid'];
            $model->psid = $data['psid'];
            $model->title = $data['title'];
            $model->cases = $data['cases'];
            $model->time_limit = $data['time_limit'];
            $model->memory_limit = $data['memory_limit'];
            $model->owner_id = $data['owner_id'];
            
            $modelm->pid= $data['pid'];
            $modelm->uid= $data['owner_id'];
            // 将 submit_ac 和 submit_all 设置为 "暂无"
            $model->submit_ac = 0;
            $model->submit_all = 0;


            // 验证模型数据并保存
            if ($model->validate() && $model->save()&&$modelm->validate() && $modelm->save()) {
                // 返回成功信息
                return json_encode(['message' => '习题新增成功']);
            } else {
                // 返回失败信息
                return json_encode(['message' => '习题新增失败，请检查数据']);
            }
        }

        // 如果不是 AJAX 请求或 POST 请求，直接返回错误
        return json_encode(['message' => '无效的请求']);
    }

    // 新增习题集
    public function actionAddProblemSet()
    {
        $model = new Problemset();

        $modelm = new ProblemsetMaintainer();
        // 检查是否是 AJAX 请求且是 POST 请求
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            // 获取 POST 数据
            $data = Yii::$app->request->post();

            // 手动将前端传递的数据赋值给模型
            $model->psid = $data['psid_set']; // 使用传递的习题集 ID
            $model->title = $data['title_set']; // 使用传递的习题集标题
            $model->description = $data['description']; // 使用习题集描述
            $model->start_time = $data['start_time']; // 使用习题集时长
            $model->end_time = $data['end_time']; // 使用习题集时长
            $model->cid = $data['cid_set']; // 使用课程 ID
            $model->owner_id = $data['owner_id_set']; // 使用习题集所有者 ID

            $modelm->psid=$data['psid_set'];
            $modelm->uid=$data['owner_id_set'];
            // 验证并保存数据
            if ($model->validate() && $model->save()&&$modelm->validate() && $modelm->save()) {
                // 返回成功消息
                return json_encode(['message' => '习题集新增成功']);
            } else {
                // 返回错误消息
                return json_encode(['message' => '习题集新增失败，请检查数据']);
            }
        }

        // 如果请求不是 AJAX 或 POST 请求，返回无效请求的消息
        return json_encode(['message' => '无效的请求']);
    }

    // 新增课程
    public function actionAddCourse()
    {
        $model = new Course();

        // 检查是否是 AJAX 请求且是 POST 请求
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            // 获取 POST 数据
            $data = Yii::$app->request->post();

            // 手动将前端传递的数据赋值给模型
            $model->cid = $data['cid_course']; // 使用传递的课程 ID
            $model->title = $data['title_course']; // 使用传递的课程标题
            $model->description = $data['description_course']; // 使用课程描述
            $model->passcode = $data['passcode']; // 使用课程的 passcode
            $model->number = $data['number']; // 使用课程的数量
            $model->owner_id = $data['owner_id_course']; // 使用课程的所有者 ID

            // 验证并保存数据
            if ($model->validate() && $model->save()) {
                return json_encode(['message' => '课程新增成功']);
            } else {
                // 返回错误消息
                return json_encode(['message' => '课程新增失败，请检查数据']);
            }
        }

        // 如果请求不是 AJAX 或 POST 请求，返回无效请求的消息
        return json_encode(['message' => '无效的请求']);
    }

    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        // 从 URL 中提取 uid
        $uid = Yii::$app->request->get('uid', null);

        // 如果 URL 中提供了 uid，保存到 session
        if ($uid !== null) {
            Yii::$app->session->set('uid', $uid);
        }
        
        // 从 session 中获取 uid
        $sessionUid = Yii::$app->session->get('uid', null);
        
        // 如果 session 中没有 uid，则抛出异常
        if ($sessionUid === null) {
            throw new \yii\web\BadRequestHttpException('无法找到有效的 UID');
        }

        $uid = $sessionUid;


        $username = User::find()
            ->select(['nickname'])  // 选择 nickname 字段
            ->where(['uid' => $uid]) // 根据 uid 查询
            ->scalar(); // 返回单个字段值


        // 查询该用户创建的最新题目的 pid
        $latestProblem = ProblemMaintainer::find()
            ->where(['uid' => $uid])
            ->orderBy(['pid' => SORT_DESC]) // 按 pid 降序排列
            ->one();
        
        //上方栏数据
        $submitAllCount = 0;
        $submitac = 0;
        $accuracy = 0;
        $passstu = 0;
        $allsubmit = 0;

        if ($latestProblem) {
            // 根据最新的 pid 查询 problem 表的 submit_all
            $problem = Problem::find()
                ->where(['pid' => $latestProblem->pid])
                ->one();

            if ($problem) {
                $submitAllCount = $problem->submit_all;
            }
        }

        if ($latestProblem) {
            // 根据最新的 pid 查询 problem 表的 submit_all
            $problem = Problem::find()
                ->where(['pid' => $latestProblem->pid])
                ->one();

            if ($problem) {
                $submitAllCount = $problem->submit_all;
                $submitac = $problem->submit_ac;
                $accuracy = round(($submitac / $submitAllCount)*100);

                // 计算通过人数 passstu
                $passstu = Solution::find()
                    ->select(['uid']) // 只查询 uid 列
                    ->where(['pid' => $latestProblem->pid, 'score' => 100]) // 查询通过的提交
                    ->distinct() // 去重
                    ->count(); // 统计人数
                $allsubmit = Solution::find()
                    ->select(['uid']) // 只查询 uid 列
                    ->where(['pid' => $latestProblem->pid]) // 查询通过的提交
                    ->distinct() // 去重
                    ->count(); // 统计人数
            }
        }


        // 查询有提交记录的最近 7 天数据并按日期分组
        $results = Solution::find()
        ->select([
            'submission_date' => 'DATE(`when`)',  // 提交日期
            'total_submissions' => 'COUNT(*)', // 总提交次数
            'passed_submissions' => 'SUM(CASE WHEN score = 100 THEN 1 ELSE 0 END)', // 通过次数
        ])
        ->where(['pid' => $latestProblem->pid])
        ->groupBy(['submission_date'])
        ->orderBy(['submission_date' => SORT_DESC]) // 按日期倒序排列
        ->limit(7) // 只取最近 7 天有提交记录的数据
        ->asArray()        // 返回数组形式
        ->all();

        // 构造每天的提交次数数组和通过次数数组
        $dates = [];
        $totalSubmissions = [];
        $passedSubmissions = [];

        // 填充结果
        foreach ($results as $result) {
        $dates[] = $result['submission_date'];
        $totalSubmissions[] = $result['total_submissions'];
        $passedSubmissions[] = $result['passed_submissions'];
        }

        // 按日期升序排序（因为查询结果是倒序）
        $dates = array_reverse($dates);
        $totalSubmissions = array_reverse($totalSubmissions);
        $passedSubmissions = array_reverse($passedSubmissions);


        // 将结果传递给视图
        return $this->render('index', [
            'username'=>$username,
            'submitAllCount' => $submitAllCount,
            'accuracy' => $accuracy,
            'passstu' => $passstu,
            'allsubmit' => $allsubmit,
            'dates' => $dates,
            'total_submissions' => $totalSubmissions,
            'passed_submissions' => $passedSubmissions,
            'username' => $username,
        ]);
    }

    public function actionIndex2()
    {   

        // 从 session 中获取 uid
        $sessionUid = Yii::$app->session->get('uid', null);
        
        // 如果 session 中没有 uid，则抛出异常
        if ($sessionUid === null) {
            throw new \yii\web\BadRequestHttpException('无法找到有效的 UID');
        }
        
        $uid = $sessionUid;
        
        $username = User::find()
            ->select(['nickname'])  // 选择 nickname 字段
            ->where(['uid' => $uid]) // 根据 uid 查询
            ->scalar(); // 返回单个字段值


        // 查询数据库获取所有习题集数据
        $problemSets = ProblemSet::find()->all(); 
        // 从 URL 中获取 psid 参数
        $psid = Yii::$app->request->get('psid', null);  // 获取 psid 参数

        // 如果没有 psid，使用默认值，默认值是 81
        if ($psid === null) {
            $psid = 81;
        }

        $setname = Problemset::find()
            ->select(['title'])
            ->where(['psid' => $psid])
            ->scalar(); // 返回单个字段值

        $allstu = 0;
        $allstu = ProblemsetUser::find()
            ->where(['psid' => $psid])
            ->count(); // 计算满足条件的记录总数
        
            
        // 找到所有 pid
        $pids = Problem::find()
            ->select('pid')
            ->where(['psid' => $psid])
            ->column();
            
        // 查询 solution 表中对应 pid 的记录数
        $totalSubmissions = Solution::find()
            ->where(['pid' => $pids])
            ->count();
        
        // 查询 solution 表中唯一的 uid 数量        
        $sql = "
            SELECT COUNT(DISTINCT uid) AS total_users
            FROM solution
            WHERE pid IN (
                SELECT pid
                FROM problem
                WHERE psid = :psid
            )
        ";
        
        $totalUsers = Yii::$app->db->createCommand($sql, [':psid' => $psid])->queryScalar();


        //总正确率
        $correctSubmissions = Solution::find()
            ->where(['pid' => $pids, 'score' => 100])
            ->count();
        
        $accuracy = round(($correctSubmissions / $totalSubmissions)*100);

        // 每日提交情况
        // 查询有提交记录的最近 7 天数据并按日期分组
        $results = Solution::find()
            ->select([
                'submission_date' => 'DATE(`when`)',  // 提交日期
                'total_submissions' => 'COUNT(*)', // 总提交次数
                'passed_submissions' => 'SUM(CASE WHEN score = 100 THEN 1 ELSE 0 END)', // 通过次数
            ])
            ->where(['pid' => $pids])
            ->groupBy(['submission_date'])
            ->orderBy(['submission_date' => SORT_DESC]) // 按日期倒序排列
            ->limit(7) // 只取最近 7 天有提交记录的数据
            ->asArray()        // 返回数组形式
            ->all();
        
            // 构造每天的提交次数数组和通过次数数组
            $dates = [];
            $totalSubmissions_day = [];
            $passedSubmissions_day = [];
        
            // 填充结果
            foreach ($results as $result) {
                $dates[] = $result['submission_date'];
                $totalSubmissions_day[] = $result['total_submissions'];
                $passedSubmissions_day[] = $result['passed_submissions'];
            }
        
            // 按日期升序排序（因为查询结果是倒序）
            $dates = array_reverse($dates);
            $totalSubmissions_day = array_reverse($totalSubmissions_day);
            $passedSubmissions_day = array_reverse($passedSubmissions_day);


        //计算这7天提交总人数
        $totalUniqueUsers = Solution::find()
            ->select(['uid']) // 选择用户ID
            ->where(['pid' => $pids]) // 限制在指定的习题集中
            ->andWhere(['>=', 'DATE(`when`)', $dates[0]]) // 使用 $dates[0] 作为时间范围
            ->distinct() // 去重
            ->count(); // 统计数量

        // 计算这7天提交成绩低于60的总次数
        $totalLowScoreSubmissions = Solution::find()
            ->select(['uid']) // 选择用户ID
            ->where(['pid' => $pids]) // 限制在指定的习题集中
            ->andWhere(['>=', 'DATE(`when`)', $dates[0]]) // 使用 $dates[0] 作为时间范围
            ->andWhere(['<', 'score', 60]) // 成绩低于60
            ->count(); // 统计提交次数
        
        // 计算这7天提交涉及的题目
        $totaldone = Solution::find()
            ->select(['pid']) // 选择题目ID
            ->where(['pid' => $pids]) // 限制在指定的习题集中
            ->andWhere(['>=', 'DATE(`when`)', $dates[0]]) // 使用 $dates[0] 作为时间范围
            ->distinct() // 去重
            ->count(); // 统计提交次数

        $pids_num = Problem::find()
            ->select('pid')
            ->where(['psid' => $psid])
            ->count();

        //该习题集提交记录
        $submissionData = Solution::find()
            ->select([
                'pid',          // 问题ID
                'uid',          // 提交用户ID
                'score',        // 得分
                '`when`',   // 提交时间
            ])
            ->where(['pid' => $pids])
            ->orderBy(['`when`' => SORT_DESC])  // 按提交时间降序排序
            ->limit(10)  // 限制结果为前20条
            ->all();

        // 饼图
        // 查询不同分数段的提交数
        $scoreRanges = [
            Solution::find()->where(['pid' => $pids, 'score' => 100])->count(),
            Solution::find()->where(['pid' => $pids])->andWhere(['between', 'score', 90, 99])->count(),
            Solution::find()->where(['pid' => $pids])->andWhere(['between', 'score', 80, 89])->count(),
            Solution::find()->where(['pid' => $pids])->andWhere(['between', 'score', 70, 79])->count(),
            Solution::find()->where(['pid' => $pids])->andWhere(['between', 'score', 60, 69])->count(),
            Solution::find()->where(['pid' => $pids])->andWhere(['<', 'score', 60])->count(),
        ];

        return $this->render('index2', [

            'username' => $username,
            'setname' => $setname,
            'allstu' => $allstu,
            'totalSubmissions' => $totalSubmissions,
            'totalUsers' => $totalUsers,
            'accuracy' => $accuracy,
            'dates' => $dates,
            'total_submissions' => $totalSubmissions_day,
            'passed_submissions' => $passedSubmissions_day,
            'totalUniqueUsers' => $totalUniqueUsers,
            'totalLowScoreSubmissions' => $totalLowScoreSubmissions,
            'totaldone' => $totaldone,
            'pids_num' => $pids_num,
            'submissionData' => $submissionData,
            'problemSets' => $problemSets,
            'scoreRanges' => $scoreRanges,
        ]); // 渲染 views/site/index2.php
    }

    public function actionIndex3()
    {   
        
        // 从 session 中获取 uid
        $sessionUid = Yii::$app->session->get('uid', null);
        
        // 如果 session 中没有 uid，则抛出异常
        if ($sessionUid === null) {
            throw new \yii\web\BadRequestHttpException('无法找到有效的 UID');
        }

                
        $uid = $sessionUid;
                
        $username = User::find()
            ->select(['nickname'])  // 选择 nickname 字段
            ->where(['uid' => $uid]) // 根据 uid 查询
            ->scalar(); // 返回单个字段值

        // 课程ID
        $courseIds = [12, 13, 14]; // 高级语言程序设计2-2 (12), Alg2024 (13), 密码学基础2024 (14)

        // 上方栏数据初始化
        $submitAllCount = 0;
        $submitac = 0;
        $accuracy = 0;
        $passstu = 0;
        $allsubmit = 0;

        // 查询每个课程的提交数据（最近7天）
        $results = [];
        foreach ($courseIds as $cid) {
            $courseResults = Solution::find()
                ->select([
                    'submission_date' => 'DATE(`when`)',  // 提交日期
                    'total_submissions' => 'COUNT(*)', // 总提交次数
                    'passed_submissions' => 'SUM(CASE WHEN score = 100 THEN 1 ELSE 0 END)', // 通过次数
                ])
                ->innerJoin('course_user', 'course_user.uid = solution.uid') // 关联课程和用户表
                ->where(['course_user.cid' => $cid]) // 过滤课程ID
                ->groupBy(['submission_date'])
                ->orderBy(['submission_date' => SORT_DESC]) // 按日期倒序排列
                ->limit(7) // 只取最近7天
                ->asArray() // 返回数组
                ->all();

            // 构造每天的提交次数数组和通过次数数组
            $dates = [];
            $totalSubmissions = [];
            $passedSubmissions = [];
            $passRates = []; // 新增通过率数组

            foreach ($courseResults as $result) {
                $dates[] = $result['submission_date'];
                $totalSubmissions[] = $result['total_submissions'];
                $passedSubmissions[] = $result['passed_submissions'];

                // 计算通过率，并保留两位小数
                $passRate = $result['total_submissions'] > 0 
                    ? round(($result['passed_submissions'] / $result['total_submissions']) * 100) 
                    : 0;
                $passRates[] = $passRate;
            }

            // 按日期升序排序（因为查询结果是倒序）
            $dates = array_reverse($dates);
            $totalSubmissions = array_reverse($totalSubmissions);
            $passedSubmissions = array_reverse($passedSubmissions);
            $passRates = array_reverse($passRates); // 反转通过率数组

            $results[] = [
                'cid' => $cid,
                'dates' => $dates,
                'total_submissions' => $totalSubmissions,
                'passed_submissions' => $passedSubmissions,
                'pass_rates' => $passRates, // 添加通过率数据
            ];
        }

        // 获取每个课程的提交次数、通过次数（得分100）、完成人数
        $submissionCounts = CourseUser::find()
            ->select(['course.cid', 'course.title', 'COUNT(solution.sid) AS submission_count'])  // 添加 course.title
            ->innerJoin('solution', 'course_user.uid = solution.uid')
            ->innerJoin('course', 'course_user.cid = course.cid')
            ->groupBy('course.cid')
            ->asArray()
            ->all();

        $passCounts = CourseUser::find()
            ->select(['course.cid', 'COUNT(solution.sid) AS pass_count'])
            ->innerJoin('solution', 'course_user.uid = solution.uid')
            ->innerJoin('course', 'course_user.cid = course.cid')
            ->where(['solution.score' => 100])
            ->groupBy('course.cid')
            ->asArray()
            ->all();

        $finishUsers = CourseUser::find()
            ->select(['course.cid', 'COUNT(DISTINCT solution.uid) AS finish_user_count'])
            ->innerJoin('solution', 'course_user.uid = solution.uid')
            ->innerJoin('course', 'course_user.cid = course.cid')
            ->where(['solution.score' => 100])
            ->groupBy('course.cid')
            ->asArray()
            ->all();

        // 将结果转为关联数组以便快速查找
        $passCountsAssoc = ArrayHelper::index($passCounts, 'cid');
        $finishUsersAssoc = ArrayHelper::index($finishUsers, 'cid');

        $courseNames = [];
        $subCounts = [];
        $finCounts = [];
        $finUsers = [];

        foreach ($submissionCounts as $submission) {
        $courseNames[] = $submission['title'];  
        $subCounts[] = $submission['submission_count'];
        $finCounts[] = $passCountsAssoc[$submission['cid']]['pass_count'] ?? 0;
        $finUsers[] = $finishUsersAssoc[$submission['cid']]['finish_user_count'] ?? 0;
        }


        $submissionData = Solution::find()
            ->select([
                'pid',          // 问题ID
                'uid',          // 提交用户ID
                'code_size',    // 代码大小
                'run_time',     // 运行时间
                'run_memory',       // 运行内存
                '`when`',   // 提交时间
                'score',        // 得分
            ])
            ->orderBy(['`when`' => SORT_DESC])  // 按提交时间降序排序
            ->limit(20)  // 限制结果为前20条
            ->all();

        // 将查询结果传递给视图
        return $this->render('index3', [

            'username' => $username,


            'results' => $results,
            'submissionData' => $submissionData,
            'courseNames' => $courseNames,
            'subCounts' => $subCounts,
            'finCounts' => $finCounts,
            'finUsers' => $finUsers,
        ]);// 渲染 views/site/index3.php
    }


    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }




    
}
