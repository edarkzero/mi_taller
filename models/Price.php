<?php

namespace app\models;

use Yii;

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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price', 'tax', 'total', 'created_at'], 'required'],
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
}
