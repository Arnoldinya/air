<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Trip;
use app\models\AirportName;

/**
 * TripSearch represents the model behind the search form about `app\models\Trip`.
 */
class TripSearch extends Trip
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'corporate_id', 'number', 'user_id', 'created_at', 'updated_at', 'coordination_at', 'saved_at', 'tag_le_id', 'trip_purpose_id', 'trip_purpose_parent_id', 'status'], 'integer'],
            [['trip_purpose_desc', 'airport'], 'safe'],
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
        $query = Trip::find()
        ->select([
            'nemo_guide_etalon.airport_name.value as airport',
            'cbt.trip.id as id',
            'cbt.trip.corporate_id as corporate_id',
            'cbt.trip.number as number',
            'cbt.trip.user_id as user_id',
            'cbt.trip.created_at as created_at',
            'cbt.trip.updated_at as updated_at',
            'cbt.trip.coordination_at as coordination_at',
            'cbt.trip.saved_at as saved_at',
            'cbt.trip.tag_le_id as tag_le_id',
            'cbt.trip.trip_purpose_id as trip_purpose_id',
            'cbt.trip.trip_purpose_parent_id as trip_purpose_parent_id',
            'cbt.trip.status as status',
        ]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id'                     => $this->id,
            'corporate_id'           => Trip::CORPORATE,
            'number'                 => $this->number,
            'user_id'                => $this->user_id,
            'created_at'             => $this->created_at,
            'updated_at'             => $this->updated_at,
            'coordination_at'        => $this->coordination_at,
            'saved_at'               => $this->saved_at,
            'tag_le_id'              => $this->tag_le_id,
            'trip_purpose_id'        => $this->trip_purpose_id,
            'trip_purpose_parent_id' => $this->trip_purpose_parent_id,
            'status'                 => $this->status,
        ]);

        $query->andFilterWhere(['like', 'trip_purpose_desc', $this->trip_purpose_desc]);

        $query->joinWith([
            'tripServices' => function ($q) {
                $q->joinWith([
                    'flightSegments' => function ($q) {
                        $q->leftJoin('nemo_guide_etalon.airport_name', 'nemo_guide_etalon.airport_name.airport_id=cbt1.flight_segment.depAirportId');
                        $q->andFilterWhere(['like', 'nemo_guide_etalon.airport_name.value', $this->airport]);
                    }
                ]);
                $q->andWhere([
                    'trip_service.service_id' => Trip::SERVICE,
                ]);
            }
        ]);

        $query->groupBy('cbt1.trip.id');

        return $dataProvider;
    }
}
