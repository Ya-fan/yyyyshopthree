<?php 
namespace app\modules\m\controllers;

use yii\web\Controller;
/**
 * User controller for the `m` module
 */
class PayController extends Controller
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