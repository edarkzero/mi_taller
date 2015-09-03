<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\CarPart;
use yii\data\Sort;

/**
 * CarPartSearch represents the model behind the search form about `app\models\CarPart`.
 */
class CarPartSearch extends CarPart
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'size_id', 'color_id', 'damage_id', 'price_id'], 'integer'],
            [['created_at', 'updated_at', 'price_total','size_name','color_name','damage_name'], 'safe'],
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
        $query = CarPart::find();
        $query->innerJoinWith('size','color','damage','price');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => new Sort([
                'attributes' => [
                    'size_name' => [
                        'asc' => ['size.name' => SORT_ASC],
                        'desc' => ['size.name' => SORT_DESC]
                    ],
                    'color_name' => [
                        'asc' => ['color.name' => SORT_ASC],
                        'desc' => ['color.name' => SORT_DESC]
                    ],
                    'damage_name' => [
                        'asc' => ['damage.name' => SORT_ASC],
                        'desc' => ['damage.name' => SORT_DESC]
                    ],
                    'price_total' => [
                        'asc' => ['price.total' => SORT_ASC],
                        'desc' => ['price.total' => SORT_DESC]
                    ],
                    'created_at',
                    'updated_at'
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
            /*'size_id' => $this->size_id,
            'color_id' => $this->color_id,
            'damage_id' => $this->damage_id,
            'price_id' => $this->price_id,*/
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'size.name', $this->size_name])->andFilterWhere(['like', 'damage.name', $this->damage_name])
            ->andFilterWhere(['like', 'color.name', $this->color_name])->andFilterWhere(['like','price.total',$this->price_total]);

        return $dataProvider;
    }
}
