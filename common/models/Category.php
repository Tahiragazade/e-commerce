<?php

namespace common\models;

use himiklab\sortablegrid\SortableGridBehavior;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property int|null $parent_id
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int|null $sort_order
 *
 * @property Category[] $categories
 * @property CategoryContent[] $categoryContents
 * @property Category $parent
 */
class Category extends \yii\db\ActiveRecord
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
				'langClassName' => CategoryContent::className(), // or namespace/for/a/class/PostLang
				'defaultLanguage' => 'az',
				'langForeignKey' => 'category_id',
				'tableName' => "{{%category_content}}",
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
		return 'categories';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['parent_id', 'status', 'created_at', 'updated_at', 'sort_order'], 'integer'],
			[['name_az', 'name_en', 'name_ru'], 'string'],
			[['created_at', 'updated_at'], 'required'],
			[['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['parent_id' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => Yii::t('app', 'ID'),
			'parent_id' => Yii::t('app', 'Parent ID'),
			'status' => Yii::t('app', 'Status'),
			'created_at' => Yii::t('app', 'Created At'),
			'updated_at' => Yii::t('app', 'Updated At'),
			'sort_order' => Yii::t('app', 'Sort Order'),
		];
	}

	/**
	 * Gets query for [[Categories]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getCategories()
	{
		return $this->hasMany(Category::class, ['parent_id' => 'id']);
	}

	/**
	 * Gets query for [[CategoryContents]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getCategoryContents()
	{
		return $this->hasMany(CategoryContent::class, ['category_id' => 'id']);
	}

	/**
	 * Gets query for [[Parent]].
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getParent()
	{
		return $this->hasOne(Category::class, ['id' => 'parent_id']);
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
