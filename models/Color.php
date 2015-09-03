<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "color".
 *
 * @property string $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CarPart[] $carParts
 */
class Color extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'color';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarParts()
    {
        return $this->hasMany(CarPart::className(), ['color_id' => 'id']);
    }
}
