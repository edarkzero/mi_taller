<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "person".
 *
 * @property string $id
 * @property string $document
 * @property string $firstname
 * @property string $lastname
 * @property string $created_at
 * @property string $updated_at
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['document', 'firstname', 'lastname', 'created_at'], 'required'],
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
            'created_at' => Yii::t('app', 'Created_at'),
            'updated_at' => Yii::t('app', 'Updated_at'),
        ];
    }
}
