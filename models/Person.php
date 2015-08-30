<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "person".
 *
 * @property string $id
 * @property string $document
 * @property string $firstname
 * @property string $lastname
 * @property string $job_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Job $job
 */
class Person extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person';
    }

    public function behaviors()
    {
        return [
            'timestamp' => array(
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
                'value' => new \yii\db\Expression('NOW()'),
            ),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['document', 'firstname', 'lastname'], 'required'],
            [['job_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['document', 'firstname', 'lastname'], 'string', 'max' => 255],
            [['document'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'document' => Yii::t('app', 'ID'),
            'firstname' => Yii::t('app', 'Firstname'),
            'lastname' => Yii::t('app', 'Lastname'),
            'job_id' => Yii::t('app', 'Job'),
            'created_at' => Yii::t('app', 'Created_at'),
            'updated_at' => Yii::t('app', 'Updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJob()
    {
        return $this->hasOne(Job::className(), ['id' => 'job_id']);
    }

    public function getFullName()
    {
        return $this->firstname." ".$this->lastname;
    }
}
