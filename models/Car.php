<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "car".
 *
 * @property string $id
 * @property string $name
 *
 * @property CarView[] $carViews
 */
class Car extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'car';
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
        return $this->hasMany(CarView::className(), ['car_id' => 'id']);
    }

    public function afterSave($insert,$changedAttributes)
    {
        parent::afterSave($insert,$changedAttributes);
        $log = new Log();

        if($insert)
            $log->saveDatabaseOperation('create',$this->tableName(),$this->name);
        else
            $log->saveDatabaseOperation('update',$this->tableName(),$this->name);
    }

    public function afterDelete()
    {
        parent::afterDelete();
        $log = new Log();
        $log->saveDatabaseOperation('delete',$this->tableName(),$this->name);
    }
}
