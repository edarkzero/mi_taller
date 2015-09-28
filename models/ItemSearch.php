<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Item;
use yii\data\Sort;

/**
 * ItemSearch represents the model behind the search form about `app\models\Item`.
 */
class ItemSearch extends Item
{
    public $item_total;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'quantity', 'quantity_stock'], 'integer'],
            [['name', 'code', 'created_at', 'updated_at','item_total'], 'safe'],
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
        $query = Item::find();
        $query->innerJoinWith('itemPrices.price');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => new Sort([
                'attributes' => [
                    'name',
                    'code',
                    'quantity',
                    'quantity_stock',
                    'created_at',
                    'updated_at',
                    'item_total' => [
                        'asc' => ['price.total' => SORT_ASC],
                        'desc' => ['price.total' => SORT_DESC]
                    ]
                ],
            ])
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'quantity' => $this->quantity,
            'quantity_stock' => $this->quantity_stock,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])->andFilterWhere(['like','price.total',$this->item_total]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchWithItem($params)
    {
        $query = Item::find();
        $query->innerJoinWith('itemPrices.price');
        $query->joinWith('billItems');
        $query->orderBy(BillItem::tableName().'.quantity DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => new Sort([
                'attributes' => [
                    'name',
                    'code',
                    'quantity',
                    'quantity_stock',
                    'created_at',
                    'updated_at',
                    'item_total' => [
                        'asc' => ['price.total' => SORT_ASC],
                        'desc' => ['price.total' => SORT_DESC]
                    ]
                ],
            ])
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'quantity' => $this->quantity,
            'quantity_stock' => $this->quantity_stock,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])->andFilterWhere(['like','price.total',$this->item_total]);

        return $dataProvider;
    }
}
