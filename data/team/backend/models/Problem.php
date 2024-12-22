<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "problem".
 *
 * @property int $pid
 * @property int $psid
 * @property string $title
 * @property int $submit_ac
 * @property int $submit_all
 * @property int $cases
 * @property int $time_limit
 * @property int $memory_limit
 * @property int $owner_id
 *
 * @property User $owner
 * @property ProblemMaintainer[] $problemMaintainers
 * @property Problemset $ps
 * @property Solution[] $solutions
 * @property User[] $us
 */
class Problem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'problem';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['psid', 'title', 'owner_id'], 'required'],
            [['psid', 'submit_ac', 'submit_all', 'cases', 'time_limit', 'memory_limit', 'owner_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['psid'], 'exist', 'skipOnError' => true, 'targetClass' => Problemset::class, 'targetAttribute' => ['psid' => 'psid']],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['owner_id' => 'uid']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pid' => 'Pid',
            'psid' => 'Psid',
            'title' => 'Title',
            'submit_ac' => 'Submit Ac',
            'submit_all' => 'Submit All',
            'cases' => 'Cases',
            'time_limit' => 'Time Limit',
            'memory_limit' => 'Memory Limit',
            'owner_id' => 'Owner ID',
        ];
    }

    /**
     * Gets query for [[Owner]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::class, ['uid' => 'owner_id']);
    }

    /**
     * Gets query for [[ProblemMaintainers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProblemMaintainers()
    {
        return $this->hasMany(ProblemMaintainer::class, ['pid' => 'pid']);
    }

    /**
     * Gets query for [[Ps]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPs()
    {
        return $this->hasOne(Problemset::class, ['psid' => 'psid']);
    }

    /**
     * Gets query for [[Solutions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSolutions()
    {
        return $this->hasMany(Solution::class, ['pid' => 'pid']);
    }

    /**
     * Gets query for [[Us]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUs()
    {
        return $this->hasMany(User::class, ['uid' => 'uid'])->viaTable('problem_maintainer', ['pid' => 'pid']);
    }
}
