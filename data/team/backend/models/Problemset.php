<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "problemset".
 *
 * @property int $psid
 * @property string $title
 * @property string|null $description
 * @property int|null $cid
 * @property int $owner_id
 * @property string $start_time
 * @property string $end_time
 *
 * @property Course $c
 * @property User $owner
 * @property Problem[] $problems
 * @property ProblemsetMaintainer[] $problemsetMaintainers
 * @property ProblemsetUser[] $problemsetUsers
 * @property User[] $us
 * @property User[] $us0
 */
class Problemset extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'problemset';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'owner_id', 'start_time', 'end_time'], 'required'],
            [['description'], 'string'],
            [['cid', 'owner_id'], 'integer'],
            [['start_time', 'end_time'], 'safe'],
            [['title'], 'string', 'max' => 255],
            [['cid'], 'exist', 'skipOnError' => true, 'targetClass' => Course::class, 'targetAttribute' => ['cid' => 'cid']],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['owner_id' => 'uid']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'psid' => 'Psid',
            'title' => 'Title',
            'description' => 'Description',
            'cid' => 'Cid',
            'owner_id' => 'Owner ID',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
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
     * Gets query for [[Owner]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::class, ['uid' => 'owner_id']);
    }

    /**
     * Gets query for [[Problems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProblems()
    {
        return $this->hasMany(Problem::class, ['psid' => 'psid']);
    }

    /**
     * Gets query for [[ProblemsetMaintainers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProblemsetMaintainers()
    {
        return $this->hasMany(ProblemsetMaintainer::class, ['psid' => 'psid']);
    }

    /**
     * Gets query for [[ProblemsetUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProblemsetUsers()
    {
        return $this->hasMany(ProblemsetUser::class, ['psid' => 'psid']);
    }

    /**
     * Gets query for [[Us]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUs()
    {
        return $this->hasMany(User::class, ['uid' => 'uid'])->viaTable('problemset_maintainer', ['psid' => 'psid']);
    }

    /**
     * Gets query for [[Us0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUs0()
    {
        return $this->hasMany(User::class, ['uid' => 'uid'])->viaTable('problemset_user', ['psid' => 'psid']);
    }
}
