<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bill_personal".
 *
 * @property string $id
 * @property string $bill_id
 * @property string $personal_id
 * @property string $amount
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Person $personal
 * @property Bill $bill
 */
class BillPersonal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bill_personal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bill_id', 'personal_id', 'amount'], 'required'],
            [['bill_id', 'personal_id'], 'integer'],
            [['amount'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['description'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'bill_id' => Yii::t('app', 'Bill'),
            'personal_id' => Yii::t('app', 'Personal'),
            'amount' => Yii::t('app', 'Amount'),
            'description' => Yii::t('app', 'Description'),
            'created_at' => Yii::t('app', 'Created_at'),
            'updated_at' => Yii::t('app', 'Updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonal()
    {
        return $this->hasOne(Person::className(), ['id' => 'personal_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBill()
    {
        return $this->hasOne(Bill::className(), ['id' => 'bill_id']);
    }
}
