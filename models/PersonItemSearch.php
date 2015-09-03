<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PersonItem;
use yii\data\Sort;

/**
 * PersonItemSearch represents the model behind the search form about `app\models\PersonItem`.
 */
class PersonItemSearch extends PersonItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'item_id', 'person_id'], 'integer'],
            [['created_at', 'updated_at','item_name','person_name'], 'safe'],
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
        $query = PersonItem::find();
        $query->innerJoinWith(['person','item']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => new Sort([
                'attributes' => [
                    'item_name' => [
                        'asc' => ['item.name' => SORT_ASC],
                        'desc' => ['item.name' => SORT_DESC]
                    ],
                    'person_name' => [
                        'asc' => ['person.lastname' => SORT_ASC],
                        'desc' => ['person.lastname' => SORT_DESC]
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
            /*'item_id' => $this->item_id,
            'person_id' => $this->person_id,*/
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andWhere('item.name LIKE :in OR item.code LIKE :in OR person.firstname LIKE :pn OR person.lastname LIKE :pn',[':pn' => '%'.$this->person_name.'%',':in' => '%'.$this->person_name.'%']);

        return $dataProvider;
    }
}
