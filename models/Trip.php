<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "trip".
 *
 * @property integer $id
 * @property integer $corporate_id
 * @property integer $number
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $coordination_at
 * @property integer $saved_at
 * @property integer $tag_le_id
 * @property integer $trip_purpose_id
 * @property integer $trip_purpose_parent_id
 * @property string $trip_purpose_desc
 * @property integer $status
 *
 * @property TripService[] $tripServices
 */
class Trip extends \yii\db\ActiveRecord
{
    const CORPORATE = 3;
    const SERVICE = 2;

    public $airport;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trip';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['corporate_id', 'number', 'user_id', 'created_at', 'updated_at', 'coordination_at', 'saved_at', 'tag_le_id', 'trip_purpose_id', 'trip_purpose_parent_id', 'trip_purpose_desc', 'status'], 'required'],
            [['corporate_id', 'number', 'user_id', 'created_at', 'updated_at', 'coordination_at', 'saved_at', 'tag_le_id', 'trip_purpose_id', 'trip_purpose_parent_id', 'status'], 'integer'],
            [['trip_purpose_desc', 'airport'], 'string'],
            [['corporate_id', 'number'], 'unique', 'targetAttribute' => ['corporate_id', 'number'], 'message' => 'The combination of Corporate ID and Number has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                     => 'ID',
            'corporate_id'           => 'Corporate ID',
            'number'                 => 'Number',
            'user_id'                => 'User ID',
            'created_at'             => 'Created At',
            'updated_at'             => 'Updated At',
            'coordination_at'        => 'Coordination At',
            'saved_at'               => 'Saved At',
            'tag_le_id'              => 'Tag Le ID',
            'trip_purpose_id'        => 'Trip Purpose ID',
            'trip_purpose_parent_id' => 'Trip Purpose Parent ID',
            'trip_purpose_desc'      => 'Trip Purpose Desc',
            'status'                 => 'Status',
            'airport'                => 'Аэропорт',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTripServices()
    {
        return $this->hasMany(TripService::className(), ['trip_id' => 'id']);
    }

    public static function getDb()
    {
        return Yii::$app->db;
    }
}
