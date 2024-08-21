<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%geo}}`.
 */
class m240821_090124_add_date_column_to_geo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%geo}}', 'date', $this->integer());
        $this->addColumn('{{%geo}}', 'hour', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%geo}}', 'date');
        $this->dropColumn('{{%geo}}', 'hour');
    }
}
