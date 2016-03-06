<?php

use yii\db\Schema;
use yii\db\Migration;

class m150419_125742_create_users_table extends Migration
{
    public function up()
    {
        $this->db->createCommand()->createTable('users', [
            'id' => 'pk',
            'username' => 'string(20) NOT NULL',
            'password' => 'string(255) NOT NULL',
            'auth_key' => 'string(255)',
        ])->execute();

        // usernameをuniqueに
        $this->createIndex('username', 'users', 'username', true);
    }

    public function down()
    {
        $this->db->createCommand()->dropTable('users')->execute();
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
