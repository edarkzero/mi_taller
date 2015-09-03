<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bill".
 *
 * @property string $id
 * @property string $price_id
 * @property string $discount
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Price $price
 */
class Bill extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bill';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price_id'], 'required'],
            [['price_id'], 'integer'],
            [['discount'], 'number'],
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
            'price_id' => Yii::t('app', 'Price'),
            'discount' => Yii::t('app', 'Discount'),
            'created_at' => Yii::t('app', 'Created_at'),
            'updated_at' => Yii::t('app', 'Updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrice()
    {
        return $this->hasOne(Price::className(), ['id' => 'price_id']);
    }
}
