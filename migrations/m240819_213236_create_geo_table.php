<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%geo}}`.
 */
class m240819_213236_create_geo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%geo}}', [
            'id' => $this->primaryKey(),
            'ip' => $this->string(),
            'city' => $this->string(),
            'device' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%geo}}');
    }
}
