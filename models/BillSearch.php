<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Bill;
use yii\data\Sort;

/**
 * BillSearch represents the model behind the search form about `app\models\Bill`.
 */
class BillSearch extends Bill
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'price_id','draft'], 'integer'],
            [['discount'], 'number'],
            [['created_at', 'updated_at','price_total','bp_paid','bp_description','bp_amount','draft','filter'], 'safe'],
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
        $query = Bill::find();
        $query->innerJoinWith('price');
        $query->orderBy('deleted_at ASC');

        if(isset($this->filter) && $this->filter != '')
        {
            if($this->filter == 0 || $this->filter == 1)
                $query->where(['draft' => $this->filter]);
            elseif($this->filter >= 2)
                $query->where(['not',['deleted_at' => null]]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => new Sort([
                'attributes' => [
                    self::tableName().'.id',
                    'price_total' => [
                        'asc' => ['price.total' => SORT_ASC],
                        'desc' => ['price.total' => SORT_DESC],
                    ],
                    'discount',
                    self::tableName().'.created_at',
                    self::tableName().'.updated_at'
                ],
                'defaultOrder' => [
                    self::tableName().'.created_at' => SORT_DESC
                ]
            ])
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            self::tableName().'.id' => $this->id,
            'price_id' => $this->price_id,
            'discount' => $this->discount,
            self::tableName().'.created_at' => $this->created_at,
            self::tableName().'.updated_at' => $this->updated_at
        ]);

        $query->andFilterWhere(['like','price.total',$this->price_total]);

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
        $query = Bill::find();
        $query->innerJoinWith('price');
        $query->joinWith('billItems.item');
        $query->orderBy(BillItem::tableName().'.updated_at DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => new Sort([
                'attributes' => [
                    self::tableName().'.id',
                    'price_total' => [
                        'asc' => ['price.total' => SORT_ASC],
                        'desc' => ['price.total' => SORT_DESC],
                    ],
                    'discount',
                    self::tableName().'.created_at',
                    self::tableName().'.updated_at'
                ],
                'defaultOrder' => [
                    self::tableName().'.updated_at' => SORT_DESC
                ]
            ])
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            self::tableName().'.id' => $this->id,
            'price_id' => $this->price_id,
            'discount' => $this->discount,
            self::tableName().'.created_at' => $this->created_at,
            self::tableName().'.updated_at' => $this->updated_at
        ]);

        $query->andFilterWhere(['like','price.total',$this->price_total]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchWithPerson($params)
    {
        $query = Bill::find();
        $query->innerJoinWith('price');
        $query->joinWith('billPersonals');
        $query->orderBy(BillPersonal::tableName().'.updated_at DESC');

        if(isset($params['id']))
        {
            $query->where([BillPersonal::tableName().'.personal_id' => $params['id']]);
            $query->orWhere([BillPersonal::tableName().'.personal_id' => null]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => new Sort([
                'attributes' => [
                    self::tableName().'.id',
                    'price_total' => [
                        'asc' => ['price.total' => SORT_ASC],
                        'desc' => ['price.total' => SORT_DESC],
                    ],
                    'discount',
                    'bp_paid' => [
                        'asc' => [BillPersonal::tableName().'.paid' => SORT_ASC],
                        'desc' => [BillPersonal::tableName().'.paid' => SORT_DESC],
                    ],
                    'bp_description' => [
                        'asc' => [BillPersonal::tableName().'.description' => SORT_ASC],
                        'desc' => [BillPersonal::tableName().'.description' => SORT_DESC],
                    ],
                    'bp_amount' => [
                        'asc' => [BillPersonal::tableName().'.amount' => SORT_ASC],
                        'desc' => [BillPersonal::tableName().'.amount' => SORT_DESC],
                    ],
                    self::tableName().'.created_at',
                    self::tableName().'.updated_at'
                ],
                'defaultOrder' => [
                    self::tableName().'.updated_at' => SORT_DESC
                ]
            ])
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if($this->bp_paid == 0)
            $this->bp_paid = null;

        $query->andFilterWhere([
            self::tableName().'.id' => $this->id,
            'price_id' => $this->price_id,
            'discount' => $this->discount,
            self::tableName().'.created_at' => $this->created_at,
            self::tableName().'.updated_at' => $this->updated_at,
            BillPersonal::tableName().'.paid' => $this->bp_paid
        ]);

        $query->andFilterWhere(['like','price.total',$this->price_total]);
        $query->andFilterWhere(['like',BillPersonal::tableName().'.amount',$this->bp_amount]);
        $query->andFilterWhere(['like',BillPersonal::tableName().'.description',$this->bp_description]);

        return $dataProvider;
    }
}
