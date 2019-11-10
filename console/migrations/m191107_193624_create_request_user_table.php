<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%request_user}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%request}}`
 */
class m191107_193624_create_request_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%request_user}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => $this->integer(),
            'request_id' => $this->integer(),
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-request_user-user_id}}',
            '{{%request_user}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-request_user-user_id}}',
            '{{%request_user}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `request_id`
        $this->createIndex(
            '{{%idx-request_user-request_id}}',
            '{{%request_user}}',
            'request_id'
        );

        // add foreign key for table `{{%request}}`
        $this->addForeignKey(
            '{{%fk-request_user-request_id}}',
            '{{%request_user}}',
            'request_id',
            '{{%request}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-request_user-user_id}}',
            '{{%request_user}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-request_user-user_id}}',
            '{{%request_user}}'
        );

        // drops foreign key for table `{{%request}}`
        $this->dropForeignKey(
            '{{%fk-request_user-request_id}}',
            '{{%request_user}}'
        );

        // drops index for column `request_id`
        $this->dropIndex(
            '{{%idx-request_user-request_id}}',
            '{{%request_user}}'
        );

        $this->dropTable('{{%request_user}}');
    }
}
