<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "view".
 *
 * @property string $id
 * @property string $name
 *
 * @property CarView[] $carViews
 */
class View extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'view';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id'], 'integer'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarViews()
    {
        return $this->hasMany(CarView::className(), ['view_id' => 'id']);
    }
}
