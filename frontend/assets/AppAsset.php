<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
//        'css/site.css',
        'css/bootstrap.css',
        'css/bootstrap.min.css',
        'css/bootstrap-reboot.min.css',
        'css/bootstrap-reboot.css',
        'css/bootstrap-grid.min.css',
        'css/bootstrap-grid.css',
	    'css/style.css',
	    'css/style.min.css',
	    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css',
	    'https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap',
	    'lib/animate/animate.min.css',
	    'lib/owlcarousel/assets/owl.carousel.min.css',
    ];
    public $js = [
//		'https://code.jquery.com/jquery-3.4.1.min.js',
//	    'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js',
	    'lib/easing/easing.min.js',
	    'lib/owlcarousel/owl.carousel.min.js',
	    'jqBootstrapValidation.min.js',
		'js/contact.js',
		'js/main.js',
	    'https://code.jquery.com/jquery-3.4.1.min.js',
	    'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js',
    ];
    public $depends = [
//        'yii\web\YiiAsset',
//        'yii\bootstrap5\BootstrapAsset',
    ];
}
