<?php 
namespace app\modules\m\controllers;

use yii\web\Controller;
/**
 * User controller for the `m` module
 */
class UserController extends Controller
{	
    public $layout = 'main';
	/**
	 * 会员中心首页
	 *	
	 * @return	bool
	 */
	public function actionIndex()
	{	
		 

		return $this->render( "index" );
	}

	/**
	 * 会员收货地址列表
	 *	
	 * @return	bool
	 */
	public function actionAddress()
	{	
		 

		return $this->render( "address" );
	}

	/**
	 * 会员收货地址添加或者修改
	 *	
	 * @return	bool
	 */
	public function actionAddress_set()
	{	
		 

		return $this->render( "address_set" );
	}

	/**
	 * 我的收藏
	 *	
	 * @return	bool
	 */
	public function actionFav()
	{	
		 

		return $this->render( "fav" );
	} 

	/**
	 * 账号的绑定
	 *	
	 * @return	bool
	 */
	public function actionBind()
	{	
		 

		return $this->render( "bind" );
	}

	/**
	 * 我的购物车
	 * @return	
	 */
	public function actionCart()
	{
		 

		return $this->render('cart');
	}

	/**
	 * 我的订单列表	
	 * @return	bool
	 */
	public function actionOrder()
	{
		 
		return	$this->render( 'order' );
	}

	/**
	 * 我的订单列表	
	 * @return	bool
	 */
	public function actionComment()
	{
		 
		return	$this->render( 'comment' );
	}

	/**
	 * 我的订单列表	
	 * @return	bool
	 */
	public function actionComment_set()
	{
		 
		return	$this->render( 'comment_set' );
	}
}


?>