<?php
namespace common\components;

use Yii;


class I18nUrlManager extends \yii\web\UrlManager {
    /**
     * @inheritdoc
     */
    public function init() {
        return parent::init();
    }

    /**
     * @param array|string $params
     * @return string
     */
    public function createUrl($params, $i18n = true) {
        if($i18n)
            $params['lang'] = Yii::$app->language;
        return parent::createUrl($params);
    }

    public static function cleanUrl($url) {
        $disallowed = array('http://', 'https://', 'www.', '/');
        foreach($disallowed as $d) {
                $url = str_replace($d, '', $url);
        }
        return $url;
    }

    public function createLanguageUrl() {}
}