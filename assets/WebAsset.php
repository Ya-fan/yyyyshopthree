<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

class WebAsset extends AssetBundle
{
    
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public function registerAssetFiles( $View )
    {
        $RELEASE_VERSION = defined('RELEASE_VERSION') ? RELEASE_VERSION : '20170401';

        $this->css = [
            '/web/css/web/bootstrap.min.css',
            
            '/web/font-awesome/css/font-awesome.css',
            
            "/web/css/web/style.css?ver=".$RELEASE_VERSION,
        ];

        $this->js = [
                
        'web/plugins/jquery-2.1.1.js',

        'js/web/bootstrap.min.js',

        'js/web/common.js?ver='.$RELEASE_VERSION,

        'web/plugins/layer/layer.js',
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
