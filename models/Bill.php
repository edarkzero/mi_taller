<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

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
    public $price_total;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bill';
    }

    public function afterSave($insert,$changedAttributes)
    {
        parent::afterSave($insert,$changedAttributes);
        $log = new Log();

        if($insert)
        {
            $log->saveDatabaseOperation('create',$this->tableName(),$this->id);
        }
        else
        {
            $log->saveDatabaseOperation('update',$this->tableName(),$this->id);
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();
        $log = new Log();
        $log->saveDatabaseOperation('delete',$this->tableName(),$this->id);
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

    public function getPriceTotal()
    {
        return isset($this->price) ? $this->price->total : '';
    }
}
