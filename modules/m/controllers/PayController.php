<?php 
namespace app\modules\m\controllers;

use app\modules\m\controllers\common\BaseMController;

use yii\web\Controller;

use app\models\PayOrder;
use app\models\OauthMemberBind;

use app\common\services\UrlService;
use app\common\services\ConstantMapService;
use app\common\services\UtilService;
use app\common\services\PayApiService;


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
		if( $this->isRequestMethod( 'get' ) )
		{
			$order_id = intval( $this->get( 'pay_order_id', 0) );
			
			$reback_url = UrlService::buildMUrl( '/user/index' );

			if( !$order_id )
			{
				$this->redirect( $reback_url );
			} 

			$PayOrder_info = PayOrder::find()->where( [  'member_id'=>$this->current_user['id'] ,'id'=>$order_id , 'status'=> -8 ] )->one();

			if( !$PayOrder_info )
			{
				$this->redirect( $reback_url );
			}

			return $this->render( "buy", [ 'PayOrder_info'=>$PayOrder_info ] );
		}

	}

	public function actionPrepare()
	{
		if( $this->isRequestMethod( 'post' ) )
		{
			$pay_order_id = intval( $this->post( 'pay_order_id', 0 ) );
			
			if( !$pay_order_id )
			{
				return $this->renderJson( [], ConstantMapService::$default_error_msg , -1 );
			}

			// 微信公众号支付 -判断当前浏览器是否是微信浏览器
			// if( !UtilService::isWechat() )
			// {
			// 	return $this->renderJson( [], '仅支持微信支付，请将页面粘贴至微信打开' , -1 );
			// }

			$pay_order_info = PayOrder::find()->where( ['id'=>$pay_order_id, 'member_id'=>$this->current_user['id'], 'status'=>-8 ] )->one();

			if( !$pay_order_info )
			{
				return $this->renderJson( [], ConstantMapService::$default_error_msg , -1 );
			}

			// 获取微信参数
			$openid = $this->getOpenid();
			if( !$openid )
			{
				return $this->renderJson( [], '请先绑定微信再购买', -1 );
			}

			$wx_params = \Yii::$app->params['wx'];

			$user_IP = $_SERVER['REMOTE_ADDR'] ;
			$user_IP = '127.0.0.1' ;

			$notify_url = $wx_params['pay']['notify_url']['m'];

			$wx_target = new PayApiService( $wx_params );

			$wx_target->Setparams( 'appid', $wx_params['appid'] );
			$wx_target->Setparams( 'mch_id', $wx_params['pay']['mch_id'] );
			// $wx_target->Setparams( 'openid', $openid );
			// $wx_target->Setparams( 'spbill_create_ip', $user_IP );

			$wx_target->Setparams( 'body', $pay_order_info['note'] );
			$wx_target->Setparams( 'out_trade_no', $pay_order_info['order_sn'] );
			$wx_target->Setparams( 'total_fee', $pay_order_info['pay_price'] * 100 );
			$wx_target->Setparams( 'trade_type', 'NATIVE' );
			$wx_target->Setparams( 'notify_url', UrlService::buildMUrl( $notify_url ) );
		
			$prepay_info = $wx_target->getPrepayInfo();

			if( !$prepay_info )
			{
				return $this->renderJson( [], '支付失败，请重新支付', -1 );
			}
			
			
			$wx_target->SetPrepareId( $prepay_info['prepay_id'] );

			$wx_target->getParams();

	}


	private function getOpenid(  )
	{
		$user_id = $this->current_user['id'];
$user_id = 8;
		$openid  = $this->getCookie( $this->auth_cookie_current_open_id, '' );

		if( !$openid )
		{
			$openid_info = OauthMemberBind::findOne(['member_id'=>$user_id] );

			if( !$openid_info || !isset( $openid_info['openid'] ) )
			{
				return false;
			}

			$openid = $openid_info['openid'];
		}

		return $openid;
	}

	public function callback()
	{
		echo 1;die;
	}

}



 ?>