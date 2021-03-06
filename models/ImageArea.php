<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "image_area".
 *
 * @property string $id
 * @property string $image_id
 * @property string $size_id
 * @property string $coord
 *
 * @property Size $size
 * @property Image $image
 */
class ImageArea extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'image_area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'image_id', 'size_id', 'coord'], 'required'],
            [['id', 'image_id', 'size_id'], 'integer'],
            [['coord'], 'string', 'max' => 750]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'image_id' => Yii::t('app', 'Image'),
            'size_id' => Yii::t('app', 'Size'),
            'coord' => Yii::t('app', 'Coordinates'),
        ];
    }

    public function afterSave($insert,$changedAttributes)
    {
        parent::afterSave($insert,$changedAttributes);
        $log = new Log();

        if($insert)
            $log->saveDatabaseOperation('create',$this->tableName(),$this->coord);
        else
            $log->saveDatabaseOperation('update',$this->tableName(),$this->coord);
    }

    public function afterDelete()
    {
        parent::afterDelete();
        $log = new Log();
        $log->saveDatabaseOperation('delete',$this->tableName(),$this->coord);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSize()
    {
        return $this->hasOne(Size::className(), ['id' => 'size_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }
}
