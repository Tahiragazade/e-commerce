<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<?= $this->render('/index/carousel',['carousels'=>$carousels,]);?>
<?= $this->render('/index/featured');?>
<?= $this->render('/index/categories',['categories'=>$categories]);?>
<?= $this->render('/index/featured_products');?>
<?= $this->render('/index/offer');?>
<?= $this->render('/index/recent_products');?>
<?= $this->render('/index/vendor');?>
