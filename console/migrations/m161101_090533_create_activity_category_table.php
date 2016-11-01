<?php

use yii\db\Migration;

/**
 * Handles the creation of table `activity_category`.
 */
class m161101_090533_create_activity_category_table extends Migration
{
    /**
     * @inheritdoc
     * Pivot table
     */
    public function up()
    {
        $this->createTable('activity_category', [
            'id' => $this->primaryKey(),
            'activity_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-activity_category-activity_id',
            'activity_category',
            'activity_id'
        );

        $this->addForeignKey(
            'fk-activity_category-activity_id',
            'activity_category',
            'activity_id',
            'activities',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-activity_category-category_id',
            'activity_category',
            'category_id'
        );

        $this->addForeignKey(
            'fk-activity_category-category_id',
            'activity_category',
            'category_id',
            'categories',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-activity_category-activity_id', 'activity_category');
        $this->dropIndex('idx-activity_category-activity_id', 'activity_category');

        $this->dropForeignKey('fk-activity_category-category_id', 'activity_category');
        $this->dropIndex('idx-activity_category-category_id', 'activity_category');
        
        $this->dropTable('activity_category');
    }
}
