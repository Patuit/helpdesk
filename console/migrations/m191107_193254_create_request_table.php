<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%request}}`.
 */
class m191107_193254_create_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%request}}', [
            'id' => Schema::TYPE_PK,
            'title' => $this->string(),
            'type' => $this->tinyInteger(),
            'priority' => $this->tinyInteger(),
            'description' => $this->text(),
            'contacts' => $this->text(),
            'comments' => $this->text(),
            'status' => $this->tinyInteger()->defaultValue(0),
            'time_complete' => $this->time(),
            'time_working' => $this->time(),
            'mark' => $this->tinyInteger()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%request}}');
    }
}
