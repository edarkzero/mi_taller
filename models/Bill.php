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
 * @property BillItem[] $billItems
 * @property BillPersonal[] $billPersonals
 */
class Bill extends \yii\db\ActiveRecord
{
    public $price_total;
    public $bp_paid;
    public $bp_description;
    public $bp_amount;

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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBillItems()
    {
        return $this->hasMany(BillItem::className(), ['bill_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBillPersonals()
    {
        return $this->hasMany(BillPersonal::className(), ['bill_id' => 'id']);
    }

    public function haveItems()
    {
        return count($this->billItems) > 0;
    }

    public function getBillPersonalDescription()
    {
        if(isset($this->billPersonals))
        {
            foreach($this->billPersonals as $billPersonal)
            {
                if($billPersonal->personal_id == Yii::$app->request->queryParams['id'])
                    return $billPersonal->description;
            }
        }

        return "";
    }

    public function getBillPersonalPaid()
    {
        if(isset($this->billPersonals))
        {
            foreach($this->billPersonals as $billPersonal)
            {
                if($billPersonal->personal_id == Yii::$app->request->queryParams['id'])
                    return $billPersonal->paid;
            }
        }

        return "";
    }

    public function getBillPersonalAmount()
    {
        if(isset($this->billPersonals))
        {
            foreach($this->billPersonals as $billPersonal)
            {
                if($billPersonal->personal_id == Yii::$app->request->queryParams['id'])
                    return $billPersonal->amount;
            }
        }

        return "";
    }

    public function getBillPersonalId()
    {
        if(isset($this->billPersonals))
        {
            foreach($this->billPersonals as $billPersonal)
            {
                if($billPersonal->personal_id == Yii::$app->request->queryParams['id'])
                    return $billPersonal->id;
            }
        }

        return "";
    }
}
