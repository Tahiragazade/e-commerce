<?php

/** @var yii\web\View $this */

$this->title = 'EBazar';
?>
<?= $this->render('/index/carousel',['carousels'=>$carousels,'discounts'=>$discounts,]);?>
<?= $this->render('/index/featured');?>
<?= $this->render('/index/categories',['categories'=>$categories]);?>
<?= $this->render('/index/featured_products',['feature_products'=>$feature_products,]);?>
<?= $this->render('/index/offer',['discounts'=>$discounts,]);?>
<?= $this->render('/index/recent_products',['recents'=>$recents,]);?>
<?= $this->render('/index/vendor',['vendors'=>$vendors,]);?>
