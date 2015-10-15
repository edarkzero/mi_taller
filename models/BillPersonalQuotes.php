<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bill_personal_quotes".
 *
 * @property string $id
 * @property string $bill_person_id
 * @property string $amount
 *
 * @property BillPersonal $billPerson
 */
class BillPersonalQuotes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bill_personal_quotes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bill_person_id', 'amount'], 'required'],
            [['bill_person_id'], 'integer'],
            [['amount'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'bill_person_id' => Yii::t('app', 'Bill'),
            'amount' => Yii::t('app', 'Amount'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBillPerson()
    {
        return $this->hasOne(BillPersonal::className(), ['id' => 'bill_person_id']);
    }
}
