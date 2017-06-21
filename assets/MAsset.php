<?php 

namespace app\assets;

use yii\web\AssetBundle;

class MAsset extends AssetBundle
{
    
    public $basePath 	= '@webroot';
    public $baseUrl 	= '@web';

    public function registerAssetFiles( $View )
    {
        $RELEASE_VERSION = defined('RELEASE_VERSION') ? RELEASE_VERSION : '20170401';

        $this->css = [
            '/web/font-awesome/css/font-awesome.css',
            
            '/m/css/m/css_style.css',
            
            "/m/css/m/app.css?ver=".$RELEASE_VERSION,
        ];


        $this->js = [
        'http://res.wx.qq.com/open/js/jweixin-1.2.0.js',

        'web/plugins/jquery-2.1.1.js',

        'js/m/TouchSlide.1.1.js',
        
        'js/m/common.js?ver='.$RELEASE_VERSION,

        'js/m/wx.js?ver='.$RELEASE_VERSION,
        ];

        parent::registerAssetFiles( $View );
    }

    // public $depends = [
    //     'yii\web\YiiAsset',
    //     'yii\bootstrap\BootstrapAsset',
    // ];
    // public $jsOptions = [
    // 'position' => \yii\web\View::POS_HEAD
    // ];
}



 ?>