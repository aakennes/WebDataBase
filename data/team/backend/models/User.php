<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $uid
 * @property string $nickname
 * @property string $email
 * @property string $color
 * @property int $acnum
 * @property int $allnum
 *
 * @property CourseUser[] $courseUsers
 * @property Course[] $cs
 * @property ProblemMaintainer[] $problemMaintainers
 * @property Problem[] $problems
 * @property ProblemsetMaintainer[] $problemsetMaintainers
 * @property ProblemsetUser[] $problemsetUsers
 * @property Problemset[] $problemsets
 * @property Problem[] $ps
 * @property Problemset[] $ps0
 * @property Problemset[] $ps1
 * @property Solution[] $solutions
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nickname', 'email'], 'required'],
            [['color'], 'string'],
            [['acnum', 'allnum'], 'integer'],
            [['nickname'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 255],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'nickname' => 'Nickname',
            'email' => 'Email',
            'color' => 'Color',
            'acnum' => 'Acnum',
            'allnum' => 'Allnum',
        ];
    }

    /**
     * Gets query for [[CourseUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourseUsers()
    {
        return $this->hasMany(CourseUser::class, ['uid' => 'uid']);
    }

    /**
     * Gets query for [[Cs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCs()
    {
        return $this->hasMany(Course::class, ['cid' => 'cid'])->viaTable('course_user', ['uid' => 'uid']);
    }

    /**
     * Gets query for [[ProblemMaintainers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProblemMaintainers()
    {
        return $this->hasMany(ProblemMaintainer::class, ['uid' => 'uid']);
    }

    /**
     * Gets query for [[Problems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProblems()
    {
        return $this->hasMany(Problem::class, ['owner_id' => 'uid']);
    }

    /**
     * Gets query for [[ProblemsetMaintainers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProblemsetMaintainers()
    {
        return $this->hasMany(ProblemsetMaintainer::class, ['uid' => 'uid']);
    }

    /**
     * Gets query for [[ProblemsetUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProblemsetUsers()
    {
        return $this->hasMany(ProblemsetUser::class, ['uid' => 'uid']);
    }

    /**
     * Gets query for [[Problemsets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProblemsets()
    {
        return $this->hasMany(Problemset::class, ['owner_id' => 'uid']);
    }

    /**
     * Gets query for [[Ps]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPs()
    {
        return $this->hasMany(Problem::class, ['pid' => 'pid'])->viaTable('problem_maintainer', ['uid' => 'uid']);
    }

    /**
     * Gets query for [[Ps0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPs0()
    {
        return $this->hasMany(Problemset::class, ['psid' => 'psid'])->viaTable('problemset_maintainer', ['uid' => 'uid']);
    }

    /**
     * Gets query for [[Ps1]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPs1()
    {
        return $this->hasMany(Problemset::class, ['psid' => 'psid'])->viaTable('problemset_user', ['uid' => 'uid']);
    }

    /**
     * Gets query for [[Solutions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSolutions()
    {
        return $this->hasMany(Solution::class, ['uid' => 'uid']);
    }
}
