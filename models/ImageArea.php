<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "image_area".
 *
 * @property string $id
 * @property string $image_id
 * @property string $coord
 *
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
            [['id', 'image_id', 'coord'], 'required'],
            [['id', 'image_id'], 'integer'],
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
            'image_id' => Yii::t('app', 'Image ID'),
            'coord' => Yii::t('app', 'Url'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }
}
