<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "person_item".
 *
 * @property string $id
 * @property string $item_id
 * @property string $person_id
 * @property int $amount
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Item $item
 * @property Person $person
 */
class PersonItem extends \yii\db\ActiveRecord
{
    public $item_name, $person_name;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person_item';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class'      => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at',
                ],
                'value'      => new \yii\db\Expression('NOW()'),
            ],
        ];
    }

    public function afterDelete()
    {
        parent::afterDelete();
        $log = new Log();
        $log->saveDatabaseOperation('delete',$this->tableName(),$this->id);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert,$changedAttributes);
        $this->calculateItemsLeft($changedAttributes);

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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_id', 'person_id', 'amount'], 'required'],
            [['item_id', 'person_id', 'amount'], 'integer'],
            [['created_at', 'updated_at', 'item_name', 'person_name'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('app', 'ID'),
            'item_id'    => Yii::t('app', 'Item'),
            'person_id'  => Yii::t('app', 'Person'),
            'amount'     => Yii::t('app', 'Amount'),
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
    public function getPerson()
    {
        return $this->hasOne(Person::className(), ['id' => 'person_id']);
    }

    public function getItemName()
    {
        return isset($this->item->name) ? $this->item->name : '';
    }

    public function getPersonName()
    {
        return isset($this->person->firstname) ? $this->person->getFullName() : '';
    }

    private function calculateItemsLeft($params)
    {
        $oldAmount = isset($params['amount']);
        $amount = (int)($oldAmount ? $params['amount'] : $this->amount);
        if(isset($this->item))
        {
            $item = $this->item;
            if($oldAmount)
                $amount = (int)($this->amount) - $amount;
            $item->quantity = (int)($item->quantity) - $amount;
            if (!$item->save(false))
                throw new Exception(Yii::t('app', 'Error updating {model}: {msj}', ['model' => Yii::t('app', ucfirst($item->tableName())), 'msj' => print_r($item->getErrors(), true)]), 500);
        }
    }
}
