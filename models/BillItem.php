<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bill_item".
 *
 * @property string $id
 * @property string $item_id
 * @property string $bill_id
 * @property string $amount
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Item $item
 * @property Bill $bill
 */
class BillItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bill_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'bill_id'], 'required'],
            [['item_id', 'bill_id', 'amount'], 'integer'],
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
            'item_id' => Yii::t('app', 'Bill'),
            'bill_id' => Yii::t('app', 'Item'),
            'amount' => Yii::t('app', 'Amount'),
            'created_at' => Yii::t('app', 'Created_at'),
            'updated_at' => Yii::t('app', 'Updated_at'),
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
    public function getBill()
    {
        return $this->hasOne(Bill::className(), ['id' => 'bill_id']);
    }
}
