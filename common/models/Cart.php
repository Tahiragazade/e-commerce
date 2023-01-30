<?php

namespace common\models;

use omgdef\multilingual\MultilingualQuery;
use Yii;

/**
 * This is the model class for table "cart".
 *
 * @property int $id
 * @property int $product_id
 * @property int $count
 * @property int $size_id
 * @property int $color_id
 * @property int $created_at
 * @property int $updated_at
 * @property int|null $user_id
 * @property string $session_id
 *
 * @property Color $color
 * @property Product $product
 * @property Size $size
 * @property User $user
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cart';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'count', 'size_id', 'color_id', 'created_at', 'updated_at', 'session_id'], 'required'],
            [['product_id', 'count', 'size_id', 'color_id', 'created_at', 'updated_at', 'user_id'], 'integer'],
            [['session_id'], 'string', 'max' => 255],
            [['color_id'], 'exist', 'skipOnError' => true, 'targetClass' => Color::class, 'targetAttribute' => ['color_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['size_id'], 'exist', 'skipOnError' => true, 'targetClass' => Size::class, 'targetAttribute' => ['size_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'count' => Yii::t('app', 'Count'),
            'size_id' => Yii::t('app', 'Size ID'),
            'color_id' => Yii::t('app', 'Color ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'user_id' => Yii::t('app', 'User ID'),
            'session_id' => Yii::t('app', 'Session ID'),
        ];
    }

    /**
     * Gets query for [[Color]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getColor()
    {
        return $this->hasOne(Color::class, ['id' => 'color_id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * Gets query for [[Size]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSize()
    {
        return $this->hasOne(Size::class, ['id' => 'size_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
	public static function find()
	{
		return new MultilingualQuery(get_called_class());
	}
	public static function updateCart(){
		$session = Yii::$app->session;
		$key=$session->get('key');
		$old_session=Session::find()->where(['key'=>$key])->one();
		if($old_session!=null){
			Cart::updateAll(['user_id'=>Yii::$app->user->id],['session_id'=>$old_session->key]);
			$old_session->delete();
		}
		$session->remove('key');
		return true;
	}
	public static function cartUpdate(){
		$old_session=Session::find()->where(['session_id'=>Yii::$app->session->id])->one();
		if($old_session!=null) {
			Yii::$app->session->set('key', $old_session->key);
		}

		return true;
	}
}
