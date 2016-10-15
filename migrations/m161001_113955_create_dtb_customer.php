<?php

use yii\db\Schema;
use yii\db\Migration;

class m161001_113955_create_dtb_customer extends Migration
{
    public function safeUp()
    {
        $this->db->createCommand()->createTable('dtb_customer', [
            'customer_id' => 'pk',
            'device_id'  => 'string(255) NOT NULL UNIQUE',
            'name' => 'string(255) NOT NULL',
            'play_count' => 'integer NOT NULL DEFAULT 0',
            'create_date' => 'datetime NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'update_date' => 'datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'del_flg' => 'integer(5) NOT NULL DEFAULT 0'
        ])->execute();
    }

    public function safeDown()
    {
        $this->db->createCommand()->dropTable('dtb_customer')->execute();
    }
}
