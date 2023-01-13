<?php

namespace common\models;

use himiklab\sortablegrid\SortableGridBehavior;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;

/**
 * This is the model class for table "color".
 *
 * @property int $id
 * @property int $created_at
 * @property int $created_by
 * @property int $sort_order
 */
class Color extends \yii\db\ActiveRecord
{
	public function behaviors()
	{
		return [
			'ml' => [
				'class' => MultilingualBehavior::className(),
				'languages' => Yii::$app->base->getLangList(),
				'languageField' => 'lang',
				//'localizedPrefix' => '',
				//'forceOverwrite' => false',
				//'dynamicLangClass' => true',
				'langClassName' => ColorContent::className(), // or namespace/for/a/class/PostLang
				'defaultLanguage' => 'az',
				'langForeignKey' => 'color_id',
				'tableName' => "{{%color_content}}",
				'attributes' => [
					'name'
				]
			],
			'sort' => [
				'class' => SortableGridBehavior::className(),
				'sortableAttribute' => 'sort_order'
			],
		];
	}
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'color';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'created_by', 'updated_at'], 'required'],
            [['created_at', 'created_by', 'sort_order','updated_at'], 'integer'],
	        [['name_az','name_en','name_ru',],'string']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'sort_order' => Yii::t('app', 'Sort Order'),
        ];
    }
	public function getColorContents()
	{
		return $this->hasMany(ColorContent::class, ['color_id' => 'id']);
	}
	public static function find()
	{
		return new MultilingualQuery(get_called_class());
	}

	public function afterSave($insert, $changedAttributes)
	{
		if($this->isNewRecord) {
			$this->sort_order = $this->id;
			$this->save(false);
		}
		return parent::afterSave($insert, $changedAttributes);
	}

}
