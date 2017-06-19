<?php 
namespace app\modules\m\controllers;
use yii\web\Controller;
use app\modules\m\controllers\common\BaseMController;

/**
 * Default controller for the `m` module
 */
class ProductController extends BaseMController
{
	public $layout = 'main';
	/**
	 * 商品列表
	 *	
	 * @return	
	 */
	public function actionIndex()
	{
		
		return	$this->render( 'index' );
	}

	/**
	 *商品详情
	 * 
	 * @return	
	 */
	public function actionInfo()
	{
		
		return	$this->render( 'info' );
	}

	/**
	 * 下订单	
	 * @return	bool
	 */
	public function actionOrder()
	{
		
		return	$this->render( 'order' );
	}
}

 ?>