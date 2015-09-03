<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "image".
 *
 * @property string $id
 * @property string $url
 *
 * @property CarView[] $carViews
 * @property ImageArea[] $imageAreas
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'url'], 'required'],
            [['id'], 'integer'],
            [['url'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'url' => Yii::t('app', 'Url'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarViews()
    {
        return $this->hasMany(CarView::className(), ['image_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImageAreas()
    {
        return $this->hasMany(ImageArea::className(), ['image_id' => 'id']);
    }
}
