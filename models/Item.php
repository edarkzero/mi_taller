<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "item".
 *
 * @property string $id
 * @property string $name
 * @property string $code
 * @property integer $quantity
 * @property integer $quantity_stock
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ItemPrice[] $itemPrices
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'code', 'quantity', 'quantity_stock', 'created_at'], 'required'],
            [['quantity', 'quantity_stock'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'code'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['code'], 'unique']
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
            'code' => Yii::t('app', 'Code'),
            'quantity' => Yii::t('app', 'Quantity'),
            'quantity_stock' => Yii::t('app', 'Quantity in stock'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemPrices()
    {
        return $this->hasMany(ItemPrice::className(), ['item_id' => 'id']);
    }
}
