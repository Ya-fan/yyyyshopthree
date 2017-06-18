<?php 
namespace app\modules\web\controllers;

use app\common\components\BaseController;
use yii\web\Controller;

use app\modules\web\controllers\common\BaseWebController;

class BrandController extends BaseWebController
{
    public $layout = 'main';
    
	/**
     * 品牌详情
     * @return string
     */
    public function actionInfo()
    {			

        return $this->render( "info" );
    }

    /**
     * 品牌添加或者删除
     * @return string
     */
    public function actionSet()
    {			

        return $this->render( "set" );
    }

    /**
     * 品牌图片
     * @return string
     */
    public function actionImages()
    {			

        return $this->render( "images" );
    }
}
 ?>