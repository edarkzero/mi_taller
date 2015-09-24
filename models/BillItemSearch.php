<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BillItem;

/**
 * BillItemSearch represents the model behind the search form about `app\models\BillItem`.
 */
class BillItemSearch extends BillItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'item_id', 'bill_id', 'amount'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = BillItem::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'item_id' => $this->item_id,
            'bill_id' => $this->bill_id,
            'amount' => $this->amount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
