<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dtb_cyclone_action".
 *
 * @property integer $cyclone_action_id
 * @property string $name
 * @property string $action_data_path
 * @property string $movie_url
 * @property string $create_date
 * @property string $update_date
 */
class CycloneAction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dtb_cyclone_action';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'action_data_path', 'movie_url', 'create_date', 'update_date'], 'required'],
            [['create_date', 'update_date'], 'safe'],
            [['name', 'action_data_path', 'movie_url'], 'string', 'max' => 255],
            [['shown', 'play_count', 'genre_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cyclone_action_id' => 'Cyclone Action ID',
            'name' => 'Name',
            'action_data_path' => 'Action Data Path',
            'movie_url' => 'Movie Url',
            'play_count' => 'Play Count',
            'genre_id' => 'Genre ID',
            'create_date' => 'Create Date',
            'update_date' => 'Update Date',
            'shown' => 'shown flg'
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                if ($this->shown == NULL) {
                    $this->shown = 0;
                }
            }
            return true;
        }
        return false;
    }
}
