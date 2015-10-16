<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "bill_personal".
 *
 * @property string $id
 * @property string $bill_id
 * @property string $personal_id
 * @property string $amount
 * @property string $description
 * @property integer $paid
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Bill $bill
 * @property Person $personal
 * @property BillPersonalQuotes[] $billPersonalQuotes
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
            [['bill_id', 'personal_id', 'amount'], 'required'],
            [['bill_id', 'personal_id', 'paid'], 'integer'],
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
            'paid' => Yii::t('app', 'Paid'),
            'created_at' => Yii::t('app', 'Created_at'),
            'updated_at' => Yii::t('app', 'Updated_at'),
        ];
    }

    public function afterSave($insert,$changedAttributes)
    {
        parent::afterSave($insert,$changedAttributes);

        $log = new Log();

        if($insert)
            $log->saveDatabaseOperation('create',$this->tableName(),$this->description);
        else
            $log->saveDatabaseOperation('update',$this->tableName(),$this->description);
    }

    public function afterDelete()
    {
        parent::afterDelete();
        $log = new Log();
        $log->saveDatabaseOperation('delete',$this->tableName(),$this->description);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBill()
    {
        return $this->hasOne(Bill::className(), ['id' => 'bill_id']);
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
    public function getBillPersonalQuotes()
    {
        return $this->hasMany(BillPersonalQuotes::className(), ['bill_person_id' => 'id']);
    }

    /**
     * @param $personal
     * @param $bill
     * @return null|BillPersonal|BillPersonal[]
     */
    public static function getAsociated($personal,$bill)
    {
        return self::find()->where(['personal_id' => $personal,'bill_id' => $bill])->all();
    }
}
