<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "course_user".
 *
 * @property int $cid
 * @property int $uid
 *
 * @property Course $c
 * @property User $u
 */
class CourseUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'course_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cid', 'uid'], 'required'],
            [['cid', 'uid'], 'integer'],
            [['cid', 'uid'], 'unique', 'targetAttribute' => ['cid', 'uid']],
            [['cid'], 'exist', 'skipOnError' => true, 'targetClass' => Course::class, 'targetAttribute' => ['cid' => 'cid']],
            [['uid'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['uid' => 'uid']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cid' => 'Cid',
            'uid' => 'Uid',
        ];
    }

    /**
     * Gets query for [[C]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getC()
    {
        return $this->hasOne(Course::class, ['cid' => 'cid']);
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
