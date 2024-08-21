<?php

namespace app\models;

/**
 * @property int $id
 * @property string $ip
 * @property string $city
 * @property string $device
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
        ];
    }


}