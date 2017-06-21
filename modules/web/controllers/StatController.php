<?php 
namespace app\modules\web\controllers;

use yii\web\Controller;

use app\modules\web\controllers\common\BaseWebController;

/**
 * User controller for the `web` module
 */
class StatController extends BaseWebController
{
    public $layout = 'main';
    
	/**
     * 财务统计
     * @return string
     */
    public function actionIndex()
    {			
        return $this->render( "index" );
    }

    /**
     * 商品统计
     * @return string
     */
    public function actionProduct()
    {			

        return $this->render( "Product" );
    }

    /**
     * 会员消费统计
     * @return string
     */
    public function actionMember()
    {			
    
        return $this->render( "member" );
    }

    /**
     * 分享统计
     * @return string
     */
    public function actionShare()
    {			

        return $this->render( "share" );
    }
}


 ?>