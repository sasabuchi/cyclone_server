<?php

use yii\db\Schema;
use yii\db\Migration;

class m150506_075032_create_dtb_cyclone_action extends Migration
{
    /*
    public function up()
    {

    }

    public function down()
    {
        echo "m150506_075032_create_dtb_cyclone_action cannot be reverted.\n";

        return false;
    }
    */
    
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->db->createCommand()->createTable('dtb_cyclone_action', [
            'cyclone_action_id' => 'pk',
            'name'  => 'string(255) NOT NULL',
            'action_data_path' => 'string(255) NOT NULL',
            'movie_url' => 'string(255) NOT NULL',
            'play_count'  => 'integer NOT NULL DEFAULT 0',
            'genre_id'  => 'integer',
            'create_date' => 'datetime NOT NULL',
            'update_date' => 'datetime NOT NULL',
            'shown'  => 'integer(5) NOT NULL DEFAULT 0',
            'del_flg' => 'integer(5) NOT NULL DEFAULT 0'
        ])->execute();
    }
    
    public function safeDown()
    {
        $this->db->createCommand()->dropTable('dtb_cyclone_action')->execute();
    }
    
}
