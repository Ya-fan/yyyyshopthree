<?php 
namespace app\modules\m\controllers;

use app\modules\m\controllers\common\BaseMController;

use yii\web\Controller;
/**
 * User controller for the `m` module
 */
class PayController extends BaseMController
{
    public $layout = 'main';

	/**
	 *	支付页面
	 * @return	bool
	 */
	public function actionBuy()
	{
		return $this->render( "buy" );
	}
}



 ?>