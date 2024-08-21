<?php

namespace app\models;

use yii\helpers\ArrayHelper;

/**
 * @property int $id
 * @property string $ip
 * @property string $city
 * @property string $device
 * @property integer $date
 * @property integer $hour
 */
class Geo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'geo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ip', 'city', 'device'], 'string'],
            [['date', 'hour'], 'integer'],
        ];
    }

    public static function countUniqueIpByHour()
    {
        return ArrayHelper::map(self::find()->select('count(distinct ip) as cnt, hour')->groupBy('hour')->asArray()->all(), 'cnt', 'hour');
    }

    public static function uniqueCityData()
    {
        return ArrayHelper::map(self::find()->select('count(city) as cnt, city')->groupBy('city')->indexBy('city')->asArray()->all(), 'cnt', 'city');
    }

}