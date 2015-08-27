<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "item_price".
 *
 * @property string $id
 * @property string $item_id
 * @property string $price_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Item $item
 * @property Job $price
 */
class ItemPrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item_price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'price_id', 'created_at'], 'required'],
            [['item_id', 'price_id'], 'integer'],
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
            'item_id' => Yii::t('app', 'Item'),
            'price_id' => Yii::t('app', 'Price'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrice()
    {
        return $this->hasOne(Job::className(), ['id' => 'price_id']);
    }
}
