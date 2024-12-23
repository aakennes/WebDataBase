<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "course".
 *
 * @property int $cid
 * @property string|null $title
 * @property string|null $description
 * @property int|null $owner_id
 * @property int|null $number
 * @property string|null $passcode
 *
 * @property CourseUser[] $courseUsers
 * @property Problemset[] $problemsets
 * @property User[] $us
 */
class Course extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'course';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cid'], 'required'],
            [['cid', 'owner_id', 'number'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['passcode'], 'string', 'max' => 100],
            [['cid'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cid' => 'Cid',
            'title' => 'Title',
            'description' => 'Description',
            'owner_id' => 'Owner ID',
            'number' => 'Number',
            'passcode' => 'Passcode',
        ];
    }

    /**
     * Gets query for [[CourseUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourseUsers()
    {
        return $this->hasMany(CourseUser::class, ['cid' => 'cid']);
    }

    /**
     * Gets query for [[Problemsets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProblemsets()
    {
        return $this->hasMany(Problemset::class, ['cid' => 'cid']);
    }

    /**
     * Gets query for [[Us]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUs()
    {
        return $this->hasMany(User::class, ['uid' => 'uid'])->viaTable('course_user', ['cid' => 'cid']);
    }
}
