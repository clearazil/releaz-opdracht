<?php

use yii\db\Migration;

/**
 * Handles the creation of table `activities`.
 */
class m161101_090454_create_activities_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('activities', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'type' => $this->string()->notNull(),
            'image_location' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-activities-user_id',
            'activities',
            'user_id'
        );

        $this->addForeignKey(
            'fk-activities-user_id',
            'activities',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );


    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-activities-user_id', 'activities');
        $this->dropIndex('idx-activities-user_id', 'activities');

        $this->dropTable('activities');
    }
}
