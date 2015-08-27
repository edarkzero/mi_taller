<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "job".
 *
 * @property string $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ItemPrice[] $itemPrices
 */
class Job extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'job';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'created_at'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique']
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
            'created_at' => Yii::t('app', 'Created_at'),
            'updated_at' => Yii::t('app', 'Updated_at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemPrices()
    {
        return $this->hasMany(ItemPrice::className(), ['price_id' => 'id']);
    }
}
