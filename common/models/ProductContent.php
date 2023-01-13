<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_content".
 *
 * @property int $id
 * @property int $product_id
 * @property int $lang
 * @property string $title
 * @property string $small_descriprion
 * @property string $description
 * @property string $information
 */
class ProductContent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_content';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'lang', 'title', 'small_description', 'description', 'information'], 'required'],
            [['product_id'], 'integer'],
	        [['lang'],'string', 'max' => 60],
            [['description', 'information'], 'string'],
            [['title', 'small_description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'product_id' => Yii::t('app', 'Product ID'),
            'lang' => Yii::t('app', 'Lang'),
            'title' => Yii::t('app', 'Title'),
            'small_descriprion' => Yii::t('app', 'Small Descriprion'),
            'description' => Yii::t('app', 'Description'),
            'information' => Yii::t('app', 'Information'),
        ];
    }
}
