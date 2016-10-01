<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dtb_customer".
 *
 * @property integer $customer_id
 * @property string $device_id
 * @property string $name
 * @property integer $play_count
 * @property string $create_date
 * @property string $update_date
 * @property integer $del_flg
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dtb_customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['device_id', 'name', 'create_date', 'update_date'], 'required'],
            [['play_count', 'del_flg'], 'integer'],
            [['create_date', 'update_date'], 'safe'],
            [['device_id', 'name'], 'string', 'max' => 255],
            [['device_id'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'customer_id' => 'Customer ID',
            'device_id' => 'Device ID',
            'name' => 'Name',
            'play_count' => 'Play Count',
            'create_date' => 'Create Date',
            'update_date' => 'Update Date',
            'del_flg' => 'Del Flg',
        ];
    }
}
