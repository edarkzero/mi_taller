<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "price".
 *
 * @property string $id
 * @property string $price
 * @property string $tax
 * @property string $total
 * @property string $created_at
 * @property string $updated_at
 */
class Price extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'price';
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
            [['price', 'tax', 'total'], 'required'],
            [['price', 'tax', 'total'], 'number'],
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
            'price' => Yii::t('app', 'Price'),
            'tax' => Yii::t('app', 'Tax'),
            'total' => Yii::t('app', 'Total'),
            'created_at' => Yii::t('app', 'Created_at'),
            'updated_at' => Yii::t('app', 'Updated_at'),
        ];
    }

    public function getPriceTax()
    {
        $tax = (double)($this->tax)/100;
        return (double)($this->price)*$tax;
    }

    public function calculate()
    {
        $this->price = (double)$this->price;
        $this->tax = (double)$this->tax;
        $this->total = (double)($this->price)+$this->getPriceTax();
        $this->total = round($this->total,2);
    }

    public function getAjaxValue()
    {
        $result = [];
        $result['price'] = $this->price;
        $result['tax'] = $this->tax;
        $result['total'] = $this->total;
        echo json_encode($result);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            //$this->calculate();
            return true;
        } else {
            return false;
        }
    }
}
