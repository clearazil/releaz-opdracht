<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "activities".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $type
 * @property string $image_location
 * @property string $description
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 * @property ActivityCategory[] $activityCategories
 */
class Activity extends \yii\db\ActiveRecord
{
    public $categories;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'activities';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type', 'image_location', 'description'], 'required'],
            [['description'], 'string'],
            [['name', 'type', 'image_location'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'type' => 'Type',
            'image_location' => 'Image Location',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getActivityCategories()
    {
        return $this->hasMany(ActivityCategory::className(), ['activity_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])
            ->via('activityCategories');
    }
}
