<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class Language extends Component {
    /**
     * @var string query param name
     */
    public $queryParam = 'lang';
    public $params = [];

    private $_key;

    /**
     * @inheritdoc
     */
    public function __init()
    {
        if (!isset(Yii::$app->params['languages'])) {
            throw new \yii\base\InvalidConfigException("You must define Yii::\$app->params['languages'] array");
        }

        $request = Yii::$app->getRequest();
        $lang = $request->get($this->queryParam);
        $this->_key = 'language.' . $this->queryParam;
        if ($lang !== null) {
            if(in_array( $lang, array_keys(Yii::$app->params['languages']) )) {
                Yii::$app->session->set($this->_key, $lang);
                Yii::$app->language = $lang;
            } else {
                Yii::$app->session->set($this->_key, 'az');
                Yii::$app->language = 'az';
            }
        } elseif (Yii::$app->session->get($this->_key) === null) {
            $preferredLang = $request->getPreferredLanguage(array_keys(Yii::$app->params['languages']));
            $preferredLang = 'az';
            if ($preferredLang !== null) {
                Yii::$app->session->set($this->_key, $preferredLang);
                Yii::$app->language = $preferredLang;
            } else {
                Yii::$app->session->set($this->_key, Yii::$app->language);
            }
        } else {
            Yii::$app->language = Yii::$app->session->get($this->_key);
        }

    }



    public static function url(array $params = [])
    {
        $currentParams = Yii::$app->getRequest()->getQueryParams();
        $currentParams[0] = '/' . Yii::$app->controller->getRoute();
        $route = ArrayHelper::merge($currentParams, $params);
        return Yii::$app->getUrlManager()->createUrl($route, false);
    }


  

    public function getMenuItems()
    {
        $subItems = [];
        foreach (Yii::$app->params['languages'] as $lang => $desc) {
            // if (Yii::$app->language != $lang) {
            //     $subItems[] = ['label' => $lang,'class'=>strtolower($desc), 'url' => $this->url(['lang' => $lang])];
            // } 

            $subItems[] = ['label' => $desc,'class'=>strtolower($desc),'lang' => $lang, 'url' => $this->url(['lang' => $lang])];
        }
        $item['items'] = $subItems;
        return $item;
    }

    public function getMobileMenuItems()
    {
        $subItems = [];
        foreach (Yii::$app->params['languages'] as $lang => $desc) {
            $desc = '<img src="/images/lang_'. strtolower($desc) .'.png" />';
            $subItems[] = ['label' => $desc,'class'=>strtolower($desc), 'url' => $this->url(['lang' => $lang])];
        }
        $item['items'] = $subItems;
        return $item;
    }

                                        
}