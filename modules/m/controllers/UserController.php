<?php 
namespace app\modules\m\controllers;
use app\modules\m\controllers\common\BaseMController;

use yii\web\Controller;

use app\models\SmsCaptcha;
use app\models\Member;
use app\common\services\UtilService;
use app\common\services\ConstantMapService;
use app\models\OauthMemberBind;

use app\common\services\UrlService;


/**
 * User controller for the `m` module
 */
class UserController extends BaseMController
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
		if( $this->isRequestMethod('get') )
		{
			return $this->render( "bind" );		
		}
		else
		{
			$mobile 		=  trim( $this->post('mobile','') );
			$img_captcha 	=  trim( $this->post('img_captcha','') );
			$captcha_code 	=  trim( $this->post('captcha_code','') );

			if( mb_strlen( $mobile ,'utf-8') < 1  || !preg_match("/^[1-9]\d{10}$/", $mobile) )
			{
				return $this->renderJson([],'请输入正确的手机号', -1);
			}

			if( mb_strlen( $img_captcha ,'utf-8') < 1   )
			{
				return $this->renderJson([],'请输入正确的图片验证码', -1);
			}

			if( mb_strlen( $mobile ,'utf-8') < 1  )
			{
				return $this->renderJson([],'请输入正确的手机号验证码', -1);
			}

			if( !SmsCaptcha::checkCaptcha( $mobile, $captcha_code) )
			{
				return $this->renderJson( [],'手机验证码不正确~~', -1 );
			}

			$member_info = Member::find()->where( ['mobile'=>$mobile,'status'=>1 ] )->one();

			if( !$member_info )
			{	
				if(Member::findOne( ['mobile'=>$mobile] ))
				{
					return  $this->renderJson([], '该手机号已经注册，请直接用手机的登录',-1);
				}

				$model_member = new Member();

				$model_member->nickname = $mobile;
				$model_member->mobile = $mobile;
				$model_member->setSalt();

				$model_member->reg_ip = UtilService::getIP() ;
				$model_member->status = 1;
				$model_member->created_time = $model_member->updated_time =  date( 'Y-m-d H:i:s' );

				$model_member->save( 0 );

				$member_info = $model_member;
			}
		
			 if( !$member_info || !$member_info['status'] )
			 {
			 	return $this->renderJson( [], '您的账号被禁止，请联系客服解决' ,-1) ;
			 }
			
			// 获取用户openid
			$openid = $this->getCookie($this->auth_cookie_current_open_id);

			// 微信用户绑定
			if( $openid )
			{
				$MemberBind =  OauthMemberBind::find()->where( ['openid'=>$openid,'member_id'=>$member_info['id'],'type'=>ConstantMapService::$client_type_wechat] )->one();
			
				if( !$MemberBind )
				{
					$MemberBind = new OauthMemberBind();
					$bind_time = date('Y-m-d H:i:s');
					$MemberBind->member_id = $member_info['id'];
					$MemberBind->client_type = 'weixin';
					$MemberBind->type = ConstantMapService::$client_type_wechat;
					$MemberBind->openid = $openid;
					$MemberBind->unionid = '';
					$MemberBind->extra = '';
					$MemberBind->updated_time = $bind_time;
					$MemberBind->created_time = $bind_time;

					$MemberBind->save( 0 );

				}
			}
			
			// 微信端注册 手动授权
			if( UtilService::isWechat() && $member_info['nickname'] == $member_info['mobile'])
			{
				return $this->renderJson( ['url'=>'/m/oauth/login'], '绑定成功' ,200 );
			}

			// 设置登录态
			$this->setLoginStatus( $member_info );
			return $this->renderJson( ['url'=>'/m/default/index'], '绑定成功' ,200 );
		}
		

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