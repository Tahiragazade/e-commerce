<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "color_content".
 *
 * @property int $id
 * @property int $color_id
 * @property string $name
 * @property int $lang
 */
class ColorContent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'color_content';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['color_id', 'name', 'lang'], 'required'],
            [['color_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['lang'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'color_id' => Yii::t('app', 'Color ID'),
            'name' => Yii::t('app', 'Name'),
            'lang' => Yii::t('app', 'Lang'),
        ];
    }
}
