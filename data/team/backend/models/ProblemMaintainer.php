<?php

namespace app\models;


use Yii;

/**
 * This is the model class for table "problem_maintainer".
 *
 * @property int $pid
 * @property int $uid
 *
 * @property Problem $p
 * @property User $u
 */
class ProblemMaintainer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'problem_maintainer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pid', 'uid'], 'required'],
            [['pid', 'uid'], 'integer'],
            [['pid', 'uid'], 'unique', 'targetAttribute' => ['pid', 'uid']],
            [['pid'], 'exist', 'skipOnError' => true, 'targetClass' => Problem::class, 'targetAttribute' => ['pid' => 'pid']],
            [['uid'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['uid' => 'uid']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pid' => 'Pid',
            'uid' => 'Uid',
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
