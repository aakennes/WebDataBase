<?php
/**
* Team: 
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

class SiteController extends Controller
{
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
        $uid = 4; // 假设通过登录用户的 UID 获取

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
            'submitAllCount' => $submitAllCount,
            'accuracy' => $accuracy,
            'passstu' => $passstu,
            'allsubmit' => $allsubmit,
            'dates' => $dates,
            'total_submissions' => $totalSubmissions,
            'passed_submissions' => $passedSubmissions,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionIndex2()
    {
        return $this->render('index2'); // 渲染 views/site/index2.php
    }

    public function actionIndex3()
    {
        return $this->render('index3'); // 渲染 views/site/index3.php
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
