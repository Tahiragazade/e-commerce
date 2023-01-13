<?php

namespace common\models;

use himiklab\sortablegrid\SortableGridBehavior;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property float $price
 * @property string|null $photo
 * @property int $category_id
 * @property int $created_by
 * @property int $sort_order
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Categories $category
 * @property User $createdBy
 * @property ProductColor[] $productColors
 * @property ProductSize[] $productSizes
 */
class Product extends \yii\db\ActiveRecord
{
	public $size;
	public $color;

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
				'langClassName' => ProductContent::className(), // or namespace/for/a/class/PostLang
				'defaultLanguage' => 'az',
				'langForeignKey' => 'product_id',
				'tableName' => "{{%product_content}}",
				'attributes' => [
					'title','description','small_description','information'
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
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price', 'category_id', 'created_by','created_at', 'updated_at'], 'required'],
            [['price'], 'number'],
            [['category_id', 'created_by', 'sort_order', 'created_at', 'updated_at'], 'integer'],
            [['photo','title_az','title_en','title_ru','small_description_az','small_description_ru','small_description_en'], 'string', 'max' => 255],
	        [['description_az','description_en','description_ru','information_az','information_en','information_ru'],'string'],
	        [['size','color'],'safe'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'price' => Yii::t('app', 'Price'),
            'photo' => Yii::t('app', 'Photo'),
            'category_id' => Yii::t('app', 'Category ID'),
            'created_by' => Yii::t('app', 'Created By'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * Gets query for [[ProductColors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductColors()
    {
        return $this->hasMany(ProductColor::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[ProductSizes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductSizes()
    {
        return $this->hasMany(ProductSize::class, ['product_id' => 'id']);
    }
	public static function find()
	{
		return new MultilingualQuery(get_called_class());
	}
	public function getProductContents()
	{
		return $this->hasMany(ProductContent::class, ['product_id' => 'id']);
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
