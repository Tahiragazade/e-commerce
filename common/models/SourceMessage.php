<?php

namespace common\models;

use himiklab\sortablegrid\SortableGridBehavior;
use omgdef\multilingual\MultilingualBehavior;
use omgdef\multilingual\MultilingualQuery;
use Yii;

/**
 * This is the model class for table "source_message".
 *
 * @property int $id
 * @property string|null $category
 * @property string|null $message
 *
 * @property Message[] $messages
 */
class SourceMessage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
	public function behaviors()
	{
		return [
			'ml' => [
				'class' => MultilingualBehavior::className(),
				'languages' => Yii::$app->base->getLangList(),
				'languageField' => 'language',
				//'localizedPrefix' => '',
				//'forceOverwrite' => false',
				//'dynamicLangClass' => true',
				'langClassName' => Message::className(), // or namespace/for/a/class/PostLang
				'defaultLanguage' => 'az',
				'langForeignKey' => 'id',
				'tableName' => "{{%message}}",
				'attributes' => [
					'translation'
				]
			],

		];
	}
    public static function tableName()
    {
        return 'source_message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['message'], 'string'],
            [['category','translation_az','translation_ru','translation_en'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category' => Yii::t('app', 'Category'),
            'message' => Yii::t('app', 'Message'),
        ];
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::class, ['id' => 'id']);
    }
	public static function find()
	{
		return new MultilingualQuery(get_called_class());
	}
}
