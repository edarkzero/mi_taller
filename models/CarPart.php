<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "car_part".
 *
 * @property string $id
 * @property string $size_id
 * @property string $color_id
 * @property string $damage_id
 * @property string $price_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Size $size
 * @property Color $color
 * @property Damage $damage
 * @property Price $price
 */
class CarPart extends \yii\db\ActiveRecord
{

    public $size_name;
    public $color_name;
    public $damage_name;
    public $price_total;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'car_part';
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['size_id'], 'required'],
            [['size_id', 'color_id', 'damage_id', 'price_id'], 'integer'],
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
            'size_id' => Yii::t('app', 'Size'),
            'color_id' => Yii::t('app', 'Color'),
            'damage_id' => Yii::t('app', 'Damage'),
            'price_id' => Yii::t('app', 'Price'),
            'created_at' => Yii::t('app', 'Created_at'),
            'updated_at' => Yii::t('app', 'Updated_at'),
        ];
    }

    /**
     * @param $size
     * @param $color
     * @param $damage
     * @return CarPart|null
     */
    public static function getByParts($size,$color,$damage)
    {
        return self::find()->filterWhere(['size_id' => $size,'color_id' => $color,'damage_id' => $damage])->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSize()
    {
        return $this->hasOne(Size::className(), ['id' => 'size_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColor()
    {
        return $this->hasOne(Color::className(), ['id' => 'color_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDamage()
    {
        return $this->hasOne(Damage::className(), ['id' => 'damage_id']);
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
        return isset($this->price->total) ? $this->price->total : "";
    }

    public function getSizeName()
    {
        return isset($this->size->name) ? $this->size->name : "";
    }

    public function getColorName()
    {
        return isset($this->color->name) ? $this->color->name : "";
    }

    public function getDamageName()
    {
        return isset($this->damage->name) ? $this->damage->name : "";
    }
}
