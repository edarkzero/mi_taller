<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "car_part".
 *
 * @property string $id
 * @property string $size_id
 * @property string $color_id
 * @property string $damage_id
 * @property string $price_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Size $size
 * @property Color $color
 * @property Damage $damage
 * @property Price $price
 */
class CarPart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'car_part';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['size_id', 'color_id', 'damage_id', 'price_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'size_id' => Yii::t('app', 'Size'),
            'color_id' => Yii::t('app', 'Color'),
            'damage_id' => Yii::t('app', 'Damage'),
            'price_id' => Yii::t('app', 'Price'),
            'created_at' => Yii::t('app', 'Created_at'),
            'updated_at' => Yii::t('app', 'Updated_at'),
        ];
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
    public function getColor()
    {
        return $this->hasOne(Color::className(), ['id' => 'color_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDamage()
    {
        return $this->hasOne(Damage::className(), ['id' => 'damage_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrice()
    {
        return $this->hasOne(Price::className(), ['id' => 'price_id']);
    }
}
