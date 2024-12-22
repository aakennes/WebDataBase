<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "solution".
 *
 * @property int $sid
 * @property int $uid
 * @property int $pid
 * @property int $code_size
 * @property int $run_time
 * @property int $run_memory
 * @property string $when
 * @property int $score
 *
 * @property Problem $p
 * @property User $u
 */
class Solution extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'solution';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'pid', 'code_size', 'run_time', 'run_memory', 'when'], 'required'],
            [['uid', 'pid', 'code_size', 'run_time', 'run_memory', 'score'], 'integer'],
            [['when'], 'safe'],
            [['uid'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['uid' => 'uid']],
            [['pid'], 'exist', 'skipOnError' => true, 'targetClass' => Problem::class, 'targetAttribute' => ['pid' => 'pid']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sid' => 'Sid',
            'uid' => 'Uid',
            'pid' => 'Pid',
            'code_size' => 'Code Size',
            'run_time' => 'Run Time',
            'run_memory' => 'Run Memory',
            'when' => 'When',
            'score' => 'Score',
        ];
    }

    /**
     * Gets query for [[P]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getP()
    {
        return $this->hasOne(Problem::class, ['pid' => 'pid']);
    }

    /**
     * Gets query for [[U]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getU()
    {
        return $this->hasOne(User::class, ['uid' => 'uid']);
    }
}
