<?php 
namespace app\modules\web\controllers;


use app\common\components\BaseController;
use yii\web\Controller;

use app\modules\web\controllers\common\BaseWebController;


class BookController extends BaseWebController
{
    public $layout = 'main';
    
	/**
     * 图书列表
     * @return string
     */
    public function actionIndex()
    {			
        return $this->render( "index" );
    }

    /**
     * 图书添加或修改
     * @return string
     */
    public function actionSet()
    {			

        return $this->render( "set" );
    }

    /**
     * 品牌详情
     * @return string
     */
    public function actionImages()
    {			

        return $this->render( "images" );
    }

    /**
     * 图书详情
     * @return string
     */
    public function actionInfo()
    {			
        return $this->render( "info" );
    }

   	/**
     * 图书分类
     * @return string
     */
    public function actionCat()
    {	
        return $this->render( "cat" );
    }

    /**
     * 分类修改
     * @return string
     */
    public function actionCatSet()
    {			
        return $this->render( "cat_set" );
    }
}	
 ?>