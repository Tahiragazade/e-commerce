<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "session".
 *
 * @property int $id
 * @property string $session_id
 * @property string $key
 */
class Session extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'session';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['session_id', 'key'], 'required'],
            [['session_id', 'key'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'session_id' => Yii::t('app', 'Session ID'),
            'key' => Yii::t('app', 'Key'),
        ];
    }
}
