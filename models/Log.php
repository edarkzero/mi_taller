<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "log".
 *
 * @property string $id
 * @property string $message
 * @property string $created_at
 * @property string $updated_at
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log';
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
            [['message'], 'required'],
            [['message'], 'string'],
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
            'message' => Yii::t('app', 'Message'),
            'created_at' => Yii::t('app', 'Created at'),
            'updated_at' => Yii::t('app', 'Updated at'),
        ];
    }

    /**
     * @param $action string
     * @param $model string
     * @param $id string
     */
    public function saveDatabaseOperation($action,$model,$id)
    {
        $modelName = Yii::t('app',ucfirst($model));

        if($action == 'create')
            $this->message = Yii::t('app','{model}, {n}, created.',['model' => $modelName,'n' => $id]);
        elseif($action == 'update')
            $this->message = Yii::t('app','{model}, {n}, updated.',['model' => $modelName,'n' => $id]);
        elseif($action == 'delete')
            $this->message = Yii::t('app','{model}, {n}, deleted.',['model' => $modelName,'n' => $id]);
        elseif($action == 'error')
            $this->message = $model.','.$id;

        $this->save();
    }
}
