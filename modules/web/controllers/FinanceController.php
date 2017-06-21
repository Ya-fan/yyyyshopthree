<?php 
namespace app\modules\web\controllers;

use yii\web\Controller;

use app\modules\web\controllers\common\BaseWebController;

/**
 * User controller for the `web` module
 */
class FinanceController extends BaseWebController
{	
    public $layout = 'main';
	
	/**
     * 财务列表
     * @return string
     */
	public function actionIndex()
	{
        return $this->render( "index" );
	}

	/**
     * 财务流水
     * @return string
     */
	public function actionAccount()
	{
        return $this->render( "account" );
	}

	/**
     * 订单详情
     * @return string
     */
	public function actionPay_info()
	{
        return $this->render( "pay_info" );
	}
}








 ?>