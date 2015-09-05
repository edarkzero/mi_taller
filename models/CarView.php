<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "car_view".
 *
 * @property string $id
 * @property string $car_id
 * @property string $view_id
 * @property string $image_id
 *
 * @property Image $image
 * @property Car $car
 * @property View $view
 */
class CarView extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'car_view';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['car_id', 'view_id', 'image_id'], 'required'],
            [['car_id', 'view_id', 'image_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'car_id' => Yii::t('app', 'Car ID'),
            'view_id' => Yii::t('app', 'View ID'),
            'image_id' => Yii::t('app', 'Image ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCar()
    {
        return $this->hasOne(Car::className(), ['id' => 'car_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getView()
    {
        return $this->hasOne(View::className(), ['id' => 'view_id']);
    }

    public function afterSave($insert,$changedAttributes)
    {
        parent::afterSave($insert,$changedAttributes);
        $log = new Log();

        if($insert)
            $log->saveDatabaseOperation('create',$this->tableName(),$this->id);
        else
            $log->saveDatabaseOperation('update',$this->tableName(),$this->id);
    }

    public function afterDelete()
    {
        parent::afterDelete();
        $log = new Log();
        $log->saveDatabaseOperation('delete',$this->tableName(),$this->id);
    }
}
