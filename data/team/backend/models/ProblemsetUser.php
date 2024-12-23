<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "problemset_user".
 *
 * @property int $psid
 * @property int $uid
 *
 * @property Problemset $ps
 * @property User $u
 */
class ProblemsetUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'problemset_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['psid', 'uid'], 'required'],
            [['psid', 'uid'], 'integer'],
            [['psid', 'uid'], 'unique', 'targetAttribute' => ['psid', 'uid']],
            [['psid'], 'exist', 'skipOnError' => true, 'targetClass' => Problemset::class, 'targetAttribute' => ['psid' => 'psid']],
            [['uid'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['uid' => 'uid']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'psid' => 'Psid',
            'uid' => 'Uid',
        ];
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
     * Gets query for [[U]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getU()
    {
        return $this->hasOne(User::class, ['uid' => 'uid']);
    }
}
