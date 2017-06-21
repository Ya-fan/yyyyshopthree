<?php 

namespace app\modules\web\controllers;

use yii\web\Controller;

use app\modules\web\controllers\common\BaseWebController;

/**
 * User controller for the `web` module
 */
class QrcodeController extends BaseWebController
{

    public $layout = 'main';

	/**
     * 营销列表
     * @return string
     */
	public function actionIndex()
	{
        return $this->render( "index" );
	}

	/**
     * 渠道设置
     * @return string
     */
	public function actionSet()
	{
        return $this->render( "set" );
	}
}




 ?>