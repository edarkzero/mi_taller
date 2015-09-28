<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

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
 * @property BillItem[] $billItems
 * @property ItemPrice[] $itemPrices
 * @property PersonItem[] $personItems
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

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'quantity', 'quantity_stock'], 'required'],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBillItems()
    {
        return $this->hasMany(BillItem::className(), ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemPrices()
    {
        return $this->hasMany(ItemPrice::className(), ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonItems()
    {
        return $this->hasMany(PersonItem::className(), ['item_id' => 'id']);
    }

    public function getTotal()
    {
        return $this->itemPrices[0]->price->total;
    }

    public function getItemQuantity($bill = null)
    {
        if(!isset($bill))
            return 0;
        else
        {
            $billItem = BillItem::find()->where(['bill_id' => $bill,'item_id' => 2])->one();
            return $billItem->quantity;
        }
    }
}
